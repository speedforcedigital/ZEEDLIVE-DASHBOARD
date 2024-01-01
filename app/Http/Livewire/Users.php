<?php

namespace App\Http\Livewire;

use App\Traits\MailTrait;
use App\Traits\pushNotificationTrait;
use CURLFile;
use App\Models\User;
use Livewire\Component;
use App\Helpers\baseUrl;
use Livewire\WithFileUploads;
use App\Helpers\MakeCurlRequest;
use App\Helpers\makeCurlFileRequest;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\WithPagination;

// protected $listeners = [];
class Users extends Component
{
    use WithFileUploads; use MailTrait; use pushNotificationTrait,  withPagination;

    public $user_id, $name, $email, $mobile, $gender, $role, $password, $type, $image;
    public $viewUser = false;
    public $updateMode = false;
    public $userProfile;
    public $filterUser = false;
    public $filterType = '';
    public $filter = 'all';
    public $selected = 'all';

    public $search = '';

    public $is_banned;
    public $is_active;

    public $reason = '';

    protected $rules = [
        'reason' => 'required',
    ];
    protected $listeners = [
        'views',
        'viewUsers' => 'view'
    ];

    public function render()
    {
        $usersQuery = User::with('Role')
            ->where("id", "<>", auth()->user()->id)
            ->where("rank", '<>', "Admin")
            ->where('is_admin', 0)
            ->orderBy('users.id', 'desc');

        if ($this->search) {
            $usersQuery->where('name', 'like', '%' . $this->search . '%')
                ->orWhere('email', 'like', '%' . $this->search . '%')
                ->orWhere('mobile', 'like', '%' . $this->search . '%');
        }

        $users = $usersQuery->paginate(10);
        $totalUsers = $users->total();
        $totalUsersCount = $totalUsers;

//        $users = User::with('Role')->where("id", "<>", auth()->user()->id)->where("rank", '<>', "Admin")->orderBy('users.id', 'desc')->paginate(10);
//        $totalUsers = $users->total();
//        $totalUsersCount = $users->total();

        $sellers = User::with('Role')->where("id", "<>", auth()->user()->id)->where("rank", "Seller")->where("rank", '<>', "Admin")->orderBy('users.id', 'desc')->paginate(10);
        $totalSellers = $sellers->total();

        $buyers = User::with('Role')->where("id", "<>", auth()->user()->id)->where("rank", "Buyer")->orderBy('users.id', 'desc')->paginate(10);
        $totalBuyers = $buyers->total();

        if ($this->filter == "all") {
            $users = $users;
            $totalUsers = $users->total();
        } else if ($this->filter == "sellers") {
            $users = $sellers;
            $totalUsers = $sellers->total();
        } else if ($this->filter == "buyers") {
            $users = $buyers;
            $totalUsers = $buyers->total();
        }
        if ($this->updateMode == false && $this->viewUser == false) {
            return view('livewire.users', compact('users', 'totalUsersCount', 'totalUsers', 'totalSellers', 'totalBuyers'));
        }
        if (request()->userId) {
            $this->view(request()->userId);
        }

        if ($this->viewUser) {
            return view('livewire.users', [
                'users' => $users,
                'totalUsers' => $totalUsers,
                'totalSellers' => $totalSellers,
                'totalBuyers' => $totalBuyers,
                'viewUser' => $this->viewUser,
                'userProfile' => $this->userProfile,
                'filterType' => $this->filterType
            ]);
        } else {
            return view('livewire.users', compact('users', 'totalUsers', 'totalSellers', 'totalBuyers'));
        }
    }

    public function delete($id)
    {
        User::destroy($id);
        $message = 'User Deleted Successfully.';
        return redirect()->route('users')->with('message', $message);

    }

    public function view($id)
    {
        $this->viewUser = true;
        $singleUser = User::with('Role')->where("id", $id)->first();

        $this->userProfile = $singleUser;
    }

    public function edit($id)
    {
        $singleUser = User::with('Role')->where("id", $id)->first();

        $this->user_id = $singleUser->id;
        $this->name = $singleUser->name;
        $this->email = $singleUser->email;
        $this->mobile = $singleUser->mobile;
        $this->gender = $singleUser->gender;
        $this->role = $singleUser->role_id;
        $this->type = $singleUser->accountDetail->type;
        $this->image = $singleUser->accountDetail->profile_image;
        $this->updateMode = true;
    }

    public function updated($field)
    {
        $validatedDate = $this->validateOnly($field, [
            'name' => 'required',
            'email' => 'required|email',
            'mobile' => 'required',
            'gender' => 'required',
            'role' => 'required'
        ]);
    }

    public function update()
    {
        $validatedDate = $this->validate([
            'name' => 'required',
            'email' => 'required|email',
            'mobile' => 'required',
            'gender' => 'required',
            'role' => 'required',
        ]);
        $image = $this->image;


        $user = User::find($this->user_id);
        $user->role_id = $this->role;
        $user->name = $this->name;
        $user->email = $this->email;
        $user->gender = $this->gender;
        $user->mobile = $this->mobile;
        $user->save();

        $this->updateMode = false;
        $this->viewUser = false;
        $message = 'User Updated Sucessfully.';
        session()->flash('message', $message);
        $this->resetInputFields();
        return redirect()->route("users");
    }

    private function resetInputFields()
    {
        $this->name = '';
        $this->email = '';
        $this->mobile = '';
        $this->gender = '';
        $this->role = '';
        $this->type = '';
        $this->password = '';
    }


    public function filter($type)
    {
        $this->filter = $type;
        $this->selected = $type;
    }

    public function banUser($id)
    {
        $this->validate();
        $user = User::find($id);
        $user->is_banned = 1;
        $user->save();
        $params = array(
            'to' => $user->email,
            'from' => env("MAIL_FROM_ADDRESS"),
            'fromname' => "Zeedlive",
            'subject' => "Account Banned",
            'text' => "Dear Mr/Ms. " . $user->name . " Your account is banned due to the following reason: " . $this->reason,
        );
        $this->sendMail($params);
        $message = 'User Banned Successfully.';
        if ($user->device_token) {
            $title = 'User Banned';
            $body = array(
                "notification_body" => "Your Account has been Banned",
                "type" => "ban",
            );
            $input = $this->sendNotification($user->device_token, $title, $body);
        }
        session()->flash('message','User Banned Successfully');
        $this->emit('alert_remove');
//        return redirect()->route('users');
    }

    public function unBan($id)
    {
        $user = User::find($id);
        $user->is_banned = 0;
        $user->save();
        $params = array(
            'to' => $user->email,
            'from' => env("MAIL_FROM_ADDRESS"),
            'fromname' => "Zeedlive",
            'subject' => "Account Activated",
            'text' => "Dear Mr/Ms. " . $user->name . " Your account is unbanned due to the following reason: " . $this->reason,
        );
        $this->sendMail($params);
        $message = 'User Unbanned Successfully.';
        if ($user->device_token) {
            $title = 'User Activated';
            $body = array(
                "notification_body" => "Your Account is Activated",
                "type" => "activated",
            );
            $input = $this->sendNotification($user->device_token, $title, $body);
        }
        session()->flash('message','User Activated Successfully');
        $this->emit('alert_remove');
//        return redirect()->route('users')->with('message', $message);
    }

}

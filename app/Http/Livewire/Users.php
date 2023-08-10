<?php
namespace App\Http\Livewire;
use CURLFile;
use App\Models\User;
use Livewire\Component;
use App\Helpers\baseUrl;
use Livewire\WithFileUploads;
use App\Helpers\MakeCurlRequest;
use App\Helpers\makeCurlFileRequest;
use Illuminate\Pagination\LengthAwarePaginator;

class Users extends Component
{
    use WithFileUploads;
    public $user_id, $name, $email, $mobile, $gender, $role, $password,$type,$image;
    public $viewUser = false;
    public $updateMode = false;
    public $userProfile;
    public $filterUser = false;
    public $filterType = '';
    protected $listeners = [
        'views'
    ];

    public function render()
    {
        $users = User::with('Role')->where("id", "<>", auth()->user()->id)->orderBy('users.id','desc')->get();
        $users_count = count($users);
        $users = User::with('Role')->where("id", "<>", auth()->user()->id)->orderBy('users.id','desc')->paginate(10);

        if(request()->userId)
        {
            $this->view(request()->userId);
        }
        if ($this->viewUser) {
            return view('livewire.users', [
                'users' => $users,
                'users_count' => $users_count,
                'viewUser' => $this->viewUser,
                'userProfile' => $this->userProfile,
                'filterType' => $this->filterType
            ]);
        } else {
            return view('livewire.users', compact('users', 'users_count'));
        }
    }

    public function delete($id)
    {
    $url = baseUrl()."delete/user/".$id;
    $data = makeCurlRequest($url, 'DELETE');
    if($data['success']==1)
    {
        $this->dispatchBrowserEvent('alert',
                ['type' => 'success',  'message' => ''.$data['Message'].'']);
    }
    }

    public function view($id)
    {
        $this->viewUser = true;
        $singleUser = User::with('Role')->where("id", $id)->first();

        $this->userProfile = $singleUser;
    }

    public function edit($id)
    {
        $singleUser =  User::with('Role')->where("id", $id)->first();

        $this->user_id =   $singleUser->id;
        $this->name = $singleUser->name;
        $this->email = $singleUser->email;
        $this->mobile = $singleUser->mobile;
        $this->gender = $singleUser->gender;
        $this->role = $singleUser->role_id;
        $this->type = $singleUser->accountDetail->type;
        $this->image = $singleUser->accountDetail->profile_image;
        $this->password = '';
        $this->updateMode = true;
    }

    public function updated($field)
    {
        $validatedDate = $this->validateOnly($field,[
            'name' => 'required',
            'email' => 'required|email',
            'mobile' => 'required',
            'gender' => 'required',
            'role' => 'required',
            'password' => 'required',
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
            'password' => 'required',
        ]);
        $image = $this->image;
        if(is_file($image))
        {
            $path = $image->getRealPath();
            $image = new \CURLFile($path, "image/jpeg",$image);
            $postData = [
                'role_id' => $this->role,
                'name' => $this->name,
                'email' => $this->email,
                'mobile' => $this->mobile,
                'gender' => $this->gender,
                'type' => $this->type,
                'password' => $this->password,
                'image' => $image,
            ];
        }
        else
        {
            $postData = [
                'role_id' => $this->role,
                'name' => $this->name,
                'email' => $this->email,
                'mobile' => $this->mobile,
                'gender' => $this->gender,
                'type' => $this->type,
                'password' => $this->password,
            ];
        }
        $url = baseUrl()."update/user/details/".$this->user_id;
        $data = makeCurlFileRequest($url, 'POST',$postData);
        if($data['success']==1)
        {
            $this->dispatchBrowserEvent('alert',
                    ['type' => 'success',  'message' => ''.$data['message'].'']);
        }
        $this->updateMode = false;
        $this->resetInputFields();
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

    public function filterUser($filterUser)
    {
    if($filterUser=='seller')
    {
      $filter = 'all/sellers';
      $key = 'User';
      $filterType='seller';
    }
    elseif($filterUser=='buyer')
    {
        $filter = 'all/buyers';
        $key = 'User';
        $filterType='buyer';
    }
    else
    {
        $filter = 'user/details';
        $key = 'Users';
        $filterType='all';
    }
    $url = baseUrl().$filter;
    $data = makeCurlRequest($url, 'GET');
    $this->filterUser = $data[$key];
    $this->filterType = $filterType;
    }


}

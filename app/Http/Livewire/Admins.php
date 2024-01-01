<?php

namespace App\Http\Livewire;

use App\Models\RolesPermissions;
use CURLFile;
use App\Models\Role;
use App\Models\User;
use Livewire\Component;
use App\Helpers\baseUrl;
use App\Models\AccountDetail;
use Livewire\WithFileUploads;
use App\Models\RolePermission;
use App\Helpers\MakeCurlRequest;
use Illuminate\Support\Facades\DB;
use App\Helpers\makeCurlFileRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\WithPagination;

class Admins extends Component
{
    use WithFileUploads,  withPagination;

    public $user_id, $name, $email, $mobile, $gender, $role, $password, $type,  $imageURL;
    public $permission = [];
    public $selectedPermssions = [];
    public $updateMode = false;
    public $addUser = false;
    public $rolePermission = false;
    public $search = '';
    public $role_id;

    public $image;

    public function render()
    {
//        dd('render',$this->image);
        //tes
        $query = User::where('is_deleted', 0)->where('is_admin', 1);

        if (!empty($this->search)) {
            $query->where('name', 'like', '%' . $this->search . '%');
        }
        $admins = $query->orderBy('id', 'desc');
        $admins_count = $admins->get()->count();
        $admins = $admins->paginate(10);
        $roles = Role::all();
        return view('livewire.admins', compact('admins', 'admins_count', 'roles'));
    }


    public function delete($id)
    {
        $user = User::where("id", $id)->first();
        $user->is_deleted = 1;
        $user->save();
        $message = 'Admin Deleted Successfully.';
        return redirect()->route('admins')->with('message', $message);
//        $url = baseUrl() . "delete/user/" . $id;
//        $data = makeCurlRequest($url, 'DELETE');
////        dd($data);
//        if ($data['success'] == 1) {
//            $this->dispatchBrowserEvent(
//                'alert',
//                ['type' => 'success', 'message' => '' . $data['Message'] . '']
//            );
//        }
    }

    public function edit($id)
    {
        $this->rolePermission = RolePermission::all();
        $user = User::where("id", $id)->first();
        $this->user_id = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->mobile = $user->mobile;
        $this->gender = $user->gender;
        $this->imageURL = $user->image;
        $this->role = $user->rank;
        $this->type = $user->type;
        $this->permission = [];
//        if ($user->account_detail->permissions != null && $user->account_detail->permissions != '"[]"') {
//            $permissions = json_decode($user->account_detail->permissions, true);
//            $decodedPermissions = json_decode($permissions, true);
//            foreach ($decodedPermissions as $permissionItem) {
//                $permissionKey = key($permissionItem);
//                $permissionValue = current($permissionItem);
//                $preCheckedValues[] = "{" . $permissionKey . ':' . $permissionValue[0] . "}";
//            }
//            $this->permission = $preCheckedValues;
//
//        }
        $this->image = null;
        $this->password = '';
        $this->updateMode = true;
        $this->addUser = false;
    }

    public function updated($field)
    {
        $validatedDate = $this->validateOnly($field, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'mobile' => 'required',
            'gender' => 'required',
            'password' => 'required',
        ]);
    }

    public function update()
    {
//        dd('here',$this->image);
        $validatedDate = $this->validate([
            'name' => 'required',
            'email' => 'required|email',
            'mobile' => 'required',
            'gender' => 'required',
            'role_id' => 'required'
        ]);

        if (is_null($this->user_id)) {
            $validatedDate = $this->validate([
                'password' => 'required'
            ]);
        }
//        dd($this->image);

        $role = Role::find($this->role_id);

        if (!$role) {
            dd("Role not found");
            return;
        }
        $permissions = RolesPermissions::where('role_id', $role->id)->value('permissions');
//        dd($permissions);
//
//        $array = json_decode($permissions, true);
////        dd($array);
//
//        $groupedArray = array();
//        foreach ($array as $element) {
//            // Ensure $element is a string before using preg_match
//            $element = is_string($element) ? $element : '';
//
//            preg_match('/^{(.+?):(.+?)}$/', $element, $matches);
//            $category = $matches[1] ?? '';
//            $action = $matches[2] ?? '';
//            if (!empty($category)) {
//                if (!array_key_exists($category, $groupedArray)) {
//                    $groupedArray[$category] = array();
//                }
//                array_push($groupedArray[$category], $action);
//            }
//        }
//
//        $json = json_encode(array_map(function ($k, $v) {
//            return array($k => $v);
//        }, array_keys($groupedArray), array_values($groupedArray)));
//
//        $permissions = json_encode($json);


//        $groupedArray = array();
//
//        foreach ($array as $category => $actions) {
//            foreach ($actions as $action) {
//                $element = '{' . $category . ':' . $action . '}';
//                array_push($groupedArray, $element);
//            }
//        }
//
//        $permissions = json_encode($groupedArray);

        try {
            DB::beginTransaction();

            if ($this->user_id != '') {
                $user = User::where("id", $this->user_id)->first();
                $accountDetail = AccountDetail::where("user_id", $this->user_id)->first();
            } else {
                $user = new User();
                $accountDetail = new AccountDetail();
            }

            $user->email = $this->email;
            $user->name = $this->name;

            if ($this->password) {
                $user->password = bcrypt($this->password);
            }

            $user->mobile = $this->mobile;
            $user->role_id = $role->id;
            $user->gender = $this->gender;
            $user->rank = Role::where('id', $role->id)->value('name');
            $user->save();

            $accountDetail->user_id = $user->id;

            if (isset($this->image)) {
                $uploadedFile = $this->image;
                $imageName = time() . '_' . $uploadedFile->getClientOriginalName();
                $imageName = Storage::disk('do')->put('zeed/users/profile/admin', $uploadedFile, "public");
                $user->image = $imageName;
                $accountDetail->profile_image = $imageName;
            }

            $user->is_admin = 1;
            $user->save();

            $accountDetail->permissions = $permissions;
            $accountDetail->save();

            $this->updateMode = false;
            $this->addUser = false;
            $this->resetInputFields();

            DB::commit();

            $message = 'User Updated Successfully.';
            session()->flash('message', $message);
        }

        catch (\Exception $th) {
            DB::rollBack();
            $this->dispatchBrowserEvent(
                'alert',
                ['type' => 'success', 'message' => $th->getMessage()]
            );
        }
    }


//    public function update()
//    {
//        $validatedDate = $this->validate([
//            'name' => 'required',
//            'email' => 'required|email',
//            'mobile' => 'required',
//            'gender' => 'required'
//        ]);
//        if ($this->user_id == '') {
//            $validatedDate = $this->validate([
//                'password' => 'required'
//            ]);
//        }
//
//        $array = $this->permission;
//        $groupedArray = array();
//        foreach ($array as $element) {
//            preg_match('/^{(.+?):(.+?)}$/', $element, $matches);
//            $category = $matches[1];
//            $action = $matches[2];
//            if (!array_key_exists($category, $groupedArray)) {
//                $groupedArray[$category] = array();
//            }
//            array_push($groupedArray[$category], $action);
//        }
//        $json = json_encode(array_map(function ($k, $v) {
//            return array($k => $v);
//        }, array_keys($groupedArray), array_values($groupedArray)));
//        $permissions = json_encode($json);
//        $image = $this->image;
//
//        $role = Role::where('name', "Admin")->first();
//        try {
//            DB::beginTransaction();
//            if ($this->user_id != '') {
//                $user = User::where("id", $this->user_id)->first();
//                $accountDetail = AccountDetail::where("user_id", $this->user_id)->first();
//            } else {
//                $user = new User();
//                $accountDetail = new AccountDetail();
//            }
//            $user->email = $this->email;
//            $user->name = $this->name;
//            if ($this->password) {
//                $user->password = bcrypt($this->password);
//            }
//            $user->mobile = $this->mobile;
//            $user->role_id = $role->id;
//            $user->gender = $this->gender;
//            $user->rank = "Admin";
//            $user->save();
//            $accountDetail->user_id = $user->id;
//            if (isset($this->image)) {
//                $uploadedFile = $this->image;
//                $imageName = time() . '_' . $uploadedFile->getClientOriginalName();
//                $imageName = Storage::disk('s3')->put('zeed/apis/users/profile', $uploadedFile, $imageName, "public");
//                $user->image = $imageName;
//                $accountDetail->profile_image = $imageName;
//            }
//            $user->is_admin = 1;
//            $user->save();
//            $accountDetail->permissions = $permissions;
//            $accountDetail->save();
//
//
//            $this->updateMode = false;
//            $this->addUser = false;
//            $this->resetInputFields();
//
//            DB::commit();
//        } catch (\Exception $th) {
//            DB::rollBack();
//            $this->dispatchBrowserEvent(
//                'alert',
//                ['type' => 'success', 'message' => $th->getMessage()]
//            );
//        }
//    }

    private function resetInputFields()
    {
        $this->name = '';
        $this->email = '';
        $this->mobile = '';
        $this->gender = '';
        $this->role = '';
        $this->type = '';
        $this->password = '';
        $this->user_id = '';
        $this->image = '';
    }

    public function add()
    {
        $this->rolePermission = RolePermission::all();
        $this->addUser = true;
    }
}

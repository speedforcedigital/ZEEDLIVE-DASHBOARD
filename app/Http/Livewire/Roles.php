<?php

namespace App\Http\Livewire;

use App\Models\AccountDetail;
use App\Models\Role;
use App\Models\RolePermission;
use App\Models\RolesPermissions;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithPagination;

class Roles extends Component
{
    use withPagination;
    public $updateMode = false;
    public $addRoles = false;

    public $imageURL, $name;
    public $rolePermission = false;

    public $selectedPermssions = [];

    public $permission = [];

    public $search = '';

    public $role_id;

    public function render()
    {
        $query = Role::query();

        if (!empty($this->search)) {
            $query->where('name', 'like', '%' . $this->search . '%');
        }
        $roles = $query->orderBy('id', 'desc');
        $roles_count = $roles->get()->count();
        $roles = $roles->paginate(10);
        return view('livewire.roles', compact('roles', 'roles_count'));
    }

    public function addRoles()
    {
        $this->rolePermission = RolePermission::all();
        $this->addRoles = true;
    }

    public function edit($id)
    {
        $this->rolePermission = RolePermission::all();
        $role = Role::findOrFail($id);
        $this->role_id = $role->id;
        $this->name = $role->name;
        $role = RolesPermissions::where('role_id', $id)->first();

        if ($role == null) {
            $this->permission = [];
        } else {

//        $this->permission = [];
            if ($role->permissions != null && $role->permissions != '"[]"') {
                $permissions = json_decode($role->permissions, true);
                $decodedPermissions = json_decode($permissions, true);
//            dd($decodedPermissions);
                foreach ($decodedPermissions as $permissionItem) {
                    $permissionKey = key($permissionItem);
                    $permissionValue = current($permissionItem);

                    if (is_array($permissionValue)) {
                        foreach ($permissionValue as $value) {
                            $preCheckedValues[] = "{" . $permissionKey . ':' . $value . "}";
                        }
                    } else {
                        $preCheckedValues[] = "{" . $permissionKey . ':' . $permissionValue . "}";
                    }

//                $preCheckedValues[] = "{" . $permissionKey . ':' . $permissionValue[0] . "}";
//                dd($preCheckedValues);
                }
                $this->permission = $preCheckedValues;

            }

        }

        $this->updateMode = true;
        $this->addRoles = false;
    }


//    public function edit($id)
//    {
//        $this->rolePermission = RolePermission::all();
//        $role = Role::findOrFail($id);
//        $this->role_id = $role->id;
//        $this->name = $role->name;
//        $role = RolesPermissions::where('role_id', $id)->first();
////        $this->permission = [];
//        $preCheckedValues = [];
//        if ($role->permissions != null && $role->permissions != '"[]"') {
//            $permissions = json_decode($role->permissions, true);
//            $decodedPermissions = json_decode($permissions, true);
//
//            foreach ($decodedPermissions as $permissionItem) {
//                $permissionKey = key($permissionItem);
//                $permissionValue = current($permissionItem);
////                dd($permissionKey, $permissionValue);
//
//                // If $permissionValue is an array, loop through it
//                if (is_array($permissionValue)) {
////                    dd($permissionValue);
//                    foreach ($permissionValue as $value) {
//                        $preCheckedValues[] = "{\"$permissionKey\":$value}";
////                        dump($preCheckedValues);
//                    }
//                } else {
//                    $preCheckedValues[] = "{\"$permissionKey\":$permissionValue}";
//                }
//            }
//            $this->selectedPermssions = $preCheckedValues;
////            dd($this->permission);
//        }
//
//        $this->updateMode = true;
//        $this->addRoles = false;
//    }


    public function update()
    {
        $validatedData = $this->validate([
            'name' => 'required',
        ]);

        $array = $this->permission;
//        dd($array);
        $groupedArray = [];

        foreach ($array as $element) {
            preg_match('/^{(.+?):(.+?)}$/', $element, $matches);
            $category = $matches[1];
            $action = $matches[2];
            if (!array_key_exists($category, $groupedArray)) {
                $groupedArray[$category] = [];
            }
            array_push($groupedArray[$category], $action);
        }

        $permissions = json_encode(array_map(function ($k, $v) {
            return [$k => $v];
        }, array_keys($groupedArray), array_values($groupedArray)));
//        dd($permissions);


        $permissions = addslashes($permissions);
        $permissions = '"' . $permissions . '"';
//        dd($permissions);


        try {
//            DB::beginTransaction();

            if ($this->role_id) {
//                dd('Role ID is not null');
                // If role_id is not null, update the existing role
                $role = Role::find($this->role_id);
                $role->update(['name' => $this->name]);

                $rolePermission = RolesPermissions::where('role_id', $this->role_id)->first();
//                dd($rolePermission);
                if ($rolePermission) {
                    $rolePermission->update(['permissions' => null]);
//                    dd('Permissions set to null');
                    $rolePermission->update(['permissions' => $permissions]);
                }

                $users = User::where('role_id', $this->role_id)->get();
//                dd($users);
                foreach ($users as $user) {
                    $user->accountDetails->update(['permissions' => null]);
                    $user->accountDetails->update(['permissions' => $permissions]);
                }

            } else {
//                dd('Role ID is null');
                // If role_id is null, create a new role
                $role = Role::create(['name' => $this->name]);

                RolesPermissions::create([
                    'role_id' => $role->id,
                    'permissions' => $permissions
                ]);
            }

//            DB::commit();

            $this->updateMode = false;
            $this->addRoles = false;
            $this->resetInputFields();
            $this->dispatchBrowserEvent(
                'alert',
                ['type' => 'success', 'message' => 'Role ' . ($this->role_id ? 'Updated' : 'Created') . ' Successfully']
            );
        } catch (\Exception $th) {
//            DB::rollBack();
            $this->dispatchBrowserEvent(
                'alert',
                ['type' => 'success', 'message' => $th->getMessage()]
            );
        }
    }


    private function resetInputFields()
    {
        $this->name = '';
    }


}

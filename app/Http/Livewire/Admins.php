<?php
namespace App\Http\Livewire;
use App\Helpers\MakeCurlRequest;
use App\Helpers\makeCurlFileRequest;
use App\Helpers\baseUrl;
use Livewire\Component;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\WithFileUploads;
use CURLFile;
class Admins extends Component
{
    use WithFileUploads;
    public $user_id, $name, $email, $mobile, $gender, $role, $password,$type,$image;
    public $permission = [];
    public $updateMode = false;
    public $addUser = false;
    public $rolePermission = false;
    public function render()
    {
    $url = baseUrl().'all/users';
    $data = makeCurlRequest($url, 'GET');
    $admins = $data['User'];
    $admins_count = count($admins); 
    //pagination
    $page = request()->query('page', 1);
    $perPage = 10;
    $admins = new LengthAwarePaginator(
        array_slice($admins, ($page - 1) * $perPage, $perPage),
        count($admins),
        $perPage,
        $page,
        [
            'path' => request()->url(),
            'query' => request()->query()
        ]
    );
        return view('livewire.admins', compact('admins', 'admins_count'));
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

    public function edit($id)
    {
        $url = baseUrl().'get/rollPermission';
        $data = makeCurlRequest($url, 'GET');
        $this->rolePermission = $data['data'];
        $url = baseUrl()."user/details/".$id;
        $data = makeCurlRequest($url, 'GET');
        $singleUser = $data['User'];
        $this->user_id =   $singleUser['id'];
        $this->name = $singleUser['name'];
        $this->email = $singleUser['email'];
        $this->mobile = $singleUser['mobile'];
        $this->gender = $singleUser['gender'];
        $this->role = $singleUser['rank'];
        $this->type = $singleUser['accountDetail']['type'];
        $this->image = $singleUser['accountDetail']['profile_image'];
        $this->password = '';
        $this->updateMode = true;
        $this->addUser = false;
    }

    public function updated($field)
    {
        $validatedDate = $this->validateOnly($field,[
            'name' => 'required',
            'email' => 'required',
            'mobile' => 'required',
            'gender' => 'required',
            'password' => 'required',
        ]);
    }

    public function update()
    {
        $validatedDate = $this->validate([
            'name' => 'required',
            'email' => 'required',
            'mobile' => 'required',
            'gender' => 'required',
            'password' => 'required',
        ]);

        $array = $this->permission;
        $groupedArray = array();
        foreach ($array as $element) {
            preg_match('/^{(.+?):(.+?)}$/', $element, $matches); 
            $category = $matches[1];
            $action = $matches[2];
            if (!array_key_exists($category, $groupedArray)) {
                $groupedArray[$category] = array(); 
            }
            array_push($groupedArray[$category], $action);
        }
        $json = json_encode(array_map(function($k, $v) { return array($k => $v); }, array_keys($groupedArray), array_values($groupedArray)));
        $permissions = json_encode($json);
        
         $image = $this->image;
         $path = $image->getRealPath();
         $postData = [
             'role' => 'Admin',
             'name' => $this->name,
             'email' => $this->email,
             'mobile' => $this->mobile,
             'gender' => $this->gender,
             'type' => $this->type,
             'password' => $this->password,
             'permissions' => $permissions,
             'image' => new \CURLFile($path, "image/jpeg",$image),
         ];
        $url = ($this->user_id) ? baseUrl()."update/user/details/".$this->user_id : baseUrl()."create/users";
        $data = makeCurlFileRequest($url, 'POST',$postData);
        if($data['success']==1)
        {
            $this->dispatchBrowserEvent('alert', 
                    ['type' => 'success',  'message' => ''.$data['message'].'']);
        }
        $this->updateMode = false;
        $this->addUser = false;
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
        $this->user_id='';
        $this->image='';
    }

    public function add()
    {
        $url = baseUrl().'get/rollPermission';
        $data = makeCurlRequest($url, 'GET');
        $this->rolePermission = $data['data'];
        $this->addUser = true;
    }

}

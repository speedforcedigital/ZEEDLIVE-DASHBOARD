<?php
namespace App\Http\Livewire;
use App\Helpers\MakeCurlRequest;
use App\Helpers\makeCurlFileRequest;
use App\Helpers\baseUrl;
use Livewire\Component;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\WithFileUploads;
use CURLFile;
class Users extends Component
{
    use WithFileUploads;
    public $user_id, $name, $email, $mobile, $gender, $role, $password,$type,$image;
    public $viewUser = false;
    public $updateMode = false;
    public $filterUser = false;
    public $filterType = '';

    public function render()
    {
    $url = baseUrl().'user/details';
    $data = makeCurlRequest($url, 'GET');
    if($this->filterUser || $this->filterType)
    {
        $users = $this->filterUser;
        $users_count = count($users);
    }
    else
    {
        $users = $data['Users'];
        $users_count = count($users); 
    }
    //pagination
    $page = request()->query('page', 1);
    $perPage = 10;
    $users = new LengthAwarePaginator(
        array_slice($users, ($page - 1) * $perPage, $perPage),
        count($users),
        $perPage,
        $page,
        [
            'path' => request()->url(),
            'query' => request()->query()
        ]
    );
    if($this->viewUser)
    {
        return view('livewire.users', [
            'users' => $users, 
            'users_count' => $users_count, 
            'viewUser' => $this->viewUser, 
            'userProfile' => $this->userProfile,
            'filterType' => $this->filterType
        ]);
    }
    else
    {
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
        $url = baseUrl()."user/details/".$id;
        $data = makeCurlRequest($url, 'GET');
        $this->userProfile = $data['User'];
    }

    public function edit($id)
    {
        $url = baseUrl()."user/details/".$id;
        $data = makeCurlRequest($url, 'GET');
        $singleUser = $data['User'];
        $this->user_id =   $singleUser['id'];
        $this->name = $singleUser['name'];
        $this->email = $singleUser['email'];
        $this->mobile = $singleUser['mobile'];
        $this->gender = $singleUser['gender'];
        $this->role = $singleUser['role_id'];
        $this->type = $singleUser['accountDetail']['type'];
        $this->image = $singleUser['accountDetail']['profile_image'];
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

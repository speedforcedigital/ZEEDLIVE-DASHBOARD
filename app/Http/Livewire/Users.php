<?php
namespace App\Http\Livewire;
use App\Helpers\MakeCurlRequest;
use App\Helpers\makeCurlPostRequest;
use App\Helpers\baseUrl;
use Livewire\Component;
use Illuminate\Pagination\LengthAwarePaginator;
class Users extends Component
{
    public $user_id, $name, $email, $mobile, $gender, $role, $password;
    public $viewUser = false;
    public $updateMode = false;
    public $filterUser = false;
    public $filterType = '';

    public function render()
    {
    $url = baseUrl().'user/details';
    $data = makeCurlRequest($url, 'GET');
    if($this->filterUser)
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
        $this->password = '';
        $this->updateMode = true;
    }

    public function updated($field)
    {
        $validatedDate = $this->validateOnly($field,[
            'name' => 'required',
            'email' => 'required',
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
            'email' => 'required',
            'mobile' => 'required',
            'gender' => 'required',
            'role' => 'required',
            'password' => 'required',
        ]);
         $postData['role_id'] = $this->role;
         $postData['name'] = $this->name;
         $postData['email'] = $this->email;
         $postData['mobile'] = $this->mobile;
         $postData['gender'] = $this->gender;
         $postData['password'] = $this->password;
        //  echo "<pre>";print_r($postData);die();
         $postData = json_encode($postData);
        $url = baseUrl()."update/user/details/".$this->user_id;
        $data = makeCurlPostRequest($url, 'POST',$postData);
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

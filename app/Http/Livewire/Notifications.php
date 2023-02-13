<?php
namespace App\Http\Livewire;
use App\Helpers\MakeCurlRequest;
use App\Helpers\makeCurlPostRequest;
use App\Helpers\baseUrl;
use Livewire\Component;
use Illuminate\Pagination\LengthAwarePaginator;
class Notifications extends Component
{
    public $notification_id, $title, $body;
    public $addNotification = false;
    public $updateMode = false;
    public function render()
    {
    $url = baseUrl().'get/push/notification';
    $data = makeCurlRequest($url, 'GET');
    $notification = $data['report'];
    $total_notification = count($notification);
    //pagination
    $page = request()->query('page', 1);
    $perPage = 10;
    $notification = new LengthAwarePaginator(
        array_slice($notification, ($page - 1) * $perPage, $perPage),
        count($notification),
        $perPage,
        $page,
        [
            'path' => request()->url(),
            'query' => request()->query()
        ]
    );
        return view('livewire.notifications', compact('notification', 'total_notification'));
    }

    public function add()
    {
        $this->addNotification = true;
    }
    public function updated($field)
    {
        $validatedDate = $this->validateOnly($field,[
            'title' => 'required',
            'body' => 'required',
        ]);
    }
    public function addNotification()
    {
        $validatedDate = $this->validate([
            'title' => 'required',
            'body' => 'required',
        ]);
         $postData['notification_title'] = $this->title;
         $postData['notification_body'] = $this->body;
         $postData = json_encode($postData);
        $url = ($this->notification_id) ? baseUrl()."edit/push/notification/".$this->notification_id : baseUrl()."add/push/notification";
        $data = makeCurlPostRequest($url, 'POST',$postData);
        if($data['success']=true)
        {
            $this->dispatchBrowserEvent('alert', 
                    ['type' => 'success',  'message' => ''.$data['message'].'']);
        }
        $this->addNotification = false;
        $this->updateMode = false;
        $this->resetInputFields();
    }
    private function resetInputFields()
    {
        $this->title = '';
        $this->body = '';
        $this->notification_id = '';
    }
    public function delete($id)
    { 
    $url = baseUrl()."delete/push/notification/".$id;
    $data = makeCurlRequest($url, 'DELETE');
    if($data['success']=true)
    {
        $this->dispatchBrowserEvent('alert', 
                ['type' => 'success',  'message' => ''.$data['Message'].'']);
    }
    }
    public function edit($id)
    {
        $url = baseUrl()."get/pushNoitification/detail/".$id;
        $data = makeCurlRequest($url, 'GET');
        // echo "<pre>";print_r($data);die();
        $singleNotification = $data['report'];
        $this->notification_id =   $singleNotification[0]['id'];
        $this->title = $singleNotification[0]['title'];
        $this->body = $singleNotification[0]['body'];
        $this->updateMode = true;
    } 
}

<?php
namespace App\Http\Livewire;
use App\Helpers\MakeCurlRequest;
use App\Helpers\makeCurlPostRequest;
use App\Helpers\baseUrl;
use Livewire\Component;
use Illuminate\Pagination\LengthAwarePaginator;
class customFields extends Component
{
    public $custom_field_title, $category_id, $type;
    public $addCustomField = false;
    public $updateMode = false;
    public $categoryList = false;
    public $fields = [];
    public function render()
    {
    $url = baseUrl().'get/customFields/all';
    $data = makeCurlRequest($url, 'GET');
    $customfields = $data['data']['customFields'];
    $customfields_count = count($customfields); 
    //pagination
    $page = request()->query('page', 1);
    $perPage = 10;
    $customfields = new LengthAwarePaginator(
        array_slice($customfields, ($page - 1) * $perPage, $perPage),
        count($customfields),
        $perPage,
        $page,
        [
            'path' => request()->url(),
            'query' => request()->query()
        ]
    );
    
        return view('livewire.customfields', compact('customfields', 'customfields_count'));
     
    }

    public function add()
    {
        $url = baseUrl().'list/category';
        $categoryList = makeCurlRequest($url, 'GET');
        $this->categoryList = $categoryList;
        $this->addCustomField = true;
    }

    public function updated($field)
    {
        $validatedDate = $this->validateOnly($field,[
            'custom_field_title' => 'required',
            'category_id' => 'required',
            'type' => 'required',
        ]);
    }

    public function addCustomField()
    {
        $validatedDate = $this->validate([
            'custom_field_title' => 'required',
            'category_id' => 'required',
            'type' => 'required',
        ]);
        $postData['custom_field_title'] = $this->custom_field_title;
        $postData['category_id'] = $this->category_id;
        $postData['type'] = $this->type;
        $postData['values'] = json_encode($this->fields);
        $postData = json_encode($postData);
        $url = baseUrl()."add/customFields";
        $data = makeCurlPostRequest($url, 'POST',$postData);
        if($data['success']=true)
        {
            $this->dispatchBrowserEvent('alert', 
                    ['type' => 'success',  'message' => ''.$data['message'].'']);
        }
        $this->addCustomField = false;
        $this->resetInputFields();


    }
    private function resetInputFields()
    {
        $this->custom_field_title = '';
        $this->category_id = '';
        $this->type = '';
    }

    public function delete($id)
    { 
    $url = baseUrl()."delete/dynamicField/custom/".$id;
    $data = makeCurlRequest($url, 'DELETE');
    if($data['success']=true)
    {
        $this->dispatchBrowserEvent('alert', 
                ['type' => 'success',  'message' => ''.$data['message'].'']);
    }
    }

    public function addField()
    {
        $this->fields[] = '';
    }

    public function removeField($index)
    {
        unset($this->fields[$index]);
        $this->fields = array_values($this->fields);
    }
    
}

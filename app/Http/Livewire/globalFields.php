<?php
namespace App\Http\Livewire;
use App\Helpers\MakeCurlRequest;
use App\Helpers\makeCurlPostRequest;
use App\Helpers\baseUrl;
use Livewire\Component;
use Illuminate\Pagination\LengthAwarePaginator;
class globalFields extends Component
{
    public $global_field;
    public $addGlobalField = false;
    public $updateMode = false;
    public $fields = [];
    public function render()
    {
    $url = baseUrl().'get/globalFields';
    $data = makeCurlRequest($url, 'GET');
    $globalfields = $data['data']['globalFields'];
    $globalfields_count = count($globalfields); 
    //pagination
    $page = request()->query('page', 1);
    $perPage = 10;
    $globalfields = new LengthAwarePaginator(
        array_slice($globalfields, ($page - 1) * $perPage, $perPage),
        count($globalfields),
        $perPage,
        $page,
        [
            'path' => request()->url(),
            'query' => request()->query()
        ]
    );
    
        return view('livewire.globalfields', compact('globalfields', 'globalfields_count'));
     
    }

    public function add()
    {
        $this->addGlobalField = true;
    }

    public function updated($field)
    {
        $validatedDate = $this->validateOnly($field,[
            'global_field' => 'required',
        ]);
    }

    public function addGlobalField()
    {
        $validatedDate = $this->validate([
            'global_field' => 'required',
        ]);

        $postData['global_field'] = $this->global_field;
        $postData['values'] = json_encode($this->fields);
        $postData = json_encode($postData);
        $url = baseUrl()."add/globalFields";
        $data = makeCurlPostRequest($url, 'POST',$postData);
        if($data['success']=true)
        {
            $this->dispatchBrowserEvent('alert', 
                    ['type' => 'success',  'message' => ''.$data['message'].'']);
        }
        $this->addGlobalField = false;
        $this->resetInputFields();


    }
    private function resetInputFields()
    {
        $this->global_field = '';
    }

    public function delete($id)
    { 
    $url = baseUrl()."delete/dynamicField/global/".$id;
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

<?php
namespace App\Http\Livewire;
use App\Helpers\MakeCurlRequest;
use App\Helpers\makeCurlPostRequest;
use App\Helpers\makeCurlFileRequest;
use App\Helpers\baseUrl;
use Livewire\Component;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\WithFileUploads;
class Models extends Component
{
    use WithFileUploads;
    public  $model_id, $brand_id, $name, $image;
    public $addModel = false;
    public $updateMode = false;
    public $brandList = false;
    public function render()
    {
    $url = baseUrl().'list/modal';
    $data = makeCurlRequest($url, 'GET');
    $modals = $data['modals'];
    $total_model = $data['total_model'];
    //pagination
    $page = request()->query('page', 1);
    $perPage = 10;
    $modals = new LengthAwarePaginator(
        array_slice($modals, ($page - 1) * $perPage, $perPage),
        count($modals),
        $perPage,
        $page,
        [
            'path' => request()->url(),
            'query' => request()->query()
        ]
    );
        return view('livewire.models', compact('modals', 'total_model'));
    }

    public function add()
    {
        $url = baseUrl().'list/brand';
        $brandList = makeCurlRequest($url, 'GET');
        $this->brandList = $brandList;
        $this->addModel = true;
    }
    public function updated($field)
    {
        $validatedDate = $this->validateOnly($field,[
            'brand_id' => 'required',
            'name' => 'required',
            'image' => 'required',
        ]);
    }
    public function addModal()
    {
        $validatedDate = $this->validate([
            'brand_id' => 'required',
            'name' => 'required',
            'image' => 'required',
        ]);
        $image = $this->image;
        $path = $image->getRealPath();
        $postData = [
            'brand_id' => $this->brand_id,
            'name' => $this->name,
            'image' => new \CURLFile($path, "image/jpeg",$image),
        ];
        $url = ($this->model_id) ? baseUrl()."edit/modal/".$this->model_id : baseUrl()."add/modal";
        $data = makeCurlFileRequest($url, 'POST',$postData);
        if($data['success']=true)
        {
            $this->dispatchBrowserEvent('alert', 
                    ['type' => 'success',  'message' => ''.$data['message'].'']);
        }
        $this->addModel = false;
        $this->updateMode = false;
        $this->resetInputFields();
    }
    private function resetInputFields()
    {
        $this->model_id = '';
        $this->name = '';
        $this->image = '';
        $this->brand_id = '';
    }
    
    public function delete($id)
    {  
    $url = baseUrl()."delete/modal/".$id;
    $data = makeCurlRequest($url, 'DELETE');
    if($data['success']=true)
    {
        $this->dispatchBrowserEvent('alert', 
                ['type' => 'success',  'message' => ''.$data['message'].'']);
    }
    }

    public function edit($id)
    {
        $url = baseUrl()."modal/details/".$id;
        $data = makeCurlRequest($url, 'GET');
        $singleModel = $data['modals'];
        $this->model_id =   $singleModel['id'];
        $this->brand_id =   $singleModel['brand_id'];
        $this->name = $singleModel['name'];
        $this->image = $singleModel['image'];
        $url = baseUrl().'list/brand';
        $brandList = makeCurlRequest($url, 'GET');
        $this->brandList = $brandList;
        $this->updateMode = true;
    } 
   
}

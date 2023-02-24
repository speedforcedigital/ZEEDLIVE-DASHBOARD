<?php
namespace App\Http\Livewire;
use App\Helpers\MakeCurlRequest;
use App\Helpers\makeCurlPostRequest;
use App\Helpers\makeCurlFileRequest;
use App\Helpers\baseUrl;
use Livewire\Component;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\WithFileUploads;
use CURLFile;
class Categories extends Component
{
    use WithFileUploads;
    public $category_id, $name, $image;
    public $addCategory = false;
    public $updateMode = false;
    public function render()
    {
    $url = baseUrl().'list/category';
    $data = makeCurlRequest($url, 'GET');
    $categories = $data['Categories'];
    $total_categories = $data['total_category'];
    //pagination
    $page = request()->query('page', 1);
    $perPage = 10;
    $categories = new LengthAwarePaginator(
        array_slice($categories, ($page - 1) * $perPage, $perPage),
        count($categories),
        $perPage,
        $page,
        [
            'path' => request()->url(),
            'query' => request()->query()
        ]
    );
        return view('livewire.categories', compact('categories', 'total_categories'));
    }

    public function add()
    {
        $this->addCategory = true;
    }
    public function updated($field)
    {
        $validatedDate = $this->validateOnly($field,[
            'name' => 'required',
            'image' => 'required',
        ]);
    }
    public function addCategory()
    {
        $validatedDate = $this->validate([
            'name' => 'required',
            'image' => 'required',
        ]);
        $image = $this->image;
        if(is_file($image)) 
        {
        $path = $image->getRealPath();
        $image = new \CURLFile($path, "image/jpeg",$image);
        $postData = [
            'name' => $this->name,
            'image' => $image,
        ];
        } 
        else 
        {
        $postData = [
            'name' => $this->name,
        ];
        }
        $url = ($this->category_id) ? baseUrl()."edit/category/".$this->category_id : baseUrl()."add/category";
        $data = makeCurlFileRequest($url, 'POST',$postData);
        if($data['success']=true)
        {
            $this->dispatchBrowserEvent('alert', 
                    ['type' => 'success',  'message' => ''.$data['Message'].'']);
        }
        $this->addCategory = false;
        $this->updateMode = false;
        $this->resetInputFields();
    }
    private function resetInputFields()
    {
        $this->name = '';
        $this->image = '';
        $this->category_id = '';
    }
    public function delete($id)
    { 
    $url = baseUrl()."delete/category/".$id;
    $data = makeCurlRequest($url, 'DELETE');
    if($data['success']=true)
    {
        $this->dispatchBrowserEvent('alert', 
                ['type' => 'success',  'message' => ''.$data['message'].'']);
    }
    }
    public function edit($id)
    {
        $url = baseUrl()."category/details/".$id;
        $data = makeCurlRequest($url, 'GET');
        $singleCategory = $data['Categories'];
        $this->category_id =   $singleCategory['id'];
        $this->name = $singleCategory['name'];
        $this->image = $singleCategory['image'];
        $this->updateMode = true;
    } 
}

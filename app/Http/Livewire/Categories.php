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
use App\Models\Category;

class Categories extends Component
{
    use WithFileUploads;
    public $category_id, $name, $image;
    public $addCategory = false;
    public $updateMode = false;
    public function render()
    {
        $perPage = 10;
        $categories = Category::paginate($perPage);
        $total_categories = Category::count();
    
        return view('livewire.categories', compact('categories', 'total_categories'));    
    }

    public function add()
    {
        return redirect()->route('categories.add');
    }
    public function updated($field)
    {
        $validatedDate = $this->validateOnly($field,[
            'name' => 'required',
            'image' => 'nullable',
        ]);
    }
    public function addCategory()
    {
        $validatedData = $this->validate([
            'name' => 'required',
            'image' => 'nullable',
        ]);

        $image = $this->image;
        if (is_file($image)) {
            $path = $image->getRealPath();
            $image = new \CURLFile($path, "image/jpeg", $image);
            $postData = [
                'name' => $this->name,
                'image' => $image,
            ];
        } else {
            $postData = [
                'name' => $this->name,
            ];
        }

        $url = ($this->category_id) ? baseUrl() . "edit/category/" . $this->category_id : baseUrl() . "add/category";
        $data = makeCurlFileRequest($url, 'POST', $postData);

        if (isset($data['success']) && $data['success'] == true) {
            $message = isset($data['Message']) ? $data['Message'] : 'Category added successfully.';
            $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => $message]);
        } else {
            $message = isset($data['Message']) ? $data['Message'] : 'Failed to add category. Please try again.';
            $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => $message]);
        }

        $this->addCategory = false;
        $this->updateMode = false;
        $this->resetInputFields();

        return View::make('components.categories.add-category');
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

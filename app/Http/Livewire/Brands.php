<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;
use App\Models\Brand;
use App\Models\Category;
use Livewire\WithPagination;

class Brands extends Component
{
    use WithFileUploads,  withPagination;

    public $brand_id, $name, $image, $category_id;
    public $addBrand = false;
    public $updateMode = false;
    public $categoryList = [];

    public function render()
    {
        $perPage = 10;
        $brands = Brand::paginate($perPage);
        $total_brand = Brand::count();
        $this->categoryList = Category::pluck('name', 'id')->toArray();

        return view('livewire.brands', compact('brands', 'total_brand'));
    }

    public function updated($field)
    {
        $this->validateOnly($field, [
            'name' => 'required',
            'image' => 'required',
            'category_id' => 'required',
        ]);
    }


    public function addBrand()
    {
        $validatedData = $this->validate([
            'name' => 'required',
            'image' => 'required',
            'category_id' => 'required',
        ]);

        $image = $this->image;
        if (is_file($image)) {
            $path = $image->getRealPath();
            $image = new \CURLFile($path, "image/jpeg", $image);
            $postData = [
                'category_id' => $this->category_id,
                'name' => $this->name,
                'image' => $image,
            ];
        } else {
            $postData = [
                'category_id' => $this->category_id,
                'name' => $this->name,
            ];
        }

        $brand = Brand::find($this->brand_id);
        if ($brand) {
            $brand->update($postData);
        } else {
            $brand = Brand::create($postData);
        }

        if ($brand) {
            $this->dispatchBrowserEvent('alert', [
                'type' => 'success',
                'message' => 'Brand saved successfully!',
            ]);
        }

        $this->addBrand = false;
        $this->updateMode = false;
        $this->resetInputFields();
    }

    public function add()
    {
        $this->addBrand = true;
        $this->categoryList = Category::pluck('name', 'id')->toArray();
        $this->emit('addBrand', $categoryList);
    }

    private function resetInputFields()
    {
        $this->brand_id = '';
        $this->name = '';
        $this->image = '';
        $this->category_id = '';
    }

    public function delete($id)
    {
        $brand = Brand::find($id);
        if ($brand) {
            $brand->delete();
            $this->dispatchBrowserEvent('alert', [
                'type' => 'success',
                'message' => 'Brand deleted successfully!',
            ]);
        }
    }

    public function edit($id)
    {
        $brand = Brand::find($id);
        if ($brand) {
            $this->brand_id = $brand->id;
            $this->category_id = $brand->category_id;
            $this->name = $brand->name;
            $this->image = $brand->image;

            $this->categoryList = Category::all()->toArray();

            $this->updateMode = true;
        }
    }
}

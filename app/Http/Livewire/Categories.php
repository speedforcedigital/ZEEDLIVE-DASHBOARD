<?php

namespace App\Http\Livewire;

use App\Models\Category;
use App\Models\Brand;
use App\Models\Model;
use Livewire\Component;

class Categories extends Component
{
    public $category_id, $name, $image;
    public $addCategory = false;
    public $updateMode = false;
    public $selectedCategory;
    public $selectedBrand;
    public $selectedModel;

    public function render()
    {
        $perPage = 10;
        $categories = Category::paginate($perPage);
        $total_categories = Category::count();

        return view('livewire.categories', [
            'categories' => $categories,
            'total_categories' => $total_categories
        ]);
    }

    public function add()
    {
        $this->addCategory = true;
    }

    public function updated($field)
    {
        $this->validateOnly($field, [
            'name' => 'required',
            'image' => 'nullable|image',
        ]);
    }

    public function addCategory()
    {
        $validatedData = $this->validate([
            'name' => 'required',
            'image' => 'nullable|image',
        ]);

        // Save category to the database
        $category = new Category();
        $category->name = $this->name;
        $category->image = $this->image->store('categories', 'public');
        $category->save();

        $message = 'Category added successfully.';
        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => $message]);

        $this->addCategory = false;
        $this->resetInputFields();
    }

    private function resetInputFields()
    {
        $this->name = '';
        $this->image = null;
        $this->category_id = null;
    }

    public function delete($id)
    {
        // Delete category from the database
        Category::find($id)->delete();

        $this->dispatchBrowserEvent('alert', [
            'type' => 'success',
            'message' => 'Category deleted successfully.'
        ]);
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        $this->category_id = $category->id;
        $this->name = $category->name;
        $this->image = null; // Assuming you don't want to display the current image in the form
        $this->updateMode = true;
    }

    public function cancelEdit()
    {
        $this->updateMode = false;
        $this->resetInputFields();
    }

    public function selectCategory($category)
    {
        $this->selectedCategory = $category;
        $this->selectedBrand = null;
        $this->selectedModel = null; // Reset the selected model when a new category is selected
    }

    public function selectBrand($brand)
    {
        $this->selectedBrand = $brand;
        $this->selectedModel = null; // Reset the selected model when a new brand is selected
    }

    public function selectModel($model)
    {
        $this->selectedModel = $model;
    }
}
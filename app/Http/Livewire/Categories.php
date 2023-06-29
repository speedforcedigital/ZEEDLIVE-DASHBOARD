<?php

namespace App\Http\Livewire;

use App\Models\Category;
use App\Models\Brand;
use App\Models\Modal;
use Livewire\Component;

class Categories extends Component
{
    public $category_id, $name, $image;
    public $addCategory = false;
    public $updateMode = false;
    public $selectedCategory;
    public $selectedBrand;
    public $selectedModal;
    public $categories;
    public $selectedBrandId;

    protected $rules = [
        'name' => 'required',
        'selectedCategory' => 'required',
        'selectedBrand' => 'required',
    ];

    public function mount()
    {
        $this->categories = Category::with('brands.modals')->get();
    }

    public function render()
    {
        $perPage = 10;
        $categoriesPaginate = Category::paginate($perPage);
        $total_categories = Category::count();

        return view('livewire.categories', [
            'categories' => $this->categories,
            'categoriesPaginate' => $categoriesPaginate,
            'total_categories' => $total_categories,
            'selectedCategory' => $this->selectedCategory,
            'selectedBrandId' => $this->selectedBrandId, // Add this line
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

    public function selectCategory($categoryId)
    {
        $this->selectedCategory = $this->categories->firstWhere('id', $categoryId);
        $this->selectedBrand = null;
        $this->selectedModal = null;
    }

    public function selectBrand($brandId)
    {
        $this->selectedBrandId = $brandId;
        $this->selectedBrand = $this->selectedCategory->brands->firstWhere('id', $brandId);
        $this->selectedModal = null;
    }

    public function selectModal($modalId)
    {
        $this->selectedModal = $this->selectedBrand->modals->firstWhere('id', $modalId);
    }

    public function resetSelection()
    {
        $this->selectedCategory = null;
        $this->selectedBrand = null;
        $this->selectedModal = null;
    }

}
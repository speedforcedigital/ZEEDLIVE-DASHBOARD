<?php

namespace App\Http\Livewire;

use App\Models\Category;
use App\Models\Brand;
use App\Models\Modal;

use Livewire\Component;

class CategoryManager extends Component
{

    public $category_id, $name, $image;
    public $addCategory = false;
    public $updateMode = false;
    public $selectedCategory = null;
    public $selectedBrand;
    public $categories;
    public $selectedBrandId;
    public $modalOpen = false;
    public $newCategoryName = null;
    public $isEditing = false;
    public $categoryName = null; // Add this line
    public $brandName = null; // Add this line
    public $modalName = null;
    public $selectedModal = null; 
    public $removeCategoryId = null;
    public $collectionsCount = 0;

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
        return view('livewire.category-manager', [
            'categories' => $this->categories,
            'selectedCategory' => $this->selectedCategory,
            'selectedBrand' => $this->selectedBrand, // Add this line
            'selectedBrandId' => $this->selectedBrandId, // Add this line
        ]);    
    }

    public function removeCategory()
    {
        if ($this->selectedCategory) {
            $category = Category::findOrFail($this->selectedCategory['id']);

            // Check if the category is connected to any collections
            $this->collectionsCount = $category->collections()->count();

            if ($this->collectionsCount > 0) {
                // If the category is connected to collections, show a modal
                $this->removeCategoryId = $category->id;
                $this->modalOpen = true;
            } else {
                // If the category is not connected to collections, delete it along with associated brands and models
                $category->brands()->each(function ($brand) {
                    $brand->models()->delete(); // Delete associated models
                });

                $category->brands()->delete(); // Delete associated brands
                $category->delete(); // Delete the category

                $this->resetSelection();
                $this->categories = Category::with('brands.modals')->get();
            }
        }
    }




    public function editSelection()
    {
        $this->isEditing = true;
    }

    public function addCategory()
    {
        $this->validate([
            'categoryName' => 'required',
        ]);

        Category::create([
            'name' => $this->categoryName,
        ]);

        $this->resetCategory();
        $this->categories = Category::with('brands.modals')->get();
    }

    public function addBrand()
    {
        $this->validate([
            'selectedCategory' => 'required',
            'brandName' => 'required',
        ]);

        $category = Category::findOrFail($this->selectedCategory['id']);

        $category->brands()->create([
            'name' => $this->brandName,
        ]);

        $this->resetBrand();
        $this->selectedCategory['brands'] = $category->brands;
    }

    public function addModal()
    {
        $this->validate([
            'selectedBrand' => 'required',
            'modalName' => 'required',
        ]);

        $brand = Brand::findOrFail($this->selectedBrand['id']);

        $brand->modals()->create([
            'name' => $this->modalName,
        ]);

        $this->resetModal();

        // Update the modals for the selected brand
        $this->selectedBrand['modals'] = $brand->modals;
    }

    public function updateCategory()
    {
        $this->validate([
            'newCategoryName' => 'required',
        ]);
    
        $category = Category::find($this->selectedCategory->id);
        $category->name = $this->newCategoryName;
        $category->save();
    
        $this->categories = Category::with('brands.modals')->get(); // Refresh categories listing
        $this->resetSelection();

        $this->reset(['newCategoryName', 'isEditing']);
    }

    public function closeModal()
    {
        $this->modalOpen = false;
    }

    public function selectCategory($categoryId)
    {
        $this->selectedCategory = Category::find($categoryId);
        $this->selectedBrandId = null;
        $this->selectedBrand = null;
        $this->selectedModal = null;
        $this->newCategoryName = $this->selectedCategory->name; // Set the new category name
    }

    public function selectBrand($brandId)
    {
        $this->selectedBrandId = $brandId;
        $this->selectedBrand = Brand::with('modals')->find($brandId);
        $this->selectedModal = null;
    }

    public function selectModal($modalId)
    {
        $this->selectedModal = Modal::find($modalId);
    }

    public function resetCategory()
    {
        $this->selectedCategory = null;
        $this->newCategoryName = null;
        $this->categoryName = null;
    }

    public function resetBrand()
    {
        $this->selectedBrandId = null;
        $this->selectedBrand = null;
        $this->selectedModal = null;
        $this->brandName = null;
    }

    public function resetModal()
    {
        $this->modalName = null;
        $this->selectedModal = null; 
    }
}

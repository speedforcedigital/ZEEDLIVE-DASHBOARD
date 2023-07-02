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
    public $selectedModal;
    public $categories;
    public $selectedBrandId;
    public $editModalOpen = false;

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

    public function editSelection()
    {
        $this->editModalOpen = true;
    }

    public function updateCategory()
    {
        $this->selectedCategory->save();
        $this->editModalOpen = false;
        $this->resetSelection();
    }

    public function selectCategory($categoryId)
    {
        $this->selectedCategory = Category::find($categoryId);
        $this->selectedBrandId = null;
        $this->selectedBrand = null;
        $this->selectedModal = null;
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

    public function resetSelection()
    {
        $this->selectedCategory = null;
        $this->selectedBrandId = null;
        $this->selectedBrand = null;
        $this->selectedModal = null;
    }
}

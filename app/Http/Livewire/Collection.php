<?php

namespace App\Http\Livewire;

use App\Models\Brand;
use App\Models\Category;
use App\Models\MyCollection;
use Livewire\Component;

class Collection extends Component
{
    public $category_id, $brand_id;
    public $search = '';

    public function render()
    {
        $perPage = 10;

        $query = MyCollection::query()
            ->when($this->category_id, fn($q) => $q->where('category_id', $this->category_id))
            ->when($this->brand_id, fn($q) => $q->where('brand_id', $this->brand_id));

        if ($this->search != null) {
            $query->where(function ($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                    ->orWhereHas('user', function ($userQuery) {
                        $userQuery->where('name', 'like', '%' . $this->search . '%');
                    });
            });
        }

        $collections = $query->paginate($perPage);

        $total_collections = $collections->total();
        $categories = Category::all();
        $brands = $this->category_id ? Category::find($this->category_id)->brands : Brand::all();

        return view('livewire.collection', compact('collections', 'total_collections', 'categories', 'brands'));
    }


    public function remove($id)
    {
        $collection = MyCollection::find($id);
        $collection->is_delete = 1;
        $collection->save();
        $message = 'Collection Disabled Sucessfully.';
        session()->flash('message', $message);
        return redirect()->route('collections.index');
    }

    public function enable($id)
    {
        $collection = MyCollection::find($id);
        $collection->is_delete = 1;
        $collection->save();
        $message = 'Collection Enabled Sucessfully.';
        session()->flash('message', $message);
        return redirect()->route('collections.index');

    }

    public function view($collectionId)
    {
        return redirect()->route('collection.show', $collectionId);
    }
}

<?php

namespace App\Http\Livewire;

use App\Models\MyCollection;
use Livewire\Component;

class Collection extends Component
{
    public function render()
    {

        $perpage = 10;
        $collections = MyCollection::paginate($perpage);
        $total_collections = $collections->total();
        return view('livewire.collection', compact('collections', 'total_collections'));
    }

    public function remove($id)
    {
        $collection =   MyCollection::find($id);
        $collection->is_delete = 1;
        $collection->save();
        $message = 'Collection Removed Sucessfully.';
        session()->flash('message', $message);
    }

    public function view($collectionId)
    {
        return redirect()->route('collection.show', $collectionId);
    }
}

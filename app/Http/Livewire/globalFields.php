<?php
namespace App\Http\Livewire;
use Livewire\Component;
use App\Helpers\baseUrl;
use App\Models\GlobalField;
use App\Helpers\MakeCurlRequest;
use App\Helpers\makeCurlPostRequest;
use Illuminate\Pagination\LengthAwarePaginator;

class globalFields extends Component
{
    public $global_field, $global_field_id;
    public $addGlobalField = false;
    public $updateMode = false;
    public $fields = [];
    public function render()
    {

        $globalfields = GlobalField::where("global_field", "<>", "Colors")->paginate(10);
        $globalfields_count = GlobalField::where("global_field", "<>", "Colors")->count();
        // dd(implode(",", json_decode($globalfields[0]->values,true)));
        return view('livewire.globalfields', compact('globalfields', 'globalfields_count'));
    }

    public function add()
    {
        $this->addGlobalField = true;
    }

    public function updated($field)
    {
        $validatedDate = $this->validateOnly($field,[
            'global_field' => 'required',
        ]);
    }

    public function addGlobalField()
    {
        $validatedDate = $this->validate([
            'global_field' => 'required',
        ]);
        $globalFieldData = [
            'global_field' => $this->global_field,
            'values' => json_encode($this->fields),
        ];
        if ($this->global_field_id) {
            $globalField = GlobalField::find($this->global_field_id);
            if ($globalField) {
                $globalField->update($globalFieldData);
            }
        } else {
            $globalField = GlobalField::create($globalFieldData);
        }
        $this->addGlobalField = false;
        $this->updateMode = false;
        $this->resetInputFields();

        if ($globalField) {

            $this->dispatchBrowserEvent('alert', [
                'type' => 'success',
                'message' => 'Global field saved successfully!',
            ]);
        }
    }
    private function resetInputFields()
    {
        $this->global_field = '';
        $this->global_field_id = '';
        $this->fields = [];

    }

    public function delete($id)
    {
        $globalField = GlobalField::find($id);
        if ($globalField) {
            $globalField->delete();
            $this->dispatchBrowserEvent('alert', [
                'type' => 'success',
                'message' => 'Global field deleted successfully!',
            ]);
        }
    }

    public function addField()
    {
        $this->fields[] = '';
    }

    public function removeField($index)
    {
        unset($this->fields[$index]);
        $this->fields = array_values($this->fields);
    }

    public function edit($id)
    {

         $this->global_field = GlobalField::all();
        $singleGlobalField = GlobalField::find($id);
        $this->global_field = $singleGlobalField->global_field;
        $this->global_field_id = $singleGlobalField->global_field_id;
      $array = json_decode($singleGlobalField->values);
        if (!empty($array)) {
            $this->fields = $array;
        }

        $this->updateMode = true;

    }

}

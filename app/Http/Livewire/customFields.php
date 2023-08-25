<?php

namespace App\Http\Livewire;

use App\Models\CustomField;
use App\Models\Category;
use Livewire\Component;
use Livewire\WithPagination;

class CustomFields extends Component
{
    use WithPagination;

    public $custom_field_title, $category_id, $type, $custom_field_id;
    public $addCustomField = false;
    public $updateMode = false;
    public $categoryList = false;
    public $fields = [];

    protected $rules = [
        'custom_field_title' => 'required',
        'category_id' => 'required',
        'type' => 'required',
    ];

    public function render()
    {
        $customfields = CustomField::paginate(10);
        $customfields_count = CustomField::count();

        return view('livewire.customfields', compact('customfields', 'customfields_count'));
    }

    public function add()
    {
        $this->categoryList = Category::all();
        $this->addCustomField = true;
    }

    public function updated($field)
    {
        $this->validateOnly($field);
    }

    public function addCustomField()
    {
        $this->validate();

        $customFieldData = [
            'custom_field_title' => $this->custom_field_title,
            'category_id' => $this->category_id,
            'type' => $this->type,
            'values' => json_encode($this->fields),
        ];
        if ($this->custom_field_id) {
            $customField = CustomField::find($this->custom_field_id);
            if ($customField) {
                $customField->update($customFieldData);
            }
        } else {
            $customField = CustomField::create($customFieldData);
        }

        if ($customField) {
            $this->dispatchBrowserEvent('alert', [
                'type' => 'success',
                'message' => 'Custom field saved successfully!',
            ]);
        }

        $this->addCustomField = false;
        $this->updateMode = false;
        $this->resetInputFields();
    }

    private function resetInputFields()
    {
        $this->custom_field_title = '';
        $this->category_id = '';
        $this->type = '';
        $this->custom_field_id = '';
        $this->fields = [];
    }

    public function delete($id)
    {
        $customField = CustomField::find($id);
        if ($customField) {
            $customField->delete();
            $this->dispatchBrowserEvent('alert', [
                'type' => 'success',
                'message' => 'Custom field deleted successfully!',
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
        $this->categoryList = Category::all();
        $customField = CustomField::find($id);
        if ($customField) {
            $this->custom_field_title = $customField->custom_field_title;
            $this->category_id = $customField->category_id;
            $this->type = $customField->type;
            $this->custom_field_id = $customField->custom_field_id;
            $array = json_decode($customField->values);
            if (!empty($array)) {
                $this->fields = $array;
            }
            $this->updateMode = true;
        }
    }
    public function updateCustomField($id)
    {
        $customField = CustomField::find($id);

    }
}

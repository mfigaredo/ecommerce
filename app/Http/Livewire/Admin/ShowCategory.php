<?php

namespace App\Http\Livewire\Admin;

use App\Models\Category;
use App\Models\Subcategory;
use Livewire\Component;
use Illuminate\Support\Str;

class ShowCategory extends Component
{
    public $category, $subcategories, $subcategory;

    public $createForm = [
        'name' => null,
        'slug' => null,
        'color' => false,
        'size' => false,
    ];

    public $editForm = [
        'name' => null,
        'slug' => null,
        'color' => false,
        'size' => false,
        'open' => false,
    ];

    protected $rules = [
        'createForm.name' => 'required|min:5',
        'createForm.slug' => 'required|unique:subcategories,slug',
        'createForm.color' => 'required',
        'createForm.size' => 'required',
    ];
    
    protected $validationAttributes = [
        'createForm.name' => 'Nombre',
        'createForm.slug' => 'Slug',
        'createForm.color' => 'Color',
        'createForm.size' => 'Talla',
    ];

    protected $listeners = ['delete'];

    public function mount(Category $category) {
        $this->category = $category;
        $this->getSubcategories();
    }

    public function getSubcategories() {
        $this->subcategories = Subcategory::where('category_id', $this->category->id)->get();
    }

    public function updatedCreateFormName($value) {
        $this->createForm['slug'] = Str::slug($value);
    }

    public function updatedEditFormName($value) {
        $this->editForm['slug'] = Str::slug($value);
    }

    public function edit(Subcategory $subcategory) {
        $this->resetValidation();
        $this->subcategory = $subcategory;

        $this->editForm['open'] = true;
        $this->editForm['name'] = $subcategory->name;
        $this->editForm['slug'] = $subcategory->slug;
        $this->editForm['color'] = $subcategory->color;
        $this->editForm['size'] = $subcategory->size;

    }

    public function update() {
        $this->validate([
            'editForm.name' => 'required|min:5',
            'editForm.slug' => 'required|unique:subcategories,slug,' . $this->subcategory->id,
            'editForm.color' => 'required',
            'editForm.size' => 'required',
        ]);

        $this->subcategory->update($this->editForm);
        $this->getSubcategories();
        $this->reset('editForm');
    }

    public function save() {
        $this->validate();
        $this->category->subcategories()->create($this->createForm);

        $this->reset('createForm');
        $this->getSubcategories();

    }

    public function delete(Subcategory $subcategory) {
        $subcategory->delete();
        $this->getSubcategories();
    }

    public function render()
    {
        return view('livewire.admin.show-category')->layout('layouts.admin');
    }
}

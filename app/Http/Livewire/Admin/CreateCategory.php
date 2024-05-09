<?php

namespace App\Http\Livewire\Admin;

use App\Models\Brand;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;

class CreateCategory extends Component
{
    use WithFileUploads;

    public $brands, $rand, $categories, $category;

    public $createForm = [
        'open' => false,
        'name' => null,
        'slug' => null,
        'icon' => null,
        'image' => null,
        'brands' => [],
    ];

    public $editForm = [
        'open' => false,
        'name' => null,
        'slug' => null,
        'icon' => null,
        'image' => null,
        'brands' => [],
    ];

    public $editImage = null;

    protected $rules = [
        'createForm.name' => 'required|min:3',
        'createForm.slug' => 'required|unique:categories,slug',
        'createForm.icon' => 'required',
        'createForm.image' => 'required|image|max:1024',
        'createForm.brands' => 'required',

    ];

    protected $validationAttributes = [
        'createForm.name' => 'nombre',
        'createForm.slug' => 'slug',
        'createForm.icon' => 'icono',
        'createForm.image' => 'imagen',
        'createForm.brands' => 'marcas',
        'editForm.name' => 'nombre',
        'editForm.slug' => 'slug',
        'editForm.icon' => 'icono',
        'editImage' => 'imagen',
        'editForm.brands' => 'marcas',
    ];

    protected $listeners = ['delete'];

    public function getBrands() {
        $this->brands = Brand::all();
    }

    public function mount() {
        $this->getBrands();
        $this->rand = rand();
        $this->getCategories();
    }

    public function updatedCreateFormName($value) {
        $this->createForm['slug'] = Str::slug($value);
    }

    public function updatedEditFormName($value) {
        $this->editForm['slug'] = Str::slug($value);
    }

    public function save() {
        $this->validate();

        $image = $this->createForm['image']->store('categories');

        $category = Category::create([
            'name' => $this->createForm['name'],
            'slug' => $this->createForm['slug'],
            'icon' => $this->createForm['icon'],
            'image' => $image,
        ]);
        $category->brands()->attach($this->createForm['brands']);
        
        $this->reset('createForm');
        $this->rand = rand();
        $this->emit('saved');
        $this->getCategories();
    }

    public function getCategories() {
        $this->categories = Category::all();
    }

    public function delete(Category $category) {
        $category->delete();
        $this->getCategories();
    }

    public function edit(Category $category) {
        $this->category = $category;
        $this->reset(['editImage']);
        $this->resetValidation();
        $this->editForm['open'] = true;
        $this->editForm['name'] = $category->name;
        $this->editForm['slug'] = $category->slug;
        $this->editForm['icon'] = $category->icon;
        $this->editForm['image'] = $category->image;
        $this->editForm['brands'] = array_map('strval', $category->brands->pluck('id')->toArray());

    }

    public function update() {

        $rules = [
            'editForm.name' => 'required|min:3',
            'editForm.slug' => 'required|unique:categories,slug,' . $this->category->id,
            'editForm.icon' => 'required',
            // 'editImage' => 'image|max:1024',
            'editForm.brands' => 'required',
        ];
        if($this->editImage) {
            $rules['editImage'] = 'required|image|max:1024';
        }

        $this->validate($rules);

        if($this->editImage) {
            Storage::delete($this->editForm['image']);
            $this->editForm['image'] = $this->editImage->store('categories');
        }

        $this->category->update($this->editForm);
        info('Category Updated:');
        info($this->category);
        
        $this->category->brands()->sync($this->editForm['brands']);
        info($this->editForm['brands']);

        $this->reset(['editForm', 'editImage']);

        $this->getCategories();
    }

    public function render()
    {
        return view('livewire.admin.create-category');
    }
}

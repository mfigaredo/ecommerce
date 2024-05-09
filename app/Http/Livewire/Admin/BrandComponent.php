<?php

namespace App\Http\Livewire\Admin;

use App\Models\Brand;
use Livewire\Component;

class BrandComponent extends Component
{
    public $brands, $brand;

    public $createForm = [
        'name' => null,
    ];

    public $editForm = [
        'name' => null,
        'open' => false,
    ];

    protected $rules = [
        'createForm.name' => 'required|min:3',
    ];

    protected $validationAttributes = [
        'createForm.name' => 'Nombre',
        'editForm.name' => 'Nombre',
    ];

    protected $listeners = ['delete'];

    public function getBrands() {
        $this->brands = Brand::all();
    }

    public function mount() {
        $this->getBrands();
    }

    public function save() {
        $this->validate();

        Brand::create($this->createForm);
        $this->reset('createForm');
        $this->getBrands();
        $this->emit('saved');

    }

    public function edit(Brand $brand) {
        $this->brand = $brand;
        $this->editForm['open'] = true;
        $this->editForm['name'] = $brand->name;

    }

    public function update() {
        $this->validate([
            'editForm.name' => 'required|min:3',
        ]);
        $this->brand->update($this->editForm);
        $this->reset('editForm');
        $this->getBrands();
    }

    public function delete(Brand $brand) {
        $brand->delete();
        $this->getBrands();
    }

    public function render()
    {
        return view('livewire.admin.brand-component')->layout('layouts.admin');
    }
}

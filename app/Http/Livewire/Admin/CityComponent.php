<?php

namespace App\Http\Livewire\Admin;

use App\Models\City;
use App\Models\District;
use Livewire\Component;

class CityComponent extends Component
{
    public $city, $districts, $district;

    protected $listeners = ['delete'];

    protected $validationAttributes = [
        'createForm.name' => 'Nombre',
        'editForm.name' => 'Nombre',
    ];

    public $createForm = [
        'name' => null,
    ];

    public $editForm = [
        'name' => null,
        'open' => false,
    ];

    public function mount(City $city) {
        $this->city = $city;
        $this->getDistricts();
    }

    public function getDistricts() {
        $this->districts = $this->city->districts()->get();
    }

    public function save() {
        $this->validate([
            'createForm.name' => 'required|min:3',
        ]);
        $this->city->districts()->create($this->createForm);
        $this->emit('saved');
        $this->reset('createForm');
        $this->getDistricts();
    }

    public function edit(District $district) {
        $this->district = $district;
        $this->editForm['open'] = true;
        $this->editForm['name'] = $district->name;
    }

    public function update() {
        $this->validate([
            'editForm.name' => 'required|min:3',
        ]);
        $this->district->name = $this->editForm['name'];
        $this->district->save();
        $this->reset('editForm');
        $this->getDistricts();
    }

    public function delete(District $district) {
        $district->delete();
        $this->getDistricts();
    }
    
    public function render()
    {
        return view('livewire.admin.city-component')->layout('layouts.admin');
    }
}

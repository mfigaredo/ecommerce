<?php

namespace App\Http\Livewire\Admin;

use App\Models\City;
use App\Models\Department;
use Livewire\Component;

class ShowDepartment extends Component
{
    public $department, $cities, $city;

    protected $listeners = ['delete'];

    protected $validationAttributes = [
        'createForm.name' => 'Nombre',
        'editForm.name' => 'Nombre',
        'createForm.cost' => 'Costo',
        'editForm.cost' => 'Costo',
    ];

    public $createForm = [
        'name' => null,
        'cost' => null,
    ];

    public $editForm = [
        'name' => null,
        'cost' => null,
        'open' => false,
    ];

    public function mount(Department $department) {
        $this->department = $department;
        $this->getCities();
    }

    public function getCities() {
        // $this->cities = City::where('department_id', $this->department->id)->get();
        // dump(City::where('department_id', $this->department->id)->get());
        $this->cities = $this->department->cities()->get();
        // dump($this->cities);
    }

    public function save() {
        $this->validate([
            'createForm.name' => 'required|min:3',
            'createForm.cost' => 'required|numeric|min:1|max:100',
        ]);
        // $this->createForm['department_id'] = $this->department->id;
        // City::create($this->createForm);
        $this->department->cities()->create($this->createForm);
        $this->emit('saved');
        $this->reset('createForm');
        $this->getCities();
    }

    public function edit(City $city) {
        $this->city = $city;
        $this->editForm['open'] = true;
        $this->editForm['name'] = $city->name;
        $this->editForm['cost'] = $city->cost;
    }

    public function update() {
        $this->validate([
            'editForm.name' => 'required|min:3',
            'editForm.cost' => 'required|numeric|min:1|max:100',
        ]);
        $this->city->name = $this->editForm['name'];
        $this->city->cost = $this->editForm['cost'];
        $this->city->save();
        $this->reset('editForm');
        $this->getCities();
    }

    public function delete(City $city) {
        $city->delete();
        $this->getCities();
    }

    public function render()
    {
        return view('livewire.admin.show-department')->layout('layouts.admin');
    }
}

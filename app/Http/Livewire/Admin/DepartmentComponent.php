<?php

namespace App\Http\Livewire\Admin;

use App\Models\Department;
use Livewire\Component;

class DepartmentComponent extends Component
{
    public $departments, $department; 

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


    public function getDepartments() {
        $this->departments = Department::all();
    }

    public function mount() {
        $this->getDepartments();
    }

    public function save() {
        $this->validate([
            'createForm.name' => 'required|min:3',
        ]);
        Department::create($this->createForm);
        $this->emit('saved');
        $this->reset('createForm');
        $this->getDepartments();
    }

    public function edit(Department $department) {
        $this->department = $department;
        $this->editForm['open'] = true;
        $this->editForm['name'] = $department->name;
    }

    public function update() {
        $this->department->name = $this->editForm['name'];
        $this->department->save();
        $this->reset('editForm');
        $this->getDepartments();
    }

    public function delete(Department $department) {
        $department->delete();
        $this->getDepartments();
    }

    public function render()
    {
        return view('livewire.admin.department-component')->layout('layouts.admin');
    }
}

<?php

namespace App\Http\Livewire\Admin;

use App\Models\Size;
use Livewire\Component;

class SizeProduct extends Component
{
    public $product, $name, $open = false;

    public $name_edit, $size;

    protected $rules = [
        'name' => 'required',
    ];

    protected $listeners = ['delete'];

    public function save() {
        $this->validate();

        $size = Size::where('product_id', $this->product->id)
            ->where('name', $this->name)
            ->first();
        
        if($size) {
            $this->emit('errorSize', 'Esa talla ya existe.');

        } else {

            $this->product->sizes()->create([
                'name' => $this->name,
            ]);
            $this->reset('name');
            
            $this->product = $this->product->fresh();
        }


    }

    public function edit(Size $size) {
        $this->open = true;
        $this->name_edit = $size->name;
        $this->size = $size;
    }

    public function update(Size $size) {
        $this->validate([
            'name_edit' => 'required',
        ]);
        $this->size->name = $this->name_edit;
        $this->size->save();
        $this->product = $this->product->fresh();

        $this->open = false;
    }

    public function delete(Size $size) {
        $size->delete();
        $this->product = $this->product->fresh();
    }

    public function render()
    {
        $sizes = $this->product->sizes;
        return view('livewire.admin.size-product', compact('sizes'));
    }
}

<?php

namespace App\Http\Livewire\Admin;

use App\Models\Color;
use Livewire\Component;
use App\Models\ColorProduct as Pivot;

class ColorProduct extends Component
{
    public $product, $colors, $color_id, $quantity, $open = false;

    public $pivot, $pivot_color_id, $pivot_quantity;

    protected $rules = [
        'color_id' => 'required',
        'quantity' => 'required|numeric',
    ];
    
    protected $listeners = ['deleteColorProduct' => 'delete'];

    public function mount() {
        $this->colors = Color::all();
    }

    public function save() {
        $this->validate();

        $pivot = Pivot::where('color_id', $this->color_id)
            ->where('product_id', $this->product->id)
            ->first();
        
        if ($pivot) {
            $pivot->quantity += $this->quantity;
            $pivot->save();
        } else {
            $this->product->colors()->attach([
                $this->color_id => [
                    'quantity' => $this->quantity,
                ],
            ]);
        }

        $this->reset(['color_id', 'quantity']);

        $this->emit('saved');

        $this->product = $this->product->fresh();
    }

    public function edit(Pivot $pivot) {
        $this->open = true;
        $this->pivot = $pivot;
        $this->pivot_color_id = $pivot->color_id;
        $this->pivot_quantity = $pivot->quantity;

    }

    public function update() {
        $this->pivot->color_id = $this->pivot_color_id;
        $this->pivot->quantity = $this->pivot_quantity;
        $this->pivot->save();
        $this->open = false;
        $this->product = $this->product->fresh();
    }

    public function delete(Pivot $pivot) {
        // info('delete Color Product');
        // info($pivot);
        $pivot->delete();
        $this->product = $this->product->fresh();
    }

    public function render()
    {
        $product_colors = $this->product->colors;
        return view('livewire.admin.color-product', compact('product_colors'));
    }
}

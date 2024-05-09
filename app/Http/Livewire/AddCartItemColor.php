<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Storage;

class AddCartItemColor extends Component
{
    public $product, $colors;
    public $quantity = 0;
    public $qty = 1;
    public $color_id = '';
    public $options = [
        'size_id' => null,
    ];

    public function mount() {
        $this->colors = $this->product->colors;
        // $this->quantity = $this->product->colors()->where('color_id', $this->color_id)->get()->quantity;
        $this->options['image'] = Storage::url($this->product->images->first()->url);
    }

    public function updatedColorId($value) {
        $color = $this->product->colors->find($value);
        // $this->quantity = $color->pivot->quantity;
        $this->quantity = qty_available($this->product->id, $color->id);
        $this->options['color'] = $color->name;
        $this->options['color_id'] = $color->id;
    }

    public function decrement() {
        // if($this->qty > 1) $this->qty--;
        $this->qty--;
    }

    public function increment() {
        $this->qty++;
    }

    public function addItem() {
        Cart::add([
            'id' => $this->product->id, 
            'name' => $this->product->name, 
            'qty' => $this->qty, 
            'price' => $this->product->price, 
            'weight' => 1, 
            'options' => $this->options,
        ]);
        $this->quantity = qty_available($this->product->id, $this->color_id);

        $this->reset('qty');
        $this->emitTo('dropdown-cart', 'render');
    }

    public function render()
    {
        return view('livewire.add-cart-item-color');
    }
}

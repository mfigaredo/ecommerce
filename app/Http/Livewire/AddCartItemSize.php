<?php

namespace App\Http\Livewire;

use App\Models\Size;
use Livewire\Component;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Storage;

class AddCartItemSize extends Component
{
    public $product, $sizes;

    public $size_id = '';
    public $colors = [];
    public $color_id = '';
    public $qty = 1;
    public $quantity = 0;
    public $options = [];

    public function mount()
    {
        $this->sizes = $this->product->sizes;
        $this->options['image'] = Storage::url($this->product->images->first()->url);
    }

    public function decrement()
    {
        // if($this->qty > 1) $this->qty--;
        $this->qty--;
    }

    public function increment()
    {
        $this->qty++;
    }

    public function updatedSizeId($size_id)
    {
        $size = Size::find($size_id);
        $this->colors = $size->colors;
        $this->color_id = '';
        $this->options['size'] = $size->name;
        $this->options['size_id'] = $size->id;
    }

    public function updatedColorId($color_id)
    {
        $size = Size::find($this->size_id);
        $color = $size->colors->find($color_id);
        // $this->quantity = $color->pivot->quantity;
        $this->quantity = qty_available($this->product->id, $color->id, $size->id);
        $this->options['color'] = $color->name;
        $this->options['color_id'] = $color->id;
    }

    public function addItem()
    {
        Cart::add([
            'id' => $this->product->id,
            'name' => $this->product->name,
            'qty' => $this->qty,
            'price' => $this->product->price,
            'weight' => 1,
            'options' => $this->options,
        ]);
        $this->quantity = qty_available($this->product->id, $this->color_id, $this->size_id);
        $this->reset('qty');
        $this->emitTo('dropdown-cart', 'render');
    }

    public function render()
    {
        return view('livewire.add-cart-item-size');
    }
}

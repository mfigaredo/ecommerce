<?php

namespace App\Http\Livewire\Admin;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Image;
use App\Models\Product;
use App\Models\Subcategory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Illuminate\Support\Str;

class EditProduct extends Component
{

  public $product, $categories, $subcategories, $brands;
  public $category_id, $slug;

  protected $rules = [
    'category_id' => 'required',
    'product.subcategory_id' => 'required',
    'product.name' => 'required',
    'slug' => 'required|unique:products,slug',
    'product.description' => 'required|min:10',
    'product.brand_id' => 'required',
    'product.price' => 'required',
    'product.quantity' => 'required',
  ];

  protected $listeners = [
    'refreshProduct', 
    'delete', 
    'redirect' => 'redirectAdmin',
  ];

  public function mount(Product $product) {
    $this->product = $product;
    $this->categories = Category::all();
    $this->slug = $this->product->slug;
    $this->category_id = $product->subcategory->category->id;
    $this->subcategories = Subcategory::where('category_id', $this->category_id)->get();
    // $this->subcategory_id = $product->subcategory_id;
    $this->brands = Brand::whereHas('categories', function(Builder $query) {
        $query->where('category_id', $this->category_id);
    })->get();

  }

  public function updatedCategoryId($value) {
    $this->subcategories = Subcategory::where('category_id', $this->category_id)->get();
    $this->brands = Brand::whereHas('categories', function(Builder $query) use ($value) {
      $query->where('category_id', $value);
    })->get();
    // $this->reset(['subcategory_id', 'brand_id']);
    $this->product->subcategory_id = '';
    $this->product->brand_id = '';

  }

  public function updatedProductName($value) {
    $this->slug = Str::slug($value);
  }

  public function getSubcategoryProperty() {
    return Subcategory::find($this->product->subcategory_id);
  }

  public function save() {
    $rules = $this->rules;

    $rules['slug'] = 'required|unique:products,slug,' . $this->product->id;
    if ($this->product->subcategory_id) {
      if (!$this->subcategory->color && !$this->subcategory->size) {
        $rules['product.quantity'] = 'required|numeric';
      } else {
        unset($rules['product.quantity']);
      }
    }
    info($rules);

    $this->validate($rules);
    $this->product->slug = $this->slug;
    $this->product->save();

    $this->emit('saved');
  }

  public function deleteImage(Image $image) {
    Storage::delete([$image->url]);
    $image->delete();
    $this->product = $this->product->fresh();
  }

  public function refreshProduct() {
    info('Refresh product');
    $this->product = $this->product->fresh();
  }

  public function delete() {
    
    // Eliminar imágenes
    $images = $this->product->images;
    foreach ($images as $image) {
      Storage::delete([$image->url]);
      $image->delete();
    }
    // $this->refreshProduct();

    $this->product->delete();

    // return redirect()->route('admin.index');
    return true;
  }

  public function redirectAdmin() {
    info('redirect Admin');
    return redirect()->route('admin.index');
  }

  public function render()
  {
    return view('livewire.admin.edit-product')->layout('layouts.admin');
  }
}

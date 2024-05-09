<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request, Product $product) {
        $request->validate([
            'comment' => 'required|min:5',
            'rating' => 'required|integer|min:1|max:5',
            // 'product_id' => 'required',
        ]);

        $product->reviews()->create([
            'rating' => $request->rating,
            'comment' => $request->comment,
            'user_id' => auth()->id(),
        ]);

        session()->flash('flash.banner', 'Tu reseña se agregó con éxito');
        session()->flash('flash.bannerStyle', 'success');
        return redirect()->back();
        // return $request->all();
    }
}

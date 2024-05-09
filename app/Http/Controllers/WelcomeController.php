<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Order;

class WelcomeController extends Controller
{
    public function __invoke()
    {
        if(auth()->user()) {

            $pendientes = Order::where('user_id', auth()->id())->where('status', Order::PENDIENTE)->count();
            if($pendientes > 0) {
                $mensaje = "Tienes {$pendientes} ordenes pendientes! <a href='".route('orders.index') . '?status=1' ."' class='font-bold'>Ir a pagar</a>";
                session()->flash('flash.banner', $mensaje);
                session()->flash('flash.bannerHtml', true);
                // session()->flash('flash.bannerStyle', 'danger');

            }

        }

        $categories = Category::all();

        return view('welcome', compact('categories'));
    }
}

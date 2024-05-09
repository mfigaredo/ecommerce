<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index() {
        $orders = Order::query()->where('status', '!=', Order::PENDIENTE);

        // if(request('status')) {
        //     $orders->where('status', request('status'));
        // }

        $orders = $orders->get();

        $estatuses = Order::ESTATUSES;
        unset($estatuses[Order::PENDIENTE]); // no mostrar pendientes
        return view('admin.orders.index', compact('orders', 'estatuses'));
    }

    public function show(Order $order) {
        return view('admin.orders.show', compact('order'));
    }
}

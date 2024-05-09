<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Http;

class OrderController extends Controller
{
    // public function payment(Order $order) {

    //     $items = json_decode($order->content);
    //     return view('orders.payment', compact('order', 'items'));
    // }

    public function index() {

        $orders = Order::query()->where('user_id', auth()->user()->id);

        // if(request('status')) {
        //     $orders->where('status', request('status'));
        // }

        $orders = $orders->get();

        $estatuses = Order::ESTATUSES;
        return view('orders.index', compact('orders', 'estatuses'));
    }

    public function show(Order $order) {

        $this->authorize('author', $order);

        $items = json_decode($order->content);
        $envio = json_decode($order->envio);

        return view('orders.show', compact('order', 'items', 'envio'));
    }

    public function pay(Order $order, Request $request) {
        // return $request->all();

        $this->authorize('author', $order);

        $payment_id = $request->get('payment_id');

        $response = Http::get('https://api.mercadopago.com/v1/payments/' . $payment_id . '?access_token=' . config('services.mercadopago.token'));

        $response = json_decode($response);

        $status = $response->status;

        if($status == 'approved') {
            $order->status = Order::RECIBIDO;
            $order->save();
        }
        return redirect()->route('orders.show', $order);

        // return $response;
    }
}

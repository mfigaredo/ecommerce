<?php

namespace App\Http\Livewire;

use App\Models\Order;
use Livewire\Component;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class PaymentOrder extends Component
{
    public $order;

    use AuthorizesRequests;

    protected $listeners = ['payOrder'];

    public function mount(Order $order) {
        $this->order = $order;
    }

    public function payOrder() {
        $this->order->status = Order::RECIBIDO;
        $this->order->save();
        return redirect()->route('orders.show', $this->order);
    }

    public function render()
    {
        $this->authorize('author', $this->order);
        $this->authorize('payment', $this->order);

        $items = json_decode($this->order->content);
        $envio = json_decode($this->order->envio);
        // echo 'LIVEWIRE<BR>';
        return view('livewire.payment-order', compact('items', 'envio'));
    }
}

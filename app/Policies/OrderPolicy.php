<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;

use Illuminate\Auth\Access\HandlesAuthorization;

class OrderPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function author(User $user, Order $order) {
        // dump($order);
        // dump($user);
        return $user->id === $order->user_id;
    }

    public function payment(User $user, Order $order) {
        return $order->status == Order::PENDIENTE;
    }
}

<?php

namespace App\Http\Livewire;

use App\Models\City;
use App\Models\Department;
use App\Models\District;
use App\Models\Order;
use Livewire\Component;
use Gloudemans\Shoppingcart\Facades\Cart;

class CreateOrder extends Component
{

    public $envio_type = 1;
    public $order;

    public $departments, $cities = [], $districts = [];

    public $department_id = '', $city_id = '', $district_id = '';

    public $contact, $phone, $address, $references, $shipping_cost = 0;

    public $rules = [
        'contact' => 'required',
        'phone' => 'required',
        'envio_type' => 'required',
    ];

    public function mount() {
        $this->departments = Department::orderBy('name')->get();

    }

    public function updatedEnvioType($value) {
        if($value == 1) {
            $this->reset(['shipping_cost', 'department_id', 'city_id', 'district_id', 'address', 'references']);
            $this->resetValidation(['department_id', 'city_id', 'district_id', 'address', 'references']);
        }
    }

    public function updatedDepartmentId($value) {
        $this->cities = City::where('department_id', $value)->orderBy('name')->get();
        $this->reset(['city_id', 'district_id']);
    }

    public function updatedCityId($value) {
        
        $city = City::find($value);

        $this->shipping_cost = $city->cost;

        $this->districts = District::where('city_id', $value)->orderBy('name')->get();
        $this->reset(['district_id']);
    }

    public function create_order() {
        
        $rules = $this->rules;

        if($this->envio_type == 2) {
            $rules['department_id'] = 'required';
            $rules['city_id'] = 'required';
            $rules['district_id'] = 'required';
            $rules['address'] = 'required';
            $rules['references'] = 'required';
        }

        $this->validate($rules);
        
        $order = new Order();
        $order->user_id = auth()->user()->id;
        $order->contact = $this->contact;
        $order->phone = $this->phone;
        $order->envio_type = $this->envio_type;
        $order->shipping_cost = $this->shipping_cost;
        $order->total = $this->shipping_cost + Cart::subTotal();
        $order->content = Cart::content();

        if($this->envio_type == 2) {
            /* $order->department_id = $this->department_id;
            $order->city_id = $this->city_id;
            $order->district_id = $this->district_id;
            $order->address = $this->address;
            $order->references = $this->references; */
            $order->envio = json_encode([
                'department' => Department::find($this->department_id)->name,
                'city' => City::find($this->city_id)->name,
                'district' => District::find($this->district_id)->name,
                'address' => $this->address,
                'references' => $this->references,
            ]);
        }

        $order->save();

        foreach(Cart::content() as $item) {
            discount($item);
        }

        Cart::destroy();
        
        return redirect(route('orders.payment', $order));
    }

    public function render()
    {
        return view('livewire.create-order');
    }
}

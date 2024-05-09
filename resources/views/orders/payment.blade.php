<x-app-layout>

  {{-- @php
      // SDK de Mercado Pago
      require base_path('vendor/autoload.php');
      // Agrega credenciales
      MercadoPago\SDK::setAccessToken(config('services.mercadopago.token'));

      // Crea un objeto de preferencia
      $preference = new MercadoPago\Preference();
      $shipments = new MercadoPago\Shipments();

      $shipments->cost = $order->shipping_cost;
      $shipments->currency_id = 'USD';
      $shipments->mode = 'not_specified';

      $preference->shipments = $shipments;

      // Crea un ítem en la preferencia
      $products = [];
      foreach ($items as $product) {
        $item = new MercadoPago\Item();
        $item->title = $product->name;
        $item->id = $product->id;
        $item->quantity = $product->qty;
        $item->unit_price = $product->price;
        $item->currency_id = 'USD';
        $products[] = $item;
      }
      // dump($products);
      $preference->items = $products;

      $preference->back_urls = array(
          "success" => route('orders.pay', $order),
          "failure" => "http://www.tu-sitio/failure",
          "pending" => "http://www.tu-sitio/pending"
      );
      $preference->auto_return = "approved";

      $preference->save();

  @endphp --}}

  <div class="grid grid-cols-5 gap-6 container py-8">

    <div class="col-span-3">
      <div class="bg-white rounded-lg shadow-lg px-6 py-4 mb-6">
        <p class="text-gray-700 uppercase">
          <span class="font-semibold">Número de orden:</span> Orden-{{ $order->id }}
        </p>
      </div>
      <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
        <div class="grid grid-cols-2 gap-6 text-gray-700">
          <div>
            <p class="text-lg font-semibold uppercase mb-4">Envío</p>
            @if ($order->envio_type==1)
                <p class="text-sm">Los productos deben ser recogidos en tienda.</p>
                <p class="text-sm">Calle Falsa, 123</p>
            @else
                <p class="text-sm">Los productos serán enviados a:</p>
                <p class="text-sm">{{ $order->address }}</p>
                <p>{{ $order->department->name }} - {{ $order->city->name }} - {{ $order->district->name }}</p>
            @endif
          </div>
          <div>
            <p class="text-lg font-semibold uppercase mb-4">Datos de Contacto</p>
            <p class="text-sm">Persona que recibirá el producto: <span class="font-semibold">{{ $order->contact }}</span></p>
            <p class="text-sm">Teléfono de Contacto: <span class="font-semibold">{{ $order->phone }}</span></p>
          </div>
        </div>
      </div>
      <div class="bg-white rounded-lg shadow-lg p-6 mb-6 text-gray-700">
        <p class="text-xl font-semibold mb-4">Resumen</p>
  
        <table class="table-auto w-full">
          <thead>
            <tr>
              <th></th>
              <th>Precio</th>
              <th>Cantidad</th>
              <th>Total</th>
            </tr>
          </thead>
          <tbody class="divide-gray-200 divide-y">
            @foreach ($items as $item)
              <tr>
                <td>
                  <div class="flex">
                    <img src="{{ $item->options->image }}" class="h-15 w-20 object-cover mr-4" alt="">
                    <article>
                      <h1 class="font-bold text-lg">{{ $item->name }}</h1>
                      <div class="flex text-xs">
                       
                        @isset($item->options->color)
                          Color: {{ __($item->options->color) }}
                        @endisset
                        @isset($item->options->size)
                          - {{ $item->options->size }}  
                        @endisset
                        
                      </div>
                    </article>
                  </div>
                </td>
                <td class="text-center">
                  {{ number_format($item->price,2) }} USD
                </td>
                <td class="text-center">
                  {{ $item->qty }}
                </td>
                <td class="text-center">
                  {{ number_format($item->price * $item->qty,2) }} USD
                </td>
              </tr>
                
            @endforeach
          </tbody>
        </table>
      </div>
  
      
    </div>

    <div class="col-span-2">

      <div class="bg-white rounded-lg shadow-lg px-6 pt-6">
        <div class=" flex justify-between items-center mb-4">
          <img src="{{ asset('img/metodos-pago.jpg') }}" class="h-32 object-cover" alt="">
          <div class="text-gray-700 text-right">
            <p class="font-semibold text-sm">
              Subtotal: {{ number_format($order->total - $order->shipping_cost ,2) }} USD
            </p>
            <p class="font-semibold text-sm">
              Envío: {{ number_format($order->shipping_cost ,2) }} USD
            </p>
            <p class="text-lg font-semibold ">
              Total: {{ number_format($order->total, 2) }} USD
            </p>
            <div class="cho-container"></div>
          </div>
        </div>
        <div id="paypal-button-container"></div>
      </div>

    </div>
  </div>

  
{{--   
  <script src="https://sdk.mercadopago.com/js/v2"></script>
  <script>
    // Agrega credenciales de SDK
    const mp = new MercadoPago("{{ config('services.mercadopago.key') }}", {
      locale: "es-AR",
    });

    // Inicializa el checkout
    mp.checkout({
      preference: {
        id: "{{ $preference->id }}",
      },
      render: {
        container: ".cho-container", // Indica el nombre de la clase donde se mostrará el botón de pago
        label: "Pagar", // Cambia el texto del botón de pago (opcional)
      },
    });
  </script> --}}

  <script src="https://www.paypal.com/sdk/js?client-id={{ config('services.paypal.client_id') }}&currency=USD"></script>
  <script>
    paypal.Buttons({

      // Sets up the transaction when a payment button is clicked
      createOrder: function(data, actions) {
        return actions.order.create({
          purchase_units: [{
            amount: {
              value: '{{ $order->total }}' // Can reference variables or functions. Example: `value: document.getElementById('...').value`
            }
          }]
        });
      },

      // Finalize the transaction after payer approval
      onApprove: function(data, actions) {
        return actions.order.capture().then(function(orderData) {
          // Successful capture! For dev/demo purposes:
              console.log('Capture result', orderData, JSON.stringify(orderData, null, 2));
              var transaction = orderData.purchase_units[0].payments.captures[0];
              alert('Transaction '+ transaction.status + ': ' + transaction.id + '\n\nSee console for all available details');

          // When ready to go live, remove the alert and show a success message within this page. For example:
          // var element = document.getElementById('paypal-button-container');
          // element.innerHTML = '';
          // element.innerHTML = '<h3>Thank you for your payment!</h3>';
          // Or go to another URL:  actions.redirect('thank_you.html');
        });
      }
    }).render('#paypal-button-container');

  </script>
</x-app-layout>
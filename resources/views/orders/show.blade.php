<x-app-layout>

  <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12">



    <div class="bg-white rounded-lg shadow-lg px-12 py-8 mb-6 flex items-center">

      <div class="relative">
        <div class="{{ ($order->status >= 2 && $order->status != 5) ? 'bg-blue-400' : 'bg-gray-400' }}  rounded-full h-12 w-12 flex items-center justify-center">
          <i class="fas fa-check text-white"></i>
        </div>
        <div class="absolute -left-1.5 mt-0.5">
          <p>Recibido</p>
        </div>
      </div>

      <div class="h-1 flex-1 {{ ($order->status >= 3 && $order->status != 5) ? 'bg-blue-400' : 'bg-gray-400' }} mx-2"></div>

      <div class="relative">
        <div class="{{ ($order->status >= 3 && $order->status != 5) ? 'bg-blue-400' : 'bg-gray-400' }} rounded-full h-12 w-12  flex items-center justify-center">
          <i class="fas fa-truck text-white"></i>
        </div>
        <div class="absolute -left-1 mt-0.5">
          <p>Enviado</p>
        </div>
      </div>
      
      <div class="h-1 flex-1 {{ ($order->status >= 4 && $order->status != 5) ? 'bg-blue-400' : 'bg-gray-400' }} mx-2"></div>

      <div class="relative">
        <div class="{{ ($order->status >= 4 && $order->status != 5) ? 'bg-blue-400' : 'bg-gray-400' }} rounded-full h-12 w-12  flex items-center justify-center">
          <i class="fas fa-check text-white"></i>
        </div>
        <div class="absolute -left-2 mt-0.5">
          <p>Entregado</p>
        </div>
      </div>
    </div>

    <div class="bg-white rounded-lg shadow-lg px-6 py-4 mb-6 flex items-center justify-between">
      <p class="text-gray-700 uppercase">
        <span class="font-semibold">Número de orden:</span> Orden-{{ $order->id }}
      </p>

      @if ($order->status == 1)
        <x-button-enlace href="{{ route('orders.payment', $order) }}">
          Ir a Pagar
        </x-button-enlace>
          
      @endif


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
              <p class="text-sm">{{ $envio->address }}</p>
              <p>{{ $envio->department }} - {{ $envio->city }} - {{ $envio->district }}</p>
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

</x-app-layout>
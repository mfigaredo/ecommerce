<x-admin-layout>
  <div class="container py-12">
    <section class="grid sm:grid-cols-2 md:grid-cols-4 gap-6 text-white">
      

      @foreach ($estatuses as $est => $estatus)

        <a href="{{ route('admin.orders.index') . '?status=' . (request('status') == $est ? '' : $est) }}" class="bg-{{ $estatus['color'] }}-500 bg-opacity-75 border-transparent rounded-lg px-12 pt-8 pb-4 border-4 {{ request('status') == $est ? 'border-blue-400' : '' }}">
          <p class="text-center text-2xl">
            {{ $orders->where('status', $est)->count() }}
          </p>
          <p class="uppercase text-center">{{ _($estatus['label']) }}</p>
          <p class="text-center text-2xl mt-2">
            <i class="fas {{ $estatus['icon'] }}"></i>
          </p>
        </a>
          
      @endforeach

      

    </section>

    @if ((request('status') ? $orders->where('status', request('status')) : $orders)->count())
    <section class="bg-white shadow-lg rounded-lg px-12 py-8 mt-12 text-gray-700">
      <h1 class="text-2xl mb-4">
        Pedidos Recientes
        <span>
          @if (request('status'))
              <a href="{{ route('admin.orders.index') }}" class="text-gray-700 ml-6 text-sm">Ver todos</a>
          @endif
        </span>
      </h1>

      <ul>
        @foreach (request('status') ? $orders->where('status', request('status')) : $orders as $order)
          <li class="">
            <a href="{{ route('admin.orders.show', $order) }}" class="flex items-center py-2 px-4 hover:bg-gray-100">
              <span class="w-12 text-center">
                
                <i class="fas {{$order->detalle_status('icon')}} text-{{$order->detalle_status('color')}}-500 opacity-50"></i>
              </span>

              <span>
                Orden: {{ $order->id }}
                <br>
                {{ $order->created_at->format('d/m/Y') }}
              </span>

              <div class="ml-auto">
                <span class="font-bold">
                  {{ _($order->detalle_status('label')) }}
                </span>

                <br>

                <span class="text-sm">
                  {{ $order->total }} USD
                </span>

              </div>

              <span>
                <i class="fas fa-angle-right ml-6"></i>
              </span>

            </a>
          </li>
        @endforeach
      </ul>

    </section>        
    @else
      <div class="py-8 px-12 rounded-lg bg-white shadow-lg mt-12 text-gray-700">
        <span class="font-bold text-lg">
          No existe registro de órdenes.
          <span>
            @if (request('status'))
                <a href="{{ route('admin.orders.index') }}" class="text-gray-700 ml-6 text-sm">Ver todos</a>
            @endif
          </span>
        </span>
      </div>   
    @endif

    

  </div>
</x-admin-layout>
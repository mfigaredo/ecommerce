<div class="px-3">
    <x-jet-dropdown width="96">
        <x-slot name="trigger">
            <span class="relative inline-block cursor-pointer flex justify-center items-center">
                <x-cart color="white" size="30"/>

                @if (Cart::count())
                    <span class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-red-100 transform translate-x-1/2 -translate-y-1/2 bg-red-600 rounded-full">{{ Cart::count() }}</span>
                @else
                    <span class="absolute top-0 right-0 inline-block w-2 h-2 transform translate-x-1/2 -translate-y-1/2 bg-red-600 rounded-full"></span>
                @endif


            </span>
        </x-slot>
        <x-slot name="content">

            <ul class="">
                @forelse (Cart::content() as $item)
                    <li class="flex p-2 border-b-gray-200">
                        <img src="{{ $item->options->image }}" class="h-15 w-20 object-cover mr-4" alt="">
                        <article class="flex-1">
                            <h1 class="font-bold">{{ $item->name }}</h1>


                            <div class="flex">
                                <p>Cant: {{ $item->qty }} </p>

                                @isset($item->options['color'])
                                    <p class="mx-2">
                                        - Color: {{ __($item->options['color']) }}
                                    </p>
                                    
                                @endisset
                                @isset($item->options['size'])
                                    <p>
                                        - {{ __($item->options['size']) }}
                                    </p>
                                    
                                @endisset

                            </div>


                            <p>USD {{ $item->price }}</p>
                        </article>
                    </li>
                @empty
                    <li class="py-6 px-4">
                        <p class="text-center text-gray-700">
                            No tiene agregado ningún item en el carrito.
                        </p>
                    </li>
                @endforelse
            </ul>

            @if (Cart::count())
                <div class="py-2 px-3">
                    <p class="text-lg text-gray-700 mt-2 mb-3"><span class="font-bold">Total:</span> USD {{ Cart::subtotal() }} </p>

                    <x-button-enlace color="orange" class="w-full" href="{{ route('shopping-cart') }}">
                        Ir al carrito de compras
                    </x-button-enlace>

                    {{-- <a href="{{route('shopping-cart')}}"> carrito </a> --}}
                </div>
            @endif
           
        </x-slot>
    </x-jet-dropdown>
</div>

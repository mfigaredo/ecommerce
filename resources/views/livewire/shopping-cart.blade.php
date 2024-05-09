<div class="container py-8">
    
    {{-- <section class="bg-white rounded-lg shadow-lg p-6 text-gray-700"> --}}
    <x-table-responsive>
       
        <div class="px-6 py-4 bg-white">
            <h1 class="text-lg font-semibold mb-6 text-gray-700">CARRO DE COMPRAS</h1>
        </div>

        @if (Cart::count())
                <table class="divide-y divide-gray-200 min-w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col"  class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                            <th scope="col"  class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Precio</th>
                            <th scope="col"  class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cant</th>
                            <th scope="col"  class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach (Cart::content() as $item)
                            <tr class="">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="h-15 w-20 flex-shrink-0">
                                            <img class="h-15 w-20 object-cover object-center" src="{{ $item->options->image }}" alt="">
                                        </div>
                                        <div class="ml-4">
                                            <p class="font-bold">
                                                {{ $item->name }}
                                            </p>
                                            @if ($item->options->color)
                                                <span>
                                                    Color: <span class="capitalize">{{ __($item->options->color) }}</span>
                                                </span>
                                            @endif
                                            @if ($item->options->size)
                                                <span class="mx-1">-</span>
                                                <span>
                                                    {{ __($item->options->size) }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center px-6 py-4 whitespace-nowrap">
                                    <span class="text-gray-500">
                                        USD {{ number_format( $item->price , 2) }}
                                    </span>
                                    <a class="ml-6 cursor-pointer hover:text-red-600"       
                                        wire:click="delete('{{ $item->rowId }}')"
                                        wire:loading.class="text-red-600 opacity-25"
                                        wire:target="delete('{{ $item->rowId }}')"
                                        >
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{-- {{ $item->rowId }} --}}
    
                                    <div class="flex justify-center items-center">
                                        @if ($item->options->size)
            
                                            @livewire('update-cart-item-size', ['rowId' => $item->rowId], key($item->rowId))
            
                                        @elseif($item->options->color)   
            
                                            @livewire('update-cart-item-color', ['rowId' => $item->rowId], key($item->rowId))
            
                                        @else
                                        
                                            @livewire('update-cart-item', ['rowId' => $item->rowId], key($item->rowId))
                                            
                                        @endif
                                    </div>
    
    
                                </td>
                                <td class="text-center px-6 py-4 whitespace-nowrap">
                                    USD {{ number_format( $item->price * $item->qty, 2) }}
                                </td>
                            </tr>
    
                        @endforeach
                    </tbody>
                </table>
            

            <a  class="text-sm cursor-pointer hover:underline mt-6 inline-block" wire:click="destroy">
                <i class="fas fa-trash"></i> 
                Borrar carrito de compras
            </a>
        @else
            <div class="flex items-center flex-col">
                <x-cart/>

                <p class="text-lg text-gray-700 mt-4 uppercase">Tu carro de compras está vacío.</p>

                <x-button-enlace href="{{ route('index') }}" class="mt-4 px-16">
                    Ir al inicio
                </x-button-enlace>
            </div>
        @endif

        
    {{-- </section> --}}
    </x-table-responsive>

    @if (Cart::count())
        <div class="bg-white rounded-lg shadow-lg px-6 py-4 mt-4">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-gray-700">
                        <span class="font-bold text-lg">Total: </span>
                        USD {{ Cart::subTotal() }}
                    </p>
                </div>
                <div>
                    <x-button-enlace href="{{ route('orders.create') }}">
                        Continuar
                    </x-button-enlace>
                </div>
            </div>
        </div>
    @endif
</div>

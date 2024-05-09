<div x-data="{ uno :false } ">

    <p class="text-xl text-gray-700">Color:</p>

    <select wire:model="color_id" class="form-control w-full capitalize">
        <option value="" selected disabled>Seleccionar un color</option>
        @foreach ($colors as $color)
            <option value="{{ $color->id }}">{{ __($color->name) }}</option>
        @endforeach

    </select>

    <p class="text-gray-700 mt-4">
        <span class="font-semibold text-lg">Stock disponible:</span> 
        @if ($quantity)
            {{ $quantity }}
        @else
            
            {{  $product->stock }}
        @endif
    </p>

    <div class="flex mt-4" x-show="$wire.color_id > 0">
        <div class="mr-4">
            <x-jet-secondary-button 
                wire:click="decrement"
                x-bind:disabled="$wire.qty <= 1"
                wire:loading.attr="disabled"
                wire:target="decrement"
            >
                -
            </x-jet-secondary-button>

            <span class="mx-2 text-gray-700">{{ $qty }}</span>

            <x-jet-secondary-button 
                wire:click="increment"
                x-bind:disabled="$wire.qty >= $wire.quantity"
                wire:loading.attr="disabled"
                wire:target="increment"
            >
                +
            </x-jet-secondary-button>
        </div>
        <div class="flex-1">
            
            <x-button 
                
                x-bind:disabled="$wire.qty > $wire.quantity"
                class="w-full disabled:bg-gray-100" 
                color="orange"
                wire:click="addItem"
                wire:loading.attr="disabled"
                wire:target="addItem"
                
                >
                Agregar a carrito de compras
            </x-button>
        </div>
        
    </div>
</div>

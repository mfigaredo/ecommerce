<div x-data>

    <p class="mb-4">
        <span class="font-semibold text-lg">Stock disponible:</span> 
        <span>{{$quantity}}</span>
    </p>

    <div class="flex">
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
                wire:click="addItem" 
                class="w-full" 
                color="orange"
                wire:loading.attr="disabled"
                wire:target="addItem">
                Agregar a carrito de compras
            </x-button>
        </div>
    </div>
</div>

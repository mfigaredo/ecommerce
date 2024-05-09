<div class="flex items-center" x-data>

    {{-- {{ $quantity }} --}}
    {{-- <span x-text="$wire.qty"></span> --}}
    <x-jet-secondary-button 
        wire:click="decrement"
        x-bind:disabled="$wire.qty <= 1"
        wire:loading.attr="disabled"
        wire:target="decrement"
    >
        -
    </x-jet-secondary-button>
    
    <span class="mx-2">{{ $qty }}</span>
    
    <x-jet-secondary-button 
        wire:click="increment"
        x-bind:disabled="$wire.quantity<=0"
        wire:loading.attr="disabled"
        wire:target="increment"
    >
        +
    </x-jet-secondary-button>

</div>

<div class="flex-1 relative mx-2" x-data>

    <form action="{{ route('search') }}" autocomplete="off">
    
        <x-jet-input name="name" wire:model="search" type="text" class="w-full" placeholder="¿Estás buscando algún producto?"/>

        <button class="absolute top-0 right-0 w-12 h-full bg-orange-500 flex items-center justify-center rounded-r-md">
            <x-search size="35" color="white" />
        </button>
    </form>

    <div class="absolute w-full mt-1 hidden" :class="{ 'hidden': !$wire.open }" @click.away="$wire.open = false">
        <div class="bg-white rounded-lg shadow mt-1">
            <div class="px-4 py-3 space-y-1">
                @forelse ($products as $product)
                    <a class="flex" href="{{ route('products.show', $product) }}">
                        <img class="w-16 h-12 object-cover" src="{{ Storage::url($product->images->first()->url) }}" alt="">

                        <div class="ml-4 text-gray-700">
                            <p class="text-lg font-semibold leading-5">{{ $product->name }}</p>
                            <p>Categoría: {{ $product->subcategory->category->name }}</p>
                        </div>
                    </a>

                @empty
                    <p class="text-lg font-semibold leading-5">
                        No existe ningún registro con los parámetros especificados.
                    </p>
                @endforelse
            </div>

        </div>

    </div>
</div>

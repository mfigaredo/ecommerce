<div>
    <div class="bg-white rounded-lg shadow-lg mb-6">
        <div class="px-6 py-2 flex justify-between items-center">
            <h1 class="font-semibold text-gray-700 uppercase">{{ $category-> name }}</h1>
            <div class="hidden md:grid md:grid-cols-2 border-gray-200 divide-x divide-gray-200 text-gray-500">
                <i class="fas fa-border-all p-3 cursor-pointer {{ $view == 'grid' ? 'text-orange-500 font-semibold' : '' }}" wire:click="$set('view', 'grid')"></i>
                <i class="fas fa-th-list p-3 cursor-pointer {{ $view == 'list' ? 'text-orange-500 font-semibold' : '' }}" wire:click="$set('view', 'list')"></i>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 @if($view=='grid') sm:grid-cols-2 @endif md:grid-cols-3 lg:grid-cols-5 gap-6">
        <aside>
            {{-- FILTROS --}}
            <h2 class="font-semibold text-center mb-2">Subcategorías</h2>
            <ul class="divide-y divide-gray-200">
                @foreach ($category->subcategories as $subcategory)
                    <li class="py-2 text-sm ">
                        <a class="cursor-pointer hover:text-orange-500 capitalize {{ $subcategoria == $subcategory->slug ? 'text-orange-500 font-semibold' : '' }}" wire:click="$set('subcategoria', '{{$subcategory->slug}}')">{{ $subcategory->name }}</a>
                    </li>
                @endforeach
            </ul>
            {{-- {{ $marca }} --}}
            <h2 class="font-semibold mt-4 text-center mb-2">Marcas</h2>
            <ul class="divide-y divide-gray-200">
                @foreach ($category->brands as $brand)
                    <li class="py-2 text-sm ">
                        <a class="cursor-pointer hover:text-orange-500 capitalize {{ $marca == $brand->name ? 'text-orange-500 font-semibold' : '' }}" wire:click="$set('marca','{{ $brand->name }}')" >{{ $brand->name }}</a>
                    </li>
                @endforeach
            </ul>

            <x-jet-button class="mt-4" wire:click="limpiar">
                Eliminar Filtros
            </x-jet-button>
        </aside>
        <div class="md:col-span-2 lg:col-span-4">

            @if ($view == 'grid')
                <ul class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @forelse ($products as $product)
                        <div class="bg-white rounded-lg shadow ">
                                
                            @if ($product->images->count())
                                <figure>
                                    <img class="h-48 w-full object-cover object-center" src="{{ Storage::url($product->images->first()->url) }}" alt="">
                                </figure>
                            @endif

                            <div class="py-4 px-6">
                                <h1 class="text-lg font-semibold">
                                    {{ $loop->iteration }}
                                    <a href="{{ route('products.show', $product) }}">{{ Str::limit($product->name, 20) }}</a>
                                </h1>
                                <p class="font-bold text-trueGray-700">US$ {{ $product->price }}</p>
                            </div>
                        </div> 
                    @empty
                        <li class="md:col-span-2 lg:col-span-4">
                            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                                <strong class="font-bold">Upsss!</strong>
                                <span class="block sm:inline">No existe ningún registro con este filtro.</span>
                                
                            </div>
                        </li>
                    @endforelse
                </ul>
                
            @else
                <ul>
                    @forelse ($products as $product)
                        <x-product-list :product="$product"></x-product-list>
                    @empty
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                            <strong class="font-bold">Upsss!</strong>
                            <span class="block sm:inline">No existe ningún registro con este filtro.</span>
                            
                        </div>    
                    @endforelse
                </ul>
            @endif


            <div class="mt-4">
                {{ $products->links() }}
            </div>
        </div>
    </div>
</div>

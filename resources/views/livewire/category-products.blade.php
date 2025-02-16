<div wire:init="loadProducts">

    @if (count($products))
        <div class="glider-contain" id="glider-{{$category->id}}">
            <div class="glider">

                @foreach ($products as $product)
                    <div class="bg-white rounded-lg shadow {{ $loop->last ? '' : 'sm:mr-4' }}">
                        
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
                @endforeach

            </div>
            
            <button aria-label="Previous" class="glider-prev">«</button>
            <button aria-label="Next" class="glider-next">»</button>
            <div role="tablist" class="dots"></div>
        </div>
        
    @else
        <div class="mb-4 h-48 flex justify-center items-center bg-white shadow-xl border border-gray-100 rounded-lg">
            <div class="rounded animate-spin ease duration-300 w-10 h-10 border-2 border-indigo-500"></div>
        </div>		
    @endif


    {{-- <div>
        @foreach ($category->products as $product)
            <p>{{$loop->iteration}} {{ $product->name }}</p>
        @endforeach
    </div> --}}
</div>

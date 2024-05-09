<x-app-layout>
  <div class="container py-8">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">
      <div>
        <!-- Place somewhere in the <body> of your page -->
        <div class="flexslider">
          <ul class="slides">

            @foreach ($product->images as $image)
              <li data-thumb="{{ Storage::url($image->url) }}">
                <img src="{{ Storage::url($image->url) }}" />
              </li>
            @endforeach
           
          </ul>
        </div>
        <div class="-mt-10 text-gray-700">
          <h2 class="font-bold text-lg">Descripción</h2>
          {!! $product->description !!}
        </div>

        @can('review', $product)
          <div class="text-gray-700 mt-4">
            <h2 class="font-bold text-lg">Dejar reseña</h2>
            <form action="{{ route('review.store', $product) }}" method="POST">
              @csrf
              <textarea id="editor" name="comment" class="w-full"></textarea>
              <x-jet-input-error for="comment" />
              <div class="flex w-full items-center mt-6" x-data="{ rating: 5 }">

                <p class="semi-bold mr-3">Puntaje: </p> 
                <ul class="flex space-x-2">
                  @foreach (range(1,5) as $k)
                    <li x-bind:class="rating >= {{$k}} ? 'text-yellow-500' : '' ">
                      <button type="button" class="focus:outline-none" x-on:click="rating = {{$k}}">
                        <i class="fas fa-star "></i>
                      </button>
                        
                    </li>
                  @endforeach
                </ul>
                <input class="hidden" type="number" name="rating" x-model="rating">
                <x-jet-input-error for="rating" />
                {{-- <input type="hidden" name="product_id" value="{{ $product->id }}"> --}}
                <x-jet-button class="ml-auto">
                  Agregar Reseña
                </x-jet-button>
              </div>
              
            </form>

          </div>
        @endcan

        @if ($product->reviews->isNotEmpty())
            <div class="mt-6">
              <h2 class="font-bold text-lg">Reseñas</h2>
              <div class="mt-2">
                @foreach ($product->reviews as $review)
                    <div class="flex">
                      <div class="flex-shrink-0 ">
                        <img src="{{ $review->user->profile_photo_url }}" alt="{{ $review->user->name }}" class="w-10 h-10 rounded-full object-cover mr-4">
                      </div>
                      <div class="flex-1">
                        <p class="font-semibold text-gray-700">{{ $review->user->name }}</p>
                        <p class="text-sm text-gray-400">{{ $review->created_at->diffForHumans() }}</p>
                        <div>
                          {!!$review->comment !!}
                        </div>
                      </div>
                      <div>
                        <p>
                          {{ $review->rating }}
                          <i class="fas fa-star text-yellow-500"></i>
                        </p>
                      </div>
                    </div>
                @endforeach
              </div>
            </div>
        @endif
        
      </div>

      <div>
        <h1 class="text-xl font-bold text-trueGray-700">{{ $product->name }}</h1>
        <div class="flex">
          <p class="text-trueGray-700">Marca: <a class="underline capitalize hover:text-orange-500" href="">{{ $product->brand->name }}</a></p>
          @if ($product->reviews()->count())
              
            <p class="mx-6"> {{ round($product->reviews()->avg('rating'), 2) }} <i class="fas fa-star text-sm text-yellow-400"></i></p>
            <a class="text-orange-500 underline hover:text-orange-600 " href="">{{ $product->reviews()->count() }} reseñas</a>
          @endif

        </div>
        <p class="text-2xl font-semibold text-trueGray-700 my-4">US$ {{ number_format($product->price, 2) }}</p>

        <div class="bg-white shadow-lg rounded-lg mb-6">
          <div class="p-4 flex items-center">
            <span class="flex items-center justify-center rounded-full h-10 w-10 bg-greenLime-600">
              <i class="fas fa-truck text-white text-sm"></i>
            </span>
            <div class="ml-4">
              <p class="text-lg font-semibold text-greenLime-600">Se hace envíos a todo el Perú.</p>
              <p>Recíbelo el {{ Date::now()->addDay(7)->locale('es')->format('l j F') }}</p>
            </div>
          </div>
        </div>

        @if ($product->subcategory->size)
          @livewire('add-cart-item-size', ['product' => $product])
        @elseif($product->subcategory->color)
          @livewire('add-cart-item-color', ['product' => $product])
        @else
          @livewire('add-cart-item', ['product' => $product])
        @endif

      </div>
    </div>
  </div>

  @push('script')
  <script src="https://cdn.ckeditor.com/ckeditor5/34.0.0/classic/ckeditor.js"></script>

  <script>
    ClassicEditor
    .create( document.querySelector( '#editor' ), {
        toolbar: [ 'heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote' ],
        // heading: {
        //     options: [
        //         { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
        //         { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
        //         { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' }
        //     ]
        // }
    } )
    .catch( error => {
        console.log( error );
    } );

  </script>
  <script>
    // Can also be used with $(document).ready()
    $(document).ready(function() {
      $('.flexslider').flexslider({
        animation: "slide",
        controlNav: "thumbnails"
      });
    });
  </script>
  @endpush

</x-app-layout>
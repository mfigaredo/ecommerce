@props(['product'])

<li class="bg-white rounded-lg shadow mb-4">
  <article class="md:flex">
      <figure>
          <img class="h-48 w-full md:w-56 object-cover object-center" src="{{ Storage::url($product->images()->first()->url) }}" alt="">
      </figure>
      <div class="flex-1 py-4 px-6 flex flex-col">
          <div class="lg:flex justify-between ">
              <div>
                  <h1 class="text-lg font-semibold text-gray-700">{{ $product->name }}</h1>
                  <p class="font-bold text-gray-700">US$ {{ $product->price }}</p>
              </div>
              <div class="flex items-center">
                  <ul class="flex test-sm text-yellow-400">
                      <li>
                          <i class="fas fa-star mr-1"></i>
                      </li>
                      <li>
                          <i class="fas fa-star mr-1"></i>
                      </li>
                      <li>
                          <i class="fas fa-star mr-1"></i>
                      </li>
                      <li>
                          <i class="fas fa-star mr-1"></i>
                      </li>
                      <li>
                          <i class="fas fa-star mr-1"></i>
                      </li>
                  </ul>
                  <span class="text-gray-700 text-sm">(24)</span>
              </div>
          </div>

          <div class="mt-4 md:mt-auto mb-6">
              <x-danger-enlace href="{{route('products.show', $product)}}">
                  Mas Información
              </x-danger-enlace>
          </div>
      </div>
  </article>
</li>
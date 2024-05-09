<x-app-layout>
  
  <div class="container py-8">
    <ul>
      @forelse ($products as $product)
        <x-product-list :product="$product"></x-product-list>
      @empty
        <li class="bg-white rounded-lg shadow-2xl">
          <div class="p-4">
            <p class="text-lg text-gray-700 font-semibold">
              Ningún producto coincide con estos parámetros.
            </p>
          </div>
        </li>
      @endforelse
    </ul>

    @if ($products->count() > 0)
        
      <div class="mt-4">
        {{ $products->appends(request()->query())->links() }}
      </div>
    @endif
  </div>

</x-app-layout>
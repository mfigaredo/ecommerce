@props(['category'])

<div class="grid grid-cols-4 p-4">
  <div>
      <p class="text-lg font-bold text-center text-trueGray-500 mb-3">Subcategorías</p>
      <ul>
          @foreach ($category->subcategories as $subcategory)
              <li>
                  <a href="{{ route('categories.show', $category) . '?subcategoria=' . $subcategory->slug }}" class="text-trueGray-500 font-semibold py-1 inline-block px-4 hover:text-orange-500">
                      {{ $subcategory->name }}
                  </a>
              </li>
          @endforeach
      </ul>
  </div>
  <div class="col-span-3">
      <img src="{{ Storage::url($category->image) }}" alt="" class="h-64 w-full object-cover object-center">
  </div>
</div>
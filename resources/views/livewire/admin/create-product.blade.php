<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12 text-gray-700">
  <h1 class="text-3xl text-center font-semibold mb-8">Complete esta información para crear un producto.</h1>

  {{-- {{ $category_id }} {{ $subcategory_id }} --}}

  <div class="grid grid-cols-2 gap-6 mb-4">

    {{-- Categoría --}}
    <div>
      <x-jet-label value="Categorías"></x-jet-label>
      {{-- <select class="w-full form-control" wire:model="category_id">
        <option value="" disabled selected>Seleccione una categoría</option>
        @foreach ($categories as $category)
          <option value="{{ $category->id }}">{{ $category->name }}</option>
        @endforeach
      </select> --}}
      <x-select 
        prompt="Seleccione una categoría"
        idRef="id"
        displayRef="name"
        wire:model="category_id"
        class="w-full form-control"
        :items="$categories"
      />
      <x-jet-input-error for="category_id"/>
    </div>

    {{-- Subcategoría --}}
    <div>
      <x-jet-label value="Subcategorías"></x-jet-label>
      {{-- <select class="w-full form-control" wire:model="subcategory_id">
        <option value="" disabled selected>Seleccione una subcategoría</option>
        @foreach ($subcategories as $subcategory)
          <option value="{{ $subcategory->id }}">{{ $subcategory->name }}</option>
        @endforeach
      </select> --}}
      <x-select 
        prompt="Seleccione una subcategoría"
        idRef="id"
        displayRef="name"
        wire:model="subcategory_id"
        class="w-full form-control"
        :items="$subcategories"
      />
      <x-jet-input-error for="subcategory_id"/>
    </div>
  </div>

  {{-- Nombre --}}
  <div class="mb-4">
    <x-jet-label value="Nombre"></x-jet-label>
    <x-jet-input type="text" 
      class="w-full" 
      placeholder="Ingrese el nombre del producto"
      wire:model="name"
    ></x-jet-input>
    <x-jet-input-error for="name"/>
  </div>

  {{-- Slug --}}
  <div class="mb-4">
    <x-jet-label value="Slug"></x-jet-label>
    <x-jet-input type="text" 
      class="w-full bg-gray-200" 
      placeholder="Ingrese el slug del producto"
      wire:model="slug"
      disabled
    ></x-jet-input>
    <x-jet-input-error for="slug"/>
  </div>

  {{-- Descripción --}}
  <div class="mb-4">
    <x-jet-label value="Descripción"></x-jet-label>
    <div wire:ignore>
      <textarea class="w-full form-control" 
        rows="4"
        x-data
        wire:model="description"
        x-ref="miEditor"
        x-init="ClassicEditor.create( $refs.miEditor ).then(function(editor){ 
          editor.model.document.on('change:data', () => {
            @this.set('description', editor.getData() )
          })
         }).catch(error => console.log(error)); "
      ></textarea>
    </div>
    <x-jet-input-error for="description"/>
  </div>

  <div class="mb-4 grid grid-cols-2 gap-6">
    {{-- Marca --}}
    <div>
      <x-jet-label value="Marca"></x-jet-label>
      {{-- <select class="form-control w-full" wire:model="brand_id">
        <option value="" selected disabled>Seleccione una marca</option>
        @foreach ($brands as $brand)
          <option value="{{ $brand->id }}">{{ $brand->name }}</option>
        @endforeach
      </select> --}}
      
      <x-select 
        prompt="Selecciona una marca" 
        class="w-full form-control" 
        :items="$brands" 
        idRef="id" 
        displayRef="name"
        wire:model="brand_id"
      ></x-select>
      <x-jet-input-error for="brand_id"/>
    </div>

    {{-- Precio --}}
    <div>
      <x-jet-label value="Precio"></x-jet-label>
      <x-jet-input 
        wire:model="price"
        type="number" 
        class="w-full" 
        step="0.01"/>
        <x-jet-input-error for="price"/>
    </div>

  </div>

  @if ($subcategory_id && !$this->subcategory->color && !$this->subcategory->size)
    {{-- Cantidad --}}
    <div class="mb-4">
      <x-jet-label value="Cantidad"></x-jet-label>
      <x-jet-input 
        wire:model="quantity"
        type="number" 
        class="w-full" />
        <x-jet-input-error for="quantity"/>
    </div>
  @endif

  <div class="flex">
    <x-jet-button 
      class="ml-auto disabled:bg-gray-300" 
      wire:click="save"
      wire:loading.attr="disabled"
      wire:target="save"
    >
      Crear Producto
    </x-jet-button>
  </div>

</div>

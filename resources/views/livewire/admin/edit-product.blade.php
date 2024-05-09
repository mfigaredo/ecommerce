<div>

  <header class="bg-white shadow">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 text-gray-700">
      <div class="flex justify-between items-center">
        <h1 class="font-semibold text-xl text-gray-800 leading-tight">
          Productos
        </h1>
        <x-jet-danger-button
          wire:click="$emit('deleteProduct')"
        >
          Eliminar
        </x-jet-danger-button>
      </div>
    </div>
  </header>

  <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12 text-gray-700">

    <h1 class="text-3xl text-center font-semibold mb-8">Complete esta información para editar un producto.</h1>

    {{-- {{$product}} --}}
    <div class="mb-4" wire:ignore>
      <form action="{{ route('admin.products.files', $product) }}"
        class="dropzone"
        method="POST"
        id="my-awesome-dropzone">
      </form>
    </div>
      
      @if ($product->images->count())
    
      <section class="bg-white shadow-xl rounded-lg p-6 mb-4">
        <h1 class="text-2xl text-center font-semibold mb-2">Imágenes del Producto</h1>
        <ul class="flex flex-wrap items-center justify-start">
          @foreach ($product->images as $image)
            <li class="relative mx-1 my-1" wire:key="image-{{ $image->id }}">
              <img src="{{ Storage::url($image->url) }}" alt="" class="w-32 object-cover h-20">
              <x-jet-danger-button 
                class="absolute top-2 right-2"
                wire:click="deleteImage({{ $image->id }})"
                wire:loading.attr="disabled"
                wire:target="deleteImage({{ $image->id }})"
              >
                x
              </x-jet-danger-button>
            </li>  
            
          @endforeach
        </ul>
      </section>
    @endif

    @livewire('admin.status-product', ['product' => $product], key('status-product-' . $product->id))

    <div class="bg-white shadow-xl rounded-lg p-6">
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
              wire:model="product.subcategory_id"
              class="w-full form-control"
              :items="$subcategories"
            />
            <x-jet-input-error for="product.subcategory_id"/>
          </div>
        </div>
      
        {{-- Nombre --}}
        <div class="mb-4">
          <x-jet-label value="Nombre"></x-jet-label>
          <x-jet-input type="text" 
            class="w-full" 
            placeholder="Ingrese el nombre del producto"
            wire:model="product.name"
          ></x-jet-input>
          <x-jet-input-error for="product.name"/>
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
              wire:model="product.description"
              x-ref="miEditor"
              x-init="ClassicEditor.create( $refs.miEditor ).then(function(editor){ 
                editor.model.document.on('change:data', () => {
                  @this.set('product.description', editor.getData() )
                })
               }).catch(error => console.log(error)); "
            ></textarea>
          </div>
          <x-jet-input-error for="product.description"/>
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
              wire:model="product.brand_id"
            ></x-select>
            <x-jet-input-error for="product.brand_id"/>
          </div>
      
          {{-- Precio --}}
          <div>
            <x-jet-label value="Precio"></x-jet-label>
            <x-jet-input 
              wire:model="product.price"
              type="number" 
              class="w-full" 
              step="0.01"/>
              <x-jet-input-error for="product.price"/>
          </div>
      
        </div>
      
        @if ($this->subcategory && !$this->subcategory->color && !$this->subcategory->size)
          {{-- Cantidad --}}
          <div class="mb-4">
            <x-jet-label value="Cantidad"></x-jet-label>
            <x-jet-input 
              wire:model.defer="product.quantity"
              type="number" 
              class="w-full" />
              <x-jet-input-error for="product.quantity"/>
          </div>
        @endif
      
        <div class="flex justify-end items-center">

          <x-jet-action-message class="mr-3" on="saved">
            Actualizado
          </x-jet-action-message>

          <x-jet-button 
            class=" disabled:bg-gray-300" 
            wire:click="save"
            wire:loading.attr="disabled"
            wire:target="save"
          >
            Actualizar Producto
          </x-jet-button>
        </div>
    </div>
  
    @if ($this->subcategory)
        
        @if ($this->subcategory->size)
            @livewire('admin.size-product', ['product' => $product], key('size-product-' . $product->id))
        @elseif($this->subcategory->color)
            @livewire('admin.color-product', ['product' => $product], key('color-product-' . $product->id))
        @endif

    @endif
  </div>
  @push('script')
      <script>
        Dropzone.options.myAwesomeDropzone = { // camelized version of the `id`
          headers: {
            'X-CSRF-TOKEN' : "{{ csrf_token() }}"
          },
          dictDefaultMessage: 'Arrastre una imagen al recuadro',
          acceptedFiles: 'image/*',
          paramName: "file", // The name that will be used to transfer the file
          maxFilesize: 5, // MB
          addRemoveLinks: true,
          dictRemoveFile: "Remove image",

          init: function() {
            thisDropzone = this;
            this.on("error", function (file, responseText) {
              console.log('responseText:', responseText);
              
              $.each(responseText.errors.file, function (index, value) {
                $('.dz-error-message').text(value);
              });
            });
          },
          complete: function(file) {
            this.removeFile(file);
          },
          queuecomplete: function() {
            Livewire.emit('refreshProduct');
          },
        };

        Livewire.on('deleteProduct', () => {
            Swal.fire({
                title: 'Estás seguro?',
                text: "Esta acción no se puede revertir.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Confirmar'
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.emitTo('admin.edit-product', 'delete');
                    Swal.fire(
                    'Eliminado',
                    '',
                    'success'
                    ).then(result => {
                      // Livewire.emitTo('admin.edit-product', 'redirect');
                      window.location = '/admin';
                    });
                }
            })
        });

        Livewire.on('deleteSize', sizeId => {
            Swal.fire({
                title: 'Estás seguro?',
                text: "Esta acción no se puede revertir.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Confirmar'
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.emitTo('admin.size-product', 'delete', sizeId);
                    Swal.fire(
                    'Eliminado',
                    '',
                    'success'
                    )
                }
            })
        });

        Livewire.on('deleteColorProductEv', pivot => {
            console.log('deleteColorProductEv', pivot)
            Swal.fire({
                title: 'Estás seguro?',
                text: "Esta acción no se puede revertir.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Confirmar'
            }).then((result) => {
                if (result.isConfirmed) {
                    console.log('delete Color-Product', pivot)
                    Livewire.emitTo('admin.color-product', 'deleteColorProduct', pivot);
                    Swal.fire(
                    'Eliminado',
                    '',
                    'success'
                    )
                }
            })
        });          


        Livewire.on('deleteColorSizeEv', pivot => {
        
          
          Swal.fire({
              title: 'Estás seguro?',
              text: "Esta acción no se puede revertir.",
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Confirmar'
          }).then((result) => {
              if (result.isConfirmed) {
                  Livewire.emitTo('admin.color-size', 'deleteColorSize', pivot);
                  Swal.fire(
                  'Eliminado',
                  '',
                  'success'
                  )
              }
          })
          
      });
      </script>
  @endpush

  
</div>
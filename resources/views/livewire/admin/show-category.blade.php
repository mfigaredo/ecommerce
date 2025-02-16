<div class="container py-12">
    
    {{-- Formular Crear Subcategoría --}}
    <x-jet-form-section submit="save" class="mb-6">
        <x-slot name="title">
            {{-- {{ dump($brands) }} --}}
            Crear nueva subcategoría
        </x-slot>
        <x-slot name="description">
            Complete la información necesaria para poder crear una nueva subcategoría
        </x-slot>
        <x-slot name="form">
            <div class="col-span-6 sm:col-span-4">
                <x-jet-label>
                    Nombre
                </x-jet-label>
                <x-jet-input wire:model="createForm.name" type="text" class="w-full mt-1" />
                <x-jet-input-error for="createForm.name" />
            </div>
            <div class="col-span-6 sm:col-span-4">
                <x-jet-label>
                    Slug
                </x-jet-label>
                <x-jet-input wire:model="createForm.slug" type="text" class="w-full mt-1 bg-gray-200" disabled  />
                <x-jet-input-error for="createForm.slug" />
            </div>
            <div class="col-span-6 sm:col-span-4">
                <div class="flex items-center ">
                    <p>¿Esta subcategoría necesita especificar color?</p>
                    <div class="ml-auto">
                        <label>
                            <input type="radio" name="color" value="1" wire:model.defer="createForm.color">
                            Sí
                        </label>
                        <label class="ml-6">
                            <input type="radio" name="color" value="0" wire:model.defer="createForm.color">
                            No
                        </label>

                    </div>
                </div>
                <x-jet-input-error for="createForm.color" />
            </div>
            <div class="col-span-6 sm:col-span-4">
                <div class="flex items-center ">
                    <p>¿Esta subcategoría necesita especificar talla?</p>
                    <div class="ml-auto">
                        <label>
                            <input type="radio" name="size" value="1" wire:model.defer="createForm.size">
                            Sí
                        </label>
                        <label class="ml-6">
                            <input type="radio" name="size" value="0" wire:model.defer="createForm.size">
                            No
                        </label>

                    </div>
                </div>
                <x-jet-input-error for="createForm.size" />
            </div>
            

            
        </x-slot>
        <x-slot name="actions">
            <x-jet-action-message class="mr-3" on="saved">
                Subcategoría creada
            </x-jet-action-message>
            <x-jet-button>
                Agregar
            </x-jet-button>
        </x-slot>
    </x-jet-form-section>

    {{-- Lista de Subcategorías --}}
    <x-jet-action-section>
        <x-slot name="title">
            Lista de Subcategorías
        </x-slot>
        <x-slot name="description">
            Aquí encontrará todas las subcategorías agregadas
        </x-slot>
        <x-slot name="content">
            <table class="text-gray-600">
                <thead class="border-b border-gray-300">
                    <tr class="text-left">
                        <th class="py-2 w-3/4">Nombre</th>
                        <th class="py-2 w-1/4">C - S</th>
                        <th class="py-2">Acción</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-300">
                    @foreach ($subcategories as $subcategory)
                        <tr>
                            <td class="py-2">
                                
                                <span class="uppercase">
                                    {{ $subcategory->name }}
                                </span>
                            </td>
                            <td class="py-2">
                                {{ $subcategory->color }} - {{ $subcategory->size }}
                            </td>
                            <td class="py-2">
                                <div class="flex justify-between divide-x divide-gray-300 font-semibold">
                                    <a class="pr-2 hover:text-blue-600 cursor-pointer" wire:click="edit('{{ $subcategory->id }}')">Editar</a>
                                    <a class="pl-2 hover:text-red-600 cursor-pointer" wire:click="$emit('deleteSubcategory', '{{ $subcategory->id }}')">Eliminar</a>
                                    
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </x-slot>
    </x-jet-action-section>

    {{-- Modal Editar --}}
    <x-jet-dialog-modal wire:model="editForm.open">
        <x-slot name="title">
            Editar Subcategoría
        </x-slot>
        <x-slot name="content">

            <div class="space-y-3">

                <div>
                    <x-jet-label>
                        Nombre
                    </x-jet-label>
                    <x-jet-input wire:model="editForm.name" type="text" class="w-full mt-1" />
                    <x-jet-input-error for="editForm.name" />
                </div>
                <div>
                    <x-jet-label>
                        Slug
                    </x-jet-label>
                    <x-jet-input wire:model="editForm.slug" type="text" class="w-full mt-1 bg-gray-200" disabled  />
                    <x-jet-input-error for="editForm.slug" />
                </div>
                <div class="">
                    <div class="flex items-center ">
                        <p>¿Esta subcategoría necesita especificar color?</p>
                        <div class="ml-auto">
                            <label>
                                <input type="radio" name="color" value="1" wire:model.defer="editForm.color">
                                Sí
                            </label>
                            <label class="ml-6">
                                <input type="radio" name="color" value="0" wire:model.defer="editForm.color">
                                No
                            </label>
    
                        </div>
                    </div>
                    <x-jet-input-error for="editForm.color" />
                </div>
                <div class="">
                    <div class="flex items-center ">
                        <p>¿Esta subcategoría necesita especificar talla?</p>
                        <div class="ml-auto">
                            <label>
                                <input type="radio" name="size" value="1" wire:model.defer="editForm.size">
                                Sí
                            </label>
                            <label class="ml-6">
                                <input type="radio" name="size" value="0" wire:model.defer="editForm.size">
                                No
                            </label>
    
                        </div>
                    </div>
                    <x-jet-input-error for="editForm.size" />
                </div>                
            </div>

        </x-slot>
        <x-slot name="footer">
            <x-jet-danger-button
                wire:loading.attr="disabled"
                wire:target="update"
                wire:click="update"
            >
                Actualizar
            </x-jet-danger-button>
        </x-slot>
    </x-jet-dialog-modal>
    
    @push('script')
    <script>
      Livewire.on('deleteSubcategory', subcategoryId => {

        Swal.fire({
          title: 'Are you sure?',
          text: "You won't be able to revert this!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
          if (result.isConfirmed) {
            Livewire.emitTo('admin.show-category', 'delete', subcategoryId)
            Swal.fire(
              'Deleted!',
              'Your file has been deleted.',
              'success'
            )
          }
        })
      });
    </script>
    @endpush
</div>

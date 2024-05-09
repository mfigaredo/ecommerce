<div class="container py-12">
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight capitalize">
                Ciudad: {{ $city->name }}
            </h2>
            <x-button-enlace class="text-center" href="{{ route('admin.departments.show', $city->department_id) }}" color="blue">
                Regresar a <br>"{{ $city->department->name }}"
            </x-button-enlace>
        </div>
    </x-slot>

    {{-- Agregar Distrito --}}
    <x-jet-form-section submit="save" class="mb-6">
        <x-slot name="title">
            Agregar un nuevo Distrito
        </x-slot>
        <x-slot name="description">
            Complete la información necesaria para agregar un nuevo distrito.
        </x-slot>
        <x-slot name="form">
            <div class="col-span-6 sm:col-span-4">
                <x-jet-label>
                    Nombre
                </x-jet-label>
                <x-jet-input wire:model.defer="createForm.name" type="text" class="w-full mt-1" />
                <x-jet-input-error for="createForm.name"/>
            </div>
            
        </x-slot>
        <x-slot name="actions">
            <x-jet-action-message class="mr-3" on="saved">
                Distrito agregado.
            </x-jet-action-message>
            <x-jet-button>
                Agregar
            </x-jet-button>
        </x-slot>
    </x-jet-form-section>

    {{-- Lista de Distritos --}}
    <x-jet-action-section>
        <x-slot name="title">
            Lista de Distritos
        </x-slot>
        <x-slot name="description">
            Aquí encontrará todas los distritos agregados
        </x-slot>
        <x-slot name="content">

            @if ($districts->count())
            <table class="text-gray-600">
                <thead class="border-b border-gray-300">
                    <tr class="text-left">
                        <th class="py2 w-full">Nombre</th>
                        <th class="py2">Acción</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-300">
                    @foreach ($districts as $district)
                        <tr>
                            <td class="py-2">
                               
                                <span class="uppercase">
                                    {{ $district->name }}
                                </span>
                            </td>
                            
                            <td class="py-2">
                                <div class="flex justify-between divide-x divide-gray-300 font-semibold">
                                    <a class="pr-2 hover:text-blue-600 cursor-pointer" wire:click="edit('{{ $district->id }}')">Editar</a>
                                    <a class="pl-2 hover:text-red-600 cursor-pointer" wire:click="$emit('deleteDistrict', '{{ $district->id }}')">Eliminar</a>
                                    
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <p>No se encontraron distritos para esta ciudad.</p>
            @endif

            
        </x-slot>
    </x-jet-action-section>

    {{-- Modal Editar --}}
    <x-jet-dialog-modal wire:model="editForm.open">
        <x-slot name="title">
            Editar Distrito
        </x-slot>
        <x-slot name="content">

            <div class="space-y-3">
                <div>
                    <x-jet-label>
                        Nombre
                    </x-jet-label>
                    <x-jet-input wire:model.defer="editForm.name" type="text" class="w-full mt-1" />
                    <x-jet-input-error for="editForm.name" />
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
      Livewire.on('deleteDistrict', districtId => {

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
            Livewire.emitTo('admin.city-component', 'delete', districtId)
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

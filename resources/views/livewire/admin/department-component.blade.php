<div class="container py-12">
    {{-- Agregar Departamento --}}

    <x-jet-form-section submit="save" class="mb-6">
        <x-slot name="title">
            Agregar un nuevo Departamento
        </x-slot>
        <x-slot name="description">
            Complete la información necesaria para agregar un nuevo departamento.
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
                Departamento agregado.
            </x-jet-action-message>
            <x-jet-button>
                Agregar
            </x-jet-button>
        </x-slot>
    </x-jet-form-section>

    {{-- Lista de Departamentos --}}
    <x-jet-action-section>
        <x-slot name="title">
            Lista de Departamentos
        </x-slot>
        <x-slot name="description">
            Aquí encontrará todas los departamentos agregados
        </x-slot>
        <x-slot name="content">
            <table class="text-gray-600">
                <thead class="border-b border-gray-300">
                    <tr class="text-left">
                        <th class="py2 w-full">Nombre</th>
                        <th class="py2">Acción</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-300">
                    @foreach ($departments as $department)
                        <tr>
                            <td class="py-2">
                               
                                <a href="{{ route('admin.departments.show', $department) }}" class="uppercase underline hover:text-blue-400">
                                    {{ $department->name }}
                                </a>
                            </td>
                            <td class="py-2">
                                <div class="flex justify-between divide-x divide-gray-300 font-semibold">
                                    <a class="pr-2 hover:text-blue-600 cursor-pointer" wire:click="edit('{{ $department->id }}')">Editar</a>
                                    <a class="pl-2 hover:text-red-600 cursor-pointer" wire:click="$emit('deleteDepartment', '{{ $department->id }}')">Eliminar</a>
                                    
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
            Editar Departamento
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
      Livewire.on('deleteDepartment', departmentId => {

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
            Livewire.emitTo('admin.department-component', 'delete', departmentId)
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

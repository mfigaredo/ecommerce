<div class="mt-4">
    <div class="bg-gray-100 rounded-lg shadow-lg p-6">

        {{-- Color --}}
        <div class="mb-6">
            <x-jet-label>Color</x-jet-label>
            <div class="grid grid-cols-6 gap-6">
                @foreach ($colors as $color)
                    <label>
                        <input type="radio" name="color_id" value="{{$color->id}}" wire:model.defer="color_id">
                        <span class="capitalize ml-2 text-gray-700">{{ __($color->name) }}</span>
                    </label>
                @endforeach
            </div>
            <x-jet-input-error for="color_id" />
        </div>

        {{-- Cantidad --}}
        <div class="mb-6">
            <x-jet-label>Cantidad</x-jet-label>
            <x-jet-input type="number"
                wire:model.defer="quantity"
                placeholder="Ingrese una cantidad"
                class="w-full"
            />
            <x-jet-input-error for="quantity" />
        </div>

        <div class="flex justify-end items-center">

            <x-jet-action-message class="mr-3" on="saved">
              Agregado
            </x-jet-action-message>
  
            <x-jet-button 
              class=" disabled:bg-gray-300" 
              wire:click="save"
              wire:loading.attr="disabled"
              wire:target="save"
            >
              Agregar
            </x-jet-button>
          </div>
    </div>

    @if ($size_colors->count())
    <div class="mt-8">
        <table>
            <thead>
                <tr>
                    <th class="px-4 py-2 w-1/3">Color</th>
                    <th class="px-4 py-2 w-1/3">Cantidad</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($size_colors as $size_color)
                    <tr wire:key="product_color-{{$size_color->pivot->id}}">
                        <td class="capitalize px-4 py-2">
                            {{__($size_color->name)}}
                            {{-- {{$size_color->pivot}} --}}
                        </td>
                        <td class="px-4 py-2">
                            {{$size_color->pivot->quantity}} unidades

                        </td>
                        <td class="px-4 py-2 flex">
                            <x-jet-secondary-button 
                                class="ml-auto mr-2" 
                                wire:click="edit({{$size_color->pivot->id}})"
                                wire:loading.attr="disabled"
                                wire:target="edit({{$size_color->pivot->id}})"
                            >
                                Actualizar
                            </x-jet-secondary-button>

                            <x-jet-danger-button 
                                wire:click="$emit('deleteColorSizeEv', {{ $size_color->pivot->id }})"
                                
                            >
                            {{-- onclick="confirm('Are you sure?') || event.stopImmediatePropagation()"  --}}
                                Eliminar
                            </x-jet-danger-button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    @endif

    <x-jet-dialog-modal wire:model="open">
        <x-slot name="title">
            Editar Colores
        </x-slot>

        <x-slot name="content">
            <div class="mb-4">
                <x-jet-label>Color</x-jet-label>
                <x-select 
                   prompt="Seleccione un color"
                   :items="$colors"
                   idRef="id"
                   wire:model="pivot_color_id"
                   displayRef="nombre"
                   class="form-control w-full" 
                />
            </div>
            <div>
                <x-jet-label>Cantidad</x-jet-label>
                <x-jet-input 
                    type="number" 
                    placeholder="Ingrese una cantidad" 
                    class="w-full form-control" 
                    wire:model="pivot_quantity" 
                />

            </div>
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button 
                class="mx-4" 
                wire:click="$set('open',false)"
            >
                Cancelar
            </x-jet-secondary-button>
            <x-jet-button 
                wire:click="update"
                wire:loading.attr="disabled"
                wire:target="update"
            >
                Actualizar
            </x-jet-button>
        </x-slot>
    </x-jet-dialog-modal>

    
</div>

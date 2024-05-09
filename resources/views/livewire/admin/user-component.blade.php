<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Usuarios</h2>
    </x-slot>

    <div class="container py-12">
        <x-table-responsive>

            <div class="px-6 py-4">
                <x-jet-input type="text" class="w-full" placeholder="escriba algo para filtrar..." wire:model="search" />
            </div>

            @if ($users->count())
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                    <tr>
                        <th scope="col"  class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                        ID
                        </th>
                        <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Nombre
                        </th>
                        <th scope="col"  class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Email
                        </th>
                        <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Rol
                        </th>
                        <th scope="col" class="relative px-6 py-3">
                        <span class="sr-only">Editar</span>
                        </th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                    
                    @foreach ($users as $user)
                    
                    <tr wire:key="{{ $user->id }}">
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                        <div class="text-gray-900">
                            {{ $user->id }}
                        </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                        
                            <div class=" text-gray-900">
                                {{ $user->name }}
                            </div>
                        
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class=" text-gray-900">
                                {{ $user->email }}
                            </div>
                        
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <div class=" text-gray-900">
                                @if ($user->roles->count())
                                    {{ $user->roles->pluck('name')->map('ucwords')->implode(', ') }}
                                @else
                                    No tiene rol
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            {{-- <a href="#" class="text-indigo-600 hover:text-indigo-900">Editar</a> --}}
                            <label>
                                <input {{ $user->roles->count() ? 'checked' : '' }} type="radio" name="{{$user->email}}" value="1" wire:change="assignRole({{$user->id}}, $event.target.value)">
                                Sí
                            </label>
                            <label class="ml-2">
                                <input {{ $user->roles->count() ? '' : 'checked' }} type="radio" name="{{$user->email}}" value="0" wire:change="assignRole({{$user->id}}, $event.target.value)">
                                No
                            </label>
                        </td>
                    </tr>
                    
                    @endforeach
                    </tbody>
                </table>
                @if ($users->hasPages())
                    <div class="px-6 py-4">
                        {{ $users->links() }}
                    </div>
                    
                @endif

            @else
                <div class="px-6 py-4">
                    NO hay ningún registro coincidente.
                </div>
            @endif

            
        </x-table-responsive>
    </div>

</div>

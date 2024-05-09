


<header class="bg-trueGray-700 sticky top-0 z-50" x-data="dropdown()">
    <div class="container flex items-center justify-between md:justify-start  h-16 ">
        <a
          href="#"
          x-on:click.stop="show()"
          class="flex order-last md:order-first flex-col items-center justify-center px-6 md:px-4 bg-white bg-opacity-25 text-white cursor-pointer font-semibold h-full"
          :class="{'bg-opacity-100 text-orange-500': open}"
        >
            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                <path class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
            <span class="text-sm hidden md:block">Categorías</span>
        </a>

        <a href="/" class="mx-6 text-orange-400">
            <x-jet-application-mark class="block h-9 w-auto" />
        </a>

        <div class="flex-1 hidden md:block">
            @livewire('search')
        </div>

        <div class="mx-6 relative hidden md:block">
            @auth
                <x-jet-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                            <img class="h-8 w-8 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                        </button>
                        
                    </x-slot>

                    <x-slot name="content">
                        <!-- Account Management -->
                        <div class="block px-4 py-2 text-xs text-gray-400">
                            {{ __('Manage Account') }}
                        </div>

                        <x-jet-dropdown-link href="{{ route('profile.show') }}">
                            {{ __('Profile') }}
                        </x-jet-dropdown-link>

                        <x-jet-dropdown-link href="{{ route('orders.index') }}">
                            {{ __('Mis Ordenes') }}
                        </x-jet-dropdown-link>

                        @role('admin')
                            <x-jet-dropdown-link href="{{ route('admin.index') }}">
                                {{ __('Administrador') }}
                            </x-jet-dropdown-link>

                        @endrole

                        <div class="border-t border-gray-100"></div>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-jet-dropdown-link href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                            this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-jet-dropdown-link>
                        </form>
                    </x-slot>
                </x-jet-dropdown>
            @else
                <x-jet-dropdown>
                    <x-slot name="trigger">
                        <i class="fas fa-user-circle text-3xl cursor-pointer text-white"></i>
                    </x-slot>
                    <x-slot name="content">
                        <x-jet-dropdown-link href="{{ route('login') }}">
                            {{ __('Login') }}
                        </x-jet-dropdown-link>
                        <x-jet-dropdown-link href="{{ route('register') }}">
                            {{ __('Register') }}
                        </x-jet-dropdown-link>
                    </x-slot>
                </x-jet-dropdown>
            @endauth
        </div>

        <div class="hidden md:block">

            @livewire('dropdown-cart')
        </div>

    </div>
    
    <nav id="navigation-menu" 
        x-show="open" x-transition
        class="bg-trueGray-700 bg-opacity-25 absolute w-full hidden"
        :class="{ 'hidden': !open && false }"
    >
        {{-- Menú Computadora --}}
        <div class="container h-full hidden md:block">
            <div
              x-on:click.outside="close()"
              class="grid grid-cols-4 h-full relative"
            >
                <ul class="bg-white">
                    @foreach ($categories as $category)
                        <li class="text-trueGray-500 hover:bg-orange-500 hover:text-white navigation-link">
                            <a href="{{ route('categories.show', $category) }}" class="py-2 px-4 text-sm flex items-center">
                                <span class="w-9 flex justify-center">{!! $category->icon !!}</span>
                                <span class="">{{ $category->name }}</span>
                            </a>

                            <div class="navigation-submenu absolute bg-gray-100 w-3/4 top-0 right-0 h-full hidden">
                                <x-navigation-subcategories :category="$category" />
                            </div>
                        </li>
                    @endforeach
                </ul>
                <div class="col-span-3 bg-gray-100">
                    {{-- {{ $categories->first() }} --}}
                    <x-navigation-subcategories :category="$categories->first()" />
                </div>
            </div>
        </div>

        {{-- Menú Móvil --}}
        <div class="bg-white h-full md:hidden overflow-y-auto">

            <div class="container bg-gray-200 py-3 mb-2">
                @livewire('search')
            </div>

            <ul>
                @foreach ($categories as $category)
                <li class="text-trueGray-500 hover:bg-orange-500 hover:text-white">
                    <a href="{{ route('categories.show', $category) }}" class="py-2 px-4 text-sm flex items-center">
                        <span class="w-9 flex justify-center">{!! $category->icon !!}</span>
                        <span class="">{{ $category->name }}</span>
                    </a>

                    
                </li>
                @endforeach
            </ul>

            <p class="text-trueGray-500 px-6 my-2">USUARIOS</p>

            @livewire('cart-mobil')

            @auth
                
                <a href="{{ route('profile.show') }}" class="py-2 px-4 text-sm flex items-center text-trueGray-500 hover:bg-orange-500 hover:text-white">
                    <span class="w-9 flex justify-center">
                        <i class="far fa-address-card"></i>
                    </span>
                    <span class="">Perfil</span>
                </a>
                
                <a href="#" class="py-2 px-4 text-sm flex items-center text-trueGray-500 hover:bg-orange-500 hover:text-white" onclick="event.preventDefault();  document.getElementById('logout-form').submit();">
                    <span class="w-9 flex justify-center">
                        <i class="fas fa-sign-out-alt"></i>
                    </span>
                    <span class="">Cerrar sesión</span>
                </a>
                <form id="logout-form" method="POST" action="{{ route('logout') }}">
                    @csrf
                </form>
            @else
                <a href="{{ route('login') }}" class="py-2 px-4 text-sm flex items-center text-trueGray-500 hover:bg-orange-500 hover:text-white">
                    <span class="w-9 flex justify-center">
                        <i class="fas fa-user-circle"></i>
                    </span>
                    <span class="">Iniciar sesión</span>
                </a>
                <a href="{{ route('register') }}" class="py-2 px-4 text-sm flex items-center text-trueGray-500 hover:bg-orange-500 hover:text-white">
                    <span class="w-9 flex justify-center">
                        <i class="fas fa-fingerprint"></i>
                    </span>
                    <span class="">Registrarse</span>
                </a>
            @endauth
        </div>
    </nav>
</header>


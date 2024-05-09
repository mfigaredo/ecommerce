<x-app-layout>
    <div class="container py-8">

        @foreach ($categories as $category)
            @if ($category->products()->publicados()->count())
                <section class="mb-6">
                    <div class="flex items-center mb-2">
                        <h1 class="text-lg uppercase font-semibold text-gray-700">
                            {{ $category->name }} ({{ $category->products()->publicados()->take(15)->get()->count() }})
                        </h1>
                        <a href="{{ route('categories.show', $category) }}" class="text-orange-500 ml-2 font-semibold hover:text-orange-400 hover:underline">Ver más</a>
                    </div>
                    @livewire('category-products', ['category' => $category])
                </section>
            @endif
        @endforeach

    </div>

    @push('script')
        <script>
            livewire.on('glider', function(id) {
                console.log('Glider id:', id);
                
                let ele = document.querySelector('#glider-' + id);
                new Glider(ele.querySelector('.glider'), {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    draggable: true,
                    dots: ele.querySelector('.dots'),
                    arrows: {
                        prev: ele.querySelector('.glider-prev'),
                        next: ele.querySelector('.glider-next'),
                    },
                    responsive: [
                        {
                            breakpoint: 640,
                            settings: {
                                slidesToShow: 2.5,
                                slidesToScroll: 2,
                            }
                        },
                        {
                            breakpoint: 768,
                            settings: {
                                slidesToShow: 3.5,
                                slidesToScroll: 3,
                            }
                        },
                        {
                            breakpoint: 1024,
                            settings: {
                                slidesToShow: 4.5,
                                slidesToScroll: 4,
                            }
                        },
                        {
                            breakpoint: 1280,
                            settings: {
                                slidesToShow: 5.5,
                                slidesToScroll: 5,
                            }
                        },
                    ],
                });
            });
        </script>
    @endpush

</x-app-layout>
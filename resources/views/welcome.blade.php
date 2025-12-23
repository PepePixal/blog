<x-layouts.app>

    {{-- lisado público de posts publicados --}}
    <ul class="space-y-5 mb-5">
        @foreach ($posts as $post)
            <li>
                <article class="bg-white rounded-lg shadow-lg">

                    <img class="h-72 w-full object-cover object-center" 
                    {{-- obtiene el path de la imagen del post, gracias al accessor image en el modelo Post --}}
                    src="{{ $post->image }}" alt="no-image"
                    >

                    <div class="px-4 py-4">
                        <h1 class="font-semibold text-xl mb-2">
                            <a href="{{ route('posts.show', $post) }}">
                                {{ $post->title }}
                            </a>
                        </h1>

                        <div>
                            {{ $post->excerpt }}
                        </div>
                    </div>

                </article>
            </li>
        @endforeach
    </ul>

    {{-- menú de paginación --}}
    {{ $posts->links() }}

</x-layouts.app>
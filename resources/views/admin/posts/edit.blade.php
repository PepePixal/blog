<x-layouts.admin>

    {{-- bloques de css que se pueden personalizar, para insertar en la plantilla admin, con @stack('css') --}}
    @push('css')
        {{-- css  para el editor de texto enriquecido de Quill --}}
        <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet"/>

        {{-- css para select2 para el select de etiquetas --}}
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    @endpush
    
    <div class="mb-4">
        <!-- Breadcrumb o mígas de pan -->
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="{{ route('admin.dashboard') }}">Dashboard</flux:breadcrumbs.item>
            <flux:breadcrumbs.item href="{{ route('admin.posts.index') }}">Posts</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>Editar Post</flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </div>


    {{-- formulario de edición de post --}}
    <div class="bg-white rounded-lg shadow-lg px-6 py-8">
        <form action="{{ route('admin.posts.update', $post) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            <!-- genera un campo oculto (input) con un token de seguridad único. -->
            @csrf

            {{-- Indica que el formulario es un PUT, requerido por el método update del controlador --}}
            @method('PUT')

            {{-- previsualizar la imagen asociada al post --}}
            <div class="relative mb-4 mr-20 ml-20">
                <img id="imgPreview" class="w-full aspect-video object-contain object-center" 
                    {{-- si existe la imagen, obtiene su url y la muestra, si no, muestra la imagen por defecto --}}
                    src="{{ $post->image_path ? Storage::url($post->image_path) : '/storage/no-image.jpg'}}" alt="no-image"
                >
   
                {{-- botón cambiar imagen en la previsualización --}}
                <div class="absolute top-8 right-8">
                    <label class="bg-gray-200 px-4 py-2 rounded-lg cursor-pointer border border-gray-300">
                        Cambiar imagen
                        <input type="file" class="hidden" name="image" accept="image/*" onchange="preview_image(event, '#imgPreview')">
                    </label>

                    {{-- enlace descargar imagen --}}
                    <div class="bg-gray-200 px-4 py-2 rounded-lg cursor-pointer border border-gray-300 mt-10">
                        <a href="{{route('prueba', $post)}}">
                            Descargar imagen
                        </a>
                    </div>
                </div>
            </div>

            <!-- con el value= old(), se mantiene el valor del campo si hay un error en la validación,
                pero si no hay error, se asigna el valor de $post->title recibido en la vista edit.blade.php -->
            <flux:input  label="Título" name="title" type="text" value="{{ old('title', $post->title) }}" oninput="string_to_slug(this.value, '#slug')"/>

            <flux:input label="Slug" name="slug" id="slug" type="text" value="{{ old('slug', $post->slug) }}"/>

            <flux:select label="Categoría" name="category_id" placeholder="Selecciona una categoría">
                @foreach ($categories as $category)
                    <flux:select.option value="{{ old('category_id', $post->category_id) }}"
                        :selected="$category->id == old('category_id', $post->category_id)">
                        {{ $category->name }}
                    </flux:select.option>
                @endforeach
            </flux:select>

            <flux:textarea label="Resumen" name="excerpt" rows="3">{{ old('excerpt', $post->excerpt) }}</flux:textarea>

            {{-- selector etiquetas. Plugin Select2 --}}
            <div>
                <p class="font-medium text-sm mb-1">Etiquetas</p>
                <select id="tags" name="tags[]" multiple="multiple" style="width: 100%">
                    {{-- generar las options iterando las etiquetas de la BD --}}
                    @foreach ($tags as $tag)
                        <option value="{{ $tag->name }}" @selected(in_array($tag->name, old('tags', $post->tags->pluck('name')->toArray())))>
                            {{ $tag->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- texarea con editor normal, para contenido --}}
            {{-- <flux:textarea label="Contenido" name="content" rows="10">{{ old('content', $post->content) }}</flux:textarea> --}}

            {{-- editor de texto enriquecido de Quill, que NO podemos enviar con el formulario --}}
            <div class="mb-4">
                <p class="font-medium text-sm mb-1">Contenido</p>
                <div>
                   <div id="editor">
                        {!! old('content', $post->content) !!}
                    </div>
                </div>
            </div>
            {{-- textarea oculto que se sincroniza con el contenido del editor enriquecido, que se envía con el formulario --}}
            <textarea class="hidden" name="content" id="content" >{{ old('content', $post->content) }}</textarea>
 
            {{-- inpts radio is_published --}}
            <div class="mb-4">
                <p class="text-sm font-semibold">Estado</p>
                <label>
                    {{-- si el valor de is_published es 0, queda chequeado--}}
                    <input type="radio" name="is_published" value="0" @checked(old('is_published', $post->is_published) == 0)>
                    No publicado
                </label>
                {{-- agregar un espacio entre los labels--}}
                <span class="mx-2">&nbsp;</span>
                <label>
                    {{-- si el valor de is_published es 1, queda chequeado --}}
                    <input type="radio" name="is_published" value="1" @checked(old('is_published', $post->is_published) == 1)>
                    Publicado
                </label>
            </div>

            <div class="flex justify-end">
                <flux:button type="submit" variant="primary">Guardar</flux:button>
            </div>

        </form>
    </div>

    {{-- bloques de js que se pueden personalizar, para insertar en la plantilla admin, con @stack('js') --}}
    @push('js')
        {{-- cdn js para el editor de texto enriquecido de Quill --}}
        <script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>

        {{-- js para el editor de texto enriquecido de Quill --}}
        <script>
            const quill = new Quill('#editor', {
                theme: 'snow'
            });

            // cuando el usuario escribe en el editor enriquecido, se actualiza el valor del textarea content oculto
            quill.on('text-change', function() {
                document.querySelector('#content').value = quill.root.innerHTML;
            });

        </script>

        {{-- cdn js de jQuery para el plugin select2 --}} 
        <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

        {{-- cdn js para plugin select2, para las etiquetas en el formulario de edición --}}
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

        {{-- js script del plugin selected2 --}}
        <script>
            $(document).ready(function() {
                $('#tags').select2({
                    tags: true,
                    tokenSeparators: [',']
                });
            });
        </script>
   
    @endpush    

</x-layouts.admin>
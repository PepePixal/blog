<x-layouts.admin>
    <div class="mb-4">

        <!-- Breadcrumb o mígas de pan -->
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="{{ route('admin.dashboard') }}">Dashboard</flux:breadcrumbs.item>
            <flux:breadcrumbs.item href="{{ route('admin.posts.index') }}">Posts</flux:breadcrumbs.item>
            <flux:breadcrumbs.item >Editar Post</flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </div>

    <form action="{{ route('admin.posts.update', $post->id) }}" method="POST" class="bg-white rounded-lg shadow-lg px-6 py-8 space-y-4">
        <!-- genera un campo oculto (input) con un token de seguridad único. -->
        @csrf

        {{-- Indica que el formulario es un PUT, requerido por el método update del controlador --}}
        @method('PUT')
        
        <!-- con el value= old(), se mantiene el valor del campo si hay un error en la validación,
             pero si no hay error, se asigna el valor de $post->title recibido en la vista edit.blade.php -->
        <flux:input label="Título" name="title" type="text" value="{{ old('title', $post->title) }}"/>
        
        <flux:input label="Slug" name="slug" type="text" value="{{ old('slug', $post->slug) }}"/>
            
        <flux:select label="Categoría" name="category_id" placeholder="Selecciona una categoría">
            @foreach ($categories as $category)
                <flux:select.option value="{{ old('category_id', $post->category_id) }}" :selected="$category->id == old('category_id', $post->category_id)">
                    {{ $category->name }}
                </flux:select.option>
            @endforeach
        </flux:select>
          
        <flux:textarea label="Resumen" name="excerpt" rows="3">{{ old('excerpt', $post->excerpt) }}</flux:textarea>
            
        <flux:textarea label="Contenido" name="content" rows="10">{{ old('content', $post->content) }}</flux:textarea>
          
        <div>
            <p class="text-sm font-semibold">Estado</p>
            <label>
                <input type="radio" name="is_published" value="0" @checked(old('is_published', $post->is_published) == 0)>
                No publicado
            </label>
            {{-- agregar un espacio entre los labels--}}
            <span class="mx-2">&nbsp;</span>    
            <label>
                <input type="radio" name="is_published" value="1" @checked(old('is_published', $post->is_published) == 1) >
                Publicado
            </label>
       </div>

        <div class="flex justify-end">
            <flux:button type="submit" variant="primary">Guardar</flux:button>
        </div>
        
    </form>

</x-layouts.admin>

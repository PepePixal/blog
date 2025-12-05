<x-layouts.admin>
    <div class="mb-4">
        <!-- Breadcrumb o mígas de pan -->
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="{{ route('admin.dashboard') }}">Dashboard</flux:breadcrumbs.item>
            <flux:breadcrumbs.item href="{{ route('admin.posts.index') }}">Posts</flux:breadcrumbs.item>
            <flux:breadcrumbs.item >Crear Nuevo Post</flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </div>

    <form action="{{ route('admin.posts.store') }}" method="POST" class="bg-white rounded-lg shadow-lg px-6 py-8 space-y-4">
        <!-- genera un campo oculto (input) con un token de seguridad único. -->
        @csrf
        
        <!-- con el value="{{ old('name') }}" se mantiene el valor del campo si hay un error en la validación -->
        <!-- oninput="string_to_slug(this.value, '#slug')", escucha el evento de entrada de caracteres del usuario y ejecuta la función string_to_slug -->
        <flux:input label="Título" name="title" type="text" value="{{ old('title') }}" oninput="string_to_slug(this.value, '#slug')"/>
        
        <!-- el id="slug" es necesario para que la función string_to_slug pueda acceder al input con name="slug" -->
        <flux:input label="Slug" name="slug" id="slug" type="text" value="{{ old('slug') }}"/>

        <flux:select label="Categoría" name="category_id" placeholder="Selecciona una categoría">
            @foreach ($categories as $category)
                <flux:select.option value="{{ $category->id }}" :selected="$category->id == old('category_id')">
                    {{ $category->name }}
                </flux:select.option>
            @endforeach
        </flux:select>

        <div class="flex justify-end">
            <flux:button type="submit" variant="primary">Guardar</flux:button>
        </div>
    </form>

</x-layouts.admin>
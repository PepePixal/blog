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
        
        <!-- con el value=" ", se mantiene el valor del campo si hay un error en la validación,
             pero si no hay error, se asigna el valor del name de la categoria recibida en la vista edit.blade.php -->
        <flux:input label="Titulo" name="title" type="text" value="{{ old('title', $post->title) }}"/>

        <div class="flex justify-end">
            <flux:button type="submit" variant="primary">Guardar</flux:button>
        </div>
        
    </form>

</x-layouts.admin>

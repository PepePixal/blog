<x-layouts.admin>
    <div class="mb-4">
        <!-- Breadcrumb o mígas de pan -->
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="{{ route('admin.dashboard') }}">Dashboard</flux:breadcrumbs.item>
            <flux:breadcrumbs.item href="{{ route('admin.permissions.index') }}">Permisos</flux:breadcrumbs.item>
            <flux:breadcrumbs.item >Editar Permiso</flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </div>

    <form action="{{ route('admin.permissions.update', $permission) }}" method="POST" class="bg-white rounded-lg shadow-lg px-6 py-8 space-y-4">
        <!-- genera un campo oculto (input) con un token de seguridad único. -->
        @csrf

        {{-- Indica que el formulario es un PUT, requerido por el método update del controlador --}}
        @method('PUT')
        
        <!-- con el value=" ", se mantiene el valor del campo si hay un error en la validación,
             pero si no hay error, se asigna el valor del name de la categoria recibida en la vista edit.blade.php -->
        <flux:input label="Nombre" name="name" type="text" value="{{ old('name', $permission->name) }}"/>

        <div class="flex justify-end">
            <flux:button type="submit" variant="primary">Guardar</flux:button>
        </div>
        
    </form>

</x-layouts.admin>
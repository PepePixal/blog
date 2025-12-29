<x-layouts.admin>
    <div class="mb-4">
        <!-- Breadcrumb o mígas de pan -->
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="{{ route('admin.dashboard') }}">Dashboard</flux:breadcrumbs.item>
            <flux:breadcrumbs.item href="{{ route('admin.roles.index') }}">Roles</flux:breadcrumbs.item>
            <flux:breadcrumbs.item >Crear Nuevo</flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </div>

    <form action="{{ route('admin.roles.store') }}" method="POST" class="bg-white rounded-lg shadow-lg px-6 py-8 space-y-4">
        <!-- genera un campo oculto (input) con un token de seguridad único. -->
        @csrf
        
        <!-- con el value="{{ old('name') }}" se mantiene el valor del campo si hay un error en la validación -->
        <flux:input label="Nombre" name="name" type="text" value="{{ old('name') }}"/>

        <div>
            <p class="text-sm font-medium mb-2">Permisos</p>
            <ul>
                @foreach ($permissions as $permission)
                    <li class="mb-1">
                        {{-- las opciones seleccionadas se almacenan en el array permissions[] --}}
                        <flux:checkbox 
                            name="permissions[]" 
                            value="{{ $permission->id }}" 
                            label="{{ $permission->name }}"
                            {{-- :checked obtiene true o false, según la condición:
                            si el id de $permission->id existe en el antiguo array 'permissions' o en el array vacio [] --}}
                            :checked="in_array($permission->id, old('permissions', []))"
                        />
                    </li>
                @endforeach
            </ul>
        </div>

        <div class="flex justify-end">
            <flux:button type="submit" variant="primary">Guardar</flux:button>
        </div>
        
    </form>
    
</x-layouts.admin>
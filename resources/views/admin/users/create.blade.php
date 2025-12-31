<x-layouts.admin>
    <div class="mb-4">
        <!-- Breadcrumb o mígas de pan -->
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="{{ route('admin.dashboard') }}">Dashboard</flux:breadcrumbs.item>
            <flux:breadcrumbs.item href="{{ route('admin.users.index') }}">Usuarios</flux:breadcrumbs.item>
            <flux:breadcrumbs.item >Crear Nuevo</flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </div>

    <form action="{{ route('admin.users.store') }}" method="POST" class="bg-white rounded-lg shadow-lg px-6 py-8 space-y-4">
        <!-- genera un campo oculto (input) con un token de seguridad único. -->
        @csrf
        
        <!-- con el value="{{ old('name') }}" se mantiene el valor del campo si hay un error en la validación -->
        <flux:input label="Nombre" name="name" type="text" value="{{ old('name') }}"/>
        
        <flux:input label="Email" name="email" type="email" value="{{ old('email') }}"/>
        
        <flux:input label="Contraseña" name="password" type="password"/>
        
        <flux:input label="Confirmar Contraseña" name="password_confirmation" type="password"/>

        {{-- listado de roles con checkbox --}}
        <div>
            <p class="text-sm font-medium mb-2">Roles</p>
            <ul>
                @foreach ($roles as $role)
                    <li class="mb-1">
                        {{-- las opciones seleccionadas se almacenan en el array roles[] --}}
                        <flux:checkbox 
                            name="roles[]" 
                            value="{{ $role->id }}" 
                            label="{{ $role->name }}"
                            {{-- :checked obtiene true o false, según la condición:
                            si el id de $role->id existe en el antiguo array 'roles' o en el array vacio [] --}}
                            :checked="in_array($role->id, old('roles', []))"
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
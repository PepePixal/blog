<x-layouts.admin>

    <div class="mb-4">
        <!-- Breadcrumb o mígas de pan -->
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="{{ route('admin.dashboard') }}">Dashboard</flux:breadcrumbs.item>
            <flux:breadcrumbs.item href="{{ route('admin.users.index') }}">Usuarios</flux:breadcrumbs.item>
            <flux:breadcrumbs.item >Editar</flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </div>

        <form action="{{ route('admin.users.update', $user) }}" method="POST" class="bg-white rounded-lg shadow-lg px-6 py-8 space-y-4">
        <!-- genera un campo oculto (input) con un token de seguridad único. -->
        @csrf

        {{-- Indica que el formulario es un PUT, requerido por el método update del controlador --}}
        <!-- genera un campo oculto (input) con el método HTTP PUT -->
        @method('PUT')
        
        <!-- con el value="{{ old('name') }}" se mantiene el valor del campo si hay un error en la validación,
        pero si no hay error, se asigna el valor de $user->name recibido en la vista edit.blade.php -->
        <flux:input label="Nombre" name="name" type="text" value="{{ old('name', $user->name) }}"/>
        
        <flux:input label="Email" name="email" type="email" value="{{ old('email', $user->email) }}"/>
        
        <flux:input label="Contraseña" name="password" type="password"/>
        
        <flux:input label="Confirmar Contraseña" name="password_confirmation" type="password"/>

        <!-- lista de roles, obteniendo los roles chequeados del usuario, si los tiene-->
        <div>
            <p class="text-sm font-medium mb-2">Roles</p>
            <ul>
                @foreach ($roles as $role)
                    <li class="mb-1">
                        {{-- las opciones chequeadas se almacenan en el array roles[] --}}
                        <flux:checkbox 
                            name="roles[]" 
                            value="{{ $role->id }}" 
                            label="{{ $role->name }}"
                            {{-- :checked obtiene true o false, según la condición:
                            si el id de $role->id existe en el antiguo array 'roles' o 
                            en el array generado a partir de la lista de ids de roles del usuario, creada con el método pluck() --}}
                            :checked="in_array($role->id, old('roles', $user->roles->pluck('id')->toArray()))"
                        />
                    </li>
                @endforeach
            </ul>
        </div>

        <div class="flex justify-end">
            <flux:button type="submit" variant="primary">Actualizar</flux:button>
        </div>
        
    </form>

</x-layouts.admin>
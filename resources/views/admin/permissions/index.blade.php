<x-layouts.admin>
        <div class="flex justify-between items-center mb-4">
        <!-- Breadcrumb o mígas de pan -->
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="{{ route('admin.dashboard') }}">Dashboard</flux:breadcrumbs.item>
            <flux:breadcrumbs.item href="{{ route('admin.permissions.index') }}">Permisos</flux:breadcrumbs.item>
        </flux:breadcrumbs>

        <!-- Botón para crear un nuevo permiso -->
        <a href="{{ route('admin.permissions.create') }}" class="btn btn-blue text-sm">
            Nuevo Permiso
        </a>
    </div>

    <!-- listado de Categorías -->
    <!-- Tabla html con Tailwind CSS de: https://flowbite.com/docs/components/tables/ -->
    <div class="relative overflow-x-auto bg-neutral-primary-soft shadow-xs rounded-base ">
        <table class="w-full text-sm text-left rtl:text-right text-body">
            <thead class="text-sm text-body bg-neutral-secondary-soft border-b rounded-base border-default">
                <tr>
                    <th scope="col" class="px-6 py-3 font-medium">
                        ID
                    </th>
                    <th scope="col" class="px-6 py-3 font-medium">
                        Nombre
                    </th>
                    <th scope="col" class="px-6 py-3 font-medium" width="100">
                        Editar
                    </th>
                    <th scope="col" class="px-6 py-3 font-medium">
                        Eliminar
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($permissions as $permission)
                    <tr class="bg-neutral-primary border-b border-default">
                        <th scope="row" class="px-6 py-4 font-medium text-heading whitespace-nowrap">
                            {{ $permission->id }}
                        </th>
                        <td class="px-6 py-4">
                            {{ $permission->name }}
                        </td>
                        <td class="px-6 py-4">
                            <a href="{{ route('admin.permissions.edit', $permission) }}" class="btn btn-green">
                                Editar
                            </a>
                        </td>
                        <td class="px-6 py-4">
                            <form class="delete-form" action="{{ route('admin.permissions.destroy', $permission) }}"
                                method="POST">
                                @csrf

                                {{-- Como el método de la ruta destroy, donde se envía el id de la permiso es tipo DELETE,
                                debemos agregar el método DELETE --}}
                                @method('DELETE')

                                {{-- El submit esta siendo escuchado por el script que se encuentra en el push js --}}
                                <button type="submit" class="btn btn-red">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>


    {{-- con @push('js') se renderiza el script en la vista admin.blade.php --}}
    @push('js')

        {{-- Script con alerta SweetAlert2 para confirmar la eliminación de la categoría --}}
        <script>
            // seleccionar todos los formularios con la clase delete-form y para cada formulario
            document.querySelectorAll('.delete-form').forEach(form => {

                // agrega un escuchador del evento submit
                form.addEventListener('submit', function (event) {

                    // prevenir el envío del formulario
                    event.preventDefault();

                    // alerta fire de SweetAlert2
                    Swal.fire({
                        title: '¿Estás seguro?',
                        text: "¡No podrás revertir esto!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Sí, eliminar',
                        cancelButtonText: 'Cancelar',
                    }).then((result) => {

                        // si el usuario confirma la eliminación
                        if (result.isConfirmed) {
                            // enviar el formulario para eliminar el permiso
                            form.submit();
                        }
                    });

                });
            });
        </script>
    @endpush

</x-layouts.admin>
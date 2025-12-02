<x-layouts.admin >
    <div class="flex justify-between items-center mb-4">
        <!-- Breadcrumb o mígas de pan -->
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="{{ route('admin.dashboard') }}">Dashboard</flux:breadcrumbs.item>
            <flux:breadcrumbs.item href="{{ route('admin.categories.index') }}">Categorías</flux:breadcrumbs.item>
        </flux:breadcrumbs>

        <!-- Botón para crear una nueva categoría -->
        <a href="{{ route('admin.categories.create') }}" class="btn btn-blue text-sm">
            Nueva Categoría
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
                    <th scope="col" class="px-6 py-3 font-medium">
                        Editar
                    </th>
                    <th scope="col" class="px-6 py-3 font-medium">
                        Eliminar
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $category)
                    <tr class="bg-neutral-primary border-b border-default">
                        <th scope="row" class="px-6 py-4 font-medium text-heading whitespace-nowrap">
                            {{ $category->id }}
                        </th>
                        <td class="px-6 py-4">
                            {{ $category->name }}
                        </td>
                        <td class="px-6 py-4">
                            Editar
                        </td>
                        <td class="px-6 py-4">
                            Eliminar
                        </td>
                    </tr>
                @endforeach        
            </tbody>
        </table>
    </div>


</x-layouts.admin>
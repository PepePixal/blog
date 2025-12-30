<x-layouts.admin>
    <div class="mb-4">
        <!-- Breadcrumb o mígas de pan -->
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="{{ route('admin.dashboard') }}">Dashboard</flux:breadcrumbs.item>
            <flux:breadcrumbs.item href="{{ route('admin.users.index') }}">Usuarios</flux:breadcrumbs.item>
            <flux:breadcrumbs.item >Mostrar Usuario</flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </div>

</x-layouts.admin>  
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
        <flux:input label="Slug" name="slug" id="slug" type="text" value="{{ old('slug') }}"/>
        <flux:select label="Categoría" name="category_id" wire:model="industry" placeholder="Selecciona una categoría">
            @foreach ($categories as $category)
                <flux:select.option value="{{ $category->id }}">{{ $category->name }}</flux:select.option>
            @endforeach
        </flux:select>

        <div class="flex justify-end">
            <flux:button type="submit" variant="primary">Guardar</flux:button>
        </div>
    </form>

    @push('js')
        {{-- función para generar el slug automaticamente, recibe dos parámetros:
          1. str: la cadena de texto a convertir
          2. querySelector: el selector del campo de entrada
        Función obtenida de https://es.stackoverflow.com/questions/184278/como-convertir-una-cadena-de-texto-en-slug-con-javascript --}}
        <script>
            function string_to_slug(str, querySelector){
                // Eliminar espacios al inicio y final
                str = str.replace(/^\s+|\s+$/g, '');
                
                // Convertir todo a minúsculas
                str = str.toLowerCase();
                
                // Definir caracteres especiales y sus reemplazos
                var from = "àáäâèéëêìíïîòóöôùúüûñç·/_,:;";
                var to = "aaaaeeeeiiiioooouuuunc------";
                
                // Reemplazar caracteres especiales por los correspondientes en 'to'
                for (var i = 0, l = from.length; i < l; i++) {
                    str = str.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));
                }
                
                // Eliminar caracteres no alfanuméricos y reemplazar espacios por guiones
                str = str.replace(/[^a-z0-9 -]/g, '')
                    .replace(/\s+/g, '-')
                    .replace(/-+/g, '-');
                
                // Asignar el slug generado al campo de entrada correspondiente
                document.querySelector(querySelector).value = str;
            }
        </script>
    @endpush

</x-layouts.admin>
# 📁 Estructura de Vistas - Laravel Blog

## Esquema Visual de Directorios

```
resources/views/
│
├── 📂 admin/                           # Vistas del área de administración
│   └── dashboard.blade.php             # Dashboard del admin
│
├── 📂 components/                      # Componentes reutilizables de Blade
│   ├── action-message.blade.php        # Mensajes de acción
│   ├── app-logo-icon.blade.php         # Ícono del logo
│   ├── app-logo.blade.php              # Logo completo
│   ├── auth-header.blade.php           # Encabezado de autenticación
│   ├── auth-session-status.blade.php   # Estado de sesión
│   ├── input-otp.blade.php             # Input para OTP (códigos)
│   ├── placeholder-pattern.blade.php   # Patrón de placeholder
│   │
│   ├── 📂 layouts/                     # Plantillas base (layouts)
│   │   ├── admin.blade.php             # Layout principal del admin
│   │   ├── app.blade.php               # Layout principal de la app
│   │   ├── auth.blade.php              # Layout de autenticación
│   │   │
│   │   ├── 📂 app/                     # Componentes del layout app
│   │   │   ├── header.blade.php        # Cabecera de la aplicación
│   │   │   └── sidebar.blade.php       # Barra lateral
│   │   │
│   │   └── 📂 auth/                    # Variantes del layout auth
│   │       ├── card.blade.php          # Auth con tarjeta
│   │       ├── simple.blade.php        # Auth simple
│   │       └── split.blade.php         # Auth con split screen
│   │
│   └── 📂 settings/                    # Componentes de configuración
│       └── layout.blade.php            # Layout de settings
│
├── 📂 flux/                            # Componentes Flux UI
│   ├── 📂 icon/                        # Íconos SVG personalizados
│   │   ├── book-open-text.blade.php    # Ícono libro
│   │   ├── chevrons-up-down.blade.php  # Ícono chevrones
│   │   ├── folder-git-2.blade.php      # Ícono carpeta git
│   │   └── layout-grid.blade.php       # Ícono grid
│   │
│   └── 📂 navlist/                     # Componentes de navegación
│       └── group.blade.php             # Grupo de navegación
│
├── 📂 livewire/                        # Componentes Livewire
│   ├── 📂 auth/                        # Autenticación Livewire
│   │   ├── confirm-password.blade.php  # Confirmar contraseña
│   │   ├── forgot-password.blade.php   # Olvidé mi contraseña
│   │   ├── login.blade.php             # Login
│   │   ├── register.blade.php          # Registro
│   │   ├── reset-password.blade.php    # Resetear contraseña
│   │   ├── two-factor-challenge.blade.php  # Desafío 2FA
│   │   └── verify-email.blade.php      # Verificar email
│   │
│   └── 📂 settings/                    # Configuración de usuario
│       ├── appearance.blade.php        # Apariencia
│       ├── delete-user-form.blade.php  # Eliminar cuenta
│       ├── password.blade.php          # Cambiar contraseña
│       ├── profile.blade.php           # Perfil de usuario
│       ├── two-factor.blade.php        # Autenticación 2FA
│       │
│       └── 📂 two-factor/              # Sub-componentes 2FA
│           └── recovery-codes.blade.php # Códigos de recuperación
│
├── 📂 partials/                        # Partials globales
│   ├── head.blade.php                  # <head> HTML
│   └── settings-heading.blade.php      # Encabezado de settings
│
├── dashboard.blade.php                 # Dashboard principal
└── welcome.blade.php                   # Página de bienvenida
```

## 📊 Resumen de la Estructura

### 🎨 Por Tipo de Vista

| Categoría | Directorio | Propósito |
|-----------|-----------|-----------|
| **Layouts** | `components/layouts/` | Plantillas base que envuelven el contenido |
| **Admin** | `admin/` | Vistas del panel de administración |
| **Componentes** | `components/` | Componentes reutilizables de Blade |
| **Livewire** | `livewire/` | Componentes interactivos con Livewire |
| **Flux UI** | `flux/` | Componentes de la librería Flux |
| **Partials** | `partials/` | Fragmentos parciales de HTML |

### 🔑 Layouts Principales

1. **`app.blade.php`** - Layout principal de la aplicación
   - Incluye: `header.blade.php`, `sidebar.blade.php`
   
2. **`admin.blade.php`** - Layout del área de administración
   
3. **`auth.blade.php`** - Layout para páginas de autenticación
   - Variantes: `card`, `simple`, `split`

### 🔐 Sistema de Autenticación

El sistema de autenticación está dividido en:

- **Componentes base**: `components/auth-*`
- **Vistas Livewire**: `livewire/auth/`
  - Login/Register
  - Recuperación de contraseña
  - Verificación de email
  - Autenticación de 2 factores

### ⚙️ Sistema de Configuración

- **Layout**: `components/settings/layout.blade.php`
- **Componentes Livewire**: `livewire/settings/`
  - Perfil de usuario
  - Cambio de contraseña
  - Autenticación 2FA
  - Apariencia
  - Eliminación de cuenta

### 🎯 Flujo de Vistas Típico

```
Usuario no autenticado:
welcome.blade.php → livewire/auth/login.blade.php → dashboard.blade.php

Usuario autenticado:
dashboard.blade.php (usa layout: components/layouts/app.blade.php)
├── Header (components/layouts/app/header.blade.php)
└── Sidebar (components/layouts/app/sidebar.blade.php)

Área de Admin:
admin/dashboard.blade.php (usa layout: components/layouts/admin.blade.php)
```

## 📝 Notas Importantes

1. **Blade Components**: Los archivos en `components/` se usan como `<x-nombre-componente />`
2. **Livewire**: Los componentes en `livewire/` son componentes interactivos que se actualizan dinámicamente
3. **Flux**: Librería de componentes UI adicionales
4. **Layouts anidados**: Los layouts pueden incluir otros componentes para crear estructuras complejas

## 🔄 Convenciones de Nomenclatura

- `*.blade.php` - Todos los archivos de vista usan la extensión Blade
- Kebab-case para nombres de archivo (ej: `two-factor-challenge.blade.php`)
- Estructura por funcionalidad (auth, settings, admin)

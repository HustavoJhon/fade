# FADE Barbershop Management System

Sistema de gestion integral para barberias con reservas online, panel de administracion, portal de barberos y area de clientes.

## Stack Tecnologico

### Backend
- **Laravel 13** - Framework PHP
- **Livewire 4** - Componentes dinamicos del lado del servidor
- **MySQL** - Base de datos relacional
- **Barryvdh/DomPDF** - Generacion de reportes PDF
- **OpenSpout** - Exportacion de reportes a Excel

### Frontend
- **Tailwind CSS 4** - Framework de estilos utilitario
- **Alpine.js 3** - Interactividad en el frontend
- **Chart.js** - Graficos y estadisticas
- **FullCalendar** - Calendario de citas interactivo
- **Vite** - Bundler y dev server

### Infraestructura
- **Docker** - Contenedores para desarrollo
- **PHP 8.4** - Version de PHP

## Cuentas por Defecto

Todas las cuentas usan la contrasena `password`.

### Administrador
| Campo | Valor |
|-------|-------|
| Email | admin@barberia.com |
| Rol | admin |
| Acceso | Panel completo de administracion |

### Barbero
Los barberos se crean durante el seed con emails generados aleatoriamente por Faker. Para obtener las credenciales exactas, ejecute en la base de datos:

```sql
SELECT u.name, u.email FROM users u JOIN barbers b ON b.user_id = u.id;
```

Nombres de los barberos creados:
- Carlos Mendes
- Rafael Oliveira
- Diego Santos

Contrasena comun: `password`

### Cliente
Los clientes se crean durante el seed con emails aleatorios. Para listarlos:

```sql
SELECT u.name, u.email FROM users u JOIN customers c ON c.user_id = u.id;
```

Contrasena comun: `password`

## Modulos del Sistema

### Publico (Sin autenticacion)
| Ruta | Descripcion |
|------|-------------|
| `/` | Landing page con presentacion del negocio |
| `/servicios` | Listado de servicios con precios |
| `/nosotros` | Informacion sobre la barberia |
| `/contacto` | Formulario de contacto |
| `/horarios` | Horarios de atencion |
| `/galeria` | Portafolio de trabajos realizados |
| `/reservar` | Sistema de reserva de citas online (paso a paso: servicio, barbero, fecha, confirmacion) |

### Cliente (`/customer/*`)
| Modulo | Descripcion |
|--------|-------------|
| Dashboard | Resumen de citas proximas, historial reciente, estadisticas personales |
| Mis Citas | Listado completo de citas con posibilidad de cancelacion |
| Historial | Historial de pagos y gastos totales |
| Perfil | Edicion de datos personales y contrasena |

### Barbero (`/barber/*`)
| Modulo | Descripcion |
|--------|-------------|
| Dashboard | Resumen del dia: citas de hoy, pendientes, ingresos del dia, resumen semanal |
| Citas | Gestion de citas asignadas con filtros por estado y fecha |
| Horario | Configuracion de disponibilidad (activo/inactivo) |
| Ganancias | Calculo de comisiones con filtro por periodo (hoy, semana, mes, ano, rango personalizado) |

### Administrador (`/admin/*`)
| Modulo | Descripcion |
|--------|-------------|
| Dashboard | Panel principal con metricas globales, graficos de ingresos, citas por estado |
| Calendario | Vista mensual de todas las citas con FullCalendar |
| Citas | CRUD completo de citas con filtros avanzados |
| Barberos | Gestion de barberos: perfiles, comisiones, disponibilidad |
| Servicios | CRUD de servicios y categorias |
| Clientes | Gestion de clientes registrados |
| Finanzas | Control de ingresos y gastos con registro manual |
| Reportes | Generacion de reportes PDF/Excel (ventas, citas, clientes, barberos, finanzas) con filtro por fechas |
| Galeria | Gestion de imagenes del portafolio con carga y eliminacion |
| Cupones | Gestion de codigos de descuento |
| Configuracion | Ajustes del negocio (nombre, direccion, telefono, moneda, etc.) |

## Instalacion y Desarrollo

### Requisitos
- Docker y Docker Compose
- PHP 8.3+
- Composer
- Node.js 20+

### Setup rapido
```bash
# Clonar repositorio
git clone <repo-url> fade
cd fade

# Configurar entorno
cp .env.example .env

# Iniciar contenedores Docker
docker compose up -d

# Instalar dependencias
docker exec laravel-app composer install
docker exec laravel-app npm install

# Configurar aplicacion
docker exec laravel-app php artisan key:generate
docker exec laravel-app php artisan storage:link

# Migrar y seedear base de datos
docker exec laravel-app php artisan migrate --seed

# Compilar assets
docker exec laravel-app npm run build

# Acceder
# http://localhost:8080
```

### Comandos utiles
```bash
# Ejecutar seed de datos de demostracion (500 citas, 80 clientes, etc.)
docker exec laravel-app php artisan db:seed --class=DemoDataSeeder

# Desarrollo con hot reload
docker exec laravel-app php artisan dev
```

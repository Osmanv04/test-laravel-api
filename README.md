# Laravel Products API

API RESTful para gestión de productos con precios en múltiples divisas, desarrollada con Laravel 13.

## Características

- ✅ CRUD completo de productos
- ✅ Gestión de precios en múltiples divisas
- ✅ Autenticación con Laravel Sanctum
- ✅ Validación de datos con mensajes personalizados
- ✅ Respuestas JSON estandarizadas
- ✅ Eloquent ORM para interacción con base de datos
- ✅ API Resources para transformación de datos
- ✅ Seeders para datos de prueba

## Requisitos

- PHP 8.4 o superior
- Composer
- PostgreSQL
- Node.js y NPM

## Instalación

1. **Clonar el repositorio**
   ```bash
   git clone <url-del-repositorio>
   cd test-laravel-api
   ```

2. **Instalar dependencias**
   ```bash
   composer install
   npm install
   ```

3. **Configurar entorno**
   ```bash
   cp .env.example .env
   ```
   
   Configurar la base de datos en `.env`:
   ```env
   DB_CONNECTION=pgsql
   DB_HOST=127.0.0.1
   DB_PORT=5432
   DB_DATABASE=your_database
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

4. **Ejecutar migraciones y seeders**
   ```bash
   php artisan migrate:fresh --seed
   ```

5. **Iniciar servidor**
   ```bash
   php artisan serve
   ```

## Credenciales de Prueba

El seeder crea un usuario de prueba:
- **Email:** test@example.com
- **Password:** password

## Documentación de la API

La documentación completa está disponible en formato de colección de Postman:
- Archivo: `postman_collection.json`
- Importar en Postman: File → Import → Seleccionar el archivo

### Flujo de Uso en Postman

1. **Login**
   - Ejecutar la request `POST /api/login`
   - Copiar el token de la respuesta
   - Pegar el token en la variable `token` de la colección

2. **Usar endpoints protegidos**
   - Todos los endpoints de productos requieren autenticación
   - La autenticación se configura automáticamente desde la variable `token`

## Endpoints

### Autenticación

#### Login
- **POST** `/api/login`
- **Body:**
  ```json
  {
    "email": "test@example.com",
    "password": "password"
  }
  ```
- **Respuesta:**
  ```json
  {
    "success": true,
    "message": "Login exitoso",
    "data": {
      "token": "1|abc123...",
      "user": {
        "id": 1,
        "name": "Test User",
        "email": "test@example.com"
      }
    }
  }
  ```

#### Logout
- **POST** `/api/logout`
- **Headers:** `Authorization: Bearer {token}`
- **Respuesta:**
  ```json
  {
    "success": true,
    "message": "Sesión cerrada exitosamente",
    "data": null
  }
  ```

### Divisas

#### Obtener Divisas
- **GET** `/api/currencies`
- **Descripción:** Obtiene todas las divisas disponibles
- **Respuesta:**
  ```json
  {
    "success": true,
    "message": "Divisas cargadas correctamente",
    "data": [
      {
        "id": 1,
        "name": "USD",
        "symbol": "$",
        "exchange_rate": "1.000000"
      },
      {
        "id": 2,
        "name": "EUR",
        "symbol": "€",
        "exchange_rate": "0.920000"
      },
      {
        "id": 3,
        "name": "VES",
        "symbol": "Bs",
        "exchange_rate": "888.118300"
      }
    ]
  }
  ```

### Productos

#### Obtener Todos los Productos
- **GET** `/api/products`
- **Headers:** `Authorization: Bearer {token}`
- **Respuesta:**
  ```json
  {
    "success": true,
    "message": "Productos cargados correctamente",
    "data": [
      {
        "id": 1,
        "name": "Laptop HP",
        "description": "Laptop HP Pavilion 15.6\" Intel i5 8GB RAM 256GB SSD",
        "price": "799.99",
        "tax_cost": "64.00",
        "manufacturing_cost": "450.00",
        "currency": {
          "id": 1,
          "name": "USD",
          "symbol": "$",
          "exchange_rate": "1.000000"
        },
        "prices": []
      }
    ]
  }
  ```

#### Crear Producto
- **POST** `/api/products`
- **Headers:** `Authorization: Bearer {token}`, `Content-Type: application/json`
- **Body:**
  ```json
  {
    "name": "Laptop Dell XPS 15",
    "description": "Laptop Dell XPS 15 15.6\" Intel i7 16GB RAM 512GB SSD",
    "price": 1299.99,
    "currency_id": 1,
    "tax_cost": 104.00,
    "manufacturing_cost": 700.00
  }
  ```
- **Respuesta:** 201 Created

#### Obtener Producto por ID
- **GET** `/api/products/{id}`
- **Headers:** `Authorization: Bearer {token}`
- **Descripción:** Obtiene un producto con sus precios en diferentes divisas
- **Respuesta:**
  ```json
  {
    "success": true,
    "message": "Producto cargado correctamente",
    "data": {
      "id": 1,
      "name": "Laptop HP",
      "description": "Laptop HP Pavilion 15.6\" Intel i5 8GB RAM 256GB SSD",
      "price": "799.99",
      "tax_cost": "64.00",
      "manufacturing_cost": "450.00",
      "currency": {
        "id": 1,
        "name": "USD",
        "symbol": "$",
        "exchange_rate": "1.000000"
      },
      "prices": [
        {
          "id": 1,
          "price": "799.99",
          "currency": {
            "id": 1,
            "name": "USD",
            "symbol": "$",
            "exchange_rate": "1.000000"
          }
        }
      ]
    }
  }
  ```

#### Actualizar Producto
- **PUT** `/api/products/{id}`
- **Headers:** `Authorization: Bearer {token}`, `Content-Type: application/json`
- **Body:** (Todos los campos son opcionales)
  ```json
  {
    "name": "Laptop HP Actualizado",
    "price": 849.99
  }
  ```

#### Eliminar Producto
- **DELETE** `/api/products/{id}`
- **Headers:** `Authorization: Bearer {token}`
- **Respuesta:** 204 No Content

#### Obtener Precios de Producto
- **GET** `/api/products/{id}/prices`
- **Headers:** `Authorization: Bearer {token}`
- **Descripción:** Obtiene todos los precios de un producto en diferentes divisas

#### Crear Precio de Producto
- **POST** `/api/products/{id}/prices`
- **Headers:** `Authorization: Bearer {token}`, `Content-Type: application/json`
- **Body:**
  ```json
  {
    "price": 850.00,
    "currency_id": 2
  }
  ```
- **Respuesta:** 201 Created

## Validación

La API incluye validación de datos con mensajes personalizados en español:

**Ejemplo de error de validación:**
```json
{
  "success": false,
  "message": "Error de validación",
  "errors": {
    "name": ["El nombre del producto es obligatorio."],
    "currency_id": ["La divisa seleccionada no existe."]
  }
}
```

**Ejemplo de error de autenticación:**
```json
{
  "success": false,
  "message": "Debe autenticarse para acceder a esta ruta",
  "errors": []
}
```

## Estructura de Respuestas

### Éxito
```json
{
  "success": true,
  "message": "Mensaje de éxito",
  "data": { ... }
}
```

### Error
```json
{
  "success": false,
  "message": "Mensaje de error",
  "errors": { ... }
}
```

## Tecnologías Utilizadas

- **Framework:** Laravel 13
- **PHP:** 8.4
- **Base de datos:** PostgreSQL
- **Autenticación:** Laravel Sanctum
- **Validación:** Form Requests
- **Transformación de datos:** API Resources
- **Documentación:** Postman Collection

## Modelo de Datos

### Products
- `id` - Identificador único
- `name` - Nombre del producto
- `description` - Descripción
- `price` - Precio en divisa base
- `currency_id` - ID de la divisa base
- `tax_cost` - Costo de impuestos
- `manufacturing_cost` - Costo de fabricación

### Currencies
- `id` - Identificador único
- `name` - Nombre de la divisa (USD, EUR, VES)
- `symbol` - Símbolo ($, €, Bs)
- `exchange_rate` - Tasa de cambio respecto a USD

### ProductPrices
- `id` - Identificador único
- `product_id` - ID del producto
- `currency_id` - ID de la divisa
- `price` - Precio en la divisa especificada

## Seguridad

- Autenticación mediante tokens Bearer (Laravel Sanctum)
- Validación de datos en todos los endpoints
- Foreign keys con cascade on delete
- Manejo estandarizado de excepciones


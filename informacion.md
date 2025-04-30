# 📚 Documentación del Sistema Atlas

## 🏗️ Estructura del Sistema

### 📂 Arquitectura MVC
// El sistema utiliza el patrón MVC para separar la lógica de negocio, la presentación y el control
El sistema sigue el patrón de diseño Modelo-Vista-Controlador (MVC), donde:
- **Modelo**: Maneja la lógica de negocio y la interacción con la base de datos
- **Vista**: Presenta la información al usuario
- **Controlador**: Coordina las interacciones entre el modelo y la vista

### 🔄 Sistema de Enrutamiento
// Todas las peticiones pasan por index.php y se redirigen según las reglas del .htaccess
El sistema utiliza un archivo `index.php` como punto de entrada único, implementando URLs amigables mediante el archivo `.htaccess`. Esto permite:
- URLs limpias y semánticas
- Mejor SEO
- Mayor seguridad al ocultar la estructura real del sistema

## 📝 Convenciones de Código

### 🎯 Nomenclatura en POO
// Las convenciones de nombres ayudan a mantener el código organizado y fácil de entender
Las convenciones de nomenclatura son esenciales para mantener un código limpio y mantenible:

#### 📌 Upper Camel Case (Pascal Case)
// Usar para nombres de clases: cada palabra comienza con mayúscula
- **Uso**: Nombres de clases
- **Regla**: Cada palabra comienza con mayúscula
- **Ejemplos**:
  - `Peticiones`
  - `DetallesDeUsuario`
  - `ControladorBase`

#### 📌 Lower Camel Case
// Usar para variables y métodos: primera palabra en minúscula, siguientes con mayúscula
- **Uso**: Variables y métodos
- **Regla**: Primera palabra en minúscula, siguientes con mayúscula
- **Ejemplos**:
  - `nombreUsuario`
  - `calcularTotal`
  - `obtenerDatos`

## 🌐 Sistema de URLs
// El sistema procesa las URLs para determinar qué controlador y acción ejecutar
El sistema procesa las URLs de la siguiente manera:
1. La petición llega al `index.php`
2. El router analiza la URL
3. Se carga el controlador correspondiente
4. Se ejecuta la acción específica
5. Se renderiza la vista



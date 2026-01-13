# 🛡️ Sistema de Login Seguro con PHP (MVC + PDO)

![PHP](https://img.shields.io/badge/PHP-7.4%2B-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MariaDB](https://img.shields.io/badge/MariaDB-003545?style=for-the-badge&logo=mariadb&logoColor=white)
![MVC](https://img.shields.io/badge/Architecture-MVC-orange?style=for-the-badge)
![Security](https://img.shields.io/badge/Security-OWASP_Practices-red?style=for-the-badge)

Este repositorio contiene la implementación de un sistema de autenticación completo bajo el patrón de arquitectura **Modelo-Vista-Controlador (MVC)** utilizando **PDO** para el acceso a datos. El proyecto se centra en la aplicación de medidas de seguridad robustas ("Defense in Depth") para proteger contra vulnerabilidades comunes en aplicaciones web.

---

## 📋 Características de Seguridad Implementadas

Este proyecto cumple estrictamente con los requisitos de seguridad planteados, divididos en las siguientes capas:

### 1. 🔒 Seguridad en Frontend (Validación JS)
* **Validación de entrada:** Control estricto en el cliente mediante JavaScript.
* **Longitud:** Usuario y contraseña restringidos entre 8 y 15 caracteres.
* **Lista Blanca (Whitelist):** La contraseña exige mayúsculas, minúsculas y caracteres especiales seguros. Se bloquean explícitamente caracteres peligrosos para evitar XSS/Injection (`' " \ / < > = ( )`).

### 2. 🍪 Gestión de Sesiones y Cookies
* **Cookies Seguras:** Configuración de `HttpOnly`, `Secure` y `SameSite` para prevenir el robo de cookies y ataques XSS.
* **Limpieza Profunda:** Al hacer logout, se elimina explícitamente la cookie de sesión antes de destruir la sesión en el servidor.
* **Configuración en Runtime:** Modificación dinámica de parámetros de `php.ini` para asegurar el entorno independientemente de la configuración del servidor.

### 3. 🛡️ Protección del Servidor
* **Token CSRF:** Generación y validación de tokens únicos por sesión para proteger operaciones críticas (modificaciones, borrados, etc.).
* **Rate Limiting:** Control de intentos de acceso fallidos (máximo 5 intentos) para mitigar ataques de fuerza bruta.
* **Ciclo de Vida de Sesión:**
    * Regeneración periódica del ID de sesión (anti-fixation).
    * Timeout absoluto de sesión (ej. 2 horas) independientemente de la actividad.

### 4. 👤 Lógica de Negocio y Usuarios
* **Registro de Usuarios:** Implementación de formulario de alta.
* **Aprobación de Administrador:** * Los nuevos registros se crean con el estado `admitido = false`.
    * Solo un administrador puede validar y activar a los usuarios nuevos (`admitido = true`).

---

## 🛠️ Instalación y Puesta en Marcha

### Requisitos
* Servidor Web (Apache/Nginx)
* PHP 7.4 o superior
* Base de datos MariaDB / MySQL

### Configuración de la Base de Datos
Ejecuta el siguiente script SQL para generar la estructura de usuarios compatible con la lógica de aprobación:

```sql
CREATE DATABASE login_mvc_db;
USE login_mvc_db;

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    admitido BOOLEAN DEFAULT FALSE, -- FALSE para nuevos registros, TRUE para admin/aprobados
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insertar un administrador inicial (Pass: Admin@1234)
-- Nota: La contraseña debe estar hasheada con password_hash() en producción
INSERT INTO usuarios (usuario, password, admitido) 
VALUES ('admin', '$2y$10$EjemploDeHashGenerado...', TRUE);

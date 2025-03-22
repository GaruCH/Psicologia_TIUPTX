# Gestor de Información y Pruebas Psicológicas - Universidad Politécnica de Tlaxcala

## Descripción
El **Gestor de Información y Pruebas Psicológicas** de la Universidad Politécnica de Tlaxcala centraliza la administración de pruebas psicológicas, optimizando tiempos y reduciendo errores. Este sistema mejora el análisis de datos, agiliza la toma de decisiones y contribuye a la sostenibilidad institucional al minimizar el uso de recursos físicos.

El área de Psicología de la universidad enfrentaba dificultades en la gestión de pruebas debido a procesos manuales. Para solucionarlo, se desarrolló una aplicación web que centraliza la información de usuarios, pruebas y citas, mejorando la calidad del servicio.

## Tecnologías Utilizadas
- **Backend:** CodeIgniter 4, PHP
- **Frontend:** HTML5, CSS, JavaScript, Bootstrap 4
- **Base de Datos:** MySQL

## Funcionalidades por Módulo

### 🛡️ Módulo 1: Autenticación y Recuperación de Cuenta
- **Login:** Acceso al sistema con credenciales de usuario.
- **Recuperar Contraseña:** Restablecimiento de contraseña en caso de olvido.

### 👥 Módulo 2: Gestión de Usuarios
- **Registro de Pacientes:** Permite registrar diferentes tipos de pacientes:
  - Alumnos (estudiantes de la universidad).
  - Administrativos (personal de la institución).
  - Invitados (personas externas que requieren atención psicológica).

### 👑 Módulo 3: Superadmin (Máximo nivel de administración)
- **Inicio:** Vista general con métricas y datos.
- **Usuarios:** Gestión de todos los usuarios del sistema (creación, edición, eliminación).

### 🔧 Módulo 4: Administrador (Gestión de psicólogos y asignaciones)
- **Inicio:** Panel de control con reportes CSV.
- **Asignaciones:** Modificar asignaciones de pacientes a psicólogos.
- **Psicólogos:** Administración de perfiles de psicólogos.

### 🩺 Módulo 5: Psicólogos (Evaluación y atención de pacientes)
- **Inicio:** Panel con información relevante.
- **Generación de Reportes:** Exportar reportes CSV.
- **Horarios:** Gestión de disponibilidad.
- **Pacientes:** Administración de pacientes y asignación de pruebas.
- **Historial de Pacientes:** Consulta de historial de pacientes.
- **Citas:** Agendar y gestionar citas.
- **Historial de Citas:** Registro de citas pasadas y futuras.
- **Ubicación Actual:** Registro de ubicación en tiempo real.

### 🏥 Módulo 6: Pacientes (Usuarios que reciben atención psicológica)
- **Inicio:** Información general de pruebas y citas.
- **Citas:** Agendar citas con psicólogos.
- **Historial de Citas:** Consulta de citas pasadas y futuras.
- **Pruebas Psicológicas:** Realización de pruebas asignadas.

## Instalación y Configuración
1. Clona el repositorio:
   ```sh
   git clone https://github.com/tu-usuario/tu-repositorio.git
   ```
2. Configura el entorno:
   - Asegúrate de tener PHP, MySQL y CodeIgniter 4 instalados.
   - Configura la base de datos en `app/Config/Database.php`.
3. Inicia el servidor:
   ```sh
   php spark serve
   ```
4. Accede a la aplicación desde `http://localhost:8080`.

## Contribuciones
Las contribuciones son bienvenidas. Para colaborar:
1. Haz un fork del repositorio.
2. Crea una rama con tu mejora (`git checkout -b feature/nueva-funcionalidad`).
3. Realiza los cambios y súbelos (`git commit -m 'Añadir nueva funcionalidad'`).
4. Envía un Pull Request.

## Licencia
Este proyecto está bajo la licencia MIT. Consulta el archivo `LICENSE` para más detalles.

---
💡 *Desarrollado para optimizar la gestión de pruebas psicológicas en la Universidad Politécnica de Tlaxcala.*

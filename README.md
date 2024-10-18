# Sistema de llamadas de Seguros para la empresa Atlántida
El desarrollo de un sistema enfocado en el registro y seguimiento de las llamadas de emergencia, integrando funcionalidades que permitan la captura de datos necesarios para la generación de reportes automatizados y el análisis de rendimiento de los operadores.

## Estructura del Proyecto

El proyecto sigue la arquitectura MVC:

```
/too-ssea
    /app
        /controllers
        /models
        /views
    /config
        /migrations
            /msql
            /sqlite
        /seeders
    /public
        index.php
    /resources
        /css
        /js
    /routes
        web.php
```

## Instalación

1. **Clonar el repositorio:**

   ```bash
   gh repo clone danielparrillas/too-ssea
   ```

2. **Navegar al directorio del proyecto:**

   ```bash
   cd too-ssea
   ```

3. **Configurar la base de datos:**
    - Edita el archivo config/database.php con las siguientes variables:

    - $host: Dirección del servidor de base de datos (por ejemplo, '127.0.0.1').

    - $db_name: Nombre de la base de datos (por ejemplo, 'too-sea').

    - $username: Nombre de usuario de la base de datos (por ejemplo, 'root').

    - $password: Contraseña de la base de datos (por ejemplo, 'tu_contraseña').

    > Para la conexión de la base de datos, puedes utilizar uno de los siguientes métodos, dependiendo de la base de datos que desees utilizar. Renombra el método elegido a connect() para definir cuál será la conexión principal:

    - _connect(): Realiza la conexión usando MySQL con las credenciales proporcionadas. Renombra este método a connect() si deseas utilizar MySQL.

    - connect(): Realiza la conexión usando SQLite. Cambia el DSN para conectarse a un archivo de base de datos SQLite (example.db). Renombra este método a connect() si deseas utilizar SQLite.

4. Crear las tablas necesarias ejecutando las migraciones: Para crear las tablas necesarias, ejecuta los scripts SQL de las migraciones correspondientes:

    - Mysql: Ejecuta el script de migración de MySQL en la carpeta config/migrations/mysql.
    - SQLite: Ejecuta el script de migración de SQLite en la carpeta config/migrations/sqlite.
    > Si deseas utilizar SQLite, asegúrate de que el archivo de base de datos (por ejemplo, example.db) esté en la carpeta config/migrations/sqlite.

    > Opcionalmente puedes ejecutar los seeders para poblar la base de datos con datos de prueba.
    
    ```bash
    php ./database/seeders/user_seeder.php
    php ./database/seeders/cliente_seeder.php
    ```


5. **Iniciar el servidor PHP:**

   ```bash
   php -S localhost:8000 -t public
   ```

## Licencia

Este proyecto está licenciado bajo la Licencia MIT.


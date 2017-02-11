Sistema de Pedidos Ares
=======================

Vista Previa
------------
Usted puede ver una vista previa del proyecto en el siguiente enlace:
[http://ares.bexandyrodriguez.com.ve](http://ares.bexandyrodriguez.com.ve)

Instalación
---------------------------
### Clone el proyecto en su servidor local

La manera más fácil es clonar el proyecto desde el repositorio [GitHub](https://github.com/bexandy/ares-app/). 

Clone el repositorio en su servidor local vía ssh:

    git clone https://github.com/bexandy/ares-app 



### Instale y actualice las dependencias utilizando Composer

1. Si usted tiene composer instalado globalmente, puede lanzar el comando de instalación directamente:

        cd ares-app
        composer install
    

2. Si no tiene Composer intalado, descargue composer dentro del directorio de su proyecto e instale las dependencias:

        curl -s https://getcomposer.org/installer | php
        php composer.phar install

Si no tiene acceso a Curl, entonces instale Composer en su proyecto como indica la [documentación](https://getcomposer.org/doc/00-intro.md).

### Instale EdpSuperLuminal y construya la caché de clases

EdpSuperluminal es un módulo ZF2 que almacena en caché las clases Zend usadas por su aplicación en un solo archivo. 
Incluir este archivo reduce en gran medida el tiempo de ejecución de su aplicación, 
ya que las llamadas al autocargador estándar se eliminan casi por completo.

Clone este módulo dentro de su directorio vendor/ 

    cd ares-app/vendor
    git clone https://github.com/EvanDotPro/EdpSuperluminal.git
    
En su navegador, vaya a http://ares-app.local/?EDPSUPERLUMINAL_CACHE para crear la clase inicial. 
Debe hacer esto para cualquier página que tenga dependiencias pesadas, y/o cada página con un gráfico de dependencias diferente. 
Cada llamada se añadirá a la caché con las clases recién descubiertas. 
LAS SOLICITUDES CUANDO SE ESTÁ CONSTRUYENDO EL CACHE SERÁ LENTO, ESTO ES NORMAL.

Una vez que este construida la caché, puede deshabilitar y eliminar EdpSuperluminal, 
dejando la línea agregada a public/index.php


    <?php
    chdir(dirname(__DIR__));
    define('ZF_CLASS_CACHE', 'data/cache/classes.php.cache'); if (file_exists(ZF_CLASS_CACHE)) require_once ZF_CLASS_CACHE;
    
### Creacion de la BDD del proyecto
1. Cree una base de datos en blanco para su proyecto, de la manera en que usted este habituado, por ejemplo:
 
        mysql -u root -p
        create database ares-app;
        quit
    
2. Restaure la bdd con el archivo sql ubicado el el directorio ares-app/data/bdd
 
        cd ares-app/data/bdd
        mysql -u root -p -v ares-app < aresdata.sql
    
 
### Configuración de la conexión a la BDD
1. Acceda al directorio ares-app/config/autoload, copie el archivo local.php.dist y renombrelo a local.php

2. Introduzca la información de configuración de la BDD para el driver PDO Mysql
 
        <?php
            return array(
                'db' => array(
                'dsn' => 'mysql:dbname=ares-app;host=localhost;charset=utf8',
                'username' => 'tu_usuario',
                'password' => 'tu_contraseña',
                ),
            );
    

Configuración del Web server
----------------------------

### Configuración Apache

Para configurar apache, configure un host virtual para que apunte al directorio public/
de su proyecto .Debe ser algo como a continuación:

    <VirtualHost *:80>
        ServerName ares-app.local
        DocumentRoot /path/ares-app/public
        SetEnv APPLICATION_ENV "development"
        <Directory /path/ares-app/public>
            DirectoryIndex index.php
            AllowOverride All
            Order allow,deny
            Allow from all
            <IfModule mod_authz_core.c>
            Require all granted
            </IfModule>
        </Directory>
    </VirtualHost>

Esta configuracion la agregará al directorio sites/available de apache, por ejemplo

        cd /etc/apache2/sites-available
        sudo nano ares-app.conf

Luego debe habilitar el sitio en apache

        sudo a2ensite ares-app.conf

Agregue la entrada respectiva a su archivo hosts

        sudo nano /etc/hosts
        127.0.0.1       ares-app.local

Recargue el servidor Apache y visite la pagina en su navegador
        
        sudo service apache2 reload

**Nota** Si aparecen mensaje de error, por ejemplo:

    Fatal error: Uncaught exception 'PDOException' with message 'could not find driver'
   
Puede probar con verificar los pasos anteriores y luego regenerar la cache, para ello debe borrar los archivos cache
localizados en ares-app/data/cache

        cd ares-app/data/cache
        rm -f module-classmap-cache.php
        rm -f module-config-cache.php

Luego vuelva a intentar acceder al sitio en http://ares-app.local


Otras opciones de Web server
----------------------------

### Nginx setup

To setup nginx, open your `/path/to/nginx/nginx.conf` and add an
[include directive](http://nginx.org/en/docs/ngx_core_module.html#include) below
into `http` block if it does not already exist:

    http {
        # ...
        include sites-enabled/*.conf;
    }


Create a virtual host configuration file for your project under `/path/to/nginx/sites-enabled/zf2-app.localhost.conf`
it should look something like below:

    server {
        listen       80;
        server_name  zf2-app.localhost;
        root         /path/to/zf2-app/public;

        location / {
            index index.php;
            try_files $uri $uri/ @php;
        }

        location @php {
            # Pass the PHP requests to FastCGI server (php-fpm) on 127.0.0.1:9000
            fastcgi_pass   127.0.0.1:9000;
            fastcgi_param  SCRIPT_FILENAME /path/to/zf2-app/public/index.php;
            include fastcgi_params;
        }
    }

Restart the nginx, now you should be ready to go!

### Vagrant server

This project supports a basic [Vagrant](http://docs.vagrantup.com/v2/getting-started/index.html) configuration with an inline shell provisioner to run the Skeleton Application in a [VirtualBox](https://www.virtualbox.org/wiki/Downloads).

1. Run vagrant up command

    vagrant up

2. Visit [http://localhost:8085](http://localhost:8085) in your browser

Look in [Vagrantfile](Vagrantfile) for configuration details.

### PHP CLI server

La forma más sencilla de empezar si está utilizando PHP 5.4 o superior es iniciar 
el PHP  CLI Server interno en el directorio raíz:

    php -S 0.0.0.0:8080 -t public/ public/index.php

Esto iniciará el cli-server en el puerto 8080 y lo enlazará a todas las
interfaces.

**Nota:** El servidor de CLI incorporado es *para desarrollo solamente*.
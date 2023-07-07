<p align="center"><img src="https://laravel.com/assets/img/components/logo-laravel.svg"></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

## Propósito y objetivos de la aplicación.

Aplicación API REST FULL PHP utilizando el framework de laravel en su versión 5.3. Creada para brindar su consumo a una SPA realizada en VueJS v3.

## Requerimeintos Tecnicos para el desarr

Composer version 2.2.21
PHP <= 7.1
MySql v5.7.31.
Apache v2.4.46
Framework: Laravel v5.3
Postman

## Instalacion y despliegue

1 -Descargar proyecto.

2- Crear base de datos con nombre db_canes (dejare el sql en la raiz del proyeto).

3- Configurar .env para la conexion a la base de datos, cambiar el name al .env-example que subi.

--------------- NOTA ----- IMPORTANTE--------
Para poder acceder a la DB, en una nueva instalacion de Laravel 5.3, me lanzaba un error algo raro, el cual me mostraba que estaba usando la configuracion .env-exmple para conectar a la DB, limpie la configuracion del framework, pero no resultaba.

Por tanto, para poder desplegar e iniciar el desarrollo, apoyandome de informacion de comunidades, como https://stackoverflow.com , modifique el archivo (database.php) con los mismos valores de la configuracion de la db que hay en el fragmento dedicado para ello en el .env.

Asi fue que pudo arrancar la comunicacion entre mi backend php y Mysql.

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_canes
DB_USERNAME=root
DB_PASSWORD=

//Instalar dependencias
4- composer install

//Correr migraciones
5- php artisan migrate

//Levantar el server
6- php artisan serve

//Poblar la db (a eleccion)
7-Correr las consultas de insert en mysql(dejo el datos_db_canes.sql en la raiz del proyecto).

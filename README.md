# Manual de instalación – Proyecto USA2

## Requisitos previos

Antes de iniciar la instalación, asegúrate de tener instalado:

- Docker Desktop  
- Docker Compose  

Puedes comprobarlo ejecutando:

docker --version  
docker compose version  

## Estructura del proyecto

El proyecto debe tener esta estructura:

(nombre_que_quiera)/  
├── Dockerfile  
├── docker-compose.yml  
├── src/  
│   ├── app/  
│   ├── public/  
│   └── ...  
└── README.md  

## Instalación y puesta en marcha

### 1. Clonar el repositorio

git clone https://github.com/ivanCompa/TFG_USA2  
cd TFG_USA2  

### 2. Construir y levantar los contenedores

docker compose up --build -d  

Esto creará:

- Contenedor Apache + PHP 8.2  
- Contenedor MySQL 8.0  
- Contenedor phpMyAdmin  
- Montaje del código en /var/www/html  

## Acceso a los servicios

Aplicación web:  
http://localhost:8080  

phpMyAdmin:  
http://localhost:8081  

Credenciales de acceso a MySQL:  
Servidor: db  
Usuario: usuario  
Contraseña: usuario123  
Base de datos: usa2  

## Importar la base de datos

Para que los productos de prueba aparezcan en la aplicación, es necesario importar el archivo usa2.sql dentro de la base de datos usa2.

Pasos:

1. Acceder a phpMyAdmin  
2. Seleccionar la base de datos "usa2"  
3. Pulsar en "Importar"  
4. Seleccionar el archivo usa2.sql  
5. Ejecutar la importación  

## Contenedores incluidos

### web (Apache + PHP 8.2)
- Construido desde el Dockerfile  
- Monta ./src en /var/www/html  
- Puerto expuesto: 8080  

### db (MySQL 8.0)
- Usuario: usuario  
- Contraseña: usuario123  
- Base de datos: usa2  
- Puerto expuesto: 3306  

### phpmyadmin
- Acceso rápido a la base de datos  
- Puerto expuesto: 8081  

## Comandos útiles

Ver logs:  
docker compose logs -f  

Reiniciar contenedores:  
docker compose restart  

Detener contenedores:  
docker compose down  

Eliminar contenedores y volúmenes:  
docker compose down -v  

## Proyecto funcionando

Una vez completados los pasos:

- La web estará disponible en http://localhost:8080  
- La base de datos en localhost:3306  
- phpMyAdmin en http://localhost:8081  

El entorno quedará completamente operativo.

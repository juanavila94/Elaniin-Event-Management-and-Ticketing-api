# Elaniin-Elaniin-Event-Ticket-Management-api

Esta API permite a usuarios autentificados, la creacion de Eventos con sus respectivos tipos de entradas. Como tambien
a usuarios no autentificados, la compra de estas entradas bajo la creacion de una orden y posterior a realizar el pago 
de las entradas, recibira un mail con los detalles de la compra.

## Tabla de Contenidos

- [Tecnologías](#tecnologías)
- [Comandos](#comandos)

## Tecnologías

Para la creacion del proyecto, se utilizaron las siguientes tecnologias principales:

- Laravel v. 10.x          
- Docker Compose
- Postman
- Git
- Github
- DBeaver

## Comandos

Para la instalacion del proyecto y desarollo del proyecto se necesitan los siguientes comandos:

-CLONACION- (git)
para su utlizacion en un entorno local se recomienda la clonacion del repositorio
 clonacion HTTP: git clone https://github.com/juanavila94/Elaniin-Event-Management-and-Ticketing-api.git
 clonacion SSH: git clone git@github.com:juanavila94/Elaniin-Event-Management-and-Ticketing-api.git


-DIRECTORIO-
-Navegue hacia el directorio del proyecto con el siguiente comando:
    cd ../../Event-Management


-INSTALA LAS DEPENDENCIAS BASICAS-
con el comando: 
    php artisan install

    
-VARIABLES-
-Cree un nuevo archivo .env(entornos de variable) con sus propias variables.
por ejemplo:  touch .develop.env


-DOCKER-
Una vez instalado y configuradas las variables, es hora de correr Docker:
- instala las dependencias presentes en el proyecto con el comando :
    php composer require laravel/sail --dev


- Genera el archivo docker-compose.yml para Sail con el comando:
    php artisan sail:install


-Luego crea los contenedores de Docker respectivos al proyecto:
 en el directorio ingresa el comando:
   ./vendor/bin/sail up -d
este comando correra los contenedores declarados en el archivo docker-compose.yml


-Finalmente para parar los contenedores ingresa el comando:
  ./vendor/bin/sail down


..EL PROYECTO DEBERIA FUNCIONAR LUEGO DE SEGUIR ESTAS INSTRUCCIONES..
   

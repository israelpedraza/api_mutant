# api_mutant
Este proyecto está realizado usando el Framework CodeIgniter 2.1.4 desplegado sobre un ambiente LAMP
Desarrollado con la intención de evaluar secuencias de ADN y encontrar si hace match con al menos secuencias de 4 letras iguales 

Versiones utilizadas:
PHP 7.2
MySQL 5.6
Apache 2.4
Linux


1. Pasos previos a la instalación :
- Verificar que la configuración del servidor apache tenga habilitada la sobreescritura de URLs en el archivo (generalmente ubicado en) /etc/httpd/conf/httpd.conf
- Reemplazar la linea AllowOverride None por AllowOverride All:

    # AllowOverride controls what directives may be placed in .htaccess files.
    # It can be "All", "None", or any combination of the keywords:
    # Options FileInfo AuthConfig Limit
    #
    AllowOverride None
    
Por:

    # AllowOverride controls what directives may be placed in .htaccess files.
    # It can be "All", "None", or any combination of the keywords:
    #   Options FileInfo AuthConfig Limit
    #
    AllowOverride All

2. Instalación del proyecto en el server
- Descargar el repositorio y ubicar los fuentes en el DocumentRoot (generalmente ubicado en) /var/www/html/
- Podrá ver un listado de Directorios y Archivos de la siguiente manera:
.htaccess
 application
 db
 index.php
 isMutant.php
 robots.txt
 system

3. Creación y configuración de la BD
- El archivo dump de la base de datos está ubicado en el directorio /db y se llama api_mutant.sql
- Proceda a cargar el dump dentro de su manejador de MySQL5.6 y defina un user/pass con privilegios de conexion a la BD
- A continuación se debe configurar las credenciales de conexión dentro del proyecto
  Ir a la ruta: api_mutant/application/config
  Editar el archivo: database.php
  Diligenciar las siguientes variables: 
  
  $db['default']['hostname'] = 'URL DE TU DATABASE';
  $db['default']['username'] = 'NOMBRE DE USUARIO';
  $db['default']['password'] = 'CONTRASEÑA';
  $db['default']['database'] = 'api_mutant';
  $db['default']['dbdriver'] = 'mysqli';

4. En este punto ya el proyecto debe estar funcional y consumible vía URL
- Si se presente algun error de despliegue, verificar que tenga correctamente instalado PHP7.2 y el driver de MySQL

5. Ejecución Standalone del Programa isMutant
Se desarrolló una rutina en PHP que puede ser ejecutada desde linea de comandos, la cual recibe un string como dato de entrada

Instrucciones: 
- Desde la terminal de Linux o Windows ir a la ruta /var/www/html/api_mutant/
- Ejecutar: 
   
   php isMutant.php 'ATGCGA,CAGTGC,TTATGT,AGAAGG,CCCCTA,TCACTG'
 
 <img width="756" alt="Screen Shot 2021-10-07 at 8 27 53 AM" src="https://user-images.githubusercontent.com/92068113/136393907-dc9426aa-12da-4cf8-a6f7-d52b19b49146.png">

 
 
La rutina retornará true e indicará la secuencia que hizo match y en que direccion (horizontal, vertical, oblicua(izquierda, derecha), oblicua(derecha-izquierda)
Ejemplo: 
  Match LR = AAAA
  Match V = GGGG
  Match H : CCCC

En caso que la secuencia no haga Match entonces retornará false
  php isMutant.php 'ATGCGA,CAGTGC,TTATTT,AGACGG,GCGTCA,TCACTG'

<img width="733" alt="Screen Shot 2021-10-07 at 8 28 04 AM" src="https://user-images.githubusercontent.com/92068113/136393972-d25499ff-7939-4910-ae7e-f25387074c8a.png">




6. Consumo del API Rest
Se desarrolló un API que actualmente está hosteada en AWS con los siguientes métodos:

a) “mutant/” 
Permite detectar si un humano es mutante enviando la secuencia de ADN mediante un HTTP POST
con un Json el cual tenga el siguiente formato:
POST → /mutant/
{
    "dna": "['ATGCGA','CAGTGC','TTATTT','AGACGG','GCGTCA','TCACTG']"
}

En caso de verificar un mutante, debería devolver un HTTP 200-OK, en caso contrario un 403-Forbidden

Ejemplo: ADN Mutante

URL: http://localhost/api_mutant/mutant/
Método: POST
{
    "dna": "['ATGCGA','CAGTGC','TTATGT','AGAAGG','CCCCTA','TCACTG']"
}
<img width="1426" alt="Screen Shot 2021-10-07 at 8 35 10 AM" src="https://user-images.githubusercontent.com/92068113/136395478-171fe0b1-a0d7-429d-aeca-2f61aea82224.png">



Ejemplo ADN Humano
URL: http://localhost/api_mutant/mutant/
Método: POST
{
    "dna": "['ATGCGA','CAGTGC','TTATTT','AGACGG','GCGTCA','TCACTG']"
}
<img width="1430" alt="Screen Shot 2021-10-07 at 8 34 21 AM" src="https://user-images.githubusercontent.com/92068113/136395628-50d01476-49b8-4338-aea4-f55f6e55abd8.png">


NOTA: Cada consulta de Secuencia de ADN almacena un registro en la tabla stats de la BD

b). “stats”
Permite consultar  las estadísticas de las verificaciones de ADN
y retorna un JSON con la estructura : {“count_mutant_dna”:40, “count_human_dna”:100: “ratio”:0.4}

Ejemplo: 
URL: http://localhost/api_mutant/stats/

<img width="1425" alt="Screen Shot 2021-10-07 at 8 42 51 AM" src="https://user-images.githubusercontent.com/92068113/136396476-8404a9c4-1785-48e2-a1cc-62dc0797b5ed.png">




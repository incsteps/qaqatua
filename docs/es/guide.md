# Cómo usarlo

## Crea una cuenta

En primer lugar debes crear una cuenta en QaQatua, usando tu email y creando una password.

## Login

Una vez registrado puedes acceder al sistema usando tu email y password.

## Crear un proyecto

Desde el dashboard podrás crear un proyecto, asignandole un nombre, campos por defecto a utilizar en el proceso de encriptacion
, etc

Así mismo puedes crear un juego de claves publica/privada para el proceso de encriptar/desencriptar o proporcionar
uno que ya tengas.

## Crear un access token

En la seccion de `settings` puedes crear tantos tokens como necesites. Los tokens son necesarios para poder realizar
las peticiones a QaQatua.

**Guarda el token proporcionado justo cuando lo creas pues no se vuelve a mostrar**

El token se usará en las cabeceras de la peticion como `Authorization` bearer

## Usar

Una vez creado el proyecto y el access token podras enviar peticiones como por ejemplo:

```bash
curl -X POST "https://qaqatua.com/api/encrypt" -H "Authorization: Bearer <your_token>" -d '{"payload": "your_payload"}'
```

# Bienvenido

Bienvenido a la documentación de Qaqatua, un servidor para encriptar y desencriptar payloads de pruebas.

La utilidad de Qaqatua es poder enviarle peticiones json y que encripte/desencripte los campos de nuestro interés.

Esto puede ser de gran utilidad para pruebas de QA donde existan microservicios que requieran que ciertos campos
sean encriptados y donde se desee comprobar su funcionamiento.


## Cómo

### Crea una cuenta

En primer lugar, necesitas crear una cuenta proporcionando tu email y password.

### Login

Una vez registrado puedes acceder al sistema proporcionando el email y password con el que te registraste

### Create a Project

Desde el dashboard puedes gestionar tus proyectos, así como crear uno nuevo.

Cuando creas un proyecto indicas los campos que por defecto quieres que se enc/desenc. 

Así mismo si proporcionas una pareja de claves pública/privada se asignaran al proyecto. Si no tienes o no la
proporcionas, Qaqatua generará unas por tí.

### Crear un access token

En la seccion de settings puedes crear tantos tokens como necesites. 

**Recuerda anotar el token una vez generado porque no se puede volver a mostrar**

Debes proporcionar este token en la cabecera cuando quieras enviar peticiones al servicio.


## Encriptar

Este es un ejemplo para encriptar un payload:

```bash
curl -X POST "https://qaqatua.com/api/encrypt" -H "Authorization: Bearer <your_token>" -d '{"payload": "your_payload"}'
```

si no has especificado ningun valor en el proyecto para `fields` el payload devuelto será el mismo
('{"payload": "your_payload"}' en este caso).

Si por ejemplo, especificaste `payload` como un campo a encriptar, la respuesta será algo como:

'{"payload": "123LSADFDSL2.....=="}'

## Desencriptar

De la misma forma, para desencriptar un payload usaremos el endpoint `/api/decrypt`:

```bash
curl -X POST "https://qaqatua.com/api/decrypt" -H "Authorization: Bearer <your_token>" -d '{"payload": "123213....=="}'
```



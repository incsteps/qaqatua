# Ofuscar

## Requisitos

Un access token. Consulta la seccion anterior para saber cómo crearlo

## Payload

Siguiendo la seccion de encriptar/desencriptar supongamos que tenemos un payload que queremos enviar a un 
servicio, pero no queremos que ciertos campos sean enviados en claro por motivos de privacidad.

Mediante este endpoint podemos alterar los campos del proyecto de una forma simple

Ejemplo:

```json
{
    "person": {
        "name": "jorge",
        "apellido": "aguilera",
        "email": "hola@caracola"
    }
}
```

Supongamos que queremos ofuscar los campos `apellido` y `email`

## Request

```bash
curl -X POST "https://qaqatua.com/api/ofuscate" -H "Authorization: Bearer <your_token>" -d '{
    "person": {
        "name": "jorge",
        "apellido": "aguilera",
        "email": "hola@caracola"
    }
}'
```

QaQatua devolverá:

```json
{
    "person": {
        "name": "jorge",
        "apellido": "flznqjwf",
        "email": "mtqf@hfwfhtqf"
    }
}
```

## Constants

La version actual ignorará los siguientes caracteres:

- '@' 
- '.'
- '/'
- '-'
- ' '



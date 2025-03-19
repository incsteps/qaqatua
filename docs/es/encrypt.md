# Encrypt

## Requisitos

Un access token. Consulta la seccion anterior para saber cómo crearlo

## Payload

Digamos que tenemos un payload como el siguiente que queremos enviar a un servicio, y ciertos campos
tienen que ser encriptados antes:

```json
{
    "person": {
        "name": "jorge",
        "apellido": "aguilera",
        "nif": "12456789Q"
    },
    "bank_account": {
        "iban": "1233333"
    }
}
```

Supongamos que el servicio espera que los campos `person.nif` y `bank_account.iban` se envíen encriptados.

Configuraremos el campo `fields` del proyecto recién creado con:

`person.nif, bank_account.iban`

## Envío de la request

```bash
curl -X POST "https://qaqatua.com/api/encrypt" -H "Authorization: Bearer <your_token>" -d '{
    "person": {
        "name": "jorge",
        "apellido": "aguilera",
        "nif": "12456789Q"
    },
    "bank_account": {
        "iban": "1233333"
    }
}'
```

A lo que Qaqatua responderá con algo similar a :

```json
{
    "person": {
        "name": "jorge",
        "apellido": "aguilera",
        "nif": "AAAAAAAaAAAAAAA=="
    },
    "bank_account": {
        "iban": "AAAAAAAaAAAAAAA=="
    }
}
```

Y este payload podra ser enviado tal cual al servicio.

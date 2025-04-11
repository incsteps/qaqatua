# Decrypt

## Requisitos

Un access token. Consulta la seccion anterior para saber cómo crearlo

## Payload

Siguiendo con el ejemplo de la seccion anterior, digamos que el servicio al que hemos llamado nos devuelve
un payload donde algunos campos están encriptados y queremos validar que la respuesta es correcta

```json
{
    "person": {
        "name": "jorge",
        "apellido": "aguilera",
        "nif": "AAAAAAA===="
    },
    "bank_account": {
        "iban": "AAAAAAA===="
    }
}
```

Validar el resto de los campos es fácil, pero para poder validar los campos encriptados necesitamos las keys
y además realizar algun proceso (tal vez usando Java, Groovy o Javascript).

Sin embargo, podemos delegar en QaQatua la conversion haciendo la llamada

## Enviando la request

```bash
curl -X POST "https://qaqatua.com/api/decrypt" -H "Authorization: Bearer <your_token>" -d '{
    "person": {
        "name": "jorge",
        "apellido": "aguilera",
        "nif": "AAAAAA===="
    },
    "bank_account": {
        "iban": "AAAAAA===="
    }
}'
```

A lo que QaQatua responderá con algo similar a:

```json
{
    "person": {
        "name": "jorge",
        "apellido": "aguilera",
        "nif": "123456Q"
    },
    "bank_account": {
        "iban": "12456"
    }
}
```



# Encrypt

## Requirements

You need an access token. Refer to the guide section to know how generate one

## Payload

Say we have some payloads we want to send to a service and some parts needs to be encrypted

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

Say the service expect `person.nif` and `bank_account.iban` be encrypted

We configure QaQatua's project fields as:

`person.nif, bank_account.iban`

## Send request

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

QaQatua will return something as:

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

so the payload returned can be send to the service

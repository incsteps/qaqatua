# Decrypt

## Requirements

You need an access token. Refer to the guide section to know how generate one

## Payload

Following with the encrypt section, say we have some payloads returned by a service and some parts are 
encrypted. 

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

We (as QA) want to validate values returned are as expected. 

We can validate "clear" fields but not the encrypted fields so we'll send the payload to qaqatua `decrypt` endpoint:


## Send request

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

Qaqatua will return something as:

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



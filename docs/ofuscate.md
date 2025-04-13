# Ofuscate

## Requirements

You need an access token. Refer to the guide section to know how generate one

## Payload

Following with the encrypt/decrypt section, say we have a payload we want to send to a service but don't want to 
send some sensible data as it. Using the ofuscate endpoint you can "alter" the fields of your projects

```json
{
    "person": {
        "name": "jorge",
        "apellido": "aguilera",
        "email": "hola@caracola"
    }
}
```

and we want to ofuscate the `apellido` and `email` fields

## Send request

```bash
curl -X POST "https://qaqatua.com/api/ofuscate" -H "Authorization: Bearer <your_token>" -d '{
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

QaQatua will return something as:

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

Current version will not change following chars:

- '@'
- '.'
- '/'
- '-'
- ' '




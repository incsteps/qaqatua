# Welcome

This is the documentation for the project qaqatua, an encrypt/decrypt site of payloads.

The aim of this site is to help you to encrypt and decrypt your payloads in a simple way

Qaqatua is useful for QA's who needs to deal with microservices where some parts of the payloads need to be encrypted before to send.


## How to use

### Create an account

First of all you need to create an account in Qaqatua, using your email and password.

### Login

After register, you can login in the site using your email and password.

### Create a Project

In the dashboard you can create a project, where you can configure the default fields you want to enc/dec.

Also you can provide a key pair (priv and public) to encrypt/decrypt the payloads or let the system generate one for you.

### Create an Access Token

In settings section you can create an access token to use in your requests. This token is used to authenticate the requests in the site.

**Grab the token once created as it will not be showed again**

Use this token in the header of your requests.


## Encrypt

After create a project and an access token you can encrypt/decrypt your payloads using the endpoint:

```bash
curl -X POST "https://qaqatua.com/api/encrypt" -H "Authorization: Bearer <your_token>" -d '{"payload": "your_payload"}'
```

In case you have not specified any "fields" in the project, the payload will not be encrypted/decrypted and the
response will be the same ( '{"payload": "your_payload"}' in this case).

In case you specified `payload` as a field to encrypt/decrypt, the response will be a response with the field
`payload` encrypted:

'{"payload": "123LSADFDSL2.....=="}'

## Decrypt

In the same way you can decrypt a payload using the endpoint `/api/decrypt`:

```bash
curl -X POST "https://qaqatua.com/api/decrypt" -H "Authorization: Bearer <your_token>" -d '{"payload": "123213....=="}'
```

The response will be the decrypted payload, '{"payload": "your_payload"}' in this case.

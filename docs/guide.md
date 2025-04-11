# How to use

## Create an account

First of all you need to create an account in QaQatua, using your email and password.

## Login

After register, you can login in the site using your email and password.

## Create a Project

In the dashboard you can create a project, where you can configure the default fields you want to enc/dec.

Also you can provide a key pair (priv and public) to encrypt/decrypt the payloads or let the system generate a pair for you.

## Create an Access Token

In settings section you can create an access token to use in your requests. This token is used to authenticate the requests in the site.

**Grab the token once created as it will not be showed again**

Use this token in the header of your requests.


## Use

After create a project and an access token you can encrypt/decrypt your payloads for example:

```bash
curl -X POST "https://qaqatua.com/api/encrypt" -H "Authorization: Bearer <your_token>" -d '{"payload": "your_payload"}'
```

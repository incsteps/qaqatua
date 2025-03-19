# Fields

When you are creating a project you can provide a comma separated list of fields to use by default in every
request (encrypt or decrypt)

For example, say we are using in our project always the `bank_account.iban` and `personal.nif` as encrypted fields.

We can set "bank_account.iban, personal.nif" in the `fields` attribute of the project and Qaqatua will use them
by default in every request

## Dynamic fields

Say we want Qaqatua encrypts a new attribute of a payload, `personal.birthday` for example, but only in an
special use case.

Instead to add this attribute to the project we can instruct Qaqatua to use this field using the query string
parameter `field`, for example `https://qaqatua.com/api/encrypt?field=personal.birthday`

In this way Qaqatua will replace `personal.birthday` only.

## Default + Dynamic

In case you want to apply both kind of fields (project+dynamic) you can use another query string `op=merge`


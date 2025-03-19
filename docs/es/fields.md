# Fields

Cuando estás creando un proyecto puedes proporcionar una lista de campos separados por coma, para ser usados
por defecto en las operaciones de encriptar/desencriptar.


## Dynamic fields

A veces nos encontramos con que en una llamada específica queremos que Qaqatua transforme algún campo que no estaba
definido en el proyecto.

En lugar de añadir el campo en la lista de por defecto, podemos proporcionarselo a Qaqatua en la peticion mediante
un Query String `field`, por ejemplo `https://qaqatua.com/api/encrypt?field=personal.birthday`

En este ejemplo Qaqatua transformará ese campo y no usará los del proyecto

## Default + Dynamic

Si lo que queremos es que Qaqatua use ambos campos, los del proyecto más el específico, añadiremos otra
Query String `op` con el valor a `merge`, por ejemplo `https://qaqatua.com/api/encrypt?field=personal.birthday&op=merge`

Así Qaqatua aplicará la transformación en los campos definidos en el proyecto más en `personal.birthday` y 
únicamente en la request actual.

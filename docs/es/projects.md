# Projects

Puedes crear hasta 3 proyectos (`projects`) identificados por un nombre 

Cada project contiene una par de claves publicas/privadas y una lista de campos (`fields`) a utilizar por defecto,
de tal forma que si necesitas trabajar con diferentes servicios y cada uno maneja claves diferentes
puedes crear flujos de trabajo de encriptacion/desencriptacion complejos usando varios projects

Para indicar qué proyecto usar en la petición, incluye el query string `project` indicando el nombre a usar.
Si no se especifica QaQatua usará el primero de tus projects

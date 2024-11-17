# TPE-API
El proposito de la api es poder acceder a los datos contenidos en la base de datos, especificamente los contenidos en las tablas "Libros" y "Autores", y poder trabajar con ellos de la manera que el usuario desee. Tambien se ha utilizado la tabla 'usuarios' para controlar si el usuario esta logueado y que de esta manera pueda crear/editar libros o autores o no.

Endpoints:

Para trabajar con los datos contenidos en la tabla "Libros" se utilizan los siguientes endpoints:

-GET:api/libros Este endpoint es el encargado de mostrar la lista con todos los libros y sus respectivos datos. Al utilizar este endpoint, se obtiene una respuesta del siguiente tipo:

{ "data": [ { "id_libros": 14,
        "Titulo": "El imperio final",
        "Saga": "Nacidos de las brumas",
        "Genero": "fantasia",
        "imagen": "https://images.cdn3.buscalibre.com/fit-in/360x360/a8/b9/a8b99ba35498b0cc7cfc150cdf00bbc7.jpg",
        "id_autor": 5 }, 
        { "id_libros": 16,
        "Titulo": "Palabras Radiantes",
        "Saga": "El archivo de las tormentas",
        "Genero": "Fantasia",
        "imagen": "",
        "id_autor": 5 } ], 
        "status": "success" }

La cantidad de elementos en el array "data" variara de acuerdo a la cantidad de libros que haya en la tabla "libros".

-GET:api/libros/:id_libros

Este endpoint es el encargado de mostrar solamente el libro cuya id coincida con la id_libros de la URL. Un ejemplo de la respuesta a obtener es el siguiente:

{ "id_libros": 14,
        "Titulo": "El imperio final",
        "Saga": "Nacidos de las brumas",
        "Genero": "fantasia",
        "imagen": "https://images.cdn3.buscalibre.com/fit-in/360x360/a8/b9/a8b99ba35498b0cc7cfc150cdf00bbc7.jpg",
        "id_autor": 5  }

En caso de que la id_libros de la URL no coincida con ninguna de las almacenadas en la base de datos se mostrara el siguiente error:

{ "data": "El libro solicitado no existe", "status": "error" }

Por otra parte, se pueden elegir criterios para ordenar estos libros y paginarlos. Como ejemplo tenemos la siguiente consulta realizada en postman:

api/libros?filter=Saga&value=El%20archivo%20de%20las%20tormentas

mostrara por ejemplo esto:
{
        "id_libros": 16,
        "Titulo": "Palabras Radiantes",
        "Saga": "El archivo de las tormentas",
        "Genero": "Fantasia",
        "imagen": "",
        "id_autor": 5
    }

Para la key "sort" colocamos el criterio a partir del cual queremos ordenar. En este caso ordenamos autores por edad y con "order" si es ascendente o descendente:
api/autores?sort=Edad&order=ASC
   {
        "id_autor": 9,
        "Nombre": "Brandon Sanderson",
        "Edad": "46",
        "Nacionalidad": "Estados Unidos"
    },
    {
        "id_autor": 5,
        "Nombre": "Roberto roberto",
        "Edad": "57",
        "Nacionalidad": "chascomus"
    },
    {
        "id_autor": 10,
        "Nombre": "Frank Herbert",
        "Edad": "66",
        "Nacionalidad": "Estados Unidos"
    },
    {
        "id_autor": 11,
        "Nombre": "George R R Martin",
        "Edad": "70",
        "Nacionalidad": "Westeros seguramente"
    }

Para la key "limit" elegimos el limite de libros que se muestran por pagina. En este caso mostramos 2 libros por pagina.
Y para la key "page" elegimos el numero de pagina, en este caso la 1:
api/libros?limit=2&page=1
{
        "id_libros": 14,
        "Titulo": "El imperio final",
        "Saga": "Nacidos de las brumas",
        "Genero": "fantasia",
        "imagen": "https://images.cdn3.buscalibre.com/fit-in/360x360/a8/b9/a8b99ba35498b0cc7cfc150cdf00bbc7.jpg",
        "id_autor": 5
    },
    {
        "id_libros": 16,
        "Titulo": "Palabras Radiantes",
        "Saga": "El archivo de las tormentas",
        "Genero": "Fantasia",
        "imagen": "",
        "id_autor": 5
    }

-POST:api/libros Este endpoint es el encargado de agregar nuevos libros a la tabla. Para el usuario debe otorgar los siguientes datos:

{ "titulo": "titulo del libro", "saga": "nombre de la saga", "genero": "genero al que pertenece", "id_autor": "la id del autor del libro" }

Un ejemplo de esto seria:

{ "titulo": "Dune",
  "saga": "Dune",
  "genero": "Ciencia Ficcion",
  "id_autor": "10" }

En caso de que no se hayan completado todos los datos necesarios aparecera el siguiente mensaje de error:

{ "data": "faltó introducir algun campo", "status": "error" }

-PUT:api/libros/:id_libros

Este endpoint es el encargado de modificar los datos del libro que tenga la id de la URL. Para ello, el usuario debe otorgar los siguientes datos:

{ "titulo": "titulo del libro", "saga": "nombre de la saga", "genero": "genero al que pertenece", "id_autor": "la id del autor del libro" }

En caso de que la id de la URL coincida con alguna de las almacenadas en la tabla "libros" se mostrara el siguiente mensaje:

"El libro con id=19 ha sido modificado."

En caso de que la id de la URL no coincida con ninguna de las almacenadas en la se mostrara el siguiente error:

"El libro con id=20 no existe."
-DELETE:api/libros/:id_libros

Este endpoint es el encargado de borrar el libro cuya id coincida con la id de la URL.

En caso de que la id de la URL coincida con alguna de las almacenadas en la tabla "libros" se mostrara el siguiente mensaje:

"El libro con id=20 ha sido borrado."(en este caso se uso la id=20)

En caso de que la id de la URL no coincida con ninguna de las almacenadas en la tabla "libros" se mostrara el siguiente error:

"El libro con id=30 no existe."

Para trabajar con los datos contenidos en la tabla "autores" se utilizan los siguientes endpoints:

-GET:api/autores

Este endpoint es el encargado de mostrar la lista con todos los autores y sus respectivos datos. Al utilizar este endpoint, se obtiene una respuesta del siguiente tipo:

{ "data": [{
        "id_autor": 9,
        "Nombre": "Brandon Sanderson",
        "Edad": "46",
        "Nacionalidad": "Estados Unidos"
    },
    {
        "id_autor": 10,
        "Nombre": "Frank Herbert",
        "Edad": "66",
        "Nacionalidad": "Estados Unidos"
    }, ], "status": "success" }

La cantidad de elementos en el array "data" variara de acuerdo a la cantidad de autores que haya en la tabla "autores".

Por otra parte, se pueden elegir criterios para ordenar estos autores y paginarlos que ya se vieron arriba, se usaron los mismos que para libros, solo hay que poner los atributos de la tabla autores por ejemplo en el filtro, en vez de saga nacionalidad.
-GET:api/autores/:id

Este endpoint es el encargado de mostrar solamente el autor (y sus datos) cuya id coincida con la id de la URL. Un ejemplo de la respuesta a obtener es el siguiente:

{ "data": {
        "id_autor": 9,
        "Nombre": "Brandon Sanderson",
        "Edad": "46",
        "Nacionalidad": "Estados Unidos"
    },
    "status": "success" }

En caso de que la id de la URL no coincida con ninguna de las almacenadas en la base de datos se mostrara el siguiente error:

{ "data": "El autor solicitado no existe",
    "status": "error"}

-POST:api/autores

Este endpoint es el encargado de agregar nuevos autores a la tabla. Para el usuario debe otorgar los siguientes datos:

{ "nombre": "Nombre del autor", "edad": "edad del autor", "nacionalidad": "donde nacio" }

Un ejemplo de esto seria:

{ "nombre": "Frank Herbert", "edad": 66, "nacionalidad": Estados Unidos }

Si se completaron los datos correctamente, se mostrara un mensaje como el siguiente:

{ "data": {
        "id_autor": 10,
        "Nombre": "Frank Herbert",
        "Edad": "66",
        "Nacionalidad": "Estados Unidos"
    },
    "status": "success" }


En caso de que no se hayan completado todos los datos necesarios aparecera el siguiente mensaje de error:

{ "data": "faltó introducir algun campo", "status": "error" }

-PUT:api/autores/:id_autor

Este endpoint es el encargado de modificar los datos del autor cuya id_autor coincida con la id_autor de la URL. Para ello, el usuario debe otorgar los siguientes datos:

{
"nombre": "Nuevo nombre del autor", "edad": nueva edad, }

Un ejemplo de esto seria:

{ "nombre": "Frank Herbasio", "edad": 22 }

En caso de que la id de la URL coincida con alguna de las almacenadas en la tabla "autores" se mostrara el siguiente mensaje:

"El autor con id=10 ha sido modificado."

En caso de que la id de la URL no coincida con ninguna de las almacenadas en la tabla "autores" se mostrara el siguiente error:

"El autor con id=33 no existe."

-DELETE:api/autores/:id_autor

Este endpoint es el encargado de borrar el autor cuya id coincida con la de la URL.

En caso de que la id de la URL coincida con alguna de las almacenadas en la tabla "autores" se mostrara el siguiente mensaje:

"El autor con id=11 ha sido borrado."

En caso de que la id de la URL no coincida con ninguna de las almacenadas en la tabla "autores" se mostrara el siguiente error:

"El autor con id=55 no existe."

-GET:api/user:/token

Este endpoint es el encargado de obtener el token de autorizacion para realizar las acciones de crear y editar libros y autores.

En nuestro caso utilizamos a la hora de testear el user:webadmin, con contraseña:123abc (Almacenados en la tabla "usuarios") para obtener el token, el cual es:

eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1c2VyX2lkIjoxLCJ1c2VyX25hbWUiOiJ3ZWJhZG1pbiIsInBhc3N3b3JkIjoiJDJ5JDEwJHBIMEc0dFZ0dlQxZE5VR3ZDNURYVS54TEs2NHJoZUV4THlDd2ZLbnFHQVI2TzRoMGlxNkVpIiwiZXhwIjoxNzEwNDg1NTk0fQ.mBBJXn8T7W4n9KhLenvmGvy0_LZjF4xW_Q-LBqPMQCI"

Este token esta compuesto de tres partes:

+Header:eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9

Este contiene los datos del algoritmo y el tipo de token utilizado: { "alg": "HS256", "typ": "JWT" }

+Payload:eyJ1c2VyX2lkIjoxLCJ1c2VyX25hbWUiOiJ3ZWJhZG1pbiIsInBhc3N3b3JkIjoiJDJ5JDEwJGRINUN3QVZPTXhLV09oanpLbW5EZS5kY000MnVvYmxlWS5uYWN1S0xqMGFkN0hmc1RmVnBhIiwiZXhwIjoxNjk5ODkwODE2fQ

este contiene la id del usuario, su nombre y contraseña y en que momento expirara el token: { "user_id": 1,
  "user_name": "webadmin",
  "password": "$2y$10$pH0G4tVtvT1dNUGvC5DXU.xLK64rheExLyCwfKnqGAR6O4h0iq6Ei",
  "exp": 1710485594}

+Signature:mBBJXn8T7W4n9KhLenvmGvy0_LZjF4xW_Q-LBqPMQCI

Tambien llamada firma, verifica que el token no haya sido alterado desde que se genero y contiene los siguientes datos:

HMACSHA256(
  base64UrlEncode(header) + "." +
  base64UrlEncode(payload),
  
your-256-bit-secret

)

Dado el caso de que el token utilizado no sea el correcto o haya expirado, se mostrara el siguiente error:

"El usuario no esta autorizado para realizar esta accion". Con el error 401 Unauthorized.

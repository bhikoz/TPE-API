# TPE-API
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

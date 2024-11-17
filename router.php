<?php
    require_once 'config.php';
    require_once 'router/route.php';

    require_once 'app/controllers/api.libros.php';
    require_once 'app/controllers/api.controller.php';
    require_once 'app/controllers/api.autores.php';
    require_once 'app/controllers/user.api.controller.php';

    $router = new Router();


    
    $router->addRoute('libros', 'GET', 'ApiLibros', 'get'); 
    $router->addRoute('libros', 'POST', 'ApiLibros', 'createLibro');
    $router->addRoute('libros/:id_libros', 'GET', 'ApiLibros', 'getById');
    $router->addRoute('libros/:id_libros', 'PUT', 'ApiLibros', 'updateLibro'); 
    $router->addRoute('libros/:id_libros', 'DELETE', 'ApiLibros', 'deleteLibro');

    $router->addRoute('autores', 'GET', 'ApiAutores', 'get'); 
    $router->addRoute('autores', 'POST', 'ApiAutores', 'createAutor');
    $router->addRoute('autores/:id_autor', 'GET', 'ApiAutores', 'getById'); 
    $router->addRoute('autores/:id_autor', 'PUT', 'ApiAutores', 'updateAutor'); 
    $router->addRoute('autores/:id_autor', 'DELETE', 'ApiAutores', 'deleteAutor');

    
     
    $router->addRoute('user/token', 'GET',    'UserApiController', 'getToken'   ); 
    
    #               del htaccess resource=(), verbo con el que llamo GET/POST/PUT/etc
    $router->route($_GET['resource']        , $_SERVER['REQUEST_METHOD']);
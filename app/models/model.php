<?php

class Model{
    protected $db;

    public  function __construct() {
        $this->db = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET, DB_USER, DB_PASS);
        $this->deploy();    
    
    }

    function deploy() {
        // Chequear si hay tablas
        $query = $this->db->query('SHOW TABLES');
        $tables = $query->fetchAll(); // Nos devuelve todas las tablas de la db
        if(count($tables)==0) {  // Si no hay crearlas
            
            $sql =<<<END
            -- Estructura de tabla para la tabla `autores`
            --
            
            CREATE TABLE `autores` (
              `id_autor` int(11) NOT NULL,
              `Nombre` varchar(255) NOT NULL,
              `Edad` varchar(255) DEFAULT NULL,
              `Nacionalidad` varchar(255) DEFAULT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
            
            --
            -- Volcado de datos para la tabla `autores`
            --
            
            INSERT INTO `autores` (`id_autor`, `Nombre`, `Edad`, `Nacionalidad`) VALUES
            (1, 'Dmitri Glujovski', '46', 'Ruso'),
            (2, 'Arkadi y Borís Strugatski', 'Fallecidos', 'Rusos'),
            (3, 'Vladimir Berezin', '56', 'Ruso'),
            (5, 'Roberto roberto', '57', 'chascomus'),
            (9, 'Brandon Sanderson', '46', 'Estados Unidos'),
            (10, 'Frank Herbert', '66', 'Estados Unidos');
            
            -- --------------------------------------------------------
            
            --
            -- Estructura de tabla para la tabla `libros`
            --
            
            CREATE TABLE `libros` (
              `id_libros` int(255) NOT NULL,
              `Titulo` varchar(255) NOT NULL,
              `Saga` varchar(255) NOT NULL,
              `Genero` varchar(255) NOT NULL,
              `imagen` varchar(255) NOT NULL,
              `id_autor` int(255) DEFAULT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
            
            --
            -- Volcado de datos para la tabla `libros`
            --
            
            INSERT INTO `libros` (`id_libros`, `Titulo`, `Saga`, `Genero`, `imagen`, `id_autor`) VALUES
            (3, 'Metro 2034', 'Metro', 'Ciencia Ficcion', '', 9),
            (12, 'Juramentada', 'el archivo de las tormentas ', 'fantasia', '', 9),
            (13, 'Dune', 'Dune', 'Ciencia Ficcion', '', 10);
            END;
            $this->db->query($sql);

        }
      



        }

    }
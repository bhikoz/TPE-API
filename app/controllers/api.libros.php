<?php
require_once 'app/controllers/api.controller.php';
require_once 'app/models/libros.model.php';
require_once 'objetos/Libro.php';
require_once 'app/helpers/auth.api.helper.php';

class ApiLibros extends ApiController {
    private $model;
    private $AuthHelper;

    function __construct() {
        parent::__construct();
        $this->model = new libros_model();
        $this->AuthHelper=new AuthHelper();
    }

    public function getById($params = []) {
        $id_libros = $params[":id_libros"];
        $libro = $this->model->getLibroById($id_libros);
      
        if (!empty($libro)) {
          $this->view->response([
            'data' => $libro,
            'status' => 'success',
          ], 200);
        } else {
          $this->view->response([
            'data' => 'El libro solicitado no existe',
            'status' => 'error'
          ], 404);
        }
      }


    function get($params = []) {

        $columns = $this->model->getColumnNames();

        // Arreglo donde se almacenarán los parámetros de consulta
        $queryParams = array();

        // Filtro
        $queryParams += $this->handleFilter($columns);
        
        // Ordenamiento
        $queryParams += $this->handleSort($columns);

        // Paginación
        $queryParams += $this->handlePagination();
        
        // Se obtienen los libros y se devuelven en formato JSON
        $Libros = $this->model->getAllLibros($queryParams);
        return $this->view->response($Libros, 200);
    }

    function deleteLibro($params = []) {

        $id_libros = $params[':id_libros'];
        $libro = $this->model->getLibroById($id_libros);
      
        if ($libro) {
          $this->model->deleteLibro($id_libros);
          $this->view->response('El libro con id=' . $id_libros . ' ha sido borrado.', 200);
        } else {
          $this->view->response('El libro con id=' . $id_libros . ' no existe.', 404);
        }
      }


      function createLibro($params = []) {

        $user = $this->AuthHelper->currentUser(); //Verifico que el usuario este logueado
        if (!$user) {
            $this->view->response('El usuario no esta autorizado para realizar esta accion', 401);
            return;
        }

        $data = $this->getData();
        $errors = [];
        if (empty($data->titulo)) {
        $errors[] = "El campo 'titulo' es obligatorio";
        }
        if (empty($data->saga)) {
        $errors[] = "El campo 'saga' es obligatorio";
        }
        if (empty($data->genero)) {
        $errors[] = "El campo 'genero' es obligatorio";
        }
        if (empty($data->id_autor)) {
        $errors[] = "El campo 'id' es obligatorio";
        }
        if (!empty($errors)) {
          $this->view->response([
            'data' => $errors,
            'status' => 'error'
          ], 400);
          return;
        }
    
        $libro = new Libro();
        $libro->setValues($data->titulo, $data->saga, $data->genero, $data->id_autor);

        $id_libros = $this->model->insertLibro($libro->getTitulo(), $libro->getSaga(), $data->genero, $data->id_autor);

        $libro_agregado = $this->model->getLibroById($id_libros);

      if ($libro_agregado) {
        $this->view->response([
        'data' => $libro_agregado,
        'status' => 'success'
        ], 200);
      } else {
        $this->view->response([
        'data' => "El libro no fue creado",
        'status' => 'error'
        ], 500);
      }
    }


  function updateLibro($params = []) {

  $user = $this->AuthHelper->currentUser(); //Verifico que el usuario este logueado
    if (!$user) {
    $this->view->response('El usuario no esta autorizado para realizar esta accion', 401);
    return;
    }
          
    $id_libros = $params[':id_libros'];
    $libro = $this->model->getLibroById($id_libros);
          
    if($libro) {
    $body = $this->getData();
    $titulo = $body->titulo;
    $saga = $body->saga;
    $genero = $body->genero;
    $id_autor = $body->id_autor;
          
    $this->model->updateLibro($titulo, $saga, $genero, $id_autor, $id_libros);
          
    $this->view->response('El libro con id='.$id_libros.' ha sido modificado.', 200);
    } else {
    $this->view->response('El libro con id='.$id_libros.' no existe.', 404);
    }
 }

        private function handleFilter($columns) {
            // Valores por defecto
            $filterData = [
                'filter' => "", // Campo de filtrado
                'value' => ""   // Valor de filtrado
            ];
    
            if (!empty($_GET['filter']) && !empty($_GET['value'])) {
                $filter = $_GET['filter'];
                $value = $_GET['value'];

          
    
                // Si el campo no existe se produce un error
                if (!in_array($filter, $columns)) {
                    $this->view->response("Invalid filter parameter (field '$filter' does not exist)", 400);
                    die();
                }
               
                $filterData['filter'] = $filter;
                $filterData['value'] = $value;
           
            }
            
            return $filterData;
        }
    
        /**
         * Método de ordenamiento de resultados según campo y orden dados
         */
        private function handleSort($columns) {
            // Valores por defecto
            $sortData = [
                'sort' => "", // Campo de ordenamiento
                'order' => "" // Orden ascendente o descendente
            ];
    
            if (!empty($_GET['sort'])) {
                $sort = $_GET['sort'];

              
    
                // Si el campo de ordenamiento no existe se produce un error
                if (!in_array($sort, $columns)) {
                    $this->view->response("Invalid sort parameter (field '$sort' does not exist)", 400);
                    die();
                }
    
                // Orden ascendente o descendente
                if (!empty($_GET['order'])) {
                    $order = strtoupper($_GET['order']);
                    $allowedOrders = ['ASC', 'DESC'];
    
                    // Si el campo de ordenamiento no existe se produce un error
                    if (!in_array($order, $allowedOrders)) {
                        $this->view->response("Invalid order parameter (only 'ASC' or 'DESC' allowed)", 400);
                        die();
                    }
                }
    
                $sortData['sort'] = $sort;
                $sortData['order'] = $order;
            }
    
            return $sortData;
        }
    
        /**
         * Método de paginación de resultados según número de página y límite dados
         */
        private function handlePagination() {
            // Valores por defecto
            $paginationData = [
                'limit' => 0,    // Límite de resultados
                'offset' => 0    // Desplazamiento
            ];
  
    
            if (!empty($_GET['page']) && !empty($_GET['limit'])) {
                $page = $_GET['page'];
                $limit = $_GET['limit'];

                
              
    
                // Si alguno de los valores no es un número natural se produce un error
                if (!is_numeric($page) || $page < 0 || !is_numeric($limit) || $limit < 0) {
                    $this->view->response("Page and limit parameters must be positive integers", 400);
                    die();
                }
    
                $offset = ($page - 1) * $limit;
    
                $paginationData['limit'] = $limit;
                $paginationData['offset'] = $offset;
            }
           
            return $paginationData;
        }
    
    

    }
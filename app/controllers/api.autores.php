<?php
require_once 'app/controllers/api.controller.php';
require_once 'app/models/autores.model.php';
require_once 'objetos/autores.php';
require_once 'app/helpers/auth.api.helper.php';

class ApiAutores extends ApiController {
    
    private $model;
    private $AuthHelper;

    function __construct() {
        parent::__construct();
        $this->model = new autores_model(); 
        $this->AuthHelper = new AuthHelper();
    }

    public function getById($params = []) {
        $id = $params[":id_autor"];
        $autor = $this->model->getAutorById($id); 

        if (!empty($autor)) {
            $this->view->response([
                'data' => $autor,
                'status' => 'success',
            ], 200);
        } else {
            $this->view->response([
                'data' => 'El autor solicitado no existe',
                'status' => 'error'
            ], 404);
        }
    }

   public function get($params = []) {
        $columns = $this->model->getColumnNames();
        $queryParams = array();
        $queryParams += $this->handleFilter($columns);
        $queryParams += $this->handleSort($columns);
        $queryParams += $this->handlePagination();
        $Autores = $this->model->getAllAutores($queryParams);
        return $this->view->response($Autores, 200);
    }
    
    function deleteAutor($params = []) {
        $id_autor = $params[":id_autor"];
        $autor = $this->model->getAutorById($id_autor);

        if ($autor) {
            $this->model->deleteAutor($id_autor);
            $this->view->response('El autor con id=' . $id_autor . ' ha sido borrado.', 200);
        } else {
            $this->view->response('El autor con id=' . $id_autor . ' no existe.', 404);
        }
    }

    function createAutor($params = []) {
        $user = $this->AuthHelper->currentUser();
        if (!$user) {
            $this->view->response('El usuario no está autorizado para realizar esta acción', 401);
            return;
        }
    
        $data = $this->getData();
        $errors = [];
        if (empty($data->nombre)) {
          $errors[] = "El campo 'nombre' es obligatorio";
        }
        if (empty($data->edad)) {
          $errors[] = "El campo 'edad' es obligatorio";
        }
        if (empty($data->nacionalidad)) {
          $errors[] = "El campo 'nacionalidad' es obligatorio";
        }
        if (!empty($errors)) {
            $this->view->response([
              'data' => $errors,
              'status' => 'error'
            ], 400);
            return;
          }
        
        $autor = new Autor();
        $autor->setValues($data->nombre, $data->edad, $data->nacionalidad);
        $autor_id = $this->model->insertAutor($autor->getNombre(), $autor->getEdad(), $autor->getNacionalidad());
        $autor_agregado = $this->model->getAutorById($autor_id);
    
        if ($autor_agregado) {
            $this->view->response([
                'data' => $autor_agregado,
                'status' => 'success'
            ], 200);
        } else {
            $this->view->response([
                'data' => "El autor no fue creado",
                'status' => 'error'
            ], 500);
        }
    }
    
    function updateAutor($params = []) {
        $user = $this->AuthHelper->currentUser();
        if (!$user) {
            $this->view->response('El usuario no está autorizado para realizar esta acción', 401);
            return;
        }
    
        $id_autor = $params[":id_autor"];
        $autor = $this->model->getAutorById($id_autor);
    
        if ($autor) {
            $body = $this->getData();
            $nombre = $body->nombre;
            $edad = $body->edad;
            $nacionalidad = $body->nacionalidad;
            $this->model->updateAutor($id_autor, $nombre, $edad, $nacionalidad);
            $this->view->response('El autor con id=' . $id_autor . ' ha sido modificado.', 200);
        } else {
            $this->view->response('El autor con id=' . $id_autor . ' no existe.', 404);
        }
    }

    private function handleFilter($columns) {
        $filterData = [
            'filter' => "",
            'value' => ""
        ];

        if (!empty($_GET['filter']) && !empty($_GET['value'])) {
            $filter = $_GET['filter'];
            $value = $_GET['value'];
            if (!in_array($filter, $columns)) {
                $this->view->response("Invalid filter parameter (field '$filter' does not exist)", 400);
                die();
            }
            $filterData['filter'] = $filter;
            $filterData['value'] = $value;
        }
        
        return $filterData;
    }
    
    private function handleSort($columns) {
        $sortData = [
            'sort' => "",
            'order' => ""
        ];

        if (!empty($_GET['sort'])) {
            $sort = $_GET['sort'];
            if (!in_array($sort, $columns)) {
                $this->view->response("Invalid sort parameter (field '$sort' does not exist)", 400);
                die();
            }
            if (!empty($_GET['order'])) {
                $order = strtoupper($_GET['order']);
                $allowedOrders = ['ASC', 'DESC'];
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
    
    private function handlePagination() {
        $paginationData = [
            'limit' => 0,
            'offset' => 0
        ];
  
        if (!empty($_GET['page']) && !empty($_GET['limit'])) {
            $page = $_GET['page'];
            $limit = $_GET['limit'];
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
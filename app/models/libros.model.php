<?php
require_once 'app/models/model.php';

class libros_model extends Model {
    public function getAllLibros($queryParams) {
        $sql = "SELECT * FROM libros";
      
        // Filtro
        if (!empty($queryParams['filter']) && !empty($queryParams['value'])) {
          $sql .= ' WHERE ' . $queryParams['filter'] . ' LIKE \'%' . $queryParams['value'] . '%\'';
        }
      
        // Ordenamiento
        if (!empty($queryParams['sort'])) {
          $sql .= ' ORDER BY ' . $queryParams['sort'];
      
          // Orden ascendente y descendente
          if (!empty($queryParams['order'])) {
            $sql .= ' ' . $queryParams['order'];
          }
        }
      
        // Paginación
        if (!empty($queryParams['limit'])) {
          $sql .= ' LIMIT ' . $queryParams['limit'] . ' OFFSET ' . $queryParams['offset'];
        }
                  
        $query = $this->db->prepare($sql);
        $query->execute();
      
        $libros = $query->fetchAll(PDO::FETCH_OBJ);
        return $libros;
      }

    public function getColumnNames() {
        $query = $this->db->query('DESCRIBE libros');
        $columns = $query->fetchAll(PDO::FETCH_COLUMN);
        return $columns;
    }

    public function updateLibro($titulo, $saga, $genero, $id_autor, $id_libros) {
        
        $query = $this->db->prepare('UPDATE libros SET titulo = ?, saga = ?, genero = ?, id_autor = ? WHERE id_libros = ?');
        $query->execute([$titulo, $saga, $genero, $id_autor, $id_libros]);
      }

    public   function getLibroById($id_libros) {
        $query = $this->db->prepare('SELECT * FROM `libros` WHERE id_libros=?');
        $query->execute([$id_libros]);

        $libro = $query->fetchAll(PDO::FETCH_OBJ);

        return $libro;
    }

    public  function insertLibro($titulo, $saga, $genero, $id_autor) {
        $query = $this->db->prepare('INSERT INTO libros (titulo, saga, genero, id_autor) VALUES(?,?,?,?)');
        $query->execute([$titulo, $saga, $genero, $id_autor]);
      
        return $this->db->lastInsertId();
      }

    public function deleteLibro($id_libros) {
        $query = $this->db->prepare('DELETE FROM libros WHERE id_libros =?');
        $query->execute([$id_libros]);
    }

    
}
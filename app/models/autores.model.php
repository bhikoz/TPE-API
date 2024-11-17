<?php
require_once 'app/models/model.php';

class autores_model extends Model {

    public function getAllAutores($queryParams) {
      $sql = "SELECT * FROM autores";
  
      if (!empty($queryParams['filter']) && !empty($queryParams['value'])) {
        $sql .= " WHERE " . $queryParams['filter'] . " LIKE '%" . $queryParams['value'] . "%'";
      }
        
      if (!empty($queryParams['sort'])) {
        $sql .= " ORDER BY " . $queryParams['sort'];
         
        if (!empty($queryParams['order'])) {
          $sql .= " " . $queryParams['order'];
        }
      }
        
      if (!empty($queryParams['limit'])) {
        $sql .= " LIMIT " . $queryParams['limit'] . " OFFSET " . $queryParams['offset'];
      }
  
      $query = $this->db->prepare($sql);
      $query->execute();
  
      $autores = $query->fetchAll(PDO::FETCH_OBJ);
      return $autores;
    }

    public function getColumnNames() {
        $query = $this->db->query('DESCRIBE autores');
        $columns = $query->fetchAll(PDO::FETCH_COLUMN);
        return $columns;
    }

    public function getAutorById($id_autor) {
        $query = $this->db->prepare('SELECT * FROM autores WHERE id_autor = ?');
        $query->execute([$id_autor]);
      
        $autor = $query->fetch(PDO::FETCH_OBJ);
        return $autor;
      }

      public function insertAutor($nombre, $edad, $nacionalidad) {
        $query = $this->db->prepare('INSERT INTO autores (Nombre, Edad, Nacionalidad) VALUES(?, ?, ?)');
        $query->execute([$nombre, $edad, $nacionalidad]);
      
        return $this->db->lastInsertId();
      }


    public function deleteAutor($id_autor) {
        $query = $this->db->prepare('DELETE FROM autores WHERE id_autor = ?');
        $query->execute([$id_autor]);
    }

    public function updateAutor($id_autor, $nombre, $edad, $nacionalidad) {
        $query = $this->db->prepare('UPDATE autores SET Nombre = ?, Edad = ?, Nacionalidad = ? WHERE id_autor = ?');
        $query->execute([$nombre, $edad, $nacionalidad, $id_autor]);
      }
}
<?php
class Autor {

    private $nombre;
    private $edad;
    private $nacionalidad;
    public $id_autor;
  
  
    public function setValues($nombre, $edad = null, $nacionalidad = null) {
      $this->nombre = $nombre;
      $this->edad = $edad;
      $this->nacionalidad = $nacionalidad;
    }
  
    public function getNombre() {
      return $this->nombre;
    }
  
    public function getEdad() {
      return $this->edad;
    }
  
    public function getNacionalidad() {
      return $this->nacionalidad;
    }
  
    public function setEdad($edad) {
      $this->edad = $edad;
    }
  
    public function setNacionalidad($nacionalidad) {
      $this->nacionalidad = $nacionalidad;
    }
  }
  ?>
<?php
class Libro {

private $titulo;
private $saga;
private $genero;
private $id_autor;



public function setValues($titulo, $saga, $genero, $id_autor) {
  $this->titulo = $titulo;
  $this->saga = $saga;
  $this->genero = $genero;
  $this->id_autor = $id_autor;
}

public function getTitulo() {
  return $this->titulo;
}


public function getSaga() {
  return $this->saga;
}

public function getGenero() {
  return $this->genero;
}


public function getIdAutor() {
  return $this->id_autor;
}

public function setSaga($saga) {
  $this->saga = $saga;
}

public function setGenero($genero) {
  $this->genero = $genero;
}

public function setIdAutor($id_autor) {
  $this->id_autor = $id_autor;
}
}
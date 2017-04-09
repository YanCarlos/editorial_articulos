<?php

class Revision {

    private $id;
    private $fecha;
    private $descripcion;
    private $url;
    private $version;
    private $mensaje;
    private $revisor;
    private $articulo;
    private $estado;

    public function __construct($fecha, $descripcion, $url, $version, $mensaje, $revisor, $articulo, $estado) {
        $this->fecha = $fecha;
        $this->descripcion = $descripcion;
        $this->url = $url;
        $this->version = $version;
        $this->mensaje = $mensaje;
        $this->revisor = $revisor;
        $this->articulo = $articulo;
        $this->estado = $estado;
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    public function getUrl() {
        return $this->url;
    }

    public function setUrl($url) {
        $this->url = $url;
    }

    public function getVersion() {
        return $this->version;
    }

    public function setVersion($version) {
        $this->version = $version;
    }

    public function getMensaje() {
        return $this->mensaje;
    }

    public function setMensaje($mensaje) {
        $this->mensaje = $mensaje;
    }

    public function getRevisor() {
        return $this->revisor;
    }

    public function setRevisor($revisor) {
        $this->revisor = $revisor;
    }

    public function getArticulo() {
        return $this->articulo;
    }

    public function setArticulo($articulo) {
        $this->articulo = $articulo;
    }

    public function getEstado() {
        return $this->estado;
    }

    public function setEstado($estado) {
        $this->estado = $estado;
    }
}

?>
<?php

class TipoUsuario {

    private $id;
    private $tipoUsuario;

    public function __construct($id, $tipoUsuario) {
        $this->id = $id;
        $this->tipoUsuario = $tipoUsuario;
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getTipoUsuario() {
        return $this->tipoUsuario;
    }

    public function setTipoUsuario($tipoUsuario) {
        $this->tipoUsuario = $tipoUsuario;
    }

}

?>
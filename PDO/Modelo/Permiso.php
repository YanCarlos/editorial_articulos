<?php

class PermisoOperacion {

    private $id;
    private $permiso;

    public function __construct($id, $permiso) {
        $this->id = $id;
        $this->permiso = $permiso;
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getPermiso() {
        return $this->permiso;
    }

    public function setPermiso($permiso) {
        $this->permiso = $permiso;
    }

}

?>
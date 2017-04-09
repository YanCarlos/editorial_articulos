<?php

class ParametrosDAO {

    private $repository;

    function ParametrosDAO() {
        require_once '../Infraestructure/Repository.php';
        $this->repository = new Repository();
    }    

    function listarEstados(){
        $query = "SELECT (id,descripcion) FROM tb_estados;";
        $this->repository->Execute($query);    
    }

    function listarPermisosPorTipoUsuario($idTipoUsuario){
        $query = "SELECT (o.permiso) FROM tb_operaciones o JOIN permisos_operaciones po ON po.operacion_id=o.id WHERE po.tipo_usuario_id=".$idTipoUsuario.";";
        $this->repository->Execute($query);
    }
}

?>
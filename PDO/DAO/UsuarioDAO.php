<?php

class UsuarioDAO {

    private $repository;

    function UsuarioDAO() {
        require_once '../Infraestructure/Repository.php';
        $this->repository = new Repository();
    }

    function buscar($idUsuario){
        $query = "SELECT u.id, u.nombre, u.apellido, u.telefono, u.email, u.password, u.direccion, u.estado, u.tipo_usuario_id, t.tipo_usuario FROM tb_usuarios u join tb_tipos_usuario t on t.id=u.tipo_usuario_id where email='".$idUsuario."';";
        $this->repository->Execute($query);
    }

    function editar(Usuario $obj){
        $query = "UPDATE tb_usuarios set nombre='".$obj->getNombre()."', apellido='".$obj->getApellido()
                ."', telefono='".$obj->getTelefono()."', direccion='".$obj->getDireccion()."', email='".$obj->getEmail()
                ."' where id=".$obj->getId().";";
        $this->repository->ExecuteTransaction($query);
    }

    function eliminar($idUsuario){
        $query = "UPDATE tb_usuarios SET estado=1 WHERE id=".$idUsuario.";";
        $this->repository->ExecuteTransaction($query);
    }

    function listarAutores(){
        $query = "SELECT (u.nombre, u.apellido, u.telefono, u.email, u.direccion, u.estado) FROM tb_usuarios u JOIN tb_tipos_usuario tu ON  u.tipo_usuario_id=tu.id WHERE tu.tipo_usuario=".AUTOR.";";
        $this->repository->Execute($query);    
    }

    function listarRevisores(){
        $query = "SELECT (u.nombre, u.apellido, u.telefono, u.email, u.direccion, u.estado) FROM tb_usuarios u JOIN tb_tipos_usuario tu ON  u.tipo_usuario_id=tu.id WHERE tu.tipo_usuario=".REVISOR.";";
        $this->repository->Execute($query);    
    }

    function listarEditores(){
        $query = "SELECT (u.nombre, u.apellido, u.telefono, u.email, u.direccion, u.estado) FROM tb_usuarios u JOIN tb_tipos_usuario tu ON  u.tipo_usuario  _id=tu.id WHERE tu.tipo_usuario=".EDITOR.";";
        $this->repository->Execute($query);    
    }
}

?>

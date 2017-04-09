<?php

class ArticuloDAO {

    private $repository;

    function ArticuloDAO() {
        require_once '../Infraestructure/Repository.php';
        $this->repository = new Repository();
    }

    function buscar($idArticulo){
        $query = "SELECT (id,descripcion,fecha,estado_id,url,codigo,autor_id) FROM tb_articulos WHERE id=".$idArticulo.";";
        $this->repository->Execute($query);
    }

    function crear(Articulo $obj){
        $query = "INSERT INTO tb_articulos (descripcion, fecha, estado_id, url, codigo, autor_id) values ('"
                .$obj->getDescripcion()."','".$obj->getFecha()."',".$obj->getEstado().",'".$obj->getUrl()
                ."','".$obj->getCodigo()."',".$obj->getAutor().");";
        $this->repository->ExecuteTransaction($query);
    }

    function editar(Articulo $obj){
        $query = "UPDATE tb_articulos SET descripcion='".$obj->getDescripcion()."', fecha='".$obj->getFecha()
                ."', estado_id=".$obj->getEstado().", url='".$obj->getUrl()."', codigo='".$obj->getCodigo()."',"
                ."autor_id=".$obj->getAutor()." where id=".$obj->getId().";";
        $this->repository->ExecuteTransaction($query);
    }

    function listar(){
        $query = "SELECT (id,descripcion,fecha,estado_id,url,codigo,autor_id) FROM tb_articulos";
        $this->repository->Execute($query);    
    }

    function listarPorAutor($idAutor){
        $query = "SELECT (id,descripcion,fecha,estado_id,url,codigo,autor_id) FROM tb_articulos WHERE autor_id="
                .$idAutor.";";
        $this->repository->Execute($query);    
    }

    function listarPorRevisorAsignado($idRevisor){
        $query = "SELECT (a.id,a.descripcion,a.fecha,a.estado_id,a.url,a.nombre,a.apellido) FROM tb_articulos a JOIN tb_usuarios u ON a.autor_id=u.id JOIN tb_revisiones r ON r.articulo_id=a.id WHERE r.revisor_id=".$idRevisor.";";
        $this->repository->Execute($query);    
    }
}

?>
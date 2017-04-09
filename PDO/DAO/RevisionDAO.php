<?php

class RevisionDAO {

    private $repository;

    function RevisionDAO() {
        require_once '../Infraestructure/Repository.php';
        $this->repository = new Repository();
    }    

    function crear(Revision $obj){
        $query = "INSERT INTO tb_revisiones (fecha,descripcion,url,version,mensaje,revisor_id,articulo_id,estado_id) VALUES ('".$obj->getFecha()."','".$obj->getDescripcion()."','".$obj->getUrl()."',".$obj->getVersion().",null,".$obj->getRevisor().",".$obj->getArticulo().",".$obj->getEstado().");";
        return $this->repository->ExecuteTransaction($query);
    }

    function buscar($idRevision){
        $query = "SELECT (r.id,r.fecha,r.descripcion,r.url,r.version,r.mensaje,r.estado_id,u.nombre,u.apellido) FROM tb_revisiones r JOIN tb_usuarios u ON u.id=r.revisor_id WHERE r.id=".$idRevision.";";
        $this->repository->Execute($query);    
    }

    function editar(Revision $obj){
        $query = "UPDATE tb_revisiones set fecha='".$obj->getFecha()."', descripcion='".$obj->getDescripcion()
                ."', url='".$obj->getUrl()."', version=".$obj->getVersion().", mensaje='".$obj->getMensaje()
                ."', estado_id=".$obj->getEstado()." where id=".$obj->getId().";";
        $this->repository->ExecuteTransaction($query);
    }

    function listarPorArticulo($idArticulo){
        $query = "SELECT (r.id,r.fecha,r.descripcion,r.url,r.version,r.mensaje,r.estado_id,u.nombre,u.apellido) FROM tb_revisiones r JOIN tb_usuarios u ON u.id=r.revisor_id WHERE r.articulo_id=".$idArticulo.";";
        $this->repository->Execute($query);    
    }
}

?>
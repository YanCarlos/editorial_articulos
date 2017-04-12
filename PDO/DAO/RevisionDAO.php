<?php

class RevisionDAO {

    private $repository;

    function RevisionDAO() {
        require_once '../Infraestructure/Repository.php';
        $this->repository = new Repository();
    }    

    function crear(Revision $obj){
        $query = "SELECT id FROM tb_estados_revision WHERE descripcion='".CORREGIR."';";  
        $estado = json_decode($this->repository->ExecuteAux($query));
        $query = "INSERT INTO tb_revisiones (revisor_id,articulo_id,estado_id) VALUES ('".$obj->getRevisor()
            ."', ".$obj->getArticulo().", ".$estado[0]->{"id"}.");";
        return $this->repository->ExecuteTransaction($query);
    }

    function buscar($idRevision){
        $query = "SELECT (r.id,r.fecha,r.descripcion,r.url,r.version,r.mensaje,r.estado_id,u.nombre,u.apellido) FROM tb_revisiones r JOIN tb_usuarios u ON u.id=r.revisor_id WHERE r.id=".$idRevision.";";
        $this->repository->Execute($query);    
    }

    function editar(Revision $obj){
        $query = "SELECT id FROM tb_estados_revision WHERE descripcion='".CORREGIR."';";  
        $estado = json_decode($this->repository->ExecuteAux($query));
        $query = 'SELECT MAX(version) as version FROM tb_revisiones GROUP BY '.$obj->getArticulo();
        $version = json_decode($this->repository->ExecuteAux($query));
        $date = new DateTime();
        $fecha = $date->format('Y-m-d');
        $url = $obj->getRevisor()."/".$obj->getArticulo()."/".$obj->getArchivo();
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
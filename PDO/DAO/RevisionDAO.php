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
        $query = "SELECT r.id,r.fecha,r.descripcion,r.url,r.version,r.mensaje,r.estado_id,u.nombre,u.apellido,e.descripcion as estado FROM tb_revisiones r JOIN tb_usuarios u ON u.id=r.revisor_id JOIN tb_estados_revision e ON e.id=r.estado_id WHERE r.id=".$idRevision.";";
        $this->repository->Execute($query);    
    }

    function editar(Revision $obj){
        $query = "SELECT id FROM tb_estados_revision WHERE descripcion='".$obj->getEstado()."';";  
        $estado = json_decode($this->repository->ExecuteAux($query));
        $query = "SELECT articulo_id, MAX(version) as version FROM tb_revisiones WHERE articulo_id=".$obj->getArticulo()
            ." GROUP BY articulo_id";
        $version = json_decode($this->repository->ExecuteAux($query));
        if($version[0]->{"version"} == null){
            $version = 1;
        } else {
            $version = $version[0]->{"version"}+1;
        }
        $date = new DateTime();
        $fecha = $date->format('Y-m-d');
        $url = $obj->getRevisor()."/".$obj->getArticulo()."/".$version."/".$obj->getArchivo();
        $query = "UPDATE tb_revisiones set fecha='".$fecha."', descripcion='".$obj->getDescripcion()
                ."', url='".$url."', version=".$version.", estado_id=".$estado[0]->{"id"}
                ." where id=".$obj->getId().";";
        $resp = json_decode($this->repository->ExecuteTransactionAux($query));
        echo(json_encode(['status' => 'true', "msg" => $url]));
    }

    function listarPorArticulo($idArticulo, $desde){
        if($desde == ""){
            $query = "SELECT r.id,r.fecha,r.descripcion,r.url,r.version,r.mensaje,r.estado_id,u.nombre,u.apellido,e.descripcion as estado FROM tb_revisiones r JOIN tb_usuarios u ON u.id=r.revisor_id JOIN tb_estados_revision e ON e.id=r.estado_id WHERE r.articulo_id=".$idArticulo." AND r.version IS NOT NULL;";    
        }else{
            $desde = ($desde-1)*10;
            $query = "SELECT r.id,r.fecha,r.descripcion,r.url,r.version,r.mensaje,r.estado_id,u.nombre,u.apellido FROM tb_revisiones r JOIN tb_usuarios u ON u.id=r.revisor_id JOIN tb_estados_revision e ON e.id=r.estado_id WHERE r.articulo_id=".$idArticulo." AND r.version IS NOT NULL LIMIT 10 OFFSET ".$desde.";";    
        }        
        $this->repository->Execute($query);    
    }

    function listarPorRevisor($idRevisor, $desde){
        if($desde == ""){
            $query = "SELECT r.id,r.fecha,r.descripcion,r.url,r.version,r.mensaje,u.nombre,u.apellido,e.descripcion as estado, r.articulo_id FROM tb_revisiones r JOIN tb_usuarios u ON u.id=r.revisor_id JOIN tb_estados_revision e ON e.id=r.estado_id WHERE r.revisor_id=".$idRevisor." AND r.version IS NOT NULL;";    
        }else{
            $desde = ($desde-1)*10;
            $query = "SELECT r.id,r.fecha,r.descripcion,r.url,r.version,r.mensaje,u.nombre,u.apellido,e.descripcion as estado, r.articulo_id FROM tb_revisiones r JOIN tb_usuarios u ON u.id=r.revisor_id JOIN tb_estados_revision e ON e.id=r.estado_id WHERE r.revisor_id=".$idRevisor." AND r.version IS NOT NULL LIMIT 10 OFFSET ".$desde.";";    
        }        
        $this->repository->Execute($query);    
    }

    function listarRevisionesPendientes($idRevisor, $desde){
        if($desde == ""){
            $query = "SELECT r.id,r.revisor_id,r.articulo_id,a.descripcion,a.fecha,a.url,e.descripcion as estado FROM
                tb_revisiones r JOIN tb_articulos a ON a.id=r.articulo_id JOIN tb_estados_revision e ON 
                e.id=a.estado WHERE r.revisor_id=".$idRevisor." AND r.version IS NULL;";
        }else{
            $desde = ($desde-1)*10;
            $query = "SELECT r.id,r.revisor_id,r.articulo_id,a.descripcion,a.fecha,a.url,e.descripcion as estado FROM
                tb_revisiones r JOIN tb_articulos a ON a.id=r.articulo_id JOIN tb_estados_revision e ON 
                e.id=a.estado WHERE r.revisor_id=".$idRevisor." AND r.version IS NULL LIMIT 10 OFFSET ".$desde.";";
        }       
        $this->repository->Execute($query);    
    }
}

?>
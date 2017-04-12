<?php

class ArticuloDAO {

    private $repository;

    function ArticuloDAO() {
        require_once '../Infraestructure/Repository.php';
        $this->repository = new Repository();
    }

    function buscar($idArticulo){
        $query = "SELECT (id,descripcion,fecha,estado,url,codigo,autor_id) FROM tb_articulos WHERE id=".$idArticulo.";";
        $this->repository->Execute($query);
    }

    function crear(Articulo $obj){
        $query = "SELECT id FROM tb_estados_revision WHERE descripcion='".CORREGIR."';";  
        $estado = json_decode($this->repository->ExecuteAux($query));       
        $date = new DateTime();
        $fecha = $date->format('Y-m-d');
        $query = "INSERT INTO tb_articulos (descripcion, fecha, estado, autor_id) values ('".$obj->getDescripcion()."','"
            .$fecha."',".$estado[0]->{"id"}.",".$obj->getAutor().");";        
        $resp = json_decode($this->repository->ExecuteTransactionAux($query));
        $query = "SELECT id FROM tb_articulos WHERE descripcion='".$obj->getDescripcion()."' AND fecha='".$fecha."' AND estado=".$estado[0]->{"id"}." AND autor_id=".$obj->getAutor().";";        
        $articulo = json_decode($this->repository->ExecuteAux($query));
        $codigo = $articulo[count($articulo)-1]->{"id"}."-".$obj->getAutor()."-".$fecha."-".$this->generateRandomString();
        $url = $obj->getAutor()."/".$codigo."/".$obj->getArchivo();
        $query = "UPDATE tb_articulos SET url='".$url."', codigo='".$codigo."' WHERE id=".$articulo[count($articulo)-1]->{"id"}.";";
        $resp = json_decode($this->repository->ExecuteTransactionAux($query));
        echo(json_encode(['status' => 'true', "msg" => $url]));
    }

    function editar(Articulo $obj){
        $query = "UPDATE tb_articulos SET descripcion='".$obj->getDescripcion()."', fecha='".$obj->getFecha()
                ."', estado=".$obj->getEstado().", url='".$obj->getUrl()."', codigo='".$obj->getCodigo()."',"
                ."autor_id=".$obj->getAutor()." where id=".$obj->getId().";";
        $this->repository->ExecuteTransaction($query);
    }

    function listar(){
        $query = "SELECT (id,descripcion,fecha,estado,url,codigo,autor_id) FROM tb_articulos";
        $this->repository->Execute($query);    
    }

    function listarPorAutor($idAutor){
        $query = "SELECT a.id,a.descripcion,a.fecha,a.url,a.codigo,a.autor_id,e.descripcion as estado FROM tb_articulos a JOIN tb_estados_revision e ON e.id=a.estado WHERE autor_id=".$idAutor.";";
        $this->repository->Execute($query);    
    }

    function listarPorEditor(){
        $query = "SELECT a.id,a.descripcion,a.fecha,a.url,a.codigo,a.autor_id,u.nombre,u.apellido,eA.descripcion 
            as estadoArticulo, eR.descripcion as estadoRevision FROM tb_articulos a JOIN tb_usuarios u ON 
            a.autor_id=u.id JOIN tb_estados_revision eA ON eA.id=a.estado LEFT JOIN (SELECT r.id,r.estado_id
            ,r.articulo_id FROM (SELECT articulo_id, MAX(version) as version FROM tb_revisiones GROUP BY 
            articulo_id) aux JOIN tb_revisiones r ON r.articulo_id=aux.articulo_id AND aux.version= r.version) r 
            on r.articulo_id=a.id LEFT JOIN tb_estados_revision eR ON eR.id=r.estado_id;";
        $this->repository->Execute($query);    
    }

    function listarPorRevisorAsignado($idRevisor){
        $query = "SELECT (a.id,a.descripcion,a.fecha,a.estado,a.url,a.nombre,a.apellido) FROM tb_articulos a JOIN tb_usuarios u ON a.autor_id=u.id JOIN tb_revisiones r ON r.articulo_id=a.id WHERE r.revisor_id=".$idRevisor.";";
        $this->repository->Execute($query);    
    }

    function generateRandomString($length = 6) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}

?>
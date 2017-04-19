<?php

/* IMPORTS */
require '../Modelo/Revision.php';
require '../DAO/RevisionDAO.php';
require '../Util/Constantes.php';

/* Capturamos el tipo de la peticion: podría ser get, post, put o delete. */
$method = $_SERVER['REQUEST_METHOD'];

$dtoRevision = new RevisionDAO();
//$daoCliente = new ClienteDAO();
// Dependiendo del método de la petición ejecutaremos la acción correspondiente.
switch (strtolower($method)) {
    /* Buscar o Listar */
    case 'get':
        $type = (isset($_REQUEST['type']) ? $_REQUEST['type'] : "");        
        $id = (isset($_REQUEST['id']) ? $_REQUEST['id'] : "");
        $pag = (isset($_REQUEST['pag']) ? $_REQUEST['pag'] : "");

        if ($type != "") {
            //Buscar
            if($type == BUSCAR){
                $dtoRevision->buscar($id);
            }else if($type == REVISIONESPORARTICULO){
                $dtoRevision->listarPorArticulo($id, $pag);
            }else if($type == REVISIONESPENDIENTES){
                $dtoRevision->listarRevisionesPendientes($id, $pag);
            }else if($type == REVISIONESPORREVISOR){
                $dtoRevision->listarPorRevisor($id, $pag); 
            }
        }
        break;

    case 'post':
        /* Guardar */
        /* CONTROL DE ACCIONES */
        $data = json_decode(json_encode($_POST));
        $obj = new Revision($data->revisor,$data->articulo);
        $dtoRevision->crear($obj);
        break;

    case 'put':
        /* Eliminar */
        /* CONTROL DE ACCIONES */
        $id = (isset($_REQUEST['id']) ? $_REQUEST['id'] : "");  
        $revisor = (isset($_REQUEST['revisor']) ? $_REQUEST['revisor'] : "");        
        $articulo = (isset($_REQUEST['articulo']) ? $_REQUEST['articulo'] : "");        
        $descripcion = (isset($_REQUEST['descripcion']) ? $_REQUEST['descripcion'] : "");        
        $estado = (isset($_REQUEST['estado']) ? $_REQUEST['estado'] : "");        
        $file = (isset($_REQUEST['file']) ? $_REQUEST['file'] : "");        
        $type = (isset($_REQUEST['type']) ? $_REQUEST['type'] : "");  
        $mensaje = (isset($_REQUEST['mensaje']) ? $_REQUEST['mensaje'] : "");  

        $obj = new Revision($revisor,$articulo);
        $obj->setDescripcion($descripcion);
        $obj->setEstado($estado);
        $obj->setArchivo($file);
        $obj->setId($id);

        if($type == "CREAR"){
            $dtoRevision->crearRevision($obj);
        }else if($type == "EDITAR"){
            $dtoRevision->editar($obj);
        }else if($type == "RESPONDER"){
            $dtoRevision->responder($id, $mensaje);
        }
        break;
}
?>
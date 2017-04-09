<?php

/* IMPORTS */
require '../Modelo/Revision.php';
require '../DAO/RevisionDAO.php';

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

        if ($type != "") {
            //Buscar
            if($type == BUSCAR){
                $dtoRevision->buscar($id);
            }
            else if($type == LISTARPORARTICULO){
                $dtoRevision->listarPorArticulo($id);
            }
        }
        break;

    case 'post':
        /* Guardar */
        /* CONTROL DE ACCIONES */
        $data = json_decode(json_encode($_POST));
        $obj = new Revision($data->fecha,$data->descripcion,$data->url,$data->version,$data->mensaje,$data->revisor,$data->articulo,$data->estado);
        $dtoRevision->crear($obj);
        break;

    case 'put':
        /* Eliminar */
        /* CONTROL DE ACCIONES */
        $data = json_decode(json_encode($_POST));        
        $obj = new Revision($data->fecha,$data->descripcion,$data->url,$data->version,$data->mensaje,$data->revisor,$data->articulo,$data->estado);
        $dtoRevision->editar($obj);
        break;
}
?>
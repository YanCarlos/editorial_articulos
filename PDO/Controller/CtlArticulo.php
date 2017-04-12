<?php

/* IMPORTS */
require '../Modelo/Articulo.php';
require '../DAO/ArticuloDAO.php';
require '../Util/Constantes.php';

/* Capturamos el tipo de la peticion: podría ser get, post, put o delete. */
$method = $_SERVER['REQUEST_METHOD'];

$dtoArticulo = new ArticuloDAO();
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
                $dtoArticulo->buscar($id);
            }
            else if($type == LISTARAUTORES){
                $dtoArticulo->listarPorAutor($id);
            }
            else if($type == LISTAREDITORES){
                $dtoArticulo->listarPorEditor();
            }
            else if($type == LISTARREVISORES){
                $dtoArticulo->listarPorRevisorAsignado($id);
            }
        }
        break;

    case 'post':
        /* Guardar */
        /* CONTROL DE ACCIONES */
        $data = json_decode(json_encode($_POST));
        $obj = new Articulo($data->descripcion,$data->autor,$data->file);
        $dtoArticulo->crear($obj);
        break;

    case 'put':
        /* Eliminar */
        /* CONTROL DE ACCIONES */
        $data = json_decode(json_encode($_POST));        
        $obj = new Articulo($data->descripcion,$data->fecha,$data->estado,$data->url,$data->codigo,$data->autor);
        $dtoArticulo->editar($obj);
        break;
}
?>
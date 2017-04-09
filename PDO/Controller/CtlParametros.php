<?php

/* IMPORTS */
require '../DAO/ParamestrosDAO.php';

/* Capturamos el tipo de la peticion: podría ser get, post, put o delete. */
$method = $_SERVER['REQUEST_METHOD'];

$daoParametros = new ParametrosDAO();
//$daoCliente = new ClienteDAO();
// Dependiendo del método de la petición ejecutaremos la acción correspondiente.
switch (strtolower($method)) {
    /* Buscar o Listar */
    case 'get':
        $tipoUsuario = (isset($_REQUEST['tipoUsuario']) ? $_REQUEST['tipoUsuario'] : "");        

        if ($tipoUsuario != "") {
            //Buscar            
            $daoParametros->listarPermisosPorTipoUsuario($tipoUsuario);
        }else{
            $daoParametros->listarEstados();
        }
        break;
}
?>
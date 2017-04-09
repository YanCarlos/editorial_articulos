<?php

/* IMPORTS */
require '../Modelo/Usuario.php';
require '../DAO/UsuarioDAO.php';
require '../Util/Constantes.php';

/* Capturamos el tipo de la peticion: podría ser get, post, put o delete. */
$method = $_SERVER['REQUEST_METHOD'];

$dtoUsuario = new UsuarioDAO();
//$daoCliente = new ClienteDAO();
// Dependiendo del método de la petición ejecutaremos la acción correspondiente.
switch (strtolower($method)) {
    /* Buscar o Listar */
    case 'get':
        $type = (isset($_REQUEST['type']) ? $_REQUEST['type'] : "");        
        $email = (isset($_REQUEST['email']) ? $_REQUEST['email'] : "");

        if ($type != "") {
            //Buscar
            if($type == BUSCAR){
                $dtoUsuario->buscar($email);
            }
            else if($type == LISTARAUTORES){
                $dtoUsuario->listarAutores();
            }
            else if($type == LISTAREDITORES){
                $dtoUsuario->listarEditores();
            }
            else if($type == LISTARREVISORES){
                $dtoUsuario->listarRevisores();
            }
        }
        break;

    case 'post':
        /* Guardar */
        /* CONTROL DE ACCIONES */
        $data = json_decode(json_encode($_POST));
        $obj = new Usuario($data->email, $data->password, $data->estado, $data->nombre, $data->apellido, $data->telefono, 
            $data->direccion, $data->tipoUsuario);
        $obj->setId($data->id);
        $dtoUsuario->editar($obj);
        break;

    case 'delete':
        /* Eliminar */
        /* CONTROL DE ACCIONES */
        $data = json_decode(json_encode($_POST));        
        $dtoUsuario->eliminar($data->id);
        break;
}
?>
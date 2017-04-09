<?php

/* IMPORTS */
require '../Modelo/LogIn.php';
require '../Modelo/Usuario.php';
require '../DAO/LogInDAO.php';

/* Capturamos el tipo de la peticion: podría ser get, post, put o delete. */
$method = $_SERVER['REQUEST_METHOD'];

$daoLogIn = new LoginDAO();
//$daoCliente = new ClienteDAO();
// Dependiendo del método de la petición ejecutaremos la acción correspondiente.
switch (strtolower($method)) {
    /* Buscar o Listar */
    case 'get':
        $email = (isset($_REQUEST['email']) ? $_REQUEST['email'] : "");
        $password = (isset($_REQUEST['password']) ? $_REQUEST['password'] : "");

        if ($email != "") {
            //Buscar
            $obj = new LogIn($email, $password);
            $daoLogIn->ingresar($obj);
        }
        break;

    case 'post':
        /* Guardar */
        /* CONTROL DE ACCIONES */        
        $data = json_decode(json_encode($_POST));        
        $obj = new Usuario($data->email, $data->password, '0', $data->nombre, $data->apellido, $data->telefono, $data->direccion, $data->tipoUsuario);
        $daoLogIn->registrar($obj);
        break;
}
?>
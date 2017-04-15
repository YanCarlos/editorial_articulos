"use strict";

app.controller('CtlUsuario', function ($scope, $window, usuarioService, logInService, TIPOSUSUARIO, LISTA){

	$scope.usuario = {};	
	$scope.editor = {};

	$scope.tipoUsuario = "";
	$scope.tiposUsuario = [
		TIPOSUSUARIO.EDITOR,
		TIPOSUSUARIO.REVISOR,
		TIPOSUSUARIO.AUTOR
	];

	$scope.tiposUsuarioEditor = [
		TIPOSUSUARIO.REVISOR,
		TIPOSUSUARIO.AUTOR
	];


	$scope.usuarios = [];

	$scope.totalItems = 100;
	$scope.currentPage = 1;
	$scope.maxSize = 5;

	$scope.buscar = function () {
		var usuario = sessionStorage.getItem("user");
		usuarioService.buscar(usuario).then(function(response){
			if(response.length > 0){
				response[0].telefono = parseInt(response[0].telefono);
				$scope.usuario = response[0];
			}else{
				alert("El usuario no existe");
			}
		});
	};

	$scope.editar = function (form){
		if(form){
			usuarioService.editar($scope.usuario).then(function(response){
				if(response.status === "true" || (response.status === "false" && response.msg === "Error en la operacion")){	
					sessionStorage.setItem("user", $scope.usuario.email);
					$window.location.href = "inicio.html";				
					alert("Se edito con éxito");
				}else if(response.msg.errorInfo[0] === "23000"){
					alert("El correo ya existe");
				}else{
					alert("No se pudo editar");
				}
			});	
		}else{
			alert("Diligencie todos los tados");
		}		
	};

	$scope.registrarEditor = function(form){
		if(form){
			$scope.editor.tipo = TIPOSUSUARIO.EDITOR;
			logInService.registrar($scope.editor).then(function (response){
				if(response.status){
					$window.location.href = "inicio.html";				
					alert("Se registro con exito");
				}else{
					alert("Error");
				}
			});
		}else{
			alert("Diligencie todos los datos");
		}
	}

	$scope.listar = function(){
		var tipo = ""
		if($scope.tipoUsuario === TIPOSUSUARIO.REVISOR){
			tipo = LISTA.REVISOR;
		}else if($scope.tipoUsuario === TIPOSUSUARIO.EDITOR){
			tipo = LISTA.EDITOR;
		}else{
			$scope.tipoUsuario = TIPOSUSUARIO.AUTOR;
			tipo = LISTA.AUTOR;
		}
		usuarioService.listarUsuariosPorTipo(tipo,$scope.currentPage).then(function(response){
			if(response.length > 0){
				$scope.usuarios = [];
				$scope.totalItems = response.length;
				for(var i=0; i< response.length; i++){
					$scope.usuarios.push({nombre: response[i].nombre, apellido: response[i].apellido, direccion: response[i].direccion,
						telefono: response[i].telefono, email: response[i].email, estado: response[i].estado});
				}
			}else{
				$scope.usuarios = [];
				alert("No hay autores registrados");
			}
		});
	}	

	$scope.setPage = function (pageNo) {
		$scope.currentPage = pageNo;
	};

	$scope.pageChanged = function() {
		console.log("Hola");
		$log.log('Page changed to: ' + $scope.currentPage);
	};	

});
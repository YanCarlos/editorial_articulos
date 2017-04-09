"use strict";

app.controller('CtlUsuario', function ($scope, $window, usuarioService, logInService, TIPOSUSUARIO){

	$scope.usuario = {};	
	$scope.editor = {};

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
			$scope.editor.tipoUsuario = TIPOSUSUARIO.EDITOR;
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

});
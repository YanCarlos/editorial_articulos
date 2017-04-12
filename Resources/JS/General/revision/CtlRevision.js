"use strict";

app.controller('CtlRevision', function($scope, $window, revisionSer, usuarioService, auxSer, ESTADO, LISTA){

	$scope.revision = {};
	$scope.articulo = auxSer.data;

	$scope.estados = [
	ESTADO.CORREGIR,
	ESTADO.APROBADO,
	ESTADO.DENEGADO
	];

	$scope.revisores = [];

	$scope.crear = function(form){	
		$scope.revision.articulo = $scope.articulo.id;			
		revisionSer.crear($scope.revision).then(function(response){
			if(response.status){
				$scope.revision = {};
				alert("El revision se registró con éxito");
			}
		});		
	};

	$scope.listarRevisores = function(){
		usuarioService.listarUsuariosPorTipo(LISTA.REVISOR, 0).then(function(response){
			if(response.length > 0){
				$scope.revisores = [];
				for(var i =0; i<response.length; i++){
					$scope.revisores.push({
						id: response[i].id,
						desc: response[i].nombre+" "+response[i].apellido
					});
				}
			}
		});
	};

	$scope.validarTipoArchivo = function(tipo){
		if (typeof $scope.articulo.url === "undefined") {
		    $window.location.href = "#/articuloseditor";
		}else{
			var archivo = $scope.articulo.url.split("/");
			var extension = archivo[archivo.length-1].split(".");
			if(extension[extension.length-1] == tipo)
				return true;
			return false;
		}
		
	}

});
"use strict";

app.controller('CtlRevision', function($scope, $window, $routeParams, fileSer, revisionSer, articuloSer, usuarioService, ESTADO, LISTA, TIPOARCHIVO){

	$scope.revision = {};
	$scope.articulo = {};

	$scope.estados = [
	ESTADO.CORREGIR,
	ESTADO.APROBADO,
	ESTADO.DENEGADO
	];

	$scope.revisores = [];

	$scope.totalItems = 100;
    $scope.currentPage = 1;
    $scope.maxSize = 5;

	$scope.crear = function(form){	
		if(form){
			$scope.revision.articulo = $scope.articulo.id;			
			revisionSer.crear($scope.revision).then(function(response){
				if(response.status){					                
					$scope.revision = {};
					alert("El revision se registró con éxito");
				}
			});		
		}else{
			alert("Diligencie el estado");
		}		
	};

	$scope.editar = function(form){	
		if(form){
			$scope.revision.id = $routeParams.idRevision;			
			$scope.revision.revisor = $routeParams.revisor;
			$scope.revision.articulo = $scope.articulo.id;			
			revisionSer.editar($scope.revision).then(function(response){
				if(response.status){
					fileSer.subirArchivo($scope.revision.file,response.msg, TIPOARCHIVO.REVISION);    
					$scope.revision = {};
					alert("El revision se registró con éxito");
				}
			});		
		}else{
			alert("Diligencie todos los datos");
		}		
	};

	$scope.listarRevisores = function(){
		usuarioService.listarUsuariosPorTipo(LISTA.REVISOR, 0).then(function(response){
			if(response.length > 0){
				$scope.revisores = [];
				for(var i =0; i<response.length; i++){
					$scope.revisores.push({
						id: response[i].articulo_id,
						descripion: response[i].descripion,
						fecha: response[i].fecha,
						estado: response[i].estado
					});
				}
			}
		});
	};

	$scope.cargarUsuario = function () {
        var usuario = sessionStorage.getItem("user");
        usuarioService.buscar(usuario).then(function(response){
            if(response.length > 0){
                $scope.revision.revisor = response[0].id;
                $scope.listarPendientes();
            }else{
                alert("El usuario no existe");
            }
        });
    };

	$scope.listarPendientes = function(){		
		$scope.revision.busqueda = $scope.revision.revisor;
		revisionSer.listar(LISTA.REVISIONESPENDIENTES, $scope.revision.busqueda).then(function(response){
			if(response.length > 0){
				$scope.revisiones = [];
				$scope.totalItems = response.length;
				for(var i =0; i<response.length; i++){
					$scope.revisiones.push({
						id: response[i].id,
						desc: response[i].nombre+" "+response[i].apellido,
						fecha: response[i].fecha,
						descripcion: response[i].descripcion,
						estado: response[i].estado,						
						articulo_id: response[i].articulo_id,
						revisor: response[i].revisor_id
					});
				}
			}
		});
	};

	$scope.listarPorRevisor = function(){
		$scope.revision.busqueda = $routeParams.idRevisor;
		revisionSer.listar(LISTA.REVISIONESPORREVISOR, $scope.revision.busqueda).then(function(response){
			if(response.length > 0){
				$scope.revisiones = [];
				$scope.totalItems = response.length;
				for(var i =0; i<response.length; i++){
					$scope.revisiones.push({
						id: response[i].id,
						fecha: response[i].fecha,
						descripcion: response[i].descripcion,
						estado: response[i].estado,						
						version: response[i].version,
						articulo_id: response[i].articulo_id
					});
				}
			}
		});
	};

    $scope.listarPorArticulo = function(){
        $scope.revision.busqueda = $routeParams.idArticulo;
        revisionSer.listar(LISTA.REVISIONESPORARTICULO, $scope.revision.busqueda).then(function(response){
            if(response.length > 0){
                $scope.revisiones = [];
                $scope.totalItems = response.length;
                for(var i =0; i<response.length; i++){
                    $scope.revisiones.push({
                        id: response[i].id,
                        fecha: response[i].fecha,
                        descripcion: response[i].descripcion,
                        estado: response[i].estado,                     
                        version: response[i].version,
                        articulo_id: response[i].articulo_id
                    });
                }
            }
        });
    };

	$scope.cargarArticulo = function() {
		articuloSer.buscar($routeParams.idArticulo, LISTA.BUSCAR).then(function(response){
			if(response.length > 0){
				$scope.articulo = response[0];
				$scope.validarTipoArchivo($scope.articulo);
			}
		});
	};

	$scope.cargarRevision = function() {
		revisionSer.buscar($routeParams.idRevision, LISTA.BUSCAR).then(function(response){
			if(response.length > 0){
				$scope.revision = response[0];
				$scope.validarTipoArchivo($scope.revision);
			}
		});
	};

	$scope.validarTipoArchivo = function(file){
		var archivo = file.url.split("/");
		var extension = archivo[archivo.length-1].split(".");
		file.tipo = extension[extension.length-1];
	};

	$scope.pageChanged = function(tipoLista) {
        revisionSer.listar(tipoLista, $scope.revision.busqueda, $scope.currentPage).then(function(response){
            if (response.length > 0) {
                $scope.revisiones = [];
                for(var i = 0; i < response.length; i++){
                    $scope.revisiones.push({
                        descripcion: response[i].descripcion,
                        fecha: response[i].fecha,
                        url: response[i].url,
                        estado: response[i].estado
                    });
                }
            } else {
                alert("No tiene revisions registrados");
            }
        });
    };  

});
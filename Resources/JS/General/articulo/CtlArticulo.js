"use strict";

app.controller('CtlArticulo', function($scope, $routeParams, $window, articuloSer, usuarioService, fileSer, TIPOSUSUARIO, ESTADO, LISTA, TIPOARCHIVO) {

    $scope.articulo = {};      
    $scope.articulos = [];

    $scope.estados = [
    ESTADO.CORREGIR,
    ESTADO.APROBADO,
    ESTADO.DENEGADO
    ]

    $scope.totalItems = 100;
    $scope.currentPage = 1;
    $scope.maxSize = 5;

    $scope.crear = function(form){
        if(form){
            articuloSer.crear($scope.articulo).then(function(response){
                if(response.status){
                    fileSer.subirArchivo($scope.articulo.file,response.msg,TIPOARCHIVO.ARTICULO);
                    $scope.articulo = {};
                    alert("El articulo se registró con éxito");
                }
            });
        }else{
            alert("Diligencie todos los datos");
        }
    };

    $scope.listarPorEditor = function(){ 
        articuloSer.listar(LISTA.EDITOR, "").then(function(response){
            if (response.length > 0) {
                $scope.articulos = [];
                $scope.totalItems = response.length;
                for(var i = 0; i < response.length; i++){
                    if(response[i].estadoRevision == null){
                        response[i].estadoRevision = "NO TIENE";
                    }
                    $scope.articulos.push({
                        id: response[i].id,
                        fecha: response[i].fecha,
                        autor: response[i].nombre+" "+response[i].apellido,
                        estadoArticulo: response[i].estadoArticulo,
                        estadoRevision: response[i].estadoRevision,
                        descripcion: response[i].descripcion,
                        url: response[i].url
                    });
                }
            } else {
                alert("No tiene articulos registrados");
            }
        });
    };

    $scope.listarPorAutor = function(){ 
        articuloSer.listar(LISTA.AUTOR, $scope.articulo.autor).then(function(response){
            if (response.length > 0) {
                $scope.articulos = [];
                $scope.totalItems = response.length;
                for(var i = 0; i < response.length; i++){
                    $scope.articulos.push({
                        id: response[i].id,
                        descripcion: response[i].descripcion,
                        fecha: response[i].fecha,
                        url: response[i].url,
                        estado: response[i].estado
                    });
                }
            } else {
                alert("No tiene articulos registrados");
            }
        });
    };

    $scope.cargarArticulo = function() {
        articuloSer.buscar($routeParams.idArticulo, LISTA.BUSCAR).then(function(response){
            if(response.length > 0){
                $scope.articulo = response[0];
                $scope.articulo.estado = response[0].descEstado;
                $scope.validarTipoArchivo();
            }
        });
    };

    $scope.cargarAutor = function () {
        var usuario = sessionStorage.getItem("user");
        usuarioService.buscar(usuario).then(function(response){
            if(response.length > 0){
                $scope.articulo.autor = response[0].id;
                $scope.listarPorAutor();
            }else{
                alert("El usuario no existe");
            }
        });
    };

    $scope.editarPorEditor = function(form) {
        if(form){
            articuloSer.editar($scope.articulo, TIPOSUSUARIO.EDITOR).then(function(response){
                if(response.status){
                    alert("Se edito con exito");
                }
            });
        }else{
            alert("Diligencie el estado");
        }        
    };

    $scope.validarTipoArchivo = function(){
        var archivo = $scope.articulo.url.split("/");
        var extension = archivo[archivo.length-1].split(".");
        $scope.articulo.tipo = extension[extension.length-1];
    };

    $scope.setPage = function (pageNo) {
        $scope.currentPage = pageNo;
    };

    $scope.pageChanged = function(tipoLista) {
        articuloSer.listar(tipoLista, $scope.articulo.autor, $scope.currentPage).then(function(response){
            if (response.length > 0) {
                $scope.articulos = [];
                for(var i = 0; i < response.length; i++){
                    $scope.articulos.push({
                        descripcion: response[i].descripcion,
                        fecha: response[i].fecha,
                        url: response[i].url,
                        estado: response[i].estado
                    });
                }
            } else {
                alert("No tiene articulos registrados");
            }
        });
    };  
});
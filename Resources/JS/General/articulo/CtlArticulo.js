"use strict";

app.controller('CtlArticulo', function($scope, articuloSer, usuarioService, fileSer, auxSer, LISTA) {

    $scope.articulo = {};      
    $scope.articulos = [];

    $scope.totalItems = 100;
    $scope.currentPage = 1;
    $scope.maxSize = 5;

    $scope.crear = function(form){
        if(form){
            articuloSer.crear($scope.articulo).then(function(response){
                if(response.status){
                    fileSer.subirArchivo($scope.articulo.file,response.msg);
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

    $scope.cargarArticulo = function(articulo){
        auxSer.data = articulo;
    }

});
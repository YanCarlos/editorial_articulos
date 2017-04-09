"use strict";
var app = angular.module("app", ['ngRoute']);






app.config(function ($routeProvider) {
    $routeProvider
        .when('/login', {
             templateUrl: 'pages/login/login.html'
        })
        .when('/', {
             templateUrl: 'pages/autor/articulo.html'
        })
        .when('/editarperfil', {
            templateUrl: 'pages/compartido/editarperfil.html'
        })
        .when('/registroeditor', {
            templateUrl: 'pages/admin/registroeditor.html'
        })
        .otherwise({
            redirectTo: '/'
        });
            
            
});


/*Controlador global, que cada vez que se cargue la pagina masterPage 
 * valida si ya inicio sesion para saber si se deja o se redirecciona 
 * al index*/
app.controller('CtlValidate', function ($scope, $window) {
    /*Se almacena en el modelo sesion, este es utilizado por el ng-show 
    * para saber si muestra o no la interfaz grafica*/
    $scope.sesion = sessionStorage.getItem("sesion");
    /*Luego se valida para saber si se redirecciona o no*/
    if (!$scope.sesion) {
        $window.location.href = 'index.html';
    }
});

app.constant('TIPOSUSUARIO',{
   AUTOR: 'AUTOR',
   SUPERVISOR: 'REVISOR',
   EDITOR: 'EDITOR'
});

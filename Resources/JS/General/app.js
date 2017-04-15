"use strict";

/*El use strict hace que se deba codificar de manera correcta, siendo estricto
 * a la hora de compilar el codigo ejemplo: 
 * x = 3.14; // This will cause an error (x is not defined)*/

/*Se definen las depenciencias que seran utilizadas por el sistema, son varias
* se separan asi: ['ngRoute', 'ngCookies', 'xxxxx']*/
var app = angular.module("appPrincipal", ['ngRoute','ui.bootstrap','ngFileUpload']);

app.config(function ($routeProvider) {
  $routeProvider
  .when('/', {
    templateUrl: 'pages/Templates/bienvenido.html'
  })
  .when('/editarperfil', {
    templateUrl: 'pages/compartido/editarperfil.html'
  })
  .when('/registroeditor', {
    templateUrl: 'pages/admin/registroeditor.html'
  })
  .when('/usuarios', {
    templateUrl: 'pages/admin/usuarios.html'
  })    
  .when('/articulos', {
    templateUrl: 'pages/autor/articulo.html'
  })
  .when('/articulosautor', {
    templateUrl: 'pages/autor/articulosautor.html'
  })
  .when('/articuloseditor', {
    templateUrl: 'pages/editor/articulos.html'
  })
  .when('/usuarioseditor', {
    templateUrl: 'pages/editor/usuarios.html'
  })  
  .when('/revision/:idArticulo', {
    templateUrl: 'pages/editor/revision.html'
  }) 
  .when('/editararticuloeditor/:idArticulo', {
    templateUrl: 'pages/editor/editararticulo.html'
  })
  .when('/revisionespendientes', {
    templateUrl: 'pages/revisor/revisionespendientes.html'
  })
  .when('/crearrevision/:idRevision', {
    templateUrl: 'pages/compartido/crearrevision.html'
  })
  .when('/editarrevision', {
    templateUrl: 'pages/compartido/editarrevision.html'
  })
  .when('/misrevisiones', {
    templateUrl: 'pages/compartido/misrevisiones.html'
  })
  .when('/editararticulo', {
    templateUrl: 'pages/autor/editararticulo.html'
  })
  .when('/revisionesporarticulo', {
    templateUrl: 'pages/autor/revisionesporarticulo.html'
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

app.directive('ngConfirmClick', [
  function(){
    return {
      link: function (scope, element, attr) {
        var msg = attr.ngConfirmClick || "Are you sure?";
        var clickAction = attr.confirmedClick;
        element.bind('click',function (event) {
          if ( window.confirm(msg) ) {
            scope.$eval(clickAction)
          }
        });
      }
    };
  }])

app.constant('TIPOSUSUARIO',{
 AUTOR: 'AUTOR',
 REVISOR: 'REVISOR',
 EDITOR: 'EDITOR',
 ADMIN: 'ADMIN'
});

app.constant('LISTA',{
 BUSCAR: 'BUSCAR',
 AUTOR: 'LISTARAUTORES',
 REVISOR: 'LISTARREVISORES',
 EDITOR: 'LISTAREDITORES',
 REVISIONESPENDIENTES: 'REVISIONESPENDIENTES',
 REVISIONESPORREVISOR: 'REVISIONESPORREVISOR',
 REVISIONESPORARTICULO: 'REVISIONESPORARTICULO'
});

app.constant('ESTADO',{
 CORREGIR: 'CORREGIR',
 APROBADO: 'APROBADO',
 DENEGADO: 'DENEGADO'
});

app.constant('TIPOARCHIVO',{
 ARTICULO: 'articulos',
 REVISION: 'revisiones'
});
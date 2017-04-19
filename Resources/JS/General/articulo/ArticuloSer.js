"use strict";

app.service('articuloSer', function($http, $httpParamSerializerJQLike){

	this.crear = function(articulo){
		var promise = $http({
			method: "post",
			url: "PDO/Controller/CtlArticulo.php",
			data: $httpParamSerializerJQLike({
				descripcion: articulo.descripcion,
				autor: articulo.autor,
				file: articulo.file.name
			}),
			headers: {'Content-Type': 'application/x-www-form-urlencoded'}
		}).then(function mySucces(response) {
			/*Todos los datos se almacenan en .data*/
			return response.data;
		}, function myError(response) {
			alert("Error");
			alert(response.statusText);
		});

		/*Luego se retorna la promesa*/
		return promise;
	};

	this.editar = function(articulo, perfil){
		var promise = $http({
			method: "put",
			url: "PDO/Controller/CtlArticulo.php",
			params: {
				perfil: perfil,
				articulo: articulo.id,
				estado: articulo.estado,
				descripcion: articulo.descripcion,
				file: articulo.file.name
			},
			headers: {'Content-Type': 'application/x-www-form-urlencoded'}
		}).then(function mySucces(response) {
			/*Todos los datos se almacenan en .data*/
			return response.data;
		}, function myError(response) {
			alert("Error");
			alert(response.statusText);
		});

		/*Luego se retorna la promesa*/
		return promise;
	}

	this.editarPorEditor = function(articulo, perfil){
		var promise = $http({
			method: "put",
			url: "PDO/Controller/CtlArticulo.php",
			params: {
				perfil: perfil,
				articulo: articulo.id,
				estado: articulo.estado
			},
			headers: {'Content-Type': 'application/x-www-form-urlencoded'}
		}).then(function mySucces(response) {
			/*Todos los datos se almacenan en .data*/
			return response.data;
		}, function myError(response) {
			alert("Error");
			alert(response.statusText);
		});

		/*Luego se retorna la promesa*/
		return promise;
	}

	this.listar = function(tipo, id, pag){
		var promise = $http({
			method: "get",
			url: "PDO/Controller/CtlArticulo.php",
			params: {
				id: id,
				type: tipo,
				pag: pag
			},
			headers: {'Content-Type': 'application/x-www-form-urlencoded'}
		}).then(function mySucces(response) {
			/*Todos los datos se almacenan en .data*/
			return response.data;
		}, function myError(response) {
			alert("Error");
			alert(response.statusText);
		});

		/*Luego se retorna la promesa*/
		return promise;
	};

	this.buscar = function(id, tipo){
		var promise = $http({
			method: "get",
			url: "PDO/Controller/CtlArticulo.php",
			params: {
				id: id,
				type: tipo
			},
			headers: {'Content-Type': 'application/x-www-form-urlencoded'}
		}).then(function mySucces(response) {
			/*Todos los datos se almacenan en .data*/
			return response.data;
		}, function myError(response) {
			alert("Error");
			alert(response.statusText);
		});

		/*Luego se retorna la promesa*/
		return promise;	
	}

});
"use strict";

app.service('revisionSer', function ($http, $httpParamSerializerJQLike) {
	// body...
	this.crear = function(revision){
		var promise = $http({
			method: 'post',
			url: 'PDO/Controller/CtlRevision.php',
			data: $httpParamSerializerJQLike({
				articulo: revision.articulo,
				revisor: revision.revisor
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

	this.buscar = function(id, tipo){
		var promise = $http({
			method: "get",
			url: "PDO/Controller/CtlRevision.php",
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

	this.editar = function(revision){
		var promise = $http({
			method: 'put',
			url: 'PDO/Controller/CtlRevision.php',
			params: {
				id: revision.id,
				articulo: revision.articulo,
				revisor: revision.revisor,
				descripcion: revision.descripcion,
				estado: revision.estado,
				file: revision.file.name,
				type: revision.tipoForm	
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

	this.responder = function(revision){
		var promise = $http({
			method: 'put',
			url: 'PDO/Controller/CtlRevision.php',
			params: {
				id: revision.id,
				mensaje: revision.mensaje,
				type: "RESPONDER"
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

	this.listar = function(type, id, pag){
		var promise = $http({
			method: 'get',
			url: 'PDO/Controller/CtlRevision.php',
			params: {
				type: type,
				id: id,
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
	}

});
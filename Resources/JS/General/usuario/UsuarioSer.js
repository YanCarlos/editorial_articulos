"use strict";

app.service('usuarioService', function($http, $httpParamSerializerJQLike){

	this.buscar = function(email) {
		var promise = $http({
			method: "get",
			url: "PDO/Controller/CtlUsuario.php",
			params: {
				type: 'BUSCAR',
				email: email
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

	this.editar = function(usuario){
		var promise = $http({
			method: "post",
			url: "PDO/Controller/CtlUsuario.php",
			data: $httpParamSerializerJQLike({
				id: usuario.id,
				nombre: usuario.nombre,
				apellido: usuario.apellido,
				direccion: usuario.direccion,
				telefono: usuario.telefono,
				email: usuario.email,
				password: usuario.password,
				tipoUsuario: usuario.tipo_usuario_id,
				estado: usuario.estado			
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
	}

	this.eliminar = function(usuario){
		var promise = $http({
			method: "delete",
			url: "PDO/Controller/CtlUsuario.php",
			data: $httpParamSerializerJQLike({
				usuario: usuario.id		
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
	}

	this.listarUsuariosPorTipo = function(tipo,pag){
		var promise = $http({
			method: "get",
			url: "PDO/Controller/CtlUsuario.php",
			params: {
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
	}

});
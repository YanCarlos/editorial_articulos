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

});
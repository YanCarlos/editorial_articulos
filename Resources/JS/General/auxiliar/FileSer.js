"use strict";

app.service('fileSer', function(Upload){

	this.subirArchivo = function (file, ruta) {
        Upload.upload({
            url: 'PDO/Util/CargarArchivo.php',
            method: 'post',
            file: file,
            data: {                
                ruta: '/articulos/'+ruta
            }
        }).then(function (resp) {
            console.log('Success ' + resp.config.data.file.name + 'uploaded. Response: ' + resp.data);
        }, function (resp) {
            console.log('Error status: ' + resp.status);
        }, function (evt) {
            var progressPercentage = parseInt(100.0 * evt.loaded / evt.total);
            console.log('progress: ' + progressPercentage + '% ' + evt.config.data.file.name);
        });
    };

});
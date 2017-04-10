"use strict";

app.controller('CtlArticulo', function($scope, FileUploader) {

	var uploader = $scope.uploader = new FileUploader({
		
	});

	uploader.filters.push({
        name: 'archivoFilter',
        fn: function(item) {
        	if(/\/(pdf)$/.test(item.type)){        		
        		return true;
        	}else{
        		var tipo = item.name.split(".");
        		if(tipo[tipo.length-1] === "zip")
        			return true;
        	}
        	return false;
        }
    });

});
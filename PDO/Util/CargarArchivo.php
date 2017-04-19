<?php

require '../../config.php';

$filename = $_FILES['file']['name'];
$meta = $_POST;
$destination = $meta['ruta'];
$ruta = split("/", $destination);
$path = "";
for($i = 1; $i<count($ruta)-1; $i++){
	$path.="/".$ruta[$i];
}

function eliminarDir($carpeta){
    foreach(glob($carpeta . "/*") as $archivos_carpeta)
    {
        echo $archivos_carpeta;
 
        if (is_dir($archivos_carpeta))
        {
            eliminarDir($archivos_carpeta);
        }
        else
        {
            unlink($archivos_carpeta);
        }
    } 
    rmdir($carpeta);
}

if ( ! is_dir(SITE_ROOT.$path)) {
    mkdir(SITE_ROOT.$path, 0755, true);
} else {
	eliminarDir(SITE_ROOT.$path);
    mkdir(SITE_ROOT.$path, 0755, true);
}
move_uploaded_file( $_FILES['file']['tmp_name'] , SITE_ROOT.$destination );
?>
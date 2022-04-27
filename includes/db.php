<?php
error_reporting(0);
date_default_timezone_set ("America/Cancun");

$servidor = "conexia57-instance-1.cfh0agjg2td3.us-east-2.rds.amazonaws.com";
$user = "admin";
$clave = "Conexia57";
$base = "ceilor";
//$base = "ceilor_pruebas";

$db = mysqli_connect($servidor, $user, $clave, $base);

?>

















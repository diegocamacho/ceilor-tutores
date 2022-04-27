<? session_start();

if(!isset($_SESSION['s_id'])){
	exit("Su sesión ha expirado.");
}
if(!isset($_SESSION['ceilorTutores'])){
	header("Location: login.php");
}

$id_tutor=$_SESSION['s_id'];
$s_tipo=$_SESSION['s_tipo'];
$s_nombre=$_SESSION['s_nombre'];
$s_id_ciclo=$_SESSION['s_id_ciclo'];
?>

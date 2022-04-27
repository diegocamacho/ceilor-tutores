<?
include("../includes/session.php");
include("../includes/db.php");
include("../includes/funciones.php");
$id_alumno=escapar($_GET['id_alumno'],1);

$sql="SELECT * FROM alumnos_academico WHERE id_alumno = $id_alumno";
$q=mysqli_query($db,$sql);
$val=mysqli_num_rows($q);
if($val){
    $ft=mysqli_fetch_assoc($q);
    echo json_encode($ft);
}else{
    echo json_encode(array("error"=>true, "msg"=>'No se han registrado ciclos aún para este alumno'));
}

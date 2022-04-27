<?
include("../includes/session.php");
include("../includes/db.php");
include("../includes/funciones.php");
$id_tutor=escapar($_GET['id_tutor'],1);

$sql="SELECT * FROM tutores WHERE id_tutor=$id_tutor";
$q=mysqli_query($db,$sql);
$val=mysqli_num_rows($q);
if($val){
    $ft=mysqli_fetch_assoc($q);
    echo json_encode($ft);
}else{
    echo json_encode(array("error"=>true, "msg"=>'No se pudo obtener los datos del tutor, intente de nuevo más tarde.'));
}

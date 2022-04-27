<?
include("../includes/session.php");
include("../includes/db.php");
include("../includes/funciones.php");
$id_tutor=escapar($_GET['id_tutor'],1);

$sql="SELECT * FROM alumnos WHERE id_tutor=$id_tutor";
$q=mysqli_query($db,$sql);
$val=mysqli_num_rows($q);
if($val){
    $lista.="<option value='0' selected disabled>Seleccione un alumno</option>";
    while($datos=mysqli_fetch_assoc($q)):
        $lista.="<option value='".$datos["id_alumno"]."'>".$datos["apaterno"]." ".$datos["amaterno"]." ".$datos["nombre"]."</option>";
    endwhile;
    echo json_encode(array("error"=>false, "msg"=>'Good', "datos"=>$lista));
}else{
    echo json_encode(array("error"=>true, "msg"=>'No se pudo obtener los datos de los alumnos para este tutor, intente de nuevo
    más tarde.'));
}

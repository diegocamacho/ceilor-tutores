<?
include("../includes/session.php");
include("../includes/db.php");
include("../includes/funciones.php");
$id_alumno=escapar($_GET['id_alumno'],1);

$sql="SELECT alumnos.curp, alumnos_academico.id_nivel, niveles.nivel_sat, niveles.rvoe FROM alumnos
alumnos JOIN alumnos_academico alumnos_academico ON 
alumnos.id_alumno = alumnos_academico.id_alumno JOIN niveles niveles
ON alumnos_academico.id_nivel = niveles.id_nivel WHERE alumnos.id_alumno = $id_alumno";
$q=mysqli_query($db,$sql);
$val=mysqli_num_rows($q);
if($val){
    $ft=mysqli_fetch_assoc($q);
    echo json_encode($ft);
}else{
    echo json_encode(array("error"=>true, "msg"=>'No se pudieron obtener los datos del alumno, intente de nuevo más tarde.'));
}

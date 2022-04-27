<?
include("../includes/session.php");
include("../includes/db.php");
include("../includes/funciones.php");

extract($_GET);
//print_r($_GET);
//exit;

if(!$apaterno):
	$error=true;
	$msg="Escriba el apellido paterno del alumno.";
endif;

if(!$amaterno):
	$error=true;
	$msg="Escriba el apellido materno del alumno.";
endif;

if(!$nombre):
	$error=true;
	$msg="Escriba el nombre del alumno.";
endif;

if(!$genero):
	$error=true;
	$msg="Seleccione el genero del alumno.";
endif;

if(!$fecha_nacimiento):
	$error=true;
	$msg="Escriba la fecha del nacimiento del alumno.";
endif;

if($id_distrito==0):
	$error=true;
	$msg="Seleccione un distrito.";
endif;

if(!$curp):
	$error=true;
	$msg="Escriba la CURP del alumno.";
endif;

if($id_denominacion==0):
	$error=true;
	$msg="Seleccione una denominación para el alumno.";
endif;

if(!$tipo_fiscal):
	$error=true;
	$msg="Debe indicar el tipo fiscal del alumno.";
endif;

if($id_ciclo==0):
	$error=true;
	$msg="Seleccione un ciclo para el alumno.";
endif;

if(!$tutor_nombre):
	$error=true;
	$msg="Escriba un nombre para el tutor.";
endif;

if(!$tutor_telefono):
	$error=true;
	$msg="Escriba un teléfono para el tutor.";
endif;

if(!$tutor_direccion):
	$error=true;
	$msg="Escriba una dirección para el tutor.";
endif;

if($id_nivel==0):
	$error=true;
	$msg="Seleccione un nivel para el alumno.";
endif;

if($id_grado==0):
	$error=true;
	$msg="Seleccione un grado para el alumno.";
endif;

if(!$id_grupo):
	$error=true;
	$msg="Seleccione un grupo para el alumno.";
endif;

if(!$colegiatura_hide):
	$error=true;
	$msg="No se detecto la colegiatura asignada, intente nuevamente.";
endif;

if($id_descuento>0):
	if(!$motivo_descuento):
	$error=true;
	$msg="Para hacer un descuento debe escribir el motivo del descuento.";
	endif;
endif;
if($vive_con==0):
	$error=true;
	$msg="Indique con quien vive el alumno";
endif;
if(!$iglesia):
	$error=true;
	$msg="Ingrese a qué iglesia pertenece el alumno.";
endif;
if(!$padre_nombre):
	$error=true;
	$msg="Debe ingresar el nombre del padre";
endif;
if(!$padre_telefono):
	$error=true;
	$msg="Debe ingresar el telefono del padre.";
endif;
if(!$padre_ocupacion):
	$error=true;
	$msg="Debe ingresar la ocupación del padre.";
endif;
if($padre_id_denominacion==0):
	$error=true;
	$msg="Debe indicar la denominación del padre.";
endif;
if(!$padre_direccion):
	$error=true;
	$msg="Debe ingresar la dirección del padre.";
endif;
if(!$madre_nombre):
	$error=true;
	$msg="Debe ingresar el nombre de la madre.";
endif;
if(!$madre_telefono):
	$error=true;
	$msg="Debe ingresar el telefono de la madre.";
endif;
if(!$madre_ocupacion):
	$error=true;
	$msg="Debe indicar la ocupación de la madre.";
endif;
if($madre_id_denominacion==0):
	$error=true;
	$msg="Debe indicar la denominación de la madre.";
endif;
if(!$madre_direccion):
	$error=true;
	$msg="Debe ingresar la dirección de la madre.";
endif;


if($error):
	$ret['respuesta']='2';
	$ret['id_alumno']='0';
	$ret['mensaje']=$msg;
	echo json_encode($ret);
	exit();
endif;

/* LIMPIAMOS LAS VARIABLES */
$apaterno=limpiaStr($apaterno,1,1);
$amaterno=limpiaStr($amaterno,1,1);
$curp=limpiaStr($curp,1,1);
$tutor_nombre=limpiaStr($tutor_nombre,1,1);
$tutor_telefono=limpiaStr($tutor_telefono,1,1);
$tutor_direccion=limpiaStr($tutor_direccion,1,1);
$fecha_nacimiento=fechaBase3($fecha_nacimiento);
/* LIMPIAMOS LAS VARIABLES */

mysqli_query($db,'BEGIN');

if($id_tutor==0){
    $sql="INSERT INTO tutores (nombre, telefono, email, direccion, adicional_nombre, adicional_telefono, rfc, razon_social)
    VALUES ('$tutor_nombre','$tutor_telefono','$tutor_email','$tutor_direccion','$adicional_nombre','$adicional_telefono','$tutor_rfc', '$tutor_razon_social')";
    $q=mysqli_query($db,$sql) or $error=true;
    $id_tutor=mysqli_insert_id($db);
}else{
    $sql="UPDATE tutores SET nombre='$tutor_nombre', telefono='$tutor_telefono', email='$tutor_email', direccion='$tutor_direccion', adicional_nombre='$adicional_nombre', adicional_telefono='$adicional_telefono', rfc='$tutor_rfc', razon_social='$tutor_razon_social' WHERE id_tutor='$id_tutor'";
    $q=mysqli_query($db,$sql) or $error=true;
}

$sql="INSERT INTO alumnos (id_tutor,id_distrito, id_denominacion, nombre, apaterno, amaterno, fecha_nacimiento, genero, curp, fechahora_alta, vive_con, comentarios, iglesia, tipo_fiscal, activo, socio_aprobado)
VALUES ('$id_tutor','$id_distrito','$id_denominacion','$nombre','$apaterno','$amaterno','$fecha_nacimiento','$genero', '$curp', '$fechahora', '$vive_con','$comentarios', '$iglesia','$tipo_fiscal', '1','$socio_aprobado')";
$q=mysqli_query($db,$sql) or $error=true;
$id_alumno=mysqli_insert_id($db);

$sql="INSERT INTO alumnos_academico (id_alumno, id_ciclo, id_nivel, id_grado, grupo)
VALUES ('$id_alumno','$id_ciclo','$id_nivel','$id_grado','$grupo')";
$q=mysqli_query($db,$sql) or $error=true;

$sql="INSERT INTO alumnos_financiero (id_alumno, id_ciclo, inscripcion, inscripcion_descuento, inscripcion_descuento_motivo, colegiatura, colegiatura_descuento, colegiatura_descuento_motivo)
VALUES ('$id_alumno','$id_ciclo','$inscripcion','$inscripcion_id_descuento','$inscripcion_motivo_descuento','$colegiatura','$id_descuento','$motivo_descuento')";
$q=mysqli_query($db,$sql) or $error=true;

$sql="INSERT INTO alumnos_padre (padre_nombre, padre_telefono, padre_ocupacion, padre_id_denominacion, padre_direccion, id_alumno)
VALUES ('$padre_nombre','$padre_telefono','$padre_ocupacion','$padre_id_denominacion','$padre_direccion','$id_alumno')";
$q=mysqli_query($db,$sql) or $error=true;

$sql="INSERT INTO alumnos_madre (madre_nombre, madre_telefono, madre_ocupacion, madre_id_denominacion, madre_direccion, id_alumno)
VALUES ('$madre_nombre','$madre_telefono','$madre_ocupacion','$madre_id_denominacion','$madre_direccion','$id_alumno')";
$q=mysqli_query($db,$sql) or $error=true;

$sql = "SELECT * FROM niveles WHERE id_nivel = $id_nivel";
$q=mysqli_query($db,$sql);
while($datos=mysqli_fetch_object($q)):
	$nivel[] = $datos;
endwhile;
$sql = "SELECT * FROM ciclos WHERE id_ciclo = $id_ciclo";
$q=mysqli_query($db,$sql);
while($datos=mysqli_fetch_object($q)):
	$ciclo[] = $datos;
endwhile;
 $descripcion_inscripcion  = "INSCRIPCION ";

$sql = "INSERT INTO alumnos_colegiatura (id_alumno, id_ciclo, fecha, descripcion, monto, pagado, id_factura, tipo) VALUES ('$id_alumno', '$id_ciclo', '', '$descripcion_inscripcion', '$inscripcion', '0', NULL, '2')";
$q=mysqli_query($db,$sql) or $error = true;
foreach($meses as $mes):
	   $nombre_mes = fechaLetraCuatro($mes);
				$nombre_mes = limpiaStr($nombre_mes,1,1);
				$descripcion = "COLEGIATURA ".$nombre_mes;
    $sq=@mysqli_query($db,"INSERT INTO alumnos_colegiatura (id_alumno,id_ciclo,fecha, descripcion, monto, pagado, id_factura, tipo ) VALUES ('$id_alumno','$id_ciclo','$mes', '$descripcion', '$colegiatura', '0', NULL, '1')");
    if(!$sq) $error = true;

endforeach;

if($error):
    mysqli_query($db,'ROLLBACK');
    $ret['respuesta']='2';
    $ret['id_alumno']='0';
    $ret['mensaje']='Ocurrió un error al inscribir al alumno, intente más tarde por favor. [1] ';
else:
    mysqli_query($db,'COMMIT');
    $ret['respuesta']='1';
    $ret['id_alumno']=$id_alumno;
endif;

echo json_encode($ret);

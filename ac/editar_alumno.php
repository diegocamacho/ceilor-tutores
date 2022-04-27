<?
include("../includes/session.php");
include("../includes/db.php");
include("../includes/funciones.php");

extract($_GET);
//print_r($_GET);
//exit;

if(!$nombre):
	$error=true;
	$msg="Escriba el nombre del alumno.";
endif;

if(!$apaterno):
	$error=true;
	$msg="Escriba el apellido paterno del alumno.";
endif;

if(!$amaterno):
	$error=true;
	$msg="Escriba el apellido materno del alumno.";
endif;

if(!$genero):
	$error=true;
	$msg="Indique el género del alumno.";
endif;

if(!$fecha_nacimiento):
	$error=true;
	$msg="Indique la fecha de nacimiento del alumno.";
endif;


if(!$curp):
	$error=true;
	$msg="Escriba el CURP del alumno.";
endif;

if(!$id_denominacion):
	$error=true;
	$msg="Indique la denominación del alumno.";
endif;

if(!$id_distrito):
	$error=true;
	$msg="Indique el distrito del alumno.";
endif;

if(!$vive_con):
	$error=true;
	$msg="Indique con quién vive el alumno.";
endif;
if(!$iglesia):
	$error=true;
	$msg="Ingresa la iglesia del alumno.";
endif;
if($tipo_fiscal==0):
	$error=true;
	$msg="Indica el tipo fiscal del alumno.";
endif;


if($error):
	$ret['respuesta']='2';
	$ret['id_alumno']='0';
	$ret['mensaje']=$msg;
	echo json_encode($ret);
	exit();
endif;

/* LIMPIAMOS LAS VARIABLES */
$nombre=limpiaStr($nombre,1,1);
$apaterno=limpiaStr($apaterno,1,1);
$amaterno=limpiaStr($amaterno,1,1);
$genero=limpiaStr($genero,1,1);
$fecha_nacimiento=limpiaStr($fecha_nacimiento,1,1);
$curp=limpiaStr($curp,1,1);
$id_denominacion=limpiaStr($id_denominacion,1,1);
$id_distrito=limpiaStr($id_distrito,1,1);
$vive_con=limpiaStr($vive_con,1,1);
$comentarios=limpiaStr($comentarios,1,1);


/* LIMPIAMOS LAS VARIABLES */

mysqli_query($db,'BEGIN');

		$sql="UPDATE alumnos SET id_tutor = '$id_tutor', nombre='$nombre', apaterno='$apaterno', amaterno='$amaterno', genero='$genero', fecha_nacimiento='$fecha_nacimiento', curp='$curp', 
		id_denominacion='$id_denominacion', id_distrito='$id_distrito', vive_con='$vive_con', comentarios='$comentarios', iglesia='$iglesia', tipo_fiscal='$tipo_fiscal', 
		socio_aprobado='$socio_aprobado' WHERE id_alumno='$id_alumno'";
		$q=mysqli_query($db,$sql) or $error=true;

		// $sql="UPDATE alumnos_academico SET id_ciclo = '$id_ciclo', id_nivel = '$id_nivel', id_grado = '$id_grado', grupo = '$grupo' WHERE id_alumno = $id_alumno";
		// $q=mysqli_query($db,$sql) or $error=true;

		// $sql="UPDATE alumnos_financiero SET id_ciclo = '$id_ciclo', inscripcion = '$inscripcion', inscrpcion_descuento = '$inscripcion_descuento', inscripcion_descuento_motivo = '$inscripcion_descuento_motivo',
		// colegiatura = '$colegiatura', colegiatura_descuento = '$id_descuento', motivo_descuento = '$motivo_descuento' WHERE id_alumno = '$id_alumno'";
		// $q=mysqli_query($db,$sql) or $error=true;

		// $sql="UPDATE alumnos_padre SET padre_nombre = '$padre_nombre', padre_telefono = '$padre_telefono', padre_ocupacion = '$padre_ocupacion', padre_id_denominacion = '$padre_id_denominacion',
		// padre_direccion = '$padre_direccion' WHERE id_alumno = $id_alumno";
		// $q=mysqli_query($db,$sql) or $error=true;

		// $sql="UPDATE alumnos_madre SET madre_nombre = '$madre_nombre', madre_telefono = '$madre_telefono', madre_ocupacion = '$madre_ocupacion', madre_id_denominacion = '$madre_id_denominacion',
		// madre_direccion = '$madre_direccion' WHERE id_alumno = $id_alumno";
		// $q=mysqli_query($db,$sql) or $error=true;
		//$id_tutor=mysqli_insert_id($db);


if($error):
    mysqli_query($db,'ROLLBACK');
    $ret['respuesta']='2';
    $ret['id_alumno']='0';
    $ret['mensaje']='Ocurrió un error al editar al alumno, intente más tarde por favor. [1] ';
else:
    mysqli_query($db,'COMMIT');
    $ret['respuesta']='1';
    $ret['id_alumno']=$id_alumno;
endif;

echo json_encode($ret);

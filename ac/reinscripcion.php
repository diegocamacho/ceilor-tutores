<?
include("../includes/session.php");
include("../includes/db.php");
include("../includes/funciones.php");

extract($_GET);
//print_r($_GET);
//exit;
//$id_alumno=2;

if(!$id_alumno):
	$error=true;
	$msg="No se identificó el alumno.";
endif;

if(!$id_ciclo):
	$error=true;
	$msg="No se identificó el alumno.";
endif;

//Confirmamos que no este inscrito
$sql="SELECT * FROM alumnos_academico WHERE id_alumno=$id_alumno AND id_ciclo=$id_ciclo";
$q=mysqli_query($db,$sql);
$valida=mysqli_num_rows($q);

if($valida>0):
	$error=true;
	$msg="El alumno ya esta reinscrito al siguiente ciclo.";
endif;

if($error):
	$ret['respuesta']='2';
	$ret['mensaje']=$msg;
	echo json_encode($ret);
	exit();
endif;

//Validamos que no tenga adeudo anterior
$sql="SELECT DISTINCT(alumnos.id_alumno),alumnos.nombre,apaterno,amaterno,alumnos.id_tutor,tutores.telefono,tutores.email, tutores.nombre AS tutor, 
(SELECT SUM(monto) as total FROM alumnos_colegiatura WHERE id_alumno=alumnos.id_alumno AND pagado=0 AND fecha < '$fecha_actual') AS deuda,
(SELECT CONCAT('[',GROUP_CONCAT(JSON_OBJECT( 'idColegiatura',id_alumno_colegiatura,'colegiatura',descripcion,'monto', monto)),']') FROM alumnos_colegiatura WHERE id_alumno=alumnos.id_alumno AND pagado=0 AND fecha < '$fecha_actual') AS meses
FROM alumnos 
JOIN alumnos_academico ON alumnos_academico.id_alumno=alumnos.id_alumno
JOIN tutores ON tutores.id_tutor=alumnos.id_tutor 
WHERE alumnos.id_alumno=$id_alumno";
$q_deuda=mysqli_query($db,$sql);
$fft=mysqli_fetch_assoc($q_deuda);
if($fft['deuda']>0){
	$ret['respuesta']='2';
	$ret['mensaje']="No se puede reinscribir, el alumno presenta adeudo en el ciclo actual.";
	echo json_encode($ret);
	exit();
}




$sql="SELECT ciclo_activo FROM configuracion_empresa WHERE id_empresa=1";
$q=mysqli_query($db,$sql);
$ft=mysqli_fetch_assoc($q);
$cicloActivo=$ft['ciclo_activo'];

$sql="SELECT id_nivel, id_grado, socio_aprobado, grupo FROM alumnos_academico 
JOIN alumnos USING (id_alumno)
WHERE id_alumno=$id_alumno AND id_ciclo=$cicloActivo";
$q=mysqli_query($db,$sql);
$dt=mysqli_fetch_assoc($q);
$id_nivel=$dt['id_nivel'];
$id_grado=$dt['id_grado'];
$grupo=$dt['grupo'];
$aprobadoASD=$dt['socio_aprobado'];

if($id_nivel==1){
    if($id_grado<3){
        $nuevoNivel=1;
        $nuevoGrado=$id_grado+1;
    }else{
        $nuevoNivel=2;
        $nuevoGrado=1;
    }
}else if($id_nivel==2){
    if($id_grado<6){
        $nuevoNivel=2;
        $nuevoGrado=$id_grado+1;
    }else{
        $nuevoNivel=3;
        $nuevoGrado=1;
    }
}else if($id_nivel==3){
    if($id_grado<3){
        $nuevoNivel=3;
        $nuevoGrado=$id_grado+1;
    }else{
        $nuevoNivel=4;
        $nuevoGrado=1;
    }
}else if($id_nivel==4){
    if($id_grado<6){
        $nuevoNivel=4;
        $nuevoGrado=$id_grado+1;
    }else{
        $nuevoNivel=5;
        $nuevoGrado=1;
    }
}

$sql = "SELECT * FROM colegiaturas WHERE id_nivel=$nuevoNivel AND id_ciclo=$id_ciclo";
$q=mysqli_query($db,$sql);
$ct=mysqli_fetch_assoc($q);

if($aprobadoASD==1){
    $inscripcion=$ct['inscripcion_socio'];
    $colegiatura=$ct['monto_socios'];
}else{
    $inscripcion=$ct['inscripcion_base'];
    $colegiatura=$ct['monto_base'];
}

$sql = "SELECT * FROM ciclos WHERE id_ciclo=$id_ciclo";
$q=mysqli_query($db,$sql);
$xd=mysqli_fetch_assoc($q);
$nombreCiclo=$xd['ciclo'];
$inicio = new DateTime($xd['inicio']);
$inicioInscripcion=$xd['inicio'];
$fin = new DateTime($xd['final']);
$descripcionInscripcion="INSCRIPCION AL CICLO ".$nombreCiclo;


if($cupon){
	$cupon=limpiaStr($cupon,1,1);

	$sql="SELECT * FROM cupones WHERE codigo='$cupon' AND activo=1";
	$q=mysqli_query($db,$sql);
	$val=mysqli_num_rows($q);
	if($val>0){
    	$dt=mysqli_fetch_assoc($q);
    	$id_cupon=$dt['id_cupon'];
    	$codigo=$dt['codigo'];
    	$cdescuento=$dt['descuento'];
    	$usos=$dt['usos'];
        $c_id_nivel=$dt['id_nivel'];
        $tipoCupon=$dt['tipo'];
		//Válidamos fechas
		$actual = new DateTime(date("Y-m-d"));
		$cinicio = new DateTime($dt['inicia']);
		$cfin = new DateTime($dt['expira']);

		if($cinicio > $actual){
            $ret['respuesta']='2';
	        $ret['mensaje']="El cupón puede usarse a partir del ".$cinicio->format('Y-m-d');
	        echo json_encode($ret);
	        exit();
		}

		if($cfin < $actual){
            $ret['respuesta']='2';
	        $ret['mensaje']="El cupón finalizo el ".$cfin->format('Y-m-d');
			echo json_encode($ret);
			exit();
		}

		//Válidamos los usos
		$sql="SELECT * FROM alumnos_colegiatura WHERE id_cupon=$id_cupon";
		$q=mysqli_query($db,$sql);
		$Cusos=mysqli_num_rows($q);

		if($Cusos >= $usos){
            $ret['respuesta']='2';
	        $ret['mensaje']="El cupón llegó a su máximo de usos :/";
			echo json_encode($ret);
			exit();
		}

		//Tenemos que válidar tipo de cupón y nivel
	
		if($tipoCupon!=0){
			if($tipoCupon!=2){
                $ret['respuesta']='2';
	            $ret['mensaje']="El cupón no puede ser aplicado [1]";
				echo json_encode($ret);
				exit();
			}
		}
	
		if($c_id_nivel!=0){
			if($c_id_nivel!=$nuevoNivel){
                $ret['respuesta']='2';
	            $ret['mensaje']="El cupón no puede ser aplicado [2]";
				echo json_encode($ret);
				exit();
			}
		}

        //Validamos que no deba colegiaturas
        $sql="SELECT * FROM alumnos_colegiatura WHERE fecha < '$fecha_actual' AND id_alumno=$id_alumno AND pagado=0";
		$q=mysqli_query($db,$sql);
		$debe=mysqli_num_rows($q);
        if($debe){
            $ret['respuesta']='2';
	        $ret['mensaje']="El alumno no puede utilizar un cupón si tiene adeudo anterior ($debe colegiaturas vencidas).";
			echo json_encode($ret);
			exit();
		}

		//Confirmamos
		$descuentoMonto=($inscripcion*$cdescuento)/100;
		$pago=$inscripcion-$descuentoMonto;
		
		$adicional="descuento='$cdescuento', id_cupon='$id_cupon'";
		
	}else{
        $ret['respuesta']='2';
	    $ret['mensaje']="El cupón no es válido.";
	    echo json_encode($ret);
	    exit();
	}
}


//exit;
mysqli_query($db,'BEGIN');

$sql="INSERT INTO alumnos_academico (id_alumno, id_ciclo, id_nivel, id_grado, grupo)
VALUES ('$id_alumno','$id_ciclo','$nuevoNivel','$nuevoGrado','$grupo')";
$q=mysqli_query($db,$sql) or $error=true;

$sql="INSERT INTO alumnos_financiero (id_alumno, id_ciclo, inscripcion, colegiatura)
VALUES ('$id_alumno','$id_ciclo','$inscripcion','$colegiatura')";
$q=mysqli_query($db,$sql) or $error=true;

$sql = "INSERT INTO alumnos_colegiatura (id_alumno, id_ciclo, fecha, descripcion, monto, pagado, id_factura, tipo) 
VALUES ('$id_alumno', '$id_ciclo', '$fecha_actual', '$descripcionInscripcion', '$inscripcion', '0', NULL, '2')";
$q=mysqli_query($db,$sql) or $error = true;

while ($inicio <= $fin) {
    $descripcion="COLEGIATURA ".limpiaStr(fechaLetraCuatro($inicio->format('Y-m-d')),1,1);
    $mes=$inicio->format('Y-m-d');
    $inicio->modify('+ 1 month');
    $contador+=1;

    $sq=@mysqli_query($db,"INSERT INTO alumnos_colegiatura (id_alumno,id_ciclo,fecha, descripcion, monto, pagado, tipo ) VALUES ('$id_alumno','$id_ciclo','$mes', '$descripcion', '$colegiatura', '0', '1')");
    if(!$sq) $error = true;
}

if($adicional){
    $sq=@mysqli_query($db,"UPDATE alumnos_colegiatura SET $adicional WHERE id_alumno=$id_alumno AND id_ciclo=$id_ciclo AND tipo=2");
    if(!$sq) $error = true;
}

if($error):
    mysqli_query($db,'ROLLBACK');
    $ret['respuesta']='2';
    $ret['mensaje']='Ocurrió un error al reinscribir el alumno, intente más tarde por favor. [1] ';
else:
    mysqli_query($db,'COMMIT');
    $ret['respuesta']='1';
    $ret['mensaje']='Alumno reinscrito con exito';
endif;

echo json_encode($ret);
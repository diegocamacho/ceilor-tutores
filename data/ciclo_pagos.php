<?
include("../includes/session.php");
include("../includes/db.php");
include("../includes/funciones.php");
$id_alumno=$_GET['id_alumno'];
$contador=0;
$sql="SELECT * FROM alumnos_colegiatura WHERE id_alumno = $id_alumno AND pagado = 0  ORDER BY tipo DESC ";
$q=mysqli_query($db,$sql);
$val=mysqli_num_rows($q);
while($datos=mysqli_fetch_object($q)):
	$alumno_colegiaturas[] = $datos;
endwhile;

if($val){ 
    //$monto = "1600";
    foreach ($alumno_colegiaturas as $alumno_colegiatura){
        if($alumno_colegiatura->fecha == "0000-00-00") {
            $meses.="<tr><td><input type='checkbox' id='mes".strval($contador+1)."' name='meses[]' onclick='actualizarMontoColegiaturas(".$alumno_colegiatura->monto.", ".strval($contador+1).",".strval($alumno_colegiatura->id_alumno_colegiatura).",\"$alumno_colegiatura->descripcion\")' value='".$alumno_colegiatura->id_alumno_colegiatura."'></td><td>".strval($contador+1)."</td><td>".$alumno_colegiatura->descripcion."</td><td id='monto".strval($contador+1)."' style='text-align:right;'>$".$alumno_colegiatura->monto."</td></tr>";
        }else{
            $fecha = fechaLetraCuatro($alumno_colegiatura->fecha);
            $fecha = limpiaStr($fecha,1,1);
            $meses.="<tr><td><input type='checkbox' id='mes".strval($contador+1)."' name='meses[]' onclick='actualizarMontoColegiaturas(".$alumno_colegiatura->monto.", ".strval($contador+1).",".strval($alumno_colegiatura->id_alumno_colegiatura).",\"$alumno_colegiatura->descripcion\")' value='".$alumno_colegiatura->id_alumno_colegiatura."'></td><td>".strval($contador+1)."</td><td>".$alumno_colegiatura->descripcion."</td><td id='monto".strval($contador+1)."' style='text-align:right;'>$".$alumno_colegiatura->monto."</td></tr>";
        }
        
        $contador+=1;
    }
    //$tabla_inicio='<table class="table table-bordered table-hover">';
    //$tabla_final='</table>';
    //echo $tabla_inicio.$meses.$tabla_final;
    echo json_encode(array("error"=>false, "msg"=>'Good', "datos"=>"<form action='#' class='horizontal-form' id='frm_pagos'>".$meses."</form>"));
}else{
    echo json_encode(array("error"=>true, "msg"=>'No se han creado el ciclo seleccionado'));
}

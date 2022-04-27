<?
include("../includes/session.php");
include("../includes/db.php");
include("../includes/funciones.php");
$id_ciclo=escapar($_GET['id_ciclo'],1);
$id_alumno=escapar($_GET['id_alumno'],1);
$contador=0;
$sql="SELECT * FROM ciclos WHERE id_ciclo=$id_ciclo";
$q=mysqli_query($db,$sql);
$val=mysqli_num_rows($q);
$sql_colegiaturas = "SELECT * FROM alumnos_colegiatura WHERE id_alumno = $id_alumno and tipo = 1";
$q_colegiaturas=mysqli_query($db,$sql_colegiaturas);
while($datos=mysqli_fetch_object($q_colegiaturas)):
    $alumno_colegiaturas[] = $datos;
endwhile;
$contador2 = 0;
$fechas_colegiaturas = array();
foreach($alumno_colegiaturas as $alumno_colegiatura){
    $fechas_colegiaturas[$contador2] = $alumno_colegiatura->fecha;
    $contador2++;
}

if($val){
    $ft=mysqli_fetch_assoc($q);
    $inicio = new DateTime($ft['inicio']);
    $fin = new DateTime($ft['final']);
    while ($inicio <= $fin) {
        //if(gmp_prob_prime($contador)==1){ $tr_in='<tr>'; $tr_out='</tr>'; }else{ $tr_in=''; $tr_out=''; }
        //echo gmp_prob_prime($contador);
        if($contador==0){ $meses='<tr>'.$meses; }
        if($contador==4){ $meses=$meses.'</tr>'; }
        if($contador==5){ $meses='<tr>'.$meses; }
        if($contador==8){ $meses=$meses.'</tr>'; }
        if($contador==9){ $meses='<tr>'.$meses; }
        if($contador==12){ $meses=$meses.'</tr>'; }
        //if($contador>9){ $tr_in='<tr>'; $tr_out='</tr>'; }
        //if($contador==12){ $tr_in='<tr>'; $tr_out='</tr>'; }else{ unset($tr_in); unset($tr_out); }
        if(in_array($inicio->format('Y-m-d'), $fechas_colegiaturas)){
            $meses.='<td><input type="checkbox" name="meses[]"  checked="1" value="'.$inicio->format('Y-m-d').'" disabled> '.fechaLetraCuatro($inicio->format('Y-m-d')).'</td>';
        }else{
            $meses.='<td><input type="checkbox" name="meses[]"  value="'.$inicio->format('Y-m-d').'"> '.fechaLetraCuatro($inicio->format('Y-m-d')).'</td>';
        }
        $inicio->modify('+ 1 month');
        $contador+=1;
       // $meses.=$alumno_colegiaturas[$contador];
        
    }
    $tabla_inicio='<table class="table table-bordered table-hover">';
    $tabla_final='</table>';
    //echo $tabla_inicio.$meses.$tabla_final;
    echo json_encode(array("error"=>false, "msg"=>'Good', "datos"=>$tabla_inicio.$meses.$tabla_final));
}else{
    echo json_encode(array("error"=>true, "msg"=>'No se han creado el ciclo seleccionado'));
}

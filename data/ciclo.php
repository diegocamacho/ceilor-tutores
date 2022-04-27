<?
include("../includes/session.php");
include("../includes/db.php");
include("../includes/funciones.php");
$id_ciclo=escapar($_GET['id_ciclo'],1);
$contador=0;
$sql="SELECT * FROM ciclos WHERE id_ciclo=$id_ciclo";
$q=mysqli_query($db,$sql);
$val=mysqli_num_rows($q);
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
        $meses.='<td><input type="checkbox" name="meses[]" checked="1" value="'.$inicio->format('Y-m-d').'"> '.fechaLetraCuatro($inicio->format('Y-m-d')).'</td>';
        $inicio->modify('+ 1 month');
        $contador+=1;

    }
    $tabla_inicio='<table class="table table-bordered table-hover">';
    $tabla_final='</table>';
    //echo $tabla_inicio.$meses.$tabla_final;
    echo json_encode(array("error"=>false, "msg"=>'Good', "datos"=>$tabla_inicio.$meses.$tabla_final));
}else{
    echo json_encode(array("error"=>true, "msg"=>'No se han creado el ciclo seleccionado'));
}

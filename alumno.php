<?
include("../includes/session.php");
include("../includes/db.php");
include("../includes/funciones.php");
if(!$_GET['id']){?>
<script>
  window.history.back();
</script>
<?exit;}

$id_alumno = escapar($_GET['id'],1);

$sql="SELECT * FROM alumnos WHERE id_alumno=$id_alumno AND id_tutor=$id_tutor";
$q=mysqli_query($db,$sql);
$val=mysqli_num_rows($q);
if(!$val){
    $mensaje="Ocurrió un error, intente más tarde.";
    echo '<div class="page-content-wrapper"><div class="page-content"><div class="row"><div class="col-md-12"><div class="alert alert-dismissable alert-danger"><p>'.$mensaje.'</p></div></div></div></div></div>';
    exit;
}

$sql="SELECT * FROM alumnos_academico WHERE id_ciclo=$s_id_ciclo AND id_alumno=$id_alumno";
$q=mysqli_query($db,$sql);
$val=mysqli_num_rows($q);
if($val){
    $id_ciclo=$s_id_ciclo;
}else{
    $id_ciclo=$s_id_ciclo+1;
}

//Datos generales
$sq="SELECT * FROM alumnos WHERE id_alumno=$id_alumno";
$q=mysqli_query($db,$sq);
$ft=mysqli_fetch_assoc($q);

$nombre=$ft['nombre'];
$apaterno=$ft['apaterno'];
$amaterno=$ft['amaterno'];
$fecha_nacimiento=$ft['fecha_nacimiento'];
if($ft['genero']=="F"){
    $genero="FEMENINO";
}else{
    $genero="MASCULINO";
}
$curp=$ft['curp'];
$comentarios=$ft['comentarios'];
//Archivos
$cartaASD=$ft['cartaASD'];
$uploadINEMadre=$ft['uploadINEMadre'];
$uploadINEPadre=$ft['uploadINEPadre'];
$uploadCURP=$ft['uploadCURP'];
$uploadActa=$ft['uploadActa'];

//Datos del padre
$sq="SELECT * FROM alumnos_padre 
JOIN denominaciones ON denominaciones.id_denominacion=alumnos_padre.padre_id_denominacion
WHERE id_alumno=$id_alumno";
$q=mysqli_query($db,$sq);
$datosPadre=mysqli_fetch_assoc($q);

//Datos de la madre
$sq="SELECT * FROM alumnos_madre
JOIN denominaciones ON denominaciones.id_denominacion=alumnos_madre.madre_id_denominacion
WHERE id_alumno=$id_alumno";
$q=mysqli_query($db,$sq);
$datosMadre=mysqli_fetch_assoc($q);

// //Datos de la colegiatura
//     $sql="SELECT alumnos.nombre,apaterno,amaterno,nivel, id_grado,grupo,tutores.nombre as tutor, descuentos.descuento, af.colegiatura_descuento, colegiatura, porcentaje 
//     FROM alumnos
//     JOIN tutores USING (id_tutor)
//     JOIN alumnos_academico USING (id_alumno)
//     JOIN alumnos_financiero af USING (id_alumno)
//     LEFT JOIN descuentos ON af.colegiatura_descuento=descuentos.id_descuento
//     JOIN niveles USING (id_nivel)
//     WHERE id_alumno=$id_alumno AND alumnos_academico.id_ciclo=$id_ciclo AND af.id_ciclo=$id_ciclo";
//     //AND alumnos_academico.id_ciclo=$id_ciclo AND af.id_ciclo=$id_ciclo
//     $q=mysqli_query($db,$sql);
//     $ft=mysqli_fetch_assoc($q);

//     $sql = "SELECT monto,descripcion,id_alumno_colegiatura,fecha,pagado,descuento, id_ciclo FROM alumnos_colegiatura 
//     WHERE id_alumno = $id_alumno AND id_ciclo=$id_ciclo ORDER BY tipo DESC";
//     //AND id_ciclo=$id_ciclo
//     $q=mysqli_query($db,$sql);
//     while($datos=mysqli_fetch_object($q)):
//         $coles[] = $datos;
//     endwhile;
//     $totalCargos = 0;
//     $totalAbonos = 0;
//     $saldo = 0;
//     $descuentos = 0;

$sql = "SELECT * FROM alumnos_colegiatura 
WHERE id_alumno = $id_alumno AND id_ciclo=$s_id_ciclo 
ORDER BY fecha ASC, id_alumno_colegiatura ASC";
$q=mysqli_query($db,$sql);
while($datos=mysqli_fetch_object($q)):
	$colegiaturas[] = $datos;
endwhile;
$totalCargos = 0;
$totalAbonos = 0;
$saldo = 0;

//Para saber la base si es colegiatura completa
$sql="SELECT * FROM colegiaturas WHERE id_ciclo=$s_id_ciclo AND id_nivel=$id_nivel";
$qu=mysqli_query($db,$sql);
$dtt=mysqli_fetch_assoc($qu);
if($dt['socio_aprobado']==1){
	$colegiaturaBase=$dtt['monto_socios'];
	$inscripcionBase=$dtt['inscripcion_socio'];
}else{
	$colegiaturaBase=$dtt['monto_base'];
	$inscripcionBase=$dtt['inscripcion_base'];
}

$totalBecas=0;


$sql = "SELECT id_descuento,descuento FROM descuentos WHERE activo=1 AND tipo=4";
$q_desc=mysqli_query($db,$sql);
while($datos=mysqli_fetch_object($q_desc)):
	$descs[] = $datos;
endwhile;
    
?>

<div class="page-content-wrapper">
    <div class="page-content">
        <div class="row">
            <div class="col-md-12">
                <div class="portlet light bordered">
                    <div class="portlet-title tabbable-line">
                        <ul class="nav nav-tabs">
                            <li class="active">
                                <a href="#portlet_tab1"  data-toggle="tab"> Información del Alumno </a>
                            </li>
                            <li>
                                <a href="#portlet_tab2" data-toggle="tab"> Información de los Padres </a>
                            </li>
                            <li>
                                <a href="#portlet_tab3" data-toggle="tab"> Documentación </a>
                            </li>
                            <li >
                                <a href="#portlet_tab4" data-toggle="tab"> Estado de cuenta</a>
                            </li>
                        </ul>                  
                    </div>
                    <div class="portlet-body form" id="v_alumno">
                        <div class="tab-content">
                            <div class="tab-pane active" id="portlet_tab1">                            
                                <!-- BEGIN FORM-->
                                <form action="#" class="horizontal-form" id="frm_alumno">
                                    <div class="form-body">
                                    
                                        <h3 class="form-section">Información del alumno</h3>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="control-label">Apellido Paterno</label>
                                                    <input type="text" name="apaterno" class="form-control" value="<?=$apaterno?>" readonly>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="control-label">Apellido Materno </label>
                                                    <input type="text" name="amaterno" class="form-control" value="<?=$amaterno?>" readonly>
                                                </div>
                                            </div>  
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="control-label">Nombre(s)</label>
                                                    <input type="text" name="nombre" class="form-control" value="<?=$nombre?>" readonly>
                                                </div>
                                            </div>
                                          
                                        </div>
                                        
                                        <div class="row">                                                       
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="control-label">Género</label>
                                                    <input type="text" name="genero" class="form-control" value="<?=$genero?>" readonly>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="control-label">Fecha de Nacimiento</label>
                                                    <input type="text" class="form-control" name="fecha_nacimiento" placeholder="dd/mm/aaaa" value="<? if($fecha_nacimiento){ echo fechaCorta($fecha_nacimiento); }?>" readonly>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="control-label">CURP</label>
                                                    <input type="text" name="curp" class="form-control" value="<?=$curp?>" readonly>
                                                </div>
                                            </div>
                                        </div> 

                                        <div class="row">
                                            <div class="col-md-12 ">
                                                <div class="form-group">
                                                    <label>Padece alguna enfermedad o alguna capacidad o situación especial, explique</label>
                                                    <input type="text" name="comentarios" class="form-control" id="comentarios" value="<?=$comentarios?>" readonly>
                                                </div>
                                            </div>
                                        </div>  
                                               
                                    </div>
                                    <!--
                                    <div class="form-actions right">
                                        <button type="button" class="btn blue-chambray" onclick="editaAlumno();">Guardar Cambios</button>
                                    </div>
                                    -->
                                </form>
                                <!-- END FORM-->            
                            </div>
                            <div class="tab-pane" id="portlet_tab2">

                                <form action="#" class="horizontal-form" id="frm_padres">
                                    <div class="form-body">
                                        <!-- <h3 class="form-section">Información del alumno</h3>-->
                                        <div class="col-md-4 oculto">
                                                <div class="form-group">           
                                                    <input type="text" id="id_alumno2" name="id_alumno2" class="form-control" value="<?php echo $alumno[0]->id_alumno; ?>">
                                                </div>
                                            </div>
                                        <h3 class="form-section">Información del Padre</h3>                       
                                        <div class="row">

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="control-label">Nombre</label>
                                                    <input type="text" name="padre_nombre" class="form-control" maxlength="255" value="<?=$datosPadre['padre_nombre']?>" readonly>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="control-label">Teléfono</label>
                                                    <input type="text" id="padre_telefono" name="padre_telefono" class="form-control" maxlength="10" value="<?=$datosPadre['padre_telefono']?>" readonly>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="control-label">Ocupación</label>
                                                    <input type="text" id="padre_ocupacion" name="padre_ocupacion" class="form-control" value="<?=$datosPadre['padre_ocupacion']?>" readonly>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                            <div class="form-group">
                                                    <label class="control-label">Religión</label>
                                                    <input type="text" name="denominacion" class="form-control" value="<?=$datosPadre['denominacion']?>" readonly>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label">Dirección</label>
                                                    <input type="text" id="padre_direccion" name="padre_direccion" class="form-control" value="<?=$datosPadre['padre_direccion']?>" readonly>
                                                </div>
                                            </div>

                                        </div>  

                                        <h3 class="form-section">Información de la Madre</h3>                       
                                        <div class="row">

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="control-label">Nombre</label>
                                                    <input type="text" id="madre_nombre" name="madre_nombre" class="form-control" maxlength="255" value="<?=$datosMadre['madre_nombre']?>" readonly>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="control-label">Teléfono</label>
                                                    <input type="text" id="madre_telefono" name="madre_telefono" class="form-control" maxlength="10" value="<?=$datosMadre['madre_telefono']?>" readonly>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="control-label">Ocupación</label>
                                                    <input type="text" id="madre_ocupacion" name="madre_ocupacion" class="form-control" value="<?=$datosMadre['madre_ocupacion']?>" readonly>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="control-label">Religión</label>
                                                    <input type="text" id="madre_denominacion" name="madre_denominacion" class="form-control" value="<?=$datosMadre['denominacion']?>" readonly>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label">Dirección</label>
                                                    <input type="text" id="madre_direccion" name="madre_direccion" class="form-control" value="<?=$datosMadre['madre_direccion']?>" readonly>
                                                </div>
                                            </div>

                                        </div>  
                                                                       
                                    </div>
                                </form>
                                <!-- END FORM-->            
                            </div>

                            <div class="tab-pane" id="portlet_tab3">
                                                         
                                <!-- BEGIN FORM-->
                                <form action="#" class="form-horizontal" id="frm_documentos">
                                    <div class="form-body">
                                    
                                        <h3 class="form-section">Documentación del alumno</h3>
                                        <? if(!($uploadActa)&&($uploadCURP)&&($uploadINEPadre)&&($uploadINEMadre)&&($cartaASD)){ ?>
                                            <div class="note note-info">
                                                <h4 class="block">Antes de empezar:</h4>
                                                <p> Todos los documentos que adjuntara deberan ser en un formato de imagen y no mayores a 10MB de tamaño.. </p>
                                            </div>
                                        <? } ?>
                                        <div class="form-group">
                                            <label for="exampleInputFile" class="col-md-3 control-label">Acta de nacimiento</label>
                                            <div class="col-md-9">
                                                <? if($uploadActa){ ?>
                                                    <label style="padding-top:8px;" class="font-green-jungle bold"><i class="fa fa-check"></i> El archivo ya se ha cargado.</label>
                                                <? }else{ ?>
                                                    <div id="uploadActa">Seleccionar archivo</div>
                                                <? } ?>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleInputFile" class="col-md-3 control-label">CURP</label>
                                            <div class="col-md-9">
                                                <? if($uploadCURP){ ?>
                                                    <label style="padding-top:8px;" class="font-green-jungle bold"><i class="fa fa-check"></i> El archivo ya se ha cargado.</label>
                                                <? }else{ ?>
                                                    <div id="uploadCURP">Seleccionar archivo</div>
                                                <? } ?>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleInputFile" class="col-md-3 control-label">INE del padre</label>
                                            <div class="col-md-9">
                                                <? if($uploadINEPadre){ ?>
                                                    <label style="padding-top:8px;" class="font-green-jungle bold"><i class="fa fa-check"></i> El archivo ya se ha cargado.</label>
                                                <? }else{ ?>
                                                    <div id="uploadINEPadre">Seleccionar archivo</div>
                                                <? } ?>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleInputFile" class="col-md-3 control-label">INE de la madre</label>
                                            <div class="col-md-9">
                                                <? if($uploadINEMadre){ ?>
                                                    <label style="padding-top:8px;" class="font-green-jungle bold"><i class="fa fa-check"></i> El archivo ya se ha cargado.</label>
                                                <? }else{ ?>
                                                    <div id="uploadINEMadre">Seleccionar archivo</div>
                                                <? } ?>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleInputFile" class="col-md-3 control-label">Carta aprobación ASD</label>
                                            <div class="col-md-9">
                                                <? if($cartaASD){ ?>
                                                    <label style="padding-top:8px;" class="font-green-jungle bold"><i class="fa fa-check"></i> El archivo ya se ha cargado.</label>
                                                <? }else{ ?>
                                                    <div id="uploadASD">Seleccionar archivo</div>
                                                <? } ?>
                                            </div>
                                        </div>


                                    </div>
                                    
                                    <!-- <div class="form-actions right">
                                        <button type="button" class="btn blue-chambray" onclick="guardaDocumentos();">Guardar documentos</button>
                                    </div> -->
                                   
                                </form>
                                <!-- END FORM-->            
                            </div>

                            <div class="tab-pane" id="portlet_tab4">
                                <div class="form-body">
                                    <h3 class="form-section">Estado de Cuenta</h3>

                                    <table class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr class="titulos">
                                                <th width="65">FOLIO</th>
                                                <th width="95">FECHA</th>
                                                <th>DESCRIPCIÓN</th>
                                                <th width="120" align="center" style="text-align:center;">CARGO</th>
                                                <th width="120" align="center" style="text-align:center;">ABONO</th>
                                                <th width="120" align="center" style="text-align:center;">SALDO</th>
                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <? foreach($colegiaturas as $colegiatura){
                                                
                                                $saldoInicial=$colegiatura->saldoInicial;
                                                
                                                if(!$ft['colegiatura_descuento']){
                                                    if($colegiatura->descuento){
                                                        if($colegiatura->descuento=="100.00"){
                                                            if($colegiatura->tipo==2){
                                                                //exit("aca");
                                                                $cargo = $inscripcionBase;
                                                                //$ds=$inscripcionBase;
                                                            }else{
                                                                $cargo = $colegiaturaBase;
                                                                //$ds=$colegiaturaBase;
                                                            }
                                                        }else{
                                                            // $ds=calculaDescuento($colegiatura->monto,$colegiatura->descuento);
                                                            // $cargo = $colegiatura->monto+$ds;
                                                            $ds=descuento($colegiatura->monto,$colegiatura->descuento);
					                                        $cargo = $colegiatura->monto;
                                                        }
                                                    }else{
                                                        $cargo = $colegiatura->monto;
                                                    }
                                                    
                                                }else{
                                                    if($ft['porcentaje']==100){
                                                        //echo $colegiatura->id_alumno_colegiatura." aca <br>";
                                                            if($colegiatura->tipo==2){
                                                                //exit("aca");
                                                                $cargo = $inscripcionBase;
                                                                $ds=$inscripcionBase;
                                                            }elseif($colegiatura->tipo==1){
                                                                $cargo = $colegiaturaBase;
                                                                $ds=$colegiaturaBase;
                                                            }elseif($colegiatura->tipo==4){
                                                                $cargo = $colegiatura->monto;
                                                            }
                                                            $totalBecas+=$cargo;
                                                    }else{
                                                        if(($tipoDescuento==2)&&($colegiatura->tipo==2)){
                                                            //$ds=calculaDescuento($colegiatura->monto,$ft['porcentaje']);
                                                            $cargo = $colegiatura->monto;
                                                        }else{
                                                            if($colegiatura->tipo<3){
                                                                $ds=calculaDescuento($colegiatura->monto,$ft['porcentaje']);
                                                                $cargo = $colegiatura->monto+$ds;
                                                            }else{
                                                                $cargo = $colegiatura->monto;
                                                            }
                                                        }
                                                        
                                                    }
                                                    
                                                }
                                                $abono = 0;

                                                // if(($tipoDescuento==2)&&($colegiatura->tipo==2)){
                                                //     //$saldoInicial=$colegiatura->monto;
                                                //     $saldo += $colegiatura->monto;
                                                // }else{
                                                //     //$saldoInicial=$colegiatura->saldoInicial;
                                                //     $saldo += $cargo - $abono -$saldoInicial;
                                                // }

                                                $saldo += $cargo - $abono -$saldoInicial;
                                                
                                                if($ft['porcentaje']==100){
                                                    //echo "<h1>aca</h1>";
                                                    if($colegiatura->tipo==2){
                                                        $totalCargos += $inscripcionBase;
                                                    }else{
                                                        $totalCargos += $colegiaturaBase;
                                                    }
                                                }else{
                                                    if(($tipoDescuento==2)&&($colegiatura->tipo==2)){
                                                        $totalCargos += $colegiatura->monto;
                                                    }else{
                                                        if($ft['colegiatura_descuento']){
                                                            $ds=calculaDescuento($colegiatura->monto,$ft['porcentaje']);
                                                            $totalCargos += $colegiatura->monto+$ds;
                                                            $totalBecas+=$ds;
                                                        }else{
                                                            $totalCargos += $colegiatura->monto;
                                                        }
                                                    }
                                                }
                                                

                                                if($colegiatura->descuento){
                                                    $descuentos += $descuento;
                                                }
                                                
                                            ?>
                                            <? if($saldoInicial){ ?>
                                                <tr class="fondo">
                                                    <td style="padding-left:5px;"></td>
                                                    <td></td>
                                                    <td>SALDO INICIAL</td>
                                                    <td align="right"></td>
                                                    <td align="right"><?=number_format($saldoInicial, 2)?></td>
                                                    <td align="right" style="padding-right:5px; color:red;">-<?=number_format($saldoInicial, 2)?></td>
                                                    
                                                </tr>
                                            <? } ?>
                                            <tr <? if($colegiatura->tipo==4){?>class="font-red-thunderbird"<? } ?>>
                                                <td style="padding-left:5px;"><?=$colegiatura->id_alumno_colegiatura?></td>
                                                <td><?=fechaCorta($colegiatura->fecha)?></td>
                                                <td ><?=$colegiatura->descripcion?></td>
                                                <td align="right">
                                                    <? 
                                                        if(($colegiatura->tipo==1)OR($colegiatura->tipo==2)){ 
                                                            echo number_format($cargo, 2); 
                                                        }elseif($colegiatura->tipo==4){ 
                                                            echo $colegiatura->monto; 
                                                        }
                                                    ?>
                                                </td>
                                                <td></td>
                                                <td align="right" style="padding-right:5px;<? if($saldo < 0){?> color:red;<?}?>"><?=number_format($saldo, 2)?></td>
                                                
                                            </tr>
                                                <? if($ft['colegiatura_descuento']){ 
                                                        
                                                        if($colegiatura->tipo<3){
                                                            if(($tipoDescuento==2)&&($colegiatura->tipo==2)){
                                                                $saldo=$saldo;
                                                        ?>
                                                                <!-- <tr>
                                                                    <td style="padding-left:5px;"></td>
                                                                    <td></td>
                                                                    <td><?=$ft['descuento']?></td>
                                                                    <td align="right"></td>
                                                                    <td align="right"><?=number_format($ds, 2)?></td>
                                                                    <td align="right" style="padding-right:5px;<? if($saldo < 0){?> color:black;<?}?>"><?=number_format($saldo,2)?></td>
                                                                </tr> -->
                                                        <?	}else{ 
                                                                $saldo=$saldo-$ds;	
                                                        ?>
                                                                <!-- $saldo=$saldo-$ds; -->
                                                                <tr class="font-purple-seance">
                                                                    <td style="padding-left:5px;"></td>
                                                                    <td></td>
                                                                    <td><?=$ft['descuento']?></td>
                                                                    <td align="right"></td>
                                                                    <td align="right"><?=number_format($ds, 2)?></td>
                                                                    <td align="right" style="padding-right:5px;<? if($saldo < 0){?> color:black;<?}?>"><?=number_format($saldo,2)?></td>
                                                                </tr>
                                                        <?	} ?>
                                                            <!-- <tr>
                                                                <td style="padding-left:5px;"></td>
                                                                <td></td>
                                                                <td><?=$ft['descuento']?></td>
                                                                <td align="right"></td>
                                                                <td align="right"><?=number_format($ds, 2)?></td>
                                                                <td align="right" style="padding-right:5px;<? if($saldo < 0){?> color:black;<?}?>"><?=number_format($saldo,2)?></td>
                                                            </tr> -->
                                                <?  	}
                                                    }    
                                                    $sql="SELECT folio,serie,cantidad, precio,fechahora FROM venta_detalle 
                                                    JOIN ventas USING (id_venta) 
                                                    WHERE id_alumno=$id_alumno AND id_alumno_colegiatura=$colegiatura->id_alumno_colegiatura AND activo=1";
                                                    $q=mysqli_query($db,$sql);
                                                    $pagos=mysqli_num_rows($q);
                                                    
                                                    if($pagos){
                                                        if(($tipoDescuento==2)&&($colegiatura->tipo==2)){
                                                            if($colegiatura->descuento){
                                                                $descuento = descuento($cargo,$colegiatura->descuento);
                                                                $saldo=$saldo-$descuento; ?>
                                                                <tr class="font-purple-seance">
                                                                    <td style="padding-left:5px;"></td>
                                                                    <td></td>
                                                                    <td>DESCUENTO</td>
                                                                    <td align="right"></td>
                                                                    <td align="right"><?=number_format($descuento, 2)?> (<?=number_format($colegiatura->descuento,0)?>%)</td>
                                                                    <td align="right" style="padding-right:5px;<? if($saldo < 0){?> color:black;<?}?>"><?=number_format($saldo,2)?></td>
                                                                </tr>
                                                        <?	} 
                                                        }else{
                                                            if(!$ft['colegiatura_descuento']){
                                                                if($colegiatura->descuento){
                                                                    $descuento = descuento($cargo,$colegiatura->descuento);
                                                                    $saldo=$saldo-$descuento;
                                                            ?>
                                                                    <tr class="font-purple-seance">
                                                                        <td style="padding-left:5px;"></td>
                                                                        <td></td>
                                                                        <td>DESCUENTO</td>
                                                                        <td align="right"></td>
                                                                        <td align="right"><?=number_format($descuento, 2)?> (<?=number_format($colegiatura->descuento,0)?>%)</td>
                                                                        <td align="right" style="padding-right:5px;<? if($saldo < 0){?> color:black;<?}?>"><?=number_format($saldo,2)?></td>
                                                                    </tr>
                                                            <?	}
                                                            }
                                                        }	




                                                        while($dt = mysqli_fetch_assoc($q))
                                                        {
                                                            $totalAbonos += $dt['precio'];
                                                            $abono = $dt['precio'];
                                                            $saldo = $saldo - $abono;

                                                        ?>	
                                                            <tr class="font-green-seagreen">
                                                                <td style="padding-left:5px;"><?=$dt['serie']?><?=$dt['folio']?></td>
                                                                <td><?=fechaCorta(fechaSinHora($dt['fechahora']))?></td>
                                                                <td>ABONO A CUENTA</td>
                                                                <td align="right"></td>
                                                                <td align="right"><?=number_format($abono, 2)?></td>
                                                                <td align="right" style="padding-right:5px;<? if($saldo < 0){?> color:red;<?}?>"><?=number_format($saldo,2)?></td>
                                                                
                                                            </tr>
                                                            <? 
                                                        //unset($descuento);
                                                        }

                                                    }else{
                                                        // if($colegiatura->descuento=="100.00"){
                                                        //     if($colegiatura->tipo==2){
                                                        //         $descuento = $inscripcionBase;
                                                        //         $saldo=$saldo-$descuento;
                                                        //     }else{
                                                        //         $descuento = $colegiaturaBase;
                                                        //         $saldo=$saldo-$descuento;
                                                        //     }
                                                            
                                                    ?>
                                                            <!-- <tr>
                                                                <td style="padding-left:5px;"></td>
                                                                <td></td>
                                                                <td>DESCUENTO</td>
                                                                <td align="right"></td>
                                                                <td align="right"><?=number_format($descuento, 2)?> (<?=number_format($colegiatura->descuento,0)?>%)</td>
                                                                <td align="right" style="padding-right:5px;<? if($saldo < 0){?> color:black;<?}?>"><?=number_format($saldo,2)?></td>
                                                            </tr> -->
                                                    <?	//}
                                        
                                                    } 
                                                } 
                                                ?>
                                                <tr>
                                                    <td class="borde-top"></td>
                                                    <td class="borde-top"></td>
                                                    <td class="borde-top"></td>
                                                    <td class="borde-top" align="right"><b><?=number_format($totalCargos,2)?></b></td>
                                                    <td class="borde-top" align="right"><b><?=number_format($totalAbonos+$totalBecas,2)?></b></td>
                                                    <td class="borde-top" align="right" style="padding-right:5px;<? if($saldo < 0){?> color:red;<?}?>"><b><?=number_format($saldo,2)?></b></td>
                                                    
                                                </tr>
                                            </tbody>
                                    </table>












                                    
                                    <div class="form-actions right">
                                        <a role="button" class="btn green-jungle" href="?Modulo=PagosPendientes"> Hacer un pago en línea </a>&nbsp;&nbsp;&nbsp;
                                        <a role="button" class="btn red-thunderbird" href="reporte/estado_cuenta_new.php?id_alumno=<?=$id_alumno?>" target="_blank"> Descargar Estado de Cuenta</a>
                                    </div>
                                    
                                </div>
                            </div>
                    </div>    
                </div>
            </div>
        </div>
    </div>
</div>
<link href="https://hayageek.github.io/jQuery-Upload-File/4.0.11/uploadfile.css" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="https://hayageek.github.io/jQuery-Upload-File/4.0.11/jquery.uploadfile.min.js"></script>
<script>
$(function(){
    $("#uploadASD").uploadFile({
	    url:"uploader/upload.php",
        multiple:false,
        dragDrop:false,
        maxFileCount:1,
        fileName:"cartaASD",
        showAbort: false,
        showStatusAfterSuccess: true,
        showFileCounter: false,
        uploadStr: "Seleccionar archivo",
        formData: {"token":<?=$id_alumno?>},
        returnType:"json",
            onLoad:function(obj){
		        //$("#eventsmessage").html($("#eventsmessage").html()+"<br/>Widget Loaded:");
            },
            onSubmit:function(files){
	            //$("#eventsmessage").html($("#eventsmessage").html()+"<br/>Submitting:"+JSON.stringify(files));
	            //return false;
            },
            onSuccess:function(files,data,xhr,pd){
	            //$(".ajax-file-upload-container").html("<br/>Success for: "+JSON.stringify(data)).append();
                $("#uploadASD").hide();
            },
            afterUploadAll:function(obj){
            	//$("#eventsmessage").html($("#eventsmessage").html()+"Se ha cargado la carta ASD");
                //aca termina
            },
            onError: function(files,status,errMsg,pd){
	            $("#eventsmessage").html($("#eventsmessage").html()+"<br/>Error for: "+JSON.stringify(files));
            },
            onCancel:function(files,pd){
		        $("#eventsmessage").html($("#eventsmessage").html()+"<br/>Canceled  files: "+JSON.stringify(files));
            }
	});
    $("#uploadINEMadre").uploadFile({
	    url:"uploader/upload.php",
        multiple:false,
        dragDrop:false,
        maxFileCount:1,
        fileName:"uploadINEMadre",
        showAbort: false,
        showStatusAfterSuccess: true,
        showFileCounter: false,
        uploadStr: "Seleccionar archivo",
        formData: {"token":<?=$id_alumno?>},
        returnType:"json",
            onLoad:function(obj){
		        //$("#eventsmessage").html($("#eventsmessage").html()+"<br/>Widget Loaded:");
            },
            onSubmit:function(files){
	            //$("#eventsmessage").html($("#eventsmessage").html()+"<br/>Submitting:"+JSON.stringify(files));
	            //return false;
            },
            onSuccess:function(files,data,xhr,pd){
	            //$("#eventsmessage").html($("#eventsmessage").html()+"<br/>Success for: "+JSON.stringify(data));
                $("#uploadINEMadre").hide();
            },
            afterUploadAll:function(obj){
            	//$("#eventsmessage").html($("#eventsmessage").html()+"Se ha cargado la carta ASD");
                //aca termina
            },
            onError: function(files,status,errMsg,pd){
	            $("#eventsmessage").html($("#eventsmessage").html()+"<br/>Error for: "+JSON.stringify(files));
            },
            onCancel:function(files,pd){
		        $("#eventsmessage").html($("#eventsmessage").html()+"<br/>Canceled  files: "+JSON.stringify(files));
            }
	});
    $("#uploadINEPadre").uploadFile({
	    url:"uploader/upload.php",
        multiple:false,
        dragDrop:false,
        maxFileCount:1,
        fileName:"uploadINEPadre",
        showAbort: false,
        showStatusAfterSuccess: true,
        showFileCounter: false,
        uploadStr: "Seleccionar archivo",
        formData: {"token":<?=$id_alumno?>},
        returnType:"json",
            onLoad:function(obj){
		        //$("#eventsmessage").html($("#eventsmessage").html()+"<br/>Widget Loaded:");
            },
            onSubmit:function(files){
	            //$("#eventsmessage").html($("#eventsmessage").html()+"<br/>Submitting:"+JSON.stringify(files));
	            //return false;
            },
            onSuccess:function(files,data,xhr,pd){
	            //$("#eventsmessage").html($("#eventsmessage").html()+"<br/>Success for: "+JSON.stringify(data));
                $("#uploadINEPadre").hide();
            },
            afterUploadAll:function(obj){
            	//$("#eventsmessage").html($("#eventsmessage").html()+"Se ha cargado la carta ASD");
                //aca termina
            },
            onError: function(files,status,errMsg,pd){
	            $("#eventsmessage").html($("#eventsmessage").html()+"<br/>Error for: "+JSON.stringify(files));
            },
            onCancel:function(files,pd){
		        $("#eventsmessage").html($("#eventsmessage").html()+"<br/>Canceled  files: "+JSON.stringify(files));
            }
	});
    $("#uploadCURP").uploadFile({
	    url:"uploader/upload.php",
        multiple:false,
        dragDrop:false,
        maxFileCount:1,
        fileName:"uploadCURP",
        showAbort: false,
        showStatusAfterSuccess: true,
        showFileCounter: false,
        uploadStr: "Seleccionar archivo",
        formData: {"token":<?=$id_alumno?>},
        returnType:"json",
            onLoad:function(obj){
		        //$("#eventsmessage").html($("#eventsmessage").html()+"<br/>Widget Loaded:");
            },
            onSubmit:function(files){
	            //$("#eventsmessage").html($("#eventsmessage").html()+"<br/>Submitting:"+JSON.stringify(files));
	            //return false;
            },
            onSuccess:function(files,data,xhr,pd){
	            //$("#eventsmessage").html($("#eventsmessage").html()+"<br/>Success for: "+JSON.stringify(data));
                $("#uploadCURP").hide();
            },
            afterUploadAll:function(obj){
            	//$("#eventsmessage").html($("#eventsmessage").html()+"Se ha cargado la carta ASD");
                //aca termina
            },
            onError: function(files,status,errMsg,pd){
	            $("#eventsmessage").html($("#eventsmessage").html()+"<br/>Error for: "+JSON.stringify(files));
            },
            onCancel:function(files,pd){
		        $("#eventsmessage").html($("#eventsmessage").html()+"<br/>Canceled  files: "+JSON.stringify(files));
            }
	});
    $("#uploadActa").uploadFile({
	    url:"uploader/upload.php",
        multiple:false,
        dragDrop:false,
        maxFileCount:1,
        fileName:"uploadActa",
        showAbort: false,
        showStatusAfterSuccess: true,
        showFileCounter: false,
        uploadStr: "Seleccionar archivo",
        formData: {"token":<?=$id_alumno?>},
        returnType:"json",
            onLoad:function(obj){
		        //$("#eventsmessage").html($("#eventsmessage").html()+"<br/>Widget Loaded:");
            },
            onSubmit:function(files){
	            //$("#eventsmessage").html($("#eventsmessage").html()+"<br/>Submitting:"+JSON.stringify(files));
	            //return false;
            },
            onSuccess:function(files,data,xhr,pd){
	            //$("#eventsmessage").html($("#eventsmessage").html()+"<br/>Success for: "+JSON.stringify(data));
                $("#uploadActa").hide();
            },
            afterUploadAll:function(obj){
            	//$("#eventsmessage").html($("#eventsmessage").html()+"Se ha cargado la carta ASD");
                //aca termina
            },
            onError: function(files,status,errMsg,pd){
	            $("#eventsmessage").html($("#eventsmessage").html()+"<br/>Error for: "+JSON.stringify(files));
            },
            onCancel:function(files,pd){
		        $("#eventsmessage").html($("#eventsmessage").html()+"<br/>Canceled  files: "+JSON.stringify(files));
            }
	});
       dameMeses();
       var inscripcion_descuento = $('#inscripcion_id_descuento_hide').val();
       var colegiatura_descuento = $('#id_descuento_hide').val();
        $('#inscripcion_id_descuento').val(inscripcion_descuento);
        $('#id_descuento').val(colegiatura_descuento);

        if($('#id_denominacion').val()== 1){
            document.getElementById('asd_aprobacion').style.display = 'block';
            $('#socio_aprobado').val("1");
        }

        $('form').submit(function(e){
            e.preventDefault();
        });

        var val_descuento = $('#id_descuento').val();
        var inscripcion_descuento = $('#inscripcion_id_descuento').val();
        if(val_descuento != "0"){
            $('#muestra_descuento').show('fast');
            $('#motivo_descuento').focus();   
        }
        if(inscripcion_descuento != "0"){
            $('#inscripcion_muestra_descuento').show('fast');
            $('#inscripcion_motivo_descuento').focus(); 
        }
$('#id_tutor').change(function(){
    App.blockUI();
    var id_tutor = $(this).val();
    $.getJSON('data/tutor.php',{id_tutor:id_tutor},function(data) {
        if(data.error!=true){
            $('#tutor_nombre').val(data.nombre);
            $('#tutor_telefono').val(data.telefono);
            $('#tutor_email').val(data.email);
            $('#tutor_direccion').val(data.direccion);
            $('#adicional_nombre').val(data.adicional_nombre);
            $('#adicional_telefono').val(data.adicional_telefono);
            $('#tutor_rfc').val(data.rfc);
            $('#tutor_razon_social').val(data.razon_social);
        }else{
            $('.datosTutor').val("");
        }
        App.unblockUI();
    });
});

$('#id_nivel').change(function(){
    App.blockUI();
    var id_nivel = $(this).val();
    var id_ciclo = $('#id_ciclo').val();

    if(id_ciclo==0){
        App.unblockUI();
        App.alert({
            type: 'info',
            message: 'Necesita seleccionar un ciclo escolar primero',
            place: 'prepent',
            container: '#v_inscripcion',
            close: true,
            focus: true
        });
        $("#id_nivel option[value=0]").attr('selected', 'selected');
        return false;
    }
    $.getJSON('data/grados.php',{id_nivel:id_nivel},function(data) {
        if(data.error!=true){
            $('#id_grado').html(data.datos);
            dameColegiatura();
            dameGrupos();
            dameMeses();
        }else{
            App.unblockUI();
            App.alert({
                type: 'info',
                message: data.msg,
                place: 'prepent',
                container: '#v_inscripcion',
                close: true,
                focus: true
            });
            $("#id_nivel option[value=0]").attr('selected', 'selected');
            return false;
        }
        App.unblockUI();
    });
});

$('#id_grado').change(function(){
    dameGrupos();
});

$('#id_denominacion').change(function(){
    var id_denominacion = $(this).val();
            
        if(id_denominacion == 1){
            document.getElementById('asd_aprobacion').style.display = "block";
            $('#socio_aprobado').val(0);
        }else{
            document.getElementById('asd_aprobacion').style.display = "none";
        }
    dameColegiatura();
});
$('#id_descuento').change(function(){
    var descuento_id = $('#id_descuento').val(); 
    var neto = $('#colegiatura_hide').val(); 
    var descuento='';
    if(descuento_id>0){
        $.post('data/alumnosTutor.php','descuento_id='+descuento_id+'&action=getDescuento',function(data){
            data = JSON.parse(data);
            descuento = data.descuento;
            var descuento_por= parseFloat(descuento)/100;
            var monto_descontar = neto*Number(descuento_por);
            var total_descuento=parseFloat(neto)-parseFloat(monto_descontar);
            $('#colegiatura').val(total_descuento.toFixed(2));
            $('#muestra_descuento').show('fast');
            $('#motivo_descuento').focus();
        });
    }else{
        $('#colegiatura').val(neto);
        $('#muestra_descuento').hide('fast');
    }
});
$('#inscripcion_id_descuento').change(function(){
    var descuento_id = $('#inscripcion_id_descuento').val();
    var neto = $('#inscripcion_hide').val();
    var descuento='';
    if(descuento_id>0){
        $.post('data/alumnosTutor.php','descuento_id='+descuento_id+'&action=getDescuento',function(data){
            data = JSON.parse(data);
            descuento = data.descuento;
            var descuento_por= parseFloat(descuento)/100;
            var monto_descontar = neto*Number(descuento_por);
            total_descuento=parseFloat(neto)-parseFloat(monto_descontar);
            $('#inscripcion').val(total_descuento.toFixed(2));
            $('#inscripcion_muestra_descuento').show('fast');
            $('#inscripcion_motivo_descuento').focus();
        });
    }else{
        $('#inscripcion').val(neto);
        $('#inscripcion_muestra_descuento').hide('fast');
    }
});

});
function dameGrupos(){
		App.blockUI();
		var id_nivel = $('#id_nivel').val();
		var id_grado = $('#id_grado').val();
		$.getJSON('data/grupos.php',{id_nivel:id_nivel,id_grado:id_grado},function(data) {
			if(data.error!=true){
				$('#id_grupo').html(data.datos);
			}else{
				App.unblockUI();
				App.alert({
					type: 'info',
					message: data.msg,
					place: 'prepent',
					container: '#v_inscripcion',
                    close: true,
					focus: true
				});
				$("#id_nivel option[value=0]").attr('selected', 'selected');
				return false;
			}
			App.unblockUI();
		});
	}
    $('#socio_aprobado').change(function(){
			dameColegiatura();
	});
	function dameColegiatura(){
		var id_nivel = $('#id_nivel').val();
		var tipo_alumno = $('#id_denominacion').val();
        var socio_aprobado = $('#socio_aprobado').val();
		$.getJSON('data/colegiaturas.php',{id_nivel:id_nivel},function(data) {
			if(data.error!=true){
				if(tipo_alumno==1 && socio_aprobado== 1){
					$('#colegiatura').val(data.monto_socios);
					$('#colegiatura_hide').val(data.monto_socios);
					$('#inscripcion').val(data.inscripcion_socio);
					$('#inscripcion_hide').val(data.inscripcion_socio);
				}else{
					$('#colegiatura').val(data.monto_base);
					$('#colegiatura_hide').val(data.monto_base);

					$('#inscripcion').val(data.inscripcion_base);
					$('#inscripcion_hide').val(data.inscripcion_base);
				}
			}else{

			}
		});
	}
    function dameMeses(){
		var id_ciclo = $('#id_ciclo').val();
        var id_alumno = $('#id_alumno').val();
		$.getJSON('data/ciclo_edita.php',{id_ciclo:id_ciclo, id_alumno:id_alumno},function(data) {
			if(data.error!=true){
				$('#muestra_colegiaturas').html(data.datos);
			}else{
				App.unblockUI();
				App.alert({
					type: 'info',
					message: data.msg,
					place: 'prepent',
					container: '#v_inscripcion',
                    close: true,
					focus: true
				});
				$("#id_nivel option[value=0]").attr('selected', 'selected');
				return false;
			}
			App.unblockUI();
		});
	}

    function editaAlumno(){
		App.blockUI();
        var datos=$('#frm_alumno').serialize();
        $.getJSON('ac/editar_alumno.php',datos,function(data){
            if(data.respuesta==1){
                editaPadres();
            }else{
				App.unblockUI();
				App.alert({
					type: 'info',
					message: data.mensaje,
					place: 'prepent',
					container: '#v_alumno',
                    close: true,
					focus: true
				});
				return false;
            }
			App.unblockUI();
        });
    }
    function editaPadres(){
		App.blockUI();
        var datos=$('#frm_padres').serialize();
        $.getJSON('ac/editar_padres.php',datos,function(data){
			console.log(data);
            if(data.respuesta==1){
                editaInformacion();
            }else{
				App.unblockUI();
				App.alert({
					type: 'info',
					message: data.mensaje,
					place: 'prepent',
					container: '#v_alumno',
                    close: true,
					focus: true
				});
				return false;
            }
			App.unblockUI();
        });
    }
    function editaInformacion(){
		App.blockUI();
        var datos=$('#frm_informacion').serialize();
        $.getJSON('ac/editar_informacion_aca_fin.php',datos,function(data){
			console.log(data);
            if(data.respuesta==1){
                window.open("?Modulo=Alumnos", "_self");    
                App.unblockUI();
				App.alert({
					type: 'info',
					message: 'Información modificada éxitosamente',
					place: 'prepent',
					container: '#v_alumno',
                    close: true,
					focus: true
				});
				return false;
              
            }else{
				App.unblockUI();
				App.alert({
					type: 'info',
					message: data.mensaje,
					place: 'prepent',
					container: '#v_alumno',
                    close: true,
					focus: true
				});
				return false;
            }
			App.unblockUI();
        });
    }
</script>


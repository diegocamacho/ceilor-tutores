<?
if($id_tutor){
    $id = $id_tutor;
    $sql = "SELECT * FROM tutores WHERE id_tutor=$id";
    $q=mysqli_query($db,$sql);
    $ft=mysqli_fetch_assoc($q);

    // $sq="SELECT alumnos.id_alumno, nombre,apaterno,amaterno, id_nivel, id_grado, grupo FROM alumnos 
    // JOIN alumnos_academico ON alumnos_academico.id_alumno=alumnos.id_alumno
    // WHERE id_tutor=$id";
    // $qu=mysqli_query($db,$sq);
    // while($datos=mysqli_fetch_object($qu)):
    //     $alumnos[] = $datos;
    // endwhile;

    $valida_alumnos=count($alumnos);

    $titulo="PERFIL DE ".$ft['nombre'];

    $sq2="SELECT id_facturacion, folio, serie, fecha, total, receptor_rfc, receptor_rs 
    FROM facturacion 
    WHERE id_tutor=$id AND activo=1 AND cancelado=0";
    $qu2=mysqli_query($db,$sq2);
    while($datos2=mysqli_fetch_object($qu2)):
        $facturas[] = $datos2;
    endwhile;

    $valida_facturas=count($facturas);
}else{
    $titulo="NUEVO TUTOR";
}

//print_r($facturas);
?>
<div class="page-content-wrapper">
    <div class="page-content">
        <div class="row">
            <div class="col-md-12">
                <div class="portlet light bordered">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="icon-moustache font-blue-hoki"></i>
                            <span class="caption-subject font-blue-hoki bold uppercase"><?=$titulo?></span>
                        </div>
                        <div class="tools">

                        </div>
                    </div>
                    <div class="portlet-body form" id="v_inscripcion">
                        <!-- BEGIN FORM-->
                        <form action="#" class="horizontal-form" id="frm_guarda">
                            <div class="form-body">
                                <!--<h3 class="form-section">Información del tutor</h3>-->
                                <div class="row">
                                    
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">Nombre </label>
                                            <input type="text" id="nombre" name="nombre" class="form-control" maxlength="255" value="<?=$ft['nombre']?>" disabled>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">Teléfono</label>
                                            <input type="text" id="telefono" name="telefono" class="form-control" maxlength="10" value="<?=$ft['telefono']?>" disabled>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">Email</label>
                                            <input type="text" id="email" name="email" class="form-control" maxlength="128" value="<?=strtolower($ft['email'])?>" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">Dirección</label>
                                            <input type="text" id="direccion" name="direccion" class="form-control" value="<?=$ft['direccion']?>" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">Nombre adicional</label>
                                            <input type="text" id="nombre_adicional" name="nombre_adicional" maxlength="255" class="form-control" value="<?=$ft['adicional_nombre']?>" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">Telefóno adicional</label>
                                            <input type="text" id="telefono_adicional" name="telefono_adicional" maxlength="10" class="form-control" value="<?=$ft['adicional_telefono']?>" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">RFC</label>
                                            <input type="text" id="rfc" name="rfc" class="form-control" maxlength="20" value="<?=$ft['rfc']?>" disabled>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">Razón Social</label>
                                            <input type="text" id="razon_social" name="razon_social" class="form-control" maxlength="255" value="<?=$ft['razon_social']?>" disabled>
                                        </div>
                                    </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <!-- <label class="control-label">Nueva contraseña</label>
                                        <input type="text" id="contrasena" name="contrasena" class="form-control" maxlength="16" > -->
                                        <label class="control-label">Cambio de contraseña</label>
                                        <div class="input-group">
                                            <input type="password" id="contrasena" name="contrasena" class="form-control" maxlength="16" placeholder="Escriba una nueva contraseña">
                                            <div class="input-group-btn">
                                            <button class="btn btn-info" type="buttom" onclick="cambiaContrasena()">
                                                Cambiar
                                            </button>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                            <? if($valida_alumnos){ ?>
                            <!-- <h3 class="form-section">Alumnos Asignados</h3>
                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table table-hover table-light">
                                        <thead>
                                            <tr>
                                                <th> Matrícula </th>
                                                <th> Nombre </th>
                                                <th> Nivel </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <? foreach($alumnos as $alumno){ ?>
                                            <tr>
                                                <td width="80" ><?=$alumno->id_alumno?></td>
                                                <td> <?=$alumno->apaterno?> <?=$alumno->amaterno?> <?=$alumno->nombre?></td>
                                                <td> <?=dameNivel($alumno->id_nivel)?> <?=dameGrado($alumno->id_grado)?> <?=$alumno->grupo?> </td>    
                                            </tr>
                                            <? } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div> -->
                            <? } ?>

                            <? if($valida_facturas){ ?>
                            <h3 class="form-section">Facturas</h3>
                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table table-hover table-light">
                                        <thead>
                                            <tr>
                                                <th> Folio </th>
                                                <th> Fecha </th>
                                                <th> Receptor </th>
                                                <th> Total </th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <? foreach($facturas as $factura){ ?>
                                            <tr>
                                                <td width="120"> <?=$factura->serie?> <?=$factura->folio?> </td>
                                                <td  ><?=devuelveFechaHora($factura->fecha)?></td>
                                                <td> <?=$factura->receptor_rs?> (<?=$factura->receptor_rfc?>) </td>
                                                <td width="120"> <?=number_format($factura->total,2)?></td>
                                                <td align="right">
                                                    <a role="button" class="btn btn-xs btn-default btn-sm" href="formatos/PDF-3-3/factura_33_html.php?id=<?=$factura->id_facturacion?>" data-target="#verPago" data-toggle="modal" class="btn btn-info btn-xs">Ver Factura</a>
                                                </td>
                                            </tr>
                                            <? } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <? } ?>

                            <!-- <div class="form-actions right">
                                <button type="button" class="btn blue" onclick="editaTutor();"> Guardar Cambios</button>
                            </div> -->
                        </form>
                        <!-- END FORM-->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(function(){

    $('form').submit(function(e){
        e.preventDefault();
    });



});

function cambiaContrasena(){
    App.blockUI();
    var datos=$('#frm_guarda').serialize();
    // alert(datos);
    $.getJSON('ac/editar_tutor.php',datos,function(data){
        //console.log(data);
        if(data.respuesta==1){
            //window.open("?Modulo=Tutores&id="+data.id_tutor, "_self");
            App.unblockUI();
            App.alert({
					type: 'success',
					message: 'Se ha actualizado la contraseña',
					place: 'prepent',
					container: '#v_inscripcion',
                    close: false,
					focus: true
				});
        }else{
            App.unblockUI();
            App.alert({
                type: 'info',
                message: data.mensaje,
                place: 'prepent',
                container: '#v_inscripcion',
                close: true,
                focus: true
            });
            return false;
        }
        App.unblockUI();
    });
}

// function enviarFactura(id){
// 	swal({
// 		title: "Reenviar factura",
// 		text: "¿Desea reenviar la factura al tutor?",
// 		type: "info",
// 		confirmButtonText: "Si, reenviar",
// 		cancelButtonText: "No",
// 		showCancelButton: true,
// 		closeOnConfirm: false,
// 		showLoaderOnConfirm: true,
// 		animation: "slide-from-top"
// 	},function(){
// 		$.post('data/enviaFactura.php',{action:'enviar', id_facturacion:id},function(data){
// 			data = JSON.parse(data);
// 			if(!data.error){
// 				swal("Confirmación", data.mensaje, "success");
// 				//window.open('?Modulo=Facturas', "_self");
// 			}else {
// 				$('#msg_error').html(data.mensaje);
// 				$('#msg_error').show('Fast');
// 			}
// 		});
// 	});

// }
  

</script>

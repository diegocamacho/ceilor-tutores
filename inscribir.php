<?php

$sql="SELECT id_ciclo, ciclo FROM ciclos WHERE abierto = 1";
$q=mysqli_query($db,$sql);
$validaCicloAbierto=mysqli_num_rows($q);
if($validaCicloAbierto){
	$ft=mysqli_fetch_assoc($q);
	$id_ciclo_abierto=$ft['id_ciclo'];
	$ciclo_abierto=$ft['ciclo'];
}

$sql="SELECT ciclo_activo, ciclo FROM configuracion_empresa
JOIN ciclos ON ciclos.id_ciclo=configuracion_empresa.ciclo_activo";
$q=mysqli_query($db,$sql);
$ft=mysqli_fetch_assoc($q);
$id_ciclo_activo=$ft['ciclo_activo'];
$ciclo_activo=$ft['ciclo'];


$sql="SELECT * FROM distritos WHERE activo = 1";
$q_distritos=mysqli_query($db,$sql);
while($datos=mysqli_fetch_object($q_distritos)):
	$distritos[] = $datos;
endwhile;

$sql="SELECT DISTINCT * FROM niveles";
$q_niveles=mysqli_query($db,$sql);
while($datos=mysqli_fetch_object($q_niveles)):
	$niveles2[] = $datos;
endwhile;

$sql="SELECT * FROM descuentos WHERE activo=1";
$q_descuentos=mysqli_query($db,$sql);
while($datos=mysqli_fetch_object($q_descuentos)):
	$descuentos[] = $datos;
endwhile;

$sql="SELECT * FROM denominaciones WHERE activo = 1";
$q_denominaciones=mysqli_query($db,$sql);
while($datos=mysqli_fetch_object($q_denominaciones)):
	$denominaciones[] = $datos;
endwhile;

$sql="SELECT * FROM tutores";
$q_tutores=mysqli_query($db,$sql);
while($datos=mysqli_fetch_object($q_tutores)):
	$tutores[] = $datos;
endwhile;
?>

<div class="page-content-wrapper">
    <div class="page-content">
        <div class="row">
            <div class="col-md-12">
                <div class="portlet light bordered">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="icon-user-following font-blue-hoki"></i>
                            <span class="caption-subject font-blue-hoki bold uppercase">Nueva Inscripción</span>
                        </div>
                        <div class="tools">

                        </div>
                    </div>
                    <div class="portlet-body form" id="v_inscripcion">
                        <!-- BEGIN FORM-->
                        <form action="#" class="horizontal-form" id="frm_guarda">
                            <div class="form-body" style="margin: 10px;">
                                <h3 class="form-section">Información del alumno</h3>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">Apellido Paterno</label>
                                            <input type="text" id="apaterno" name="apaterno" class="form-control" autocomplete="off">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">Apellido Materno</label>
                                            <input type="text" id="amaterno" name="amaterno" class="form-control" autocomplete="off">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">Nombre(s)</label>
                                            <input type="text" id="nombre" name="nombre" class="form-control" autocomplete="off">
                                        </div>
                                    </div>

                                </div>
                                <!--/row-->
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">Género</label>
                                            <select class="form-control" name="genero" id="genero">
                                                <option value="0" selected disabled>Seleccione</option>
                                                <option value="M">Masculino</option>
                                                <option value="F">Femenino</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">Fecha de Nacimiento</label>
                                            <input type="text" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" autocomplete="off">
                                            <!-- <input type="text" class="form-control" name="fecha_nacimiento" placeholder="dd/mm/aaaa"> -->
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">CURP</label>
                                            <input type="text" id="curp" name="curp" class="form-control" autocomplete="off">
                                        </div>
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">Religión</label>
                                            <select class="form-control" name="id_denominacion" id="id_denominacion">
                                                <option value="0" selected disabled>Seleccione</option>
                                                <? foreach($denominaciones as $denominacion){ ?>
                                                    <option value="<?=$denominacion->id_denominacion?>"><?=$denominacion->denominacion?></option>
                                                <? } ?>
                                            </select>
                                        </div>
                                    </div>

                                    
                                    <div class="col-md-4 asd_aprobacion" style="display:none;">
                                        <div class="form-group">
                                            <label class="control-label">Distrito</label>
                                            <select class="form-control" name="id_distrito" id="id_distrito">
                                                <option value="0" selected disabled>Seleccione</option>
                                                <? foreach($distritos as $distrito){ ?>
                                                    <option value="<?=$distrito->id_distrito?>"><?=$distrito->distrito?></option>
                                                <? } ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4 asd_aprobacion" style="display:none;">
                                        <div class="form-group">
                                            <label class="control-label">Iglesia</label>
                                            <input type="text" id="iglesia" name="iglesia" class="form-control" autocomplete="off">
                                        </div>
                                    </div>
                                    

                                </div>
                                
                                    

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">Vive Con</label>
                                            <select class="form-control" name="vive_con" id="vive_con">
                                                <option value="0" selected disabled>Seleccione</option>
                                                <option value="1">Ambos Padres</option>
                                                <option value="2">Solo con la Madre</option>
                                                <option value="3">Solo con el Padre</option>
                                                <option value="4">Otro</option>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label>¿Padece alguna enfermedad o alguna capacidad o situación especial?</label>
                                            <input type="text" name="comentarios" class="form-control datosTutor" id="comentarios" autocomplete="off">
                                        </div>
                                    </div>

                                </div>

                                
                                <hr style="margin-top:20px;">
                                <h3 class="form-section">Información del padre</h3>
                                <div class="row">

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="control-label">Nombre</label>
                                            <input type="text" id="padre_nombre" name="padre_nombre" class="form-control" maxlength="255" autocomplete="off">
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="control-label">Teléfono</label>
                                            <input type="text" id="padre_telefono" name="padre_telefono" class="form-control" maxlength="10" autocomplete="off">
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="control-label">Ocupación</label>
                                            <input type="text" id="padre_ocupacion" name="padre_ocupacion" class="form-control" autocomplete="off">
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="control-label">Religión</label>
                                            <select class="form-control" name="padre_id_denominacion">
                                                <option value="0" selected disabled>Seleccione</option>
                                                <? foreach($denominaciones as $denominacion){ ?>
                                                    <option value="<?=$denominacion->id_denominacion?>"><?=$denominacion->denominacion?></option>
                                                <? } ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label">Dirección</label>
                                            <input type="text" id="padre_direccion" name="padre_direccion" class="form-control" autocomplete="off">
                                        </div>
                                    </div>

                                </div>

                                <hr style="margin-top:20px;">
                                <h3 class="form-section">Información de la madre</h3>
                                <div class="row">

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="control-label">Nombre</label>
                                            <input type="text" id="madre_nombre" name="madre_nombre" class="form-control" maxlength="255" autocomplete="off">
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="control-label">Teléfono</label>
                                            <input type="text" id="madre_telefono" name="madre_telefono" class="form-control" maxlength="10" autocomplete="off">
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="control-label">Ocupación</label>
                                            <input type="text" id="madre_ocupacion" name="madre_ocupacion" class="form-control" autocomplete="off">
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="control-label">Religión</label>
                                            <select class="form-control" name="madre_id_denominacion">
                                                <option value="0" selected disabled>Seleccione</option>
                                                <? foreach($denominaciones as $denominacion){ ?>
                                                    <option value="<?=$denominacion->id_denominacion?>"><?=$denominacion->denominacion?></option>
                                                <? } ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label">Dirección</label>
                                            <input type="text" id="madre_direccion" name="madre_direccion" class="form-control" autocomplete="off">
                                        </div>
                                    </div>

                                </div>
                                
                                <hr style="margin-top:20px;">
                                <h3 class="form-section">Información académica y financiera</h3>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">Seleccione el ciclo</label>
                                            <select class="form-control" name="id_ciclo" id="id_ciclo">
                                                <option value="0" selected disabled>Seleccione</option>
                                                <? if($id_ciclo_abierto){ ?>
                                                    <option value="<?=$id_ciclo_abierto?>">Ciclo <?=$ciclo_abierto?> (por inciar)</option>
                                                <? } ?>
                                                <option value="<?=$id_ciclo_activo?>">Ciclo <?=$ciclo_activo?> (actual)</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">Nivel</label>
                                            <select class="form-control" id="id_nivel" name="id_nivel">
                                                <option value="0" selected disabled>Seleccione</option>
                                                <? foreach($niveles2 as $nivel){ ?>
                                                <option value="<?=$nivel->id_nivel?>"><?=$nivel->nivel?></option>
                                                <? } ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">Grado</label>
                                            <select class="form-control" id="id_grado" name="id_grado">
                                                <option value="0" selected disabled>Seleccione Nivel</option>
                                            </select>
                                        </div>
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Pago de colegiatura</label>
                                            <input type="text" name="colegiatura" id="colegiatura" class="form-control" readonly>
                                            <input type="hidden" name="colegiatura_hide" id="colegiatura_hide" class="form-control">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Pago de inscripción</label>
                                            <input type="text" name="inscripcion" id="inscripcion" class="form-control" readonly>
                                            <input type="hidden" name="inscripciona_hide" id="inscripcion_hide" class="form-control">
                                        </div>
                                    </div>

                                    <!-- <div class="col-md-4">
                                        <div class="form-group">
                                            <label>¿Tienes un código de invitación?</label>
                                            <input type="text" name="codigo_invitacion" class="form-control is-valid" maxlength="20" autocomplete="off">
                                        </div>
                                    </div> -->

                                    <!-- <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Cuéntanos cómo supiste de nosotros</label>
                                            <input type="text" class="form-control datosTutor" name="origen" autocomplete="off">
                                            <small class="form-text text-muted">Este campo es opcional pero nos ayudarías mucho si lo utilizas :)</small>
                                        </div>
                                    </div> -->

                                    <div class="col-md-12">
                                        <div class="alert alert-info" role="alert">Si tiene algún cupón de descuento lo podrá aplicar al momento del pago en <b>caja o en línea</b></div>
                                        <div class="alert alert-danger" role="alert" id="msg-error" style="display:none;">Ocurrió un error</div>
                                    </div>

                                </div>

                            </div>

                            <div class="form-group row">
                                <div class="col-sm-12 text-right" style="margin-top:20px;">
                                    <!-- <a href="?Modulo=Inscripciones" role="button" class="btn btn-default" >Cancelar</a>&nbsp;&nbsp;&nbsp;&nbsp; -->
                                    <a href="#" role="button" class="btn blue-chambray" onclick="inscribeAlumno();"> Inscribir alumno </a>
                                </div>
                            </div>

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

$('#fecha_nacimiento').datepicker({
    format: "dd/mm/yyyy",
    language: "es",
    autoclose: true
});

$('form').submit(function(e){
    e.preventDefault();
});

$('#id_nivel').change(function(){

    var id_nivel = $(this).val();
    var id_ciclo = $('#id_ciclo').val();

    if(id_ciclo==0){
        alert('Necesita seleccionar un ciclo escolar primero');
        $("#id_nivel option[value=0]").attr('selected', 'selected');
        return false;
    }
    $.getJSON('data/grados.php',{id_nivel:id_nivel},function(data) {
        console.log(data);
        if(data.error!=true){
            $('#id_grado').html(data.datos);
            dameColegiatura();
            // dameGrupos();
            // dameMeses();
        }else{
            alert(data.msg);
            $("#id_nivel option[value=0]").attr('selected', 'selected');
            return false;
        }

    });
});

// $('#id_grado').change(function(){
// 	dameGrupos();
// });

$('#id_denominacion').change(function(){
    var id_denominacion = $(this).val();
    
    if(id_denominacion == "1"){
        $('.asd_aprobacion').show('fast');
    }else{
        $('.asd_aprobacion').hide('fast');
        document.getElementById('socio_aprobado').value ='0';
    }
    //dameColegiatura();
});

$('#id_ciclo').change(function(){		
    dameColegiatura();
});

});

// function dameGrupos(){
// 	var id_nivel = $('#id_nivel').val();
// 	var id_grado = $('#id_grado').val();
// 	$.getJSON('data/grupos.php',{id_nivel:id_nivel,id_grado:id_grado},function(data) {
// 		console.log(data);
// 		if(data.error!=true){
// 			$('#id_grupo').html(data.datos);
// 		}else{
// 			App.unblockUI();
// 			App.alert({
// 				type: 'info',
// 				message: data.msg,
// 				place: 'prepent',
// 				container: '#v_inscripcion',
// 				close: true,
// 				focus: true
// 			});
// 			$("#id_nivel option[value=0]").attr('selected', 'selected');
// 			return false;
// 		}
// 		App.unblockUI();
// 	});
// }


function dameColegiatura(){
var id_ciclo = $('#id_ciclo').val();
var id_nivel = $('#id_nivel').val();
var tipo_alumno = $('#id_denominacion').val();
var socio_aprobado = $('#socio_aprobado').val();
$.getJSON('data/colegiaturas.php',{id_nivel:id_nivel,id_ciclo:id_ciclo},function(data) {
    console.log(data);
    if(data.error!=true){
        $('#colegiatura').val(data.monto_base);
        $('#colegiatura_hide').val(data.monto_base);
        $('#inscripcion').val(data.inscripcion_base);
        $('#inscripcion_hide').val(data.inscripcion_base);
    }else{

    }
});
}

// function dameMeses(){
// var id_ciclo = $('#id_ciclo').val();
// $.getJSON('data/ciclo.php',{id_ciclo:id_ciclo},function(data) {
// 	console.log(data);
// 	if(data.error!=true){
// 		$('#muestra_meses').html(data.datos);
// 	}else{
// 		App.unblockUI();
// 		App.alert({
// 			type: 'info',
// 			message: data.msg,
// 			place: 'prepent',
// 			container: '#v_inscripcion',
// 			close: true,
// 			focus: true
// 		});
// 		$("#id_nivel option[value=0]").attr('selected', 'selected');
// 		return false;
// 	}
// 	App.unblockUI();
// });
// }
function inscribeAlumno(){
$.blockUI({ 
    message: '<img src="loader.gif" /><br>Estamos creando su registro...',
    overlayCSS: { 
        backgroundColor: '#fff',
        opacity: 1, 
        cursor: 'wait' 
    },
    css: { 
        backgroundColor: '#fff', 
        color: '#333', 
        border: 'none'
    }
});
var datos=$('#frm_guarda').serialize();
$.getJSON('ac/inscribe_alumno.php',datos,function(data){
    console.log(data);
    if(data.respuesta==1){
        window.open("?Modulo=Alumnos", "_self");
    }else{
        $('#msg-error').text(data.mensaje).show('fast');
        $.unblockUI();
    }
});
}
</script>

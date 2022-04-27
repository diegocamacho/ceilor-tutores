<?php
$sql="SELECT * FROM distritos WHERE activo = 1";
$q_distritos=mysqli_query($db,$sql);
while($datos=mysqli_fetch_object($q_distritos)):
	$distritos[] = $datos;
endwhile;

$sql="SELECT * FROM niveles";
$q_niveles=mysqli_query($db,$sql);
while($datos=mysqli_fetch_object($q_niveles)):
	$niveles[] = $datos;
endwhile;

$sql="SELECT * FROM descuentos WHERE activo=1";
$q_descuentos=mysqli_query($db,$sql);
while($datos=mysqli_fetch_object($q_descuentos)):
	$descuentos[] = $datos;
endwhile;

$sql="SELECT id_ciclo,ciclo FROM ciclos";
$q_ciclos=mysqli_query($db,$sql);
while($datos=mysqli_fetch_object($q_ciclos)):
	$ciclos[] = $datos;
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
                            <div class="form-body">
                                <h3 class="form-section">Información del Alumno</h3>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">Apellido Paterno</label>
                                            <input type="text" id="apaterno" name="apaterno" class="form-control">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">Apellido Materno</label>
                                            <input type="text" id="amaterno" name="amaterno" class="form-control">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">Nombre(s)</label>
                                            <input type="text" id="nombre" name="nombre" class="form-control">
                                        </div>
                                    </div>

                                </div>
                                <!--/row-->
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">Genero</label>
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
                                            <input type="text" class="form-control" name="fecha_nacimiento" placeholder="dd/mm/aaaa">
                                        </div>
                                    </div>

									<div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">CURP</label>
                                            <input type="text" id="curp" name="curp" class="form-control">
                                        </div>
                                    </div>

                                </div>

								<div class="row">
									<div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">Denominación</label>
                                            <select class="form-control" name="id_denominacion" id="id_denominacion">
												<option value="0" selected disabled>Seleccione</option>
                                                <? foreach($denominaciones as $denominacion){ ?>
                                                    <option value="<?=$denominacion->id_denominacion?>"><?=$denominacion->denominacion?></option>
                                                <? } ?>
                                            </select>
                                        </div>
                                    </div>

									<div class="col-md-4">
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

									<div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">Iglesia</label>
                                            <input type="text" id="iglesia" name="iglesia" class="form-control">
                                        </div>
                                    </div>

                                </div>
                                <div class="row" id="asd_aprobacion" style="display:none;">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">Aprobado</label>
                                            <select class="form-control" name="socio_aprobado" id="socio_aprobado">
												<option value="0" selected="selected">No</option>
                                                <option value="1" >Sí</option>   
                                            </select>
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

									<div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">Tipo Físcal</label>
                                            <select class="form-control" name="tipo_fiscal" id="tipo_fiscal">
												<option value="0" selected disabled>Seleccione</option>
												<option value="1">No Fiscal</option>
                                                <option value="2">Físcal</option>
                                            </select>
                                        </div>
                                    </div>

									<div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">Ciclo Escolar</label>
                                            <select class="form-control" name="id_ciclo" id="id_ciclo">
												<option value="0" selected disabled>Seleccione</option>
                                                <? foreach($ciclos as $ciclo){ ?>
                                                    <option value="<?=$ciclo->id_ciclo?>"><?=$ciclo->ciclo?></option>
                                                <? } ?>
                                            </select>
                                        </div>
                                    </div>

                                </div>

								<div class="row">
									<div class="col-md-12 ">
                                        <div class="form-group">
                                            <label>Padece alguna enfermedad o alguna capacidad o situación especial, explique</label>
                                            <input type="text" name="comentarios" class="form-control datosTutor" id="comentarios">
										</div>
                                    </div>
                                </div>

								<h3 class="form-section">Información del Padre</h3>
								<div class="row">

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="control-label">Nombre</label>
                                            <input type="text" id="padre_nombre" name="padre_nombre" class="form-control" maxlength="255">
                                        </div>
                                    </div>

									<div class="col-md-3">
                                        <div class="form-group">
                                            <label class="control-label">Teléfono</label>
                                            <input type="text" id="padre_telefono" name="padre_telefono" class="form-control" maxlength="10">
                                        </div>
                                    </div>

									<div class="col-md-3">
                                        <div class="form-group">
                                            <label class="control-label">Ocupación</label>
                                            <input type="text" id="padre_ocupacion" name="padre_ocupacion" class="form-control">
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
                                            <input type="text" id="padre_direccion" name="padre_direccion" class="form-control">
                                        </div>
                                    </div>

                                </div>


								<h3 class="form-section">Información de la Madre</h3>
								<div class="row">

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="control-label">Nombre</label>
                                            <input type="text" id="madre_nombre" name="madre_nombre" class="form-control" maxlength="255">
                                        </div>
                                    </div>

									<div class="col-md-3">
                                        <div class="form-group">
                                            <label class="control-label">Teléfono</label>
                                            <input type="text" id="madre_telefono" name="madre_telefono" class="form-control" maxlength="10">
                                        </div>
                                    </div>

									<div class="col-md-3">
                                        <div class="form-group">
                                            <label class="control-label">Ocupación</label>
                                            <input type="text" id="madre_ocupacion" name="madre_ocupacion" class="form-control">
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
                                            <input type="text" id="madre_direccion" name="madre_direccion" class="form-control">
                                        </div>
                                    </div>

                                </div>


                                <h3 class="form-section">Tutor</h3>
								<div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group has-success">
                                            <label class="control-label">Seleccione un tutor existente</label>
											<select class="form-control select2" name="id_tutor" id="id_tutor">
												<option value="0">Nuevo Tutor</option>
                                                <? foreach($tutores as $tutor){ ?>
                                                    <option value="<?=$tutor->id_tutor?>"><?=$tutor->nombre?></option>
                                                <? } ?>
                                            </select>
                                        </div>
                                    </div>
								</div>


								<div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">Nombre</label>
                                            <input type="text" id="tutor_nombre" name="tutor_nombre" class="form-control datosTutor">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">Teléfono</label>
                                            <input type="text" id="tutor_telefono" name="tutor_telefono" class="form-control datosTutor">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">Email</label>
                                            <input type="text" id="tutor_email" name="tutor_email" class="form-control datosTutor">
                                        </div>
                                    </div>

									<div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">Situación de los Padres</label>
											<select class="form-control" name="vive_con" id="vive_con">
												<option value="0" selected disabled>Seleccione</option>
												<option value="1">Casados</option>
                                                <option value="2">Separados</option>
												<option value="3">Divorciados</option>
												<option value="4">Otra situación</option>
                                            </select>
                                        </div>
                                    </div>

									<div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">Parentesco </label>
                                            <input type="text" id="tutor_parentesco" name="tutor_parentesco" class="form-control datosTutor">
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-md-12 ">
                                        <div class="form-group">
                                            <label>Dirección</label>
                                            <input type="text" name="tutor_direccion" class="form-control datosTutor" id="tutor_direccion">
										</div>
                                    </div>
                                </div>


								<h3 class="form-section">Información Físcal</h3>
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label>Razón Social o Nombre</label>
                                            <input type="text" class="form-control datosTutor" name="tutor_razon_social" id="tutor_razon_social">
										</div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>RFC</label>
                                            <input type="text" class="form-control datosTutor" name="tutor_rfc" id="tutor_rfc">
                                        </div>
                                    </div>

                                </div>

								<h3 class="form-section">Información Académica y Financiera</h3>

								<div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">Nivel</label>
                                            <select class="form-control" id="id_nivel" name="id_nivel">
                                                <option value="0" selected disabled>Seleccione</option>
												<? foreach($niveles as $nivel){ ?>
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

									<div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">Grupo</label>
                                            <select class="form-control" id="id_grupo" name="id_grupo">
												<option value="0" selected disabled>Seleccione</option>
                                            </select>
                                        </div>
                                    </div>

                                </div>

								<div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Colegiatura</label>
                                            <input type="text" name="colegiatura" id="colegiatura" class="form-control" readonly>
											<input type="hidden" name="colegiatura_hide" id="colegiatura_hide" class="form-control">
										</div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Descuento</label>
											<select class="form-control" id="id_descuento" name="id_descuento">
												<option value="0">Sin Descuento</option>
                                                <? foreach($descuentos as $descuento){ ?>
                                                    <option value="<?=number_format($descuento->id_descuento,0)?>"><?=number_format($descuento->porcentaje)." %"?></option>
                                                <? } ?>
                                            </select>
                                        </div>
                                    </div>

									<div class="col-md-4">
                                        <div class="form-group" id="muestra_descuento" style="display:none;">
                                            <label>Motivo de Descuento</label>
                                            <input type="text" class="form-control" name="motivo_descuento" id="motivo_descuento">
                                        </div>
                                    </div>

                                </div>

								<div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Inscripción</label>
                                            <input type="text" name="inscripcion" id="inscripcion" class="form-control" readonly>
											<input type="hidden" name="inscripciona_hide" id="inscripcion_hide" class="form-control">
										</div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Descuento</label>
											<select class="form-control" id="inscripcion_id_descuento" name="inscripcion_id_descuento">
												<option value="0">Sin Descuento</option>
                                                <? foreach($descuentos as $descuento){ ?>
                                                    <option value="<?=number_format($descuento->id_descuento,0)?>"><?=number_format($descuento->porcentaje)." %"?></option>
                                                <? } ?>
                                            </select>
                                        </div>
                                    </div>

									<div class="col-md-4">
                                        <div class="form-group" id="inscripcion_muestra_descuento" style="display:none;">
                                            <label>Motivo de Descuento</label>
                                            <input type="text" class="form-control" name="inscripcion_motivo_descuento" id="inscripcion_motivo_descuento">
                                        </div>
                                    </div>

                                </div>

								<div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Colegiaturas</label>
                                            <div id="muestra_meses"></div>
										</div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-actions right">
                                <a href="?Modulo=Inscripciones" type="button" class="btn default" >Cancelar</a>
                                <button type="button" class="btn blue" onclick="inscribeAlumno();"> Inscribir Alumno</button>
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

        $('form').submit(function(e){
            e.preventDefault();
        });
		//id_tutor
		$('#id_tutor').change(function(){
			App.blockUI();
			var id_tutor = $(this).val();
			$.getJSON('data/tutor.php',{id_tutor:id_tutor},function(data) {
	            console.log(data);
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
	            console.log(data);
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
            
            if(id_denominacion == "1"){
                document.getElementById('asd_aprobacion').style.display = "block";
            }else{
                document.getElementById('asd_aprobacion').style.display = "none";
                document.getElementById('socio_aprobado').value ='0';
            }
			dameColegiatura();
		});
        
        $('#socio_aprobado').change(function(){
			dameColegiatura();
		});

		$('#id_descuento').change(function(){
            var val_descuento = $('#id_descuento').val();
			if(val_descuento==100){
				var descuento = 1;
			}else{
				var descuento = "."+$('#id_descuento').val();
			}
			var colegiatura = $('#colegiatura_hide').val();;
			var monto_descontar = Number(colegiatura)*Number(descuento);
			var total_descuento=Number(colegiatura)-Number(monto_descontar);
			total_descuento = Math.round(total_descuento);
			if(descuento>0){
				$('#colegiatura').val(total_descuento.toFixed(2));
				$('#muestra_descuento').show('fast');
				$('#motivo_descuento').focus();
			}else{
				$('#colegiatura').val(colegiatura);
				$('#muestra_descuento').hide('fast');
			}
		});

		$('#inscripcion_id_descuento').change(function(){
			var val_descuento = $('#inscripcion_id_descuento').val();
			if(val_descuento==100){
				var descuento = 1;
			}else{
				var descuento = "."+$('#inscripcion_id_descuento').val();
			}
			var inscripcion = $('#inscripcion_hide').val();;
			var monto_descontar = Number(inscripcion)*Number(descuento);
			var total_descuento=Number(inscripcion)-Number(monto_descontar);
			total_descuento = Math.round(total_descuento);
			if(descuento>0){
				$('#inscripcion').val(total_descuento.toFixed(2));
				$('#inscripcion_muestra_descuento').show('fast');
				$('#inscripcion_motivo_descuento').focus();
			}else{
				$('#inscripcion').val(inscripcion);
				$('#inscripcion_muestra_descuento').hide('fast');
			}
		});

    });
	function dameGrupos(){
		App.blockUI();
		var id_nivel = $('#id_nivel').val();
		var id_grado = $('#id_grado').val();
		$.getJSON('data/grupos.php',{id_nivel:id_nivel,id_grado:id_grado},function(data) {
			console.log(data);
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


	function dameColegiatura(){
		var id_nivel = $('#id_nivel').val();
        var tipo_alumno = $('#id_denominacion').val();
		var socio_aprobado = $('#socio_aprobado').val();
		$.getJSON('data/colegiaturas.php',{id_nivel:id_nivel},function(data) {
			console.log(data);
			if(data.error!=true){
				if(tipo_alumno==1 && socio_aprobado == 1){
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
		$.getJSON('data/ciclo.php',{id_ciclo:id_ciclo},function(data) {
			console.log(data);
			if(data.error!=true){
				$('#muestra_meses').html(data.datos);
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
    function inscribeAlumno(){
		App.blockUI();
        var datos=$('#frm_guarda').serialize();
        $.getJSON('ac/inscribe_alumno.php',datos,function(data){
			console.log(data);
            if(data.respuesta==1){
                window.open("?Modulo=Inscripciones&id="+data.id_alumno, "_self");
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

</script>

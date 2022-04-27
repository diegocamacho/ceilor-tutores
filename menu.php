<?php
$menu = isset($_GET['Modulo']) ? $_GET['Modulo']: NULL;

switch($menu){

    case 'Alumnos':
    $alumnos_active = "active";
    break;

    case 'Alumno':
    $alumnos_active = "active";
    break;

    case 'PagosPendientes':
    $pagos_active = "active";
    break;

    case 'Reinscripciones':
    $reinscripcion_active = "active";
    break;

    case 'NuevoTutor':
    $configuracion_active = 1;
    $tutor_active = "active";
    break;
    
    default:
    $panel_active ="active";
	break;
}

?>

<div class="page-sidebar-wrapper">
    <!-- BEGIN SIDEBAR -->
    <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
    <!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
    <div class="page-sidebar navbar-collapse collapse">
        <!-- BEGIN SIDEBAR MENU -->
        <!-- DOC: Apply "page-sidebar-menu-light" class right after "page-sidebar-menu" to enable light sidebar menu style(without borders) -->
        <!-- DOC: Apply "page-sidebar-menu-hover-submenu" class right after "page-sidebar-menu" to enable hoverable(hover vs accordion) sub menu mode -->
        <!-- DOC: Apply "page-sidebar-menu-closed" class right after "page-sidebar-menu" to collapse("page-sidebar-closed" class must be applied to the body element) the sidebar sub menu mode -->
        <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
        <!-- DOC: Set data-keep-expand="true" to keep the submenues expanded -->
        <!-- DOC: Set data-auto-speed="200" to adjust the sub menu slide up/down speed -->
        <ul class="page-sidebar-menu   " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">

            <li class="nav-item start <?=$panel_active?>">
                <a href="index.php" class="nav-link">
                    <i class="icon-home"></i>
                    <span class="title">Inicio</span>
                </a>
            </li>
            <li class="nav-item  <?=$alumnos_active?>">
                <a href="?Modulo=Alumnos" class="nav-link">
                    <i class="icon-user"></i>
                    <span class="title">Alumnos</span>
                </a>
            </li>
            <li class="nav-item  <?=$pagos_active?>">
                <a href="?Modulo=PagosPendientes" class="nav-link">
                    <i class="icon-bell"></i>
                    <span class="title">Pagos Pendientes</span>
                </a>
            </li>
            <li class="nav-item  <?=$reinscripcion_active?>">
                <a href="?Modulo=Reinscripciones" class="nav-link">
                    <i class="icon-refresh"></i>
                    <span class="title">Reinscripción de alumnos</span>
                </a>
            </li>
            

            
            <li class="nav-item <? if($configuracion_active==1){ ?> active open <? } ?>">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="icon-settings"></i>
                    <span class="title">Configuración</span>
                    <span class="arrow <? if($configuracion_active==1){ ?>open <? } ?>"></span>
                </a>
                <ul class="sub-menu <? if($configuracion_active==1){ ?>in<? } ?>" >
                    <li class="nav-item  <?=$tutor_active?>">
                        <a href="?Modulo=NuevoTutor" class="nav-link ">
                            <span class="title">Mis Datos</span>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
        <!-- END SIDEBAR MENU -->
    </div>
    <!-- END SIDEBAR -->
</div>


<script>
//abrir modales
function reporteASD(){
    $('#reportASD').modal('show');
}
function reporteCobranza(){
    $('#reporteCobranza').modal('show');
}
function estadoCuenta(){
    $('#estadoCuenta').modal('show');
}
function corteCaja(){
    $('#modalCorte').modal('show');
}
function getAlumnos(){
    var tutor_id = $('#id_tutor_edocta').val();
    App.blockUI(
			{
				boxed: true,
				message: 'Buscando Alumnos'
			}
		);
    $.post('data/alumnosTutor.php','tutor_id='+tutor_id+'&action=getAlumnoxTutor',function(data){
        $('#msg_error_edocta').hide('Fast'); 
        data = JSON.parse(data);
        if(!data.error){
            $('#id_alumno_edocta').html("");
            $('#id_alumno_edocta').html(data.data);
            App.unblockUI();
        }else {
            $('#id_alumno_edocta').html("");
            $('#msg_error_edocta').html(data.msg);
            $('#msg_error_edocta').show('Fast'); 
            App.unblockUI();
        }
    });
}



function setReportASD(){
    var select_idGrado = $('#id_grado2').val();
    var id_denominacion = $('#id_denominacion2').val();
    if (select_idGrado != null && select_idGrado != 'null') {
        console.log(select_idGrado);
        var splitGrado = select_idGrado.split(".", 2);
        var id_grado = splitGrado[0];
        var id_nivel = splitGrado[1];
    } else {
        var id_grado = "";
        var id_nivel = "";
    }
    if(id_denominacion != null && id_denominacion != 'null') {
        var id_denominacion = id_denominacion;
    }else {
        var id_denominacion = ""
    }
    window.open(
        "reporte/reporteASD.php?id_grado="+id_grado+"&id_denominacion="+id_denominacion+"&id_nivel="+id_nivel,
        "_blank"
    );
}

function setReporteCobranza(){
    var id_nivel_cobranza = $('#id_nivel_cobranza').val();
   if(!id_nivel_cobranza){
    App.unblockUI();
        App.alert({
            type: 'info',
            message: "Debe seleccionar un nivel",
            place: 'prepent',
            container: '#modal_cobranza',
            close: true,
            focus: true
        });
        return false;
   }
    window.open(
        "reporte/cobranza.php?id_nivel="+id_nivel_cobranza,
        "_blank"
    );
}
function setEstadoCuenta(){
    var id_alumno = $('#id_alumno_edocta').val();
    if(!id_alumno){
    App.unblockUI();
        App.alert({
            type: 'info',
            message: "Debe seleccionar un alumno",
            place: 'prepent',
            container: '#modal_edoCuenta',
            close: true,
            focus: true
        });
        return false;
   }else{
            window.open(
            "reporte/estado_cuenta.php?id_alumno="+id_alumno,
            "_blank"
        );
   }
}
function verCorte(){
    var fecha1 = $('#fecha1').val();
    var fecha2 = $('#fecha2').val();
    if(!fecha1 || !fecha2){
    App.unblockUI();
        App.alert({
            type: 'info',
            message: "Debe seleccionar un rango de fechas a consultar.",
            place: 'prepent',
            container: '#modal_Corte',
            close: true,
            focus: true
        });
        return false;
   }else{
        window.open(
            "reporte/corteDeCaja.php?fecha1="+fecha1+"&fecha2="+fecha2,
            "_blank"
        );
    }
}
</script>

<?php
$sql = "SELECT * FROM grados
inner join niveles on niveles.id_nivel = grados.id_nivel
ORDER BY niveles.id_nivel ASC;";
$q_grado=mysqli_query($db,$sql);
while($datos=mysqli_fetch_object($q_grado)):
	$grados[] = $datos;
endwhile;

$sql = "SELECT * FROM niveles";
$q_niveles=mysqli_query($db,$sql);
while($datos=mysqli_fetch_object($q_niveles)):
	$niveles[] = $datos;
endwhile;

$sql = "SELECT * FROM tutores WHERE activo = 1";
$q_tutores=mysqli_query($db,$sql);
while($datos=mysqli_fetch_object($q_tutores)):
	$tutores[] = $datos;
endwhile;
?>

<div class="modal fade" id="reportASD">
	<div class="modal-dialog ">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
				<h4 class="modal-title">Generar Reporte ASD & NASD</h4>
			</div>
			<div class="modal-body">
				<form id="frm-nuevo" class="form-horizontal">
					<div class="alert alert-danger oculto" role="alert" id="msg_error_empleado"></div>
                    <div class="form-group">
						<label for="descripcion" class="col-md-3 control-label">Nivel</label>
						<div class="col-md-9">
                        <select class="form-control select2" name="id_grado2" id="id_grado2">
                            <option selected disabled>Seleccionar un grado</option>
                            <option value="null">Todos</option>
                            <? foreach($grados as $grado){ ?>
                                <option value="<?=$grado->id_grado?>.<?=$grado->id_nivel?>"><?=$grado->grado?> <?=$grado->nivel?> </option>
                            <?php } ?>
                        </select>
						</div>
					</div>
                    <div class="form-group">
						<label for="descripcion" class="col-md-3 control-label">Denominación</label>
						<div class="col-md-9">
                            <select class="form-control select2" name="id_denominacion2" id="id_denominacion2">
                                <option selected disabled>Seleccionar la denominación</option>
                                <option value="null">Todos</option>
                                <option value="1">ASD </option>
                            </select>
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default btn_ac" data-dismiss="modal">Cancelar</button>
				<button type="button" class="btn blue-chambray btn_ac" onclick="setReportASD()">Generar</button>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="reporteCobranza">
	<div class="modal-dialog ">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
				<h4 class="modal-title">Generar Reporte Cobranza</h4>
			</div>
			<div class="modal-body" id="modal_cobranza"> 
				<form id="frm-nuevo" class="form-horizontal">
					<div class="alert alert-danger oculto" role="alert" id="msg_error_empleado"></div>
                    <div class="form-group">
						<label for="descripcion" class="col-md-3 control-label">Nivel</label>
						<div class="col-md-9">
                        <select class="form-control select2" name="id_nivel_cobranza" id="id_nivel_cobranza">
                            <option selected disabled>Seleccionar un nivel</option>
                            <? foreach($niveles as $nivel){ ?>
                                <option value="<?=$nivel->id_nivel?>"><?=$nivel->nivel?> </option>
                            <?php } ?>
                        </select>
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default btn_ac" data-dismiss="modal">Cancelar</button>
				<button type="button" class="btn blue-chambray btn_ac" onclick="setReporteCobranza()">Generar</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="estadoCuenta">
	<div class="modal-dialog ">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
				<h4 class="modal-title">Estado de Cuenta</h4>
			</div>
			<div class="modal-body" id="modal_edoCuenta"> 
				<form id="frm-nuevo" class="form-horizontal">
					<div class="alert alert-danger oculto" role="alert" id="msg_error_edocta"></div>
                    <div class="form-group">
						<label for="tutor" class="col-md-3 control-label">Tutor</label>
						<div class="col-md-9">
                        <select class="form-control select2" name="id_tutor_edocta" id="id_tutor_edocta" onchange="getAlumnos()">
                            <option selected disabled>Seleccionar un tutor</option>
                            <? foreach($tutores as $tutor){ ?>
                                <option value="<?=$tutor->id_tutor?>"><?=$tutor->nombre?> </option>
                            <?php } ?>
                        </select>
						</div>
					</div>
                    <div class="form-group">
						<label for="tutor" class="col-md-3 control-label">Alumno</label>
						<div class="col-md-9">
                        <select class="form-control select2" name="id_alumno_edocta" id="id_alumno_edocta">
                            <option selected disabled>Seleccionar un alumno</option>
                        </select>
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default btn_ac" data-dismiss="modal">Cancelar</button>
				<button type="button" class="btn blue-chambray btn_ac" onclick="setEstadoCuenta()">Generar</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="modalCorte">
	<div class="modal-dialog ">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
				<h4 class="modal-title">Estado de Cuenta</h4>
			</div>
			<div class="modal-body" id="modal_Corte"> 
				<form id="frm-nuevo" class="form-horizontal">
					<div class="alert alert-danger oculto" role="alert" id="msg_error_corte"></div>
                    <div class="form-group">
                        <label class="control-label col-md-3">Selecciona Fechas</label>
                        <div class="col-md-4">
                            <div class="input-group input-large date-picker input-daterange" data-date="10/11/2012" data-date-format="mm/dd/yyyy">
                                <input type="text" class="form-control" name="fecha1" id="fecha1">
                                <span class="input-group-addon"> a </span>
                                <input type="text" class="form-control" name="fecha2" id="fecha2"> 
                            </div>
                        </div>
                    </div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default btn_ac" data-dismiss="modal">Cancelar</button>
				<button type="button" class="btn blue-chambray btn_ac" onclick="verCorte()">Consultar</button>
			</div>
		</div>
	</div>
</div>
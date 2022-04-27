<?php
//Nuevo ciclo
$nuevoCicilo=$cicloActivo+1;
$sql="SELECT * FROM ciclos WHERE id_ciclo=$nuevoCicilo";
$q=mysqli_query($db,$sql);
$dt=mysqli_fetch_assoc($q);
$nuevoCicloId=$dt['id_ciclo'];
$nuevoCicloNombre=$dt['ciclo'];

$valida=true;
?>

<div class="page-content-wrapper">
	<div class="page-content">
		<div class="row">
			<div class="col-md-12">
				<div class="portlet light portlet-fit">
					<div class="portlet-title">
						<div class="caption">
							<i class="icon-refresh font-blue-hoki"></i>
							<span class="caption-subject font-blue-hoki bold uppercase">Reinscripción de alumno</span>
						</div>

					</div>
					<div class="portlet-body" id="v_alumnos">
						<? if($valida){ ?>
							<table class="table table-striped table-bordered table-hover" id="tabla_alumnos">
								<thead>
									<tr>
										<th>Ciclo</th>
										<th>Nivel</th>
										<th>Grado y Grupo</th>
										<th>Nombre completo</th>
										<th width="210"></th>
									</tr>
								</thead>
								<tbody>
								<?foreach($alumnos as $alumno){
									if($cicloActivo!=$alumno->id_ciclo){ continue; } ?>
									<tr>
										<td><?=dameCiclo($alumno->id_ciclo)?></td>
										<td><?=dameNivel($alumno->id_nivel)?></td>
										<td><?=dameGrado($alumno->id_grado)?> <?=$alumno->grupo?></td>
										<td><?=$alumno->apaterno?> <?=$alumno->amaterno?> <?=$alumno->nombre?></td>
										<td align="right">
                                            <?  $sql="SELECT * FROM alumnos_academico WHERE id_alumno=$alumno->id_alumno AND id_ciclo=$nuevoCicloId";
                                                $q=mysqli_query($db,$sql);
                                                $validaNciclo=mysqli_num_rows($q);
                                                if($validaNciclo){
													$sql="SELECT id_alumno_colegiatura FROM alumnos_colegiatura WHERE id_alumno=$alumno->id_alumno AND id_ciclo=$nuevoCicloId AND tipo=2";
                                                	$q=mysqli_query($db,$sql);
													$dt=mysqli_fetch_assoc($q);
											?>
											<a role="button" href="https://pagos.ceilor.mx/pay.php?token=<?=base64_encode($alumno->id_alumno."|".$id_tutor."|".$dt['id_alumno_colegiatura'])?>" target="_blank" class="btn btn-info btn-xs">Pagar en línea</a>
											<a role="button" href="https://inscripciones.ceilor.mx/reportes/comprobantePago.php?token=<?=base64_encode($alumno->id_alumno."|".$alumno->id_ciclo)?>" target="_blank" class="btn btn-warning btn-xs">Pagar en caja</a>
											<?
                                                }else{
                                            ?>
                                                <a role="button" href="javascript:;" onclick="reinscribeAlumno(<?=$alumno->id_alumno?>,<?=$nuevoCicloId?>)" class="btn green-jungle btn-xs">Reinscribir <?=$nuevoCicloNombre?></a>
                                            <? } ?>
                                        </td>
									</tr>
								<? } ?>
								</tbody>
							</table>
						<? }else{ ?>
							<div class="alert alert-dismissable alert-info"><p>Estimado tutor, aún no se ha aperturado un nuevo ciclo.</p></div>
						<? } ?>
					</div> <!--portlet-body-->
				</div>
			</div>
		</div>
	</div>
</div>
<script>
function reinscribeAlumno(id_alumno,id_ciclo){

	swal({
		title: "Reinscripción de Alumno",
  		text: "Esta acción inscribirá al alumno al siguiente ciclo (<?=$nuevoCicloNombre?>)",
  		type: "input",
  		showCancelButton: true,
  		closeOnConfirm: false,
		showLoaderOnConfirm: true,
  		inputPlaceholder: "Si tiene un cupón agregalo"
		},function(inputValue){
  			if(inputValue===false) return false;
  			// if(inputValue===""){
    		// 	swal.showInputError("You need to write something!");
    		// 	return false
  			// }
				//alert(inputValue);
			$.getJSON('ac/reinscripcion.php',{id_alumno:id_alumno,id_ciclo:id_ciclo,cupon:inputValue},function(data){
				if(data.respuesta==1){
					window.open("?Modulo=Reinscripciones","_self");
				}else{
					swal("Error", data.mensaje, "error");
				}
			});
	});
    
	// swal({
  	// 	title: "Reinscripción de Alumno",
  	// 	text: "Esta acción inscribirá al alumno al siguiente ciclo (<?=$nuevoCicloNombre?>)",
  	// 	type: "info",
  	// 	showCancelButton: true,
	// 	confirmButtonText: "Si, reinscribir",
	// 	confirmButtonClass: "btn-info",
  	// 	cancelButtonText: "No, cancelar",
  	// 	closeOnConfirm: false,
  	// 	showLoaderOnConfirm: true
	// },function(){
	// 	$.getJSON('ac/reinscripcion.php',{id_alumno:id_alumno,id_ciclo:id_ciclo},function(data){
	// 		if(data.respuesta==1){
	// 			swal("Confirmación", data.mensaje, "success");
	// 		}else{
	// 			swal("Error", data.mensaje, "error");
	// 		}
	// 	});
	// });
}

</script>
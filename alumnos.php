<?php

?>

<div class="page-content-wrapper">
	<div class="page-content">
		<div class="row">
			<div class="col-md-12">
				<div class="portlet light portlet-fit">
					<div class="portlet-title">
						<div class="caption">
							<i class="icon-user font-blue-hoki"></i>
							<span class="caption-subject font-blue-hoki bold uppercase">Alumnos</span>
						</div>

					</div>
					<div class="portlet-body" id="v_alumnos">
						<? if($valida){ ?>
							<table class="table table-striped table-bordered table-hover" id="tabla_alumnos">
								<thead>
									<tr>
										<th>Nivel</th>
										<th>Grado y Grupo</th>
										<th>Nombre completo</th>
										<th width="50"></th>
									</tr>
								</thead>
								<tbody>
								<?	foreach($alumnos as $alumno){ 
									
									if($s_id_ciclo!=$alumno->id_ciclo){ continue; }	
								?>
									<tr>
										<td><?=dameNivel($alumno->id_nivel)?></td>
										<td><?=dameGrado($alumno->id_grado)?> <?=$alumno->grupo?></td>
										<td><?=$alumno->apaterno?> <?=$alumno->amaterno?> <?=$alumno->nombre?></td>
										<td><a role="button" href="?Modulo=Alumno&id=<?=$alumno->id_alumno?>" class="btn blue-chambray btn-xs">Consultar Alumno</a></td>
									</tr>
								<? } ?>
								</tbody>
							</table>
						<? }else{ ?>
							<div class="alert alert-dismissable alert-info"><p>Estimado tutor, aún no tiene alumnos asignados.</p></div>
						<? } ?>
					</div> <!--portlet-body-->
				</div>
			</div>
		</div>
	</div>
</div>
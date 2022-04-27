<?
//Nuevo ciclo
$nuevoCicilo=$cicloActivo+1;
$sql="SELECT * FROM ciclos WHERE id_ciclo=$nuevoCicilo";
$q=mysqli_query($db,$sql);
$dt=mysqli_fetch_assoc($q);
$nuevoCicloId=$dt['id_ciclo'];
$nuevoCicloNombre=$dt['ciclo'];
?>

<div class="page-content-wrapper">
    <div class="page-content">
        <div class="row">
            <div class="col-md-12">
                <div class="portlet light portlet-fit" id="PagosPendientesActual">
                    <div class="portlet-title">
                        <div class="caption">
							<i class="icon-bell font-blue-hoki"></i>
							<span class="caption-subject font-blue-hoki bold uppercase">Pagos pendientes ciclo actual</span></div>
                        <div class="actions btn-set">
                            <!-- <a class="btn btn-sm btn-success" href="?Modulo=NuevoPago" role="button">Nuevo Pago</a> -->
                        </div>
                        
                    </div>
                    <div class="portlet-body">
						<?	foreach($alumnos as $alumno){ 
							$id_alumno=$alumno->id_alumno;
							if($s_id_ciclo!=$alumno->id_ciclo){ continue; }
						?>
						
						<?
							$sql="SELECT * FROM alumnos_colegiatura WHERE id_alumno=$id_alumno AND id_ciclo=$s_id_ciclo AND pagado=0
							ORDER BY fecha ASC, id_alumno_colegiatura ASC LIMIT 1";
							$q=mysqli_query($db,$sql);
							$validaPendientes=mysqli_num_rows($q);
							if($validaPendientes){
						?>
							<h3>PAGOS PENDIENTES PARA <?=$alumno->apaterno?> <?=$alumno->amaterno?> <?=$alumno->nombre?></h3>
							<table class="table table-striped table-bordered table-hover" id="tabla_alumnos">
								<thead>
									<tr>
										<th>Concepto</th>
										<th width="120">Vencimiento</th>
										<th width="120" style="text-align:center;">Monto</th>
										<th width="100"></th>
									</tr>
								</thead>
								<tbody>
								<?
									while($dt = mysqli_fetch_assoc($q)){
								?>
									<tr>
										<td><?=ucwords(strtolower($dt['descripcion']))?></td>
										<td><?=fechaCorta($dt['fecha'])?></td>
										<td align="right"><?=number_format($dt['monto'],2)?></td>
										<td><a role="button" href="https://pagos.ceilor.mx/pay.php?token=<?=base64_encode($id_alumno."|".$id_tutor."|".$dt['id_alumno_colegiatura'])?>" class="btn green-jungle btn-xs" target="_blank">Pagar en línea</a></td>
									</tr>
								<? } ?>		
								</tbody>
							</table>
								<input type="hidden" id="pagosPendientes" value=2 />
							<? }else{ ?>
								<input type="hidden" id="pagosPendientes" value=1 />
							<? } ?>
						<? } ?>
					</div>
              	</div>

				  <div class="portlet light portlet-fit" id="PagosPendientesNuevosVista">
                    <div class="portlet-title">
                        <div class="caption">
							<i class="icon-bell font-blue-hoki"></i>
							<span class="caption-subject font-blue-hoki bold uppercase">Pagos pendientes ciclo <?=$nuevoCicloNombre?></span></div>
                        <div class="actions btn-set">
                            <!-- <a class="btn btn-sm btn-success" href="?Modulo=NuevoPago" role="button">Nuevo Pago</a> -->
                        </div>
                        
                    </div>
                    <div class="portlet-body">
						<?	foreach($alumnos as $alumno){ 
							$id_alumno=$alumno->id_alumno;
							if($nuevoCicloId!=$alumno->id_ciclo){ continue; }
						
							$sql="SELECT * FROM alumnos_colegiatura WHERE id_alumno=$id_alumno AND id_ciclo=$nuevoCicloId AND pagado=0";
							$q=mysqli_query($db,$sql);
							$validaPendientesNuevos=mysqli_num_rows($q);
							if($validaPendientesNuevos){
						?>
							<h3>PAGOS PENDIENTES PARA <?=$alumno->apaterno?> <?=$alumno->amaterno?> <?=$alumno->nombre?></h3>
							<table class="table table-striped table-bordered table-hover" id="tabla_alumnos">
								<thead>
									<tr>
										<th>Concepto</th>
										<th width="120">Vencimiento</th>
										<th width="120" style="text-align:center;">Monto</th>
										<th width="100"></th>
									</tr>
								</thead>
								<tbody>
								<?
									while($dt = mysqli_fetch_assoc($q)){
								?>
									<tr>
										<td><?=ucwords(strtolower($dt['descripcion']))?></td>
										<td><?=fechaCorta($dt['fecha'])?></td>
										<td align="right"><?=number_format($dt['monto'],2)?></td>
										<td><a role="button" href="https://pagos.ceilor.mx/pay.php?token=<?=base64_encode($id_alumno."|".$id_tutor."|".$dt['id_alumno_colegiatura'])?>" class="btn green-jungle btn-xs" target="_blank">Pagar en línea</a></td>
									</tr>
								<? } ?>		
								</tbody>
							</table>
							<? } ?>
							
						<? } ?>
						<input type="hidden" id="pagosPendientesNuevos" value="<?=$validaPendientesNuevos?>" />
					</div>
              	</div> 
				
            </div>
        </div>
    </div>
</div>

<script>
$(function(){
        
	var Pendientes = $('#pagosPendientes').val();
	if(Pendientes==1){
		$('#PagosPendientesActual').hide();
	}

	var PendientesN = $('#pagosPendientesNuevos').val();
	if(PendientesN<1){
		$('#PagosPendientesNuevosVista').hide();
	}

});
</script>

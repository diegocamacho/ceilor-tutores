<?php set_time_limit(0); 
ob_start(); 
include("../includes/session.php");
include("../includes/db.php");
include("../includes/funciones.php");
$id_alumno = escapar($_GET['id_alumno'],1);

$sql="SELECT * FROM alumnos WHERE id_alumno=$id_alumno AND id_tutor=$id_tutor";
$q=mysqli_query($db,$sql);
$val=mysqli_num_rows($q);
if(!$val){
    echo "Ocurrió un error, intente más tarde.";
    exit;
}

extract($_GET);
$logo="../LOGO_CEILOR.png";
$color="#07470a";

//Sacamos el ciclo activo
$id_alumno = $_GET['id_alumno'];
$id_ciclo = $_GET['id_ciclo'];
if(!$_GET['id_ciclo']){
	$sql="SELECT ciclo_activo FROM configuracion_empresa WHERE id_empresa=1";
	$q=mysqli_query($db,$sql);
	$dt=mysqli_fetch_assoc($q);
	$id_ciclo=$dt['ciclo_activo'];
}

$sql="SELECT alumnos.nombre,apaterno,amaterno,nivel, id_grado,grupo,tutores.nombre as tutor, descuentos.descuento,descuentos.tipo, af.colegiatura_descuento, colegiatura, porcentaje, alumnos_academico.id_nivel, descuentos.id_descuento, socio_aprobado 
FROM alumnos
JOIN tutores USING (id_tutor)
JOIN alumnos_academico USING (id_alumno)
JOIN alumnos_financiero af USING (id_alumno)
LEFT JOIN descuentos ON af.colegiatura_descuento=descuentos.id_descuento
JOIN niveles USING (id_nivel)
WHERE id_alumno=$id_alumno AND alumnos_academico.id_ciclo=$id_ciclo AND af.id_ciclo=$id_ciclo";
$q=mysqli_query($db,$sql);
$ft=mysqli_fetch_assoc($q);
$id_nivel=$ft['id_nivel'];
$tipoDescuento=$ft['tipo'];
$socioAprobado=$ft['socio_aprobado'];

$sql = "SELECT * FROM alumnos_colegiatura 
WHERE id_alumno = $id_alumno AND id_ciclo=$id_ciclo ORDER BY fecha,id_alumno_colegiatura ASC";
$q=mysqli_query($db,$sql);
while($datos=mysqli_fetch_object($q)):
	$colegiaturas[] = $datos;
endwhile;
$totalCargos = 0;
$totalAbonos = 0;
$saldo = 0;

//Para saber la base si es colegiatura completa
$sql="SELECT * FROM colegiaturas WHERE id_ciclo=$id_ciclo AND id_nivel=$id_nivel";
$qu=mysqli_query($db,$sql);
$dtt=mysqli_fetch_assoc($qu);
if($socioAprobado==1){
	$colegiaturaBase=$dtt['monto_socios'];
	$inscripcionBase=$dtt['inscripcion_socio'];
}else{
	$colegiaturaBase=$dtt['monto_base'];
	$inscripcionBase=$dtt['inscripcion_base'];
}


$totalBecas=0;
?>
<style>
.rojo{
	color: #FF0000;
}
.verde{
	color: #07470a;
}
.titulos{
	background-color: <?=$color?>;
	color: #FFF;
}
.font-purple-seance{
	color: #9A12B3;
}

.borde-azul{
	border: <?=$color?> 1px solid ;
}
.borde-iz{
	border-left: <?=$color?> 1px solid;
}
.borde-der{
	border-right: <?=$color?> 1px solid;
}
.borde-bot{
	border-bottom: <?=$color?> 1px solid;
}
.borde-top{
	border-top: <?=$color?> 1px solid;
}
b{
	/* font-family: Arial; */
	font-family: sfsemi;
}
table{
	/* font-family: Arial; */
	font-family: sf;
}
.f16{
	font-size: 16px;
}
.f12{
	font-size: 12px;
}
.f11{
	font-size: 11px;
}
.f10{
	font-size: 10px;
}
.f14{
	font-size: 14px;
	font-weight: bold;
}
.m-top{
	margin-top: 35px;
}
.m-left{
	margin-left: 38px;
}
.logo{
	max-width: 250px;
	/*height: 30;*/
	max-height: 100px;

}
.fondo{
	background: #f3f3f3;
	/* font-weight: bold; */
}
</style>
<page backtop="80mm" backbottom="2mm" backleft="4mm" backright="5mm" footer="page">

	<page_header>
		<table  cellpadding="0" cellspacing="0" class="f14" style="margin-left: 15px">
			<tr>
				<td width="300" height="110" >
					<img height="100" src="<?=$logo?>" class="logo" />
				</td>
				<td width="450" height="110" valign="top" align="right" valign="middle">
				FILÁNTROPICA Y EDUCATIVA DEL SUR DE QUINTANA ROO AC<br>
				<b style="color:<?=$color?>;">CENTRO EDUCATIVO IGNACIO LOPEZ RAYÓN</b><br>
				AV. 16 DE SEPTIEMBRE #65 COL. CENTRO<br>
				CHETUMAL, QUINTANA ROO C.P. 77000 <br>
				TEL: (983) 8331410 / RFC: FES-151204-QJ1
				</td>
			</tr>
		</table>

		<table cellpadding="0" cellspacing="0" class="f14" style="margin-left: 15px">
			<tr>
				<td width="750" style="border-top: 0.5px #D7DBDD solid;" >
					<h3 style="text-align: center;margin-top: 10px;margin-bottom: 0px;">ESTADO DE CUENTA</h3>
					<p style="text-align: center;margin-bottom: 0px;">CICLO <?=dameCiclo($id_ciclo);?></p>
					<p style="text-align: center;margin-bottom: 0px;">GENERADO EL <?=strtoupper(fechaHoraMeridian($fechahora))?></p>
				</td>
			</tr>
		</table>

		<table cellpadding="0" cellspacing="0" class="borde-azul f14" style="margin-left: 15px;margin-top: 10px">
			<tr>
				<td width="385" class="borde-der" style="padding-left:5px;"><b>ALUMNO:</b> <?=$ft['apaterno']?> <?=$ft['amaterno']?> <?=$ft['nombre']?> [<?=$id_alumno?>]</td>
				<td width="345" style="padding-left:5px;"><b>TUTOR:</b> <?=$ft['tutor']?></td>
			</tr>
			<tr>
				<td colspan="2" class="borde-top" style="padding-left:5px;"><b>NIVEL:</b> <?=$ft['nivel']?> <?=$ft['id_grado']?>-<?=$ft['grupo']?></td>
			</tr>
			<? if($ft['colegiatura_descuento']){ ?>
			<tr>
				<td colspan="2" class="borde-top" style="padding-left:5px;"><b>DESCUENTO:</b> <?=$ft['descuento']?></td>
			</tr>
			<? } ?>
		</table>

	</page_header>

	<page_footer>
		<table width="750" border="0" cellpadding="0" cellspacing="0" class="f11">
			<tr>
				<td width="450">POWERED BY FILÁNTROPICA Y EDUCATIVA DEL SUR DE QUINTANA ROO AC</td>
			</tr>
		</table>
	</page_footer>




<table width="700" cellpadding="0" cellspacing="0" class="borde-azul f12">
	<thead>
    	<tr class="titulos">
			<th height="25" class="f11" width="65" style="padding-left:5px;">FOLIO</th>
			<th height="25" class="f11" width="90">FECHA</th>
			<th height="25" class="f11" width="340">DESCRIPCIÓN</th>
            <th height="25" class="f11" width="80" align="right">CARGO</th>
            <th height="25" class="f11" width="80" align="right">ABONO</th>
			<th height="25" class="f11" width="80" align="right"style="padding-right:5px;">SALDO</th>
		</tr>
	</thead>
	<tbody>
	<? foreach($colegiaturas as $colegiatura)
	{
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
					//$ds=calculaDescuento($colegiatura->monto,$colegiatura->descuento);
					$ds=descuento($colegiatura->monto,$colegiatura->descuento);
					$cargo = $colegiatura->monto;
				}
			}else{
				$cargo = $colegiatura->monto;
			}
		}else{
			if($ft['porcentaje']==100){
				
				if($colegiatura->tipo==2){
					//exit("aca");
					$cargo = $inscripcionBase;
					$ds=$inscripcionBase;
				}else{
					$cargo = $colegiaturaBase;
					$ds=$colegiaturaBase;
				}
				$totalBecas+=$cargo;
			}else{
				if(($tipoDescuento==2)&&($colegiatura->tipo==2)){
					
					//$ds=calculaDescuento($colegiatura->monto,$ft['porcentaje']);
					//$cargo = $colegiatura->monto+$ds;
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
	<tr <? if($colegiatura->tipo==4){?>class="rojo"<? } ?>>
		<td style="padding-left:5px;"><?=$colegiatura->id_alumno_colegiatura?></td>
		<td><?=fechaCorta($colegiatura->fecha)?></td>
		<td><?=$colegiatura->descripcion?></td>
		<td align="right"><?=number_format($cargo, 2)?></td>
		<td align="right"></td>
	<td align="right" style="padding-right:5px;<? if($saldo < 0){?> color:red;<?}?>"><?=number_format($saldo, 2)?></td>
	</tr>
		<? if($ft['colegiatura_descuento']){ 
				//if(($tipoDescuento!=2)&&($colegiatura->tipo!=2)){
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
			WHERE id_alumno=$id_alumno AND ventas.activo=1 AND id_alumno_colegiatura=$colegiatura->id_alumno_colegiatura";
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



				while($dt = mysqli_fetch_assoc($q)){
					$totalAbonos += $dt['precio'];
					$abono = $dt['precio'];
					$saldo = $saldo - $abono;

				?>	
					<tr class="verde">
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
				// 	if($colegiatura->tipo==2){
				// 		$descuento = $inscripcionBase;
				// 		$saldo=$saldo-$descuento;
				// 	}else{
				// 		$descuento = $colegiaturaBase;
				// 		$saldo=$saldo-$descuento;
				// 	}
					
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
</page>
<?php

	$content_html = ob_get_clean();
	require_once(dirname(__FILE__).'/pdf/html2pdf.class.php');
	try
	{
		$html2pdf = new HTML2PDF('P','A4','es', true, 'UTF-8', array(1, 5, 1, 2));
		$html2pdf->pdf->SetDisplayMode('fullpage');

		$html2pdf->addFont("sf");
		$html2pdf->addFont("sfsemi");
		$html2pdf->writeHTML($content_html, isset($_GET['vuehtml']));
        $html2pdf->Output('ESTADO-CUENTA-'.$id_alumno.'.pdf');
	}
	catch(HTML2PDF_exception $e) { echo $e; }	

?>
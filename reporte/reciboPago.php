<? 
set_time_limit(0);
ob_start();
include("../includes/db.php");
include("../includes/funciones.php");
include("../includes/num_letra.php");
//$id_venta=
extract($_GET);
$logo="../LOGO_CEILOR.png";
$color="#07470a";

$sql = "SELECT fechahora,metodo_pago,usuarios.nombre as usuario, tutores.nombre as tutor,serie,folio,tutores.email,tutores.telefono,referencia FROM ventas
JOIN metodo_pago ON metodo_pago.id_metodo_pago=ventas.id_metodo_pago
JOIN usuarios ON usuarios.id_usuario=ventas.id_usuario
JOIN tutores ON tutores.id_tutor=ventas.id_tutor
WHERE id_venta = $id_venta";
$q = mysqli_query($db,$sql);
$datos = @mysqli_fetch_assoc($q);

//Variables globales de la venta
$vendedor = mb_strtoupper($datos['usuario'],'UTF-8');
$tutor = mb_strtoupper($datos['tutor'],'UTF-8');
$email = mb_strtoupper($datos['email'],'UTF-8');
$telefono = mb_strtoupper($datos['telefono'],'UTF-8');
$fecha_hora_ticket = devuelveFechaHora($datos['fechahora']);
$fecha = fechaSinHora($datos['fechahora']);
$metodo_pago = mb_strtoupper($datos['metodo_pago'],'UTF-8');
$serie = mb_strtoupper($datos['serie'],'UTF-8');
$folio = mb_strtoupper($datos['folio'],'UTF-8');
$referencia = mb_strtoupper($datos['referencia'],'UTF-8');

//exit;

?>
<style>
.titulos{
	background-color: <?=$color?>;
	color: #FFF;
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
<page backtop="55mm" backbottom="2mm" backleft="4mm" backright="5mm" footer="page">

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
				<td width="750" style="border-top: 0.5px #D7DBDD solid;">
					<h3 style="text-align: center;margin-top: 10px;margin-bottom: 0px;">COMPROBANTE DE PAGO
					<br><small><b>FOLIO: <?=$serie?>-<?=$folio?></b></small>
					</h3>
				</td>
			</tr>
		</table>

		<table cellpadding="0" cellspacing="0" class="borde-azul f14" style="margin-left: 15px;margin-top: 10px">
			<tr>
				<td colspan="2" style="padding-left:5px;"><b>TUTOR:</b> <?=$tutor?></td>
			</tr>
			<tr>
				<td width="365" class="borde-top borde-der" style="padding-left:5px;"><b>EMAIL:</b> <?=$email?></td>
				<td width="365" class="borde-top" style="padding-left:5px;"><b>TELEFONO:</b>  <?=$telefono?></td>
			</tr>
			
		</table>

	</page_header>

	<page_footer>
		<table width="750" border="0" cellpadding="0" cellspacing="0" class="f11">
			<tr>
				<td width="450">POWERED BY FILÁNTROPICA Y EDUCATIVA DEL SUR DE QUINTANA ROO AC</td>
			</tr>
		</table>
	</page_footer>





        <h4 style="text-align: center;margin-top: 10px;margin-bottom: 15px;font-weight:200;">CONCEPTOS</h4>
	    <table width="700" cellpadding="0" cellspacing="0" class="borde-azul f11">
            <thead>
                <tr class="titulos">
                    <th height="25" class="f11" width="260">&nbsp;&nbsp;ALUMNO</th>
                    <th height="25" class="f11" width="125">DESCRIPCIÓN</th>
                    <th height="25" class="f11" width="90" align="right">MONTO</th>
                    <th height="25" class="f11" width="90" align="right">DESCUENTO</th>
                    <th height="25" class="f11" width="90" align="right"style="padding-right:5px;">TOTAL</th>
                </tr>
            </thead>
            <tbody>

		<?
        $sql = "SELECT cantidad,venta_detalle.precio,nombre,apaterno,amaterno,producto,ac.fecha as fecha_colegiatura, venta_detalle.tipo, ac.monto, ac.descripcion, ac.descuento FROM venta_detalle
        LEFT JOIN alumnos ON alumnos.id_alumno=venta_detalle.id_alumno
        LEFT JOIN productos ON productos.id_producto=venta_detalle.id_producto
        LEFT JOIN alumnos_colegiatura ac ON ac.id_alumno_colegiatura=venta_detalle.id_alumno_colegiatura
        WHERE id_venta = $id_venta";
        $q = mysqli_query($db,$sql);
        while($ft=mysqli_fetch_assoc($q)){
            if($ft['tipo']==2){
                if($ft['precio']<$ft['monto']){
                    $abono="ABONO A ";
                }
                $nombre_item = $abono.$descripcion;
            }else{
                $nombre_item = acentos($ft2['producto']);
            }
                $sub = $ft['cantidad']*$ft['precio'];
        ?>

            <tr class="fondogg">
		        <td width="250" style="padding-left:5px;"><?=$ft['apaterno'].' '.$ft['amaterno'].' '.$ft['nombre']?></td>
		        <td width="210"><?=$ft['descripcion']?></td>
		        <td align="right"><?=number_format($ft['monto'],2)?></td>
		        <td align="right"><? if($ft['descuento']){ echo number_format(descuento($ft['monto'],$ft['descuento']),2)." (".$ft['descuento']."%)";  }?></td>
	            <td align="right" style="padding-right:5px;<? if($saldo < 0){?> color:red;<?}?>"><?=number_format($ft['precio'], 2)?></td>
	        </tr>
		<? $total+=$ft['precio']; ?>
        <? } ?>

			<tr class="fondo">
		        <td style="padding-left:5px;"></td>
		        <td></td>
		        <td align="right"></td>
		        <td align="right"></td>
	            <td align="right" style="padding-right:5px;"><?=number_format($total, 2)?></td>
	        </tr>
        </tbody>
    </table>
	<br><br>
	<table cellpadding="0" cellspacing="0" class="borde-azul f14" style="">
		<tr>
			<td width="745" height="20" style="padding-left:5px;"><b>FECHA Y HORA:</b> <?=$fecha_hora_ticket?></td>
		</tr>
		<tr>
			<td width="745" height="20" style="padding-left:5px;"><b>FORMA DE PAGO:</b> <?=$metodo_pago?></td>
		</tr>
		<tr>
			<td width="745" height="20" style="padding-left:5px;"><b>REFERENCIA:</b> <?=$referencia?></td>
		</tr>
		<tr>
			<td width="745" height="20" style="padding-left:5px;"><b>ATENDIÓ:</b> <?=$vendedor?></td>
		</tr>
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
        $html2pdf->Output('RECIBO-'.$serie.''.$folio.'.pdf');
	}
	catch(HTML2PDF_exception $e) { echo $e; }	

?>
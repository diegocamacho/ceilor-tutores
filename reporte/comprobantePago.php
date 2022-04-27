<?php set_time_limit(0); 
$token=$_GET['token'];
// $token=base64_encode($idAlumno."|".$idCiclo);
if(!$token){
	exit('Ocurrió un error');
}else{
	$tk=base64_decode($token);
	$temp = explode("|", $tk);
	$mostrar = true;

	if(!is_numeric($temp[0])){
		exit('Ocurrió un error');
	}
	
	if(!is_numeric($temp[1])){
		exit('Ocurrió un error');
	}
}
ob_start();
include("../includes/db.php");
include("../includes/funciones.php");

extract($_GET);
$logo="../LOGO_CEILOR.png";
$color="#07470a";

// $id_alumno = $_GET['id_alumno'];
// $id_ciclo = $_GET['id_ciclo'];

$id_alumno	=	$temp[0];
$id_ciclo	=	$temp[1];

$sql="SELECT al.apaterno, al.amaterno, al.nombre, t.nombre as tutor, aa.id_nivel, aa.id_grado, aa.grupo, t.telefono, t.email 
FROM alumnos al
JOIN alumnos_academico aa USING (id_alumno)
JOIN alumnos_financiero USING (id_alumno)
JOIN tutores t USING (id_tutor)
WHERE aa.id_ciclo=$id_ciclo AND al.id_alumno=$id_alumno
GROUP BY al.id_alumno";
$q=mysqli_query($db,$sql);
$ft=mysqli_fetch_assoc($q);
// $sql = "SELECT monto,descripcion,id_alumno_colegiatura,fecha,pagado,descuento FROM alumnos_colegiatura 
// WHERE id_alumno = $id_alumno AND id_ciclo=$id_ciclo ORDER BY tipo DESC";
// $q=mysqli_query($db,$sql);
// while($datos=mysqli_fetch_object($q)):
// 	$colegiaturas[] = $datos;
// endwhile;
// $totalCargos = 0;
// $totalAbonos = 0;
// $saldo = 0;
$sql="SELECT * FROM alumnos_colegiatura WHERE id_alumno=$id_alumno AND id_ciclo=$id_ciclo AND tipo=1 LIMIT 1";
$q=mysqli_query($db,$sql);
$ddt=mysqli_fetch_assoc($q);
$colegiatura=$ddt['monto'];

$sql="SELECT ac.*, cupones.codigo, cupones.expira FROM alumnos_colegiatura ac
LEFT JOIN cupones USING (id_cupon)
WHERE id_alumno=$id_alumno AND id_ciclo=$id_ciclo AND ac.tipo=2";
$q=mysqli_query($db,$sql);
$dt=mysqli_fetch_assoc($q);

$descuentoMonto=($dt['monto']*$dt['descuento'])/100;
$pago=$dt['monto']-$descuentoMonto;


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
<page backtop="65mm" backbottom="2mm" backleft="4mm" backright="5mm" footer="page">

	<page_header>
		<table  cellpadding="0" cellspacing="0" class="f14" style="margin-left: 15px">
			<tr>
				<td width="100" height="110" >
					<img height="100" src="<?=$logo?>" class="logo" />
				</td>
				<td width="200" height="110">
					<img src="banner-promo.png" width="200" />
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
					<h3 style="text-align: center;margin-top: 10px;margin-bottom: 0px;">COMPROBANTE DE INSCRIPCIÓN</h3>
				</td>
			</tr>
		</table>

		<table cellpadding="0" cellspacing="0" class="borde-azul f14" style="margin-left: 15px;margin-top: 10px">
			<tr>
				<td width="365" class="borde-der" style="padding-left:5px;"><b>ALUMNO:</b> <?=$ft['apaterno']?> <?=$ft['amaterno']?> <?=$ft['nombre']?></td>
				<td width="365" style="padding-left:5px;"><b>NIVEL:</b> <?=strtoupper(dameNivel($ft['id_nivel']))?> <?=strtoupper(dameGrado($ft['id_grado']))?> <?=$ft['grupo']?></td>
			</tr>
			<tr>
				<td colspan="2" class="borde-top" style="padding-left:5px;"><b>TUTOR:</b> <?=$ft['tutor']?></td>
			</tr>
			<tr>
				<td width="365" class="borde-top borde-der" style="padding-left:5px;"><b>EMAIL:</b> <?=$ft['email']?></td>
				<td width="365" class="borde-top" style="padding-left:5px;"><b>TELEFONO:</b>  <?=$ft['telefono']?></td>
			</tr>
			
		</table>

	</page_header>

	<page_footer>
		<table width="750" border="0" cellpadding="0" cellspacing="0" class="f11">
			<tr>
				<td width="300" >POWERED BY FILÁNTROPICA Y EDUCATIVA DEL SUR DE QUINTANA ROO AC</td>
			</tr>
		</table>
	</page_footer>

	<table cellpadding="0" cellspacing="0" class="borde-azul f14" >
		<tr>
			<td width="240" class="borde-der" style="padding-left:5px;"><b>INSCRIPCIÓN:</b> <?=number_format($dt['monto'],2)?></td>
			<td width="240" class="borde-der" style="padding-left:5px;"><b>CUPÓN:</b> <?=number_format($dt['descuento'],0)?>% (<?=$dt['codigo']?>)</td>
			<td width="238" style="padding-left:5px;"><b>TOTAL:</b> <?=number_format($pago,2)?></td>
		</tr>
		<tr>
			<td colspan="3" class="borde-top" style="padding-left:5px;"><b>COLEGIATURA MENSUAL:</b> <?=number_format($colegiatura,2)?></td>
		</tr>
	</table>
	<p style="text-align:center;">Para poder hacer válido el cupón de descuento es necesario que aplique su pago en <b>línea o en caja de ceilor</b> <br>antes del <b><?=fechaLetraTres($dt['expira'])?></b></p>
	<p style="text-align:center;"><b>Este no es un comprobante de pago</b></p>




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
        $html2pdf->Output('ESTADO-CUENTA.pdf');
	}
	catch(HTML2PDF_exception $e) { echo $e; }	

?>
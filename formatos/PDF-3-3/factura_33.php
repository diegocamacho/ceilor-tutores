<? set_time_limit(0);
#error_reporting(E_ALL);
include('../num_letra.php');
include('catalogosSAT.php');

$rfc = $_GET['rfc'];
$uuid = $_GET['uuid'];
$NomArch = $uuid.'.xml';
$NombrePDF = $uuid.'.pdf';

$url_aws = "https://s3.amazonaws.com/cfdi-vault/xml/$rfc/$uuid.xml";
$cfdi_data = file_get_contents($url_aws);
$nombre_guardar = '../../facturacion/xml/'.$NomArch;

file_put_contents($nombre_guardar, $cfdi_data);

$data = file_get_contents('../../facturacion/xml/'.$NomArch);
$archivo_xml = '../../facturacion/xml/'.$NomArch;

require 'vendor/autoload.php';
use CFDIReader\CFDICleaner;
use CFDIReader\CFDICleanerException;
function procesaXML($archivo_xml){

	if(!file_exists($archivo_xml)) return false;

	try {
		$xml_content = file_get_contents($archivo_xml);
		$reader = new \CFDIReader\CFDIReader($xml_content);
		$cfdi = $reader->comprobante();
		unset($data);

		if(isset($cfdi->complemento->pagos['version'])):
			return false;
		endif;

		//Generales
		$data['version']			= (string)$cfdi['version'];
		$data['serie'] 				= (string)strtoupper($cfdi['serie']);
		$data['folio']				= (string)$cfdi['folio'];
		$data['fecha']			 	= (string)$cfdi['fecha'];
		$data['metodoPago']		 	= (string)$cfdi['metodoPago'];
		$data['formaPago']			= (string)$cfdi['formaPago'];
		$data['tipoCFDI']			= (string)$cfdi['tipoDeComprobante'];
		$data['moneda']				= (string)$cfdi['moneda'];
		$data['tipoCambio']			= (string)$cfdi['tipoCambio'];
		$data['condicionesDePago']	= (string)$cfdi['condicionesDePago'];
		$data['lugarExpedicion']	= (string)$cfdi['lugarExpedicion'];
		$data['confirmacion']	= (string)$cfdi['Confirmacion'];
		$data['subTotal']			= (float)$cfdi['subTotal'];
		$data['descuento']			= (float)$cfdi['descuento'];
		$data['total']				= (float)$cfdi['total'];
		$data['noCertificado']		= (string)$cfdi['noCertificado'];

		//Emisor
		$data['emisor_rfc']			= (string)strtoupper($cfdi->emisor['rfc']);
		$data['emisor_rs']			= (string)strtoupper($cfdi->emisor['nombre']);
		$data['regimenFiscal']		= (string)strtoupper($cfdi->emisor['regimenFiscal']);

		//Receptor
		$data['receptor_rfc'] 		= (string)strtoupper($cfdi->receptor['rfc']);
		$data['receptor_rs']		= (string)strtoupper($cfdi->receptor['nombre']);
		$data['usoCFDI']			= (string)strtoupper($cfdi->receptor['usoCFDI']);

		//Impuestos
		$data['totalImpuestosTrasladados']= (float)$cfdi->impuestos['totalImpuestosTrasladados'];

		//Complementos
		$data['fecha_timbrado'] 	= (string)$cfdi->complemento->timbreFiscalDigital["fechaTimbrado"];
		$data['fecha_timbrado'] 	= $data['fecha_timbrado'];
		$data['uuid'] 				= (string)strtoupper($cfdi->complemento->timbreFiscalDigital["UUID"]);
		$data['rfcProvCertif'] 		= (string)$cfdi->complemento->timbreFiscalDigital["rfcProvCertif"];
		$data['selloCFD']	 		= (string)$cfdi->complemento->timbreFiscalDigital["selloCFD"];
		$data['noCertificadoSAT'] 	= (string)$cfdi->complemento->timbreFiscalDigital["noCertificadoSAT"];
		$data['selloSAT'] 			= (string)$cfdi->complemento->timbreFiscalDigital["selloSAT"];

		//CFDI Relacionado
		$x=0;
		foreach($cfdi->cfdiRelacionados as $tr):

			$data['relacionado'][$x]['tipoRelacion']		=	(string)$tr['tipoRelacion'];
			$data['relacionado'][$x]['UUID_relacionado']			=	(string)$tr->cfdiRelacionado['UUID'];

			$x++;
		endforeach;

		//print_r($data);
		//print_r($cfdi);

		$c=0;
		foreach($cfdi->conceptos->concepto as $tr):

			$data['productos'][$c]['claveProdServ']		=	(string)$tr['claveProdServ'];
			$data['productos'][$c]['cantidad']			=	(float)$tr['cantidad'];
			$data['productos'][$c]['unidad']			=	(string)$tr['unidad'];
			$data['productos'][$c]['claveUnidad']		=	(string)$tr['claveUnidad'];
			$data['productos'][$c]['noIdentificacion']	=	(string)$tr['noIdentificacion'];
			$data['productos'][$c]['descripcion']		=	(string)$tr['descripcion'];
			$data['productos'][$c]['valorUnitario']		=	(float)$tr['valorUnitario'];
			$data['productos'][$c]['importe']			=	(float)$tr['importe'];
			$data['productos'][$c]['descuento']			=	(float)$tr['descuento'];



			$data['productos'][$c]['impuesto']		= (string)$tr->impuestos->traslados->traslado['impuesto'];
			$data['productos'][$c]['tasaOCuota']	= (string)$tr->impuestos->traslados->traslado['tasaOCuota'];
			$data['productos'][$c]['impuesto_importe']		= (float)$tr->impuestos->traslados->traslado['importe'];


			$c++;
		endforeach;

	return $data;

	}catch(InvalidArgumentException $e){
		return 'Error al leer el XML.';
	}

}

$datos=procesaXML($archivo_xml);

//print_r($datos);
$relacionados=$datos['relacionado'];
$conceptos=$datos['productos'];
$impuestos=$datos['imp'];

//Datos en factura
$version=$datos['version'];
$serie=$datos['serie'];
$folio=$datos['folio'];
$fecha=$datos['fecha'];
$lugarExpedicion=$datos['lugarExpedicion'];
$tipoComprobante=$datos['tipoCFDI'];

//Emisor
$emisorRFC=$datos['emisor_rfc'];
$emisorNombre=$datos['emisor_rs'];
$emisorRegimen=$datos['regimenFiscal'];

//Receptor
$receptorRFC=$datos['receptor_rfc'];
$receptorNombre=$datos['receptor_rs'];
$receptorResidencia="";
$receptorUso=$datos['usoCFDI'];
$receptorIdTrib="";

//Datos generales del comprobante
$moneda=$datos['moneda'];
$formaPago=$datos['formaPago'];
$tipoCambio=$datos['tipoCambio'];
$condicionesPago=$datos['condicionesDePago'];
$claveConfirmacion=$datos['Confirmacion'];
$metodPago=$datos['metodoPago'];

//Partidas del comprobante
/*creamos un Array */

//CFDI Relacionado
$tipoRelacion="";
$cfdiRelacionado="";

$importeLetra=mb_strtoupper(NumLet($datos['total']));
$numeroSerie=$datos['noCertificadoSAT'];
$certificadoEmisor=$datos['noCertificado'];
$fechaHoraCertificado=$datos['fecha_timbrado'];
$uuid=$datos['uuid'];

//Billete padresito
$subtotal=number_format((double)$datos['subTotal'],2);
$descuento=number_format((double)$datos['descuento'],2);
$impuestoTrasladado=number_format((double)$datos['totalImpuestosTrasladados'],2);
$impuestoRetenido=number_format((double)$datos['totalImpuestosRetenidos'],2);
$total=number_format((double)$datos['total'],2);

//Cadenas
$selloCFD=$datos['selloCFD'];
$selloSAT=$datos['selloSAT'];


//print_r($datos['conceptos']);
ob_start();

//color

$color="#395c80";

?>
<style>
.titulos{
	background-color: <?=$color?>;
	color: #FFF;
	font-weight: 600;
	/*padding-left: 5px;*/
}
.borde-azul{
	border: <?=$color?> 1px solid ;
}
.borde-iz{
	border-left: <?=$color?> 1px solid;
}
.borde-iz-titulo{
	border-right: #FFF 1px solid;
}
.borde-der{
	border-right: <?=$color?> 1px solid;
}
.borde-bot{
	border-bottom: <?=$color?> 1px solid;
}
b{
	font-family: sfsemi;
}
table{
	font-family: sf;
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
.strip{
	background-color: <?=$color?>;
	color: #FFF;
}
.indice{
	color: <?=$color?>;
	font-weight: 600;
	padding-left: 10px;
}
.row0{
	background-color: #FFF;
}
.row1{
	background-color: #f2f2f2;
}
</style>

<page backtop="75mm" backbottom="59mm" backleft="0mm" backright="2mm" footer="page">

	<page_header>
		<table width="795" border="0" cellpadding="0" cellspacing="0" class="f11">
			<tr>
				<td width="495" valign="top">
					<table width="495" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td width="495" height="100" valign="middle">
								<?if($emisorRFC=="UNBE6005078B2" && $serie=="CP"){?>
									<img src="../logo_compu.png" height="80" />
			        			<?}elseif($emisorRFC=="UNBE6005078B2" && $serie=="B"){?>
									<img src="../logo_sqroo.jpg" height="80" />
			        			<?}elseif($emisorRFC=="CALM900222LL3"){?>
									<img src="../logo_clanz.jpg" height="80" />
			        			<?}elseif($emisorRFC=="PEMC900817DGA"){?>
									<img src="../logo_cc.jpg" height="80" />
			        			<?}else{?>
									<img src="../../files/872342.png" height="50" />
			        			<?}?>
							</td>
						</tr>
					</table>
				</td>
				<td width="280" valign="top">
					<table width="280" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td width="150" height="20" valign="top" style="text-align:right;" valign="middle" >Serie: &nbsp;</td>
							<td width="143" height="20" valign="top" valign="middle"><?=$serie?></td>
						</tr>
						<tr class="strip">
							<td width="150" height="20" valign="top" style="text-align:right;" valign="middle">Folio: &nbsp;</td>
							<td width="143" height="20" valign="top" valign="middle"><?=$folio?></td>
						</tr>
						<tr>
							<td width="150" height="20" valign="top" style="text-align:right;" valign="middle">Fecha: &nbsp;</td>
							<td width="143" height="20" valign="top" valign="middle"><?=$fecha?></td>
						</tr>
						<tr class="strip">
							<td width="150" height="20" valign="top" style="text-align:right;" valign="middle">Lugar Expedición: &nbsp;</td>
							<td width="143" height="20" valign="top" valign="middle"><?=$lugarExpedicion?></td>
						</tr>
						<tr>
							<td width="150" height="20" valign="top" style="text-align:right;" valign="middle">Tipo de Comprobante: &nbsp;</td>
							<td width="143" height="20" valign="top" valign="middle"><?=$tipoComprobante?> - <?=dameTipoComprobante($tipoComprobante)?></td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
<!-- datos del emisor -->
		<table width="795" border="0" cellpadding="0" cellspacing="0" class="borde-azul f11">
			<tr>
				<td width="795" valign="middle" class="titulos f12" align="center" colspan="2">EMISOR</td>
			</tr>
			<tr>
				<td width="295" valign="middle" class=""><b class="indice">RFC: </b> <?=$emisorRFC?></td>
				<td width="500" valign="middle" class=""><b class="indice">Nombre: </b> <?=$emisorNombre?></td>
			</tr>
			<tr>
				<td width="795" valign="middle" colspan="2"><b class="indice">Régimen Fiscal: </b> <?=$emisorRegimen?> - <?=dameRegimenFiscal($emisorRegimen)?></td>
			</tr>
		</table>
<!-- Datos del receptor -->
		<table width="795" border="0" cellpadding="0" cellspacing="0" class="borde-azul f11">
			<tr>
				<td width="795" valign="middle" class="titulos f12" align="center" colspan="2">RECEPTOR</td>
			</tr>
			<tr>
				<td width="295" valign="middle" class=""><b class="indice">RFC: </b> <?=$receptorRFC?></td>
				<td width="500" valign="middle" class=""><b class="indice">Nombre: </b> <?=$receptorNombre?></td>
			</tr>
			<tr>
				<td width="295" valign="middle" class=""><b class="indice">Residencia Físcal: </b> <?=$receptorResidencia?></td>
				<td width="500" valign="middle" class=""><b class="indice">Uso CFDI: </b> <?=$receptorUso?> - <?=dameUsoCFDI($receptorUso)?></td>
			</tr>
			<tr>
				<td width="795" valign="middle" colspan="2"><b class="indice">NumRegIdTrib: </b><?=$receptorIdTrib?> </td>
			</tr>
		</table>
<!-- Datos generales del comprobante -->
		<table width="795" border="0" cellpadding="0" cellspacing="0" class="borde-azul f11">
			<tr>
				<td width="795" valign="middle" class="titulos f12" align="center" colspan="2">DATOS GENERALES DEL COMPROBANTE</td>
			</tr>
			<tr>
				<td width="400" valign="middle" class=""><b class="indice">Moneda: </b> <?=$moneda?> - <?=dameMoneda($moneda)?></td>
				<td width="395" valign="middle" class=""><b class="indice">Forma Pago: </b> <?=$formaPago?> - <?=dameFormaPago($formaPago)?></td>
			</tr>
			<tr>
				<td width="400" valign="middle" class=""><b class="indice">Tipo de Cambio: </b> <?=$tipoCambio?></td>
				<td width="395" valign="middle" class=""><b class="indice">Condiciones de Pago: </b> <?=$condicionesPago?></td>
			</tr>
			<tr>
				<td width="400" valign="middle" class=""><b class="indice">Clave Confirmación: </b> <?=$claveConfirmacion?></td>
				<td width="395" valign="middle" class=""><b class="indice">Método de Pago: </b> <?=$metodPago?> - <?=dameMetodoPago($metodPago)?></td>
			</tr>
		</table>

	</page_header>



<!-- Footer -->
<page_footer>
	<table width="795" border="0" cellpadding="0" cellspacing="0" class="f10">
		<tr>
			<td width="200" valign="middle" align="center" rowspan="3">
				<?
				$Cadena = "?re=".$emisorRFC."&rr=".$receptorRFC."&tt=".$total."&id=".$uuid; ?>
				<qrcode value="<?=$Cadena?>" ec="H" style="width: 159px; border: none; background-color: white; color: black;"></qrcode>
			</td>
			<td width="595" height="60" valign="middle"><b class="indice">Sello digital: </b>
				<? $arrCadena = str_split($selloCFD,90);
				foreach($arrCadena as $val): ?>
				 <?= $val ?><br/>
				<? endforeach; ?>
			</td>
		</tr>
		<tr>
			<td width="595" height="60" valign="middle"><b class="indice">Sello del SAT: </b>
				<? $arrCadena = str_split($selloSAT,90);
				foreach($arrCadena as $val): ?>
				 <?= $val ?><br/>
				<? endforeach; ?>
			</td>
		</tr>
		<tr>
			<td width="595" height="60" valign="middle"><b class="indice">Cadena Original: </b>
				<?php

				$cadenaOriginal =  $version.'|'.$uuid.'|'.$fechaHoraCertificado.'|'.$selloCFD.'|'.$numeroSerie.'||';
				$arrCadena = str_split($cadenaOriginal,90);

				foreach($arrCadena as $val): ?>
				 <?= $val ?><br/>
				<? endforeach; ?>
			</td>
		</tr>
	</table>

	<!-- Firma rey -->
	<table width="780" border="0" cellpadding="0" cellspacing="0" class="f11">
		<tr>
			<td width="300" style="padding-top: 10px;padding-bottom: 16px;">Descarga tus facturas desde el SAT automáticamente: <b>www.adminus.mx</b></td>
			<td width="480" style="padding-top: 10px;padding-bottom: 16px;">Este documento es una representación impresa de un CFDI</td>
		</tr>
	</table>
</page_footer>

<!-- Partidas del comprobante (los productos coneo) -->
<table width="798" border="0" cellpadding="0" cellspacing="0" class="borde-azul f11" style="border-bottom: 1px solid #FFF;">
	<tr>
		<td width="798" valign="middle" class="titulos f12" align="center" >PARTIDAS DEL COMPROBANTE</td>
	</tr>
</table>

<table width="795" cellpadding="0" cellspacing="0" class="borde-azul f11">
	<thead>
    	<tr class="titulos">
			<th width="70" height="25" class="f10 borde-iz-titulo" align="center">ClaveProdServ</th>
			<th width="60" height="25" class="f10 borde-iz-titulo" align="center">Número Identificación</th>
			<th width="40" height="25" class="f10 borde-iz-titulo" align="center">Cantidad</th>
			<th width="40" height="25" class="f10 borde-iz-titulo" align="center">Clave Unidad</th>
			<th width="50" height="25" class="f10 borde-iz-titulo" align="center">Unidad</th>
			<th width="155" height="25" class="f10 borde-iz-titulo" align="center">Descripción</th>
			<th width="70" height="25" class="f10 borde-iz-titulo" align="center">Valor Unitario</th>
			<th width="50" height="25" class="f10 borde-iz-titulo" align="center">Descuento</th>
			<th width="115" height="25" class="f10 borde-iz-titulo" colspan="2" style="text-align:center;">Impuesto</th>
			<th width="80" height="25" class="f10" align="right" style="padding-right: 5px;">Importe</th>
		</tr>
	</thead>
	<tbody>
		<? foreach($conceptos as $id => $res): ?>
    	<tr class="row<?php echo($i++ & 1 );?>">
			<td width="70" class="f10 borde-der" align="center"><?=$res['claveProdServ']?></td>
			<td width="60" class="f10 borde-der" align="center">
				<? $noIdentificacion = str_split($res['noIdentificacion'],10);
				foreach($noIdentificacion as $val): ?>
				 <?= $val ?><br/>
				<? endforeach; ?>
			</td>
			<td width="40" class="f10 borde-der" align="center"><?=$res['cantidad']?></td>
			<td width="40" class="f10 borde-der" align="center"><?=$res['claveUnidad']?></td>
			<td width="50" class="f10 borde-der" align="center"><?=$res['unidad']?></td>
			<td width="155" class="f10 borde-der"><?=$res['descripcion']?></td>
			<td width="70" class="f10 borde-der" align="right"><? echo number_format((double)$res['valorUnitario'],2) ?>&nbsp;</td>
			<td width="50" class="f10 borde-der" align="right"><? echo number_format((double)$res['descuento'],2) ?>&nbsp;</td>
			<td width="60" class="f10 borde-der" align="center"><?=$res['impuesto']?> - <?=dameImpuesto($res['impuesto'])?></td>
			<td width="55" class="f10 borde-der" align="right"><?=number_format((double)$res['impuesto_importe'],2)?></td>
			<td width="80" class="f10" align="right"><?=number_format((double)$res['importe'],2)?></td>
		</tr>
	<? endforeach; ?>
	</tbody>
</table>

<!-- CFDI Relacionado -->
<? if($relacionados): ?>
<table width="795" border="0" cellpadding="0" cellspacing="0" class=" f11">
	<tr>
		<td width="795" valign="middle" class="titulos f12" align="center" colspan="2">CFDI RELACIONADO</td>
	</tr>
	<? foreach($relacionados as $res): ?>
	<tr>
		<td width="397" valign="middle" class=""><b class="indice">Tipo Relación: </b> <?=$res['tipoRelacion']?> <? if($res['tipoRelacion']): echo " - ".dameTipoRelacion($res['tipoRelacion']); endif; ?></td>
		<td width="398" valign="middle" class=""><b class="indice">CFDI Relacionado: </b> <?=$res['UUID_relacionado']?></td>
	</tr>
	<? endforeach; ?>
</table>
<hr style="border: <?=$color?> 0.5px solid;">
<? endif; ?>
<!-- Tipos de relaciones y deducciones -->
<table width="795" border="0" cellpadding="0" cellspacing="0" class="f11">
	<tr>
		<td width="395" valign="top">
			<table width="395" border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td width="395" valign="middle" class=""><b class="indice">Importe con letra: </b></td>
				</tr>
				<tr>
					<td width="395" valign="middle" class=""><?=$importeLetra?></td>
				</tr>

				<tr>
					<td width="395" valign="middle" class=""><b class="indice">Número de Serie del Certificado SAT: </b></td>
				</tr>
				<tr>
					<td width="395" valign="middle" class=""><?=$numeroSerie?></td>
				</tr>
				<tr>
					<td width="395" valign="middle" class=""><b class="indice">Número de Serie del Certificado del Emisor: </b></td>
				</tr>
				<tr>
					<td width="395" valign="middle" class=""><?=$certificadoEmisor?></td>
				</tr>
				<tr>
					<td width="395" valign="middle" class=""><b class="indice">Fecha y Hora de Certificación: </b></td>
				</tr>
				<tr>
					<td width="395" valign="middle" class=""><?=$fechaHoraCertificado?></td>
				</tr>
				<tr>
					<td width="395" valign="middle" class=""><b class="indice">Folio Fiscal - UUID: </b></td>
				</tr>
				<tr>
					<td width="395" valign="middle" class=""><?=$uuid?></td>
				</tr>
			</table>
		</td>
		<td width="400" valign="top">
			<table width="400" border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td width="290" valign="middle" align="right"><b class="indice">Sub Total: </b>&nbsp;</td>
					<td width="100" valign="middle" align="right"><?=$subtotal?></td>
				</tr>
				<tr>
					<td width="290" valign="middle" align="right"><b class="indice">Descuento: </b>&nbsp;</td>
					<td width="100" valign="middle" align="right"><?=$descuento?></td>
				</tr>
				<tr>
					<td width="290" valign="middle" align="right"><b class="indice">Total Impuestos Trasladados: </b>&nbsp;</td>
					<td width="100" valign="middle" align="right"><?=$impuestoTrasladado?></td>
				</tr>
				<tr>
					<td width="290" valign="middle" align="right"><b class="indice">Total Impuestos Retenidos: </b>&nbsp;</td>
					<td width="100" valign="middle" align="right"><?=$impuestoRetenido?></td>
				</tr>
				<tr>
					<td width="290" valign="middle" align="right"><b class="indice">Total Comprobante: </b>&nbsp;</td>
					<td width="100" valign="middle" align="right"><?=$total?></td>
				</tr>
			</table>
		</td>
	</tr>
</table>
</page>

<?php

	$content_html = ob_get_clean();

	// initialisation de HTML2PDF
	require_once(dirname(__FILE__).'/../pdf/html2pdf.class.php');
	try
	{
		$html2pdf = new HTML2PDF('P','letter','es', true, 'UTF-8', array(2, 0, 0, 0));
		$html2pdf->pdf->SetDisplayMode('fullpage');

		$html2pdf->addFont("sf");
		$html2pdf->addFont("sfsemi");
		//$html2pdf = new HTML2PDF('L','A4','es', false, 'utf-8', array(0, 0, 0, 0));
		$html2pdf->writeHTML($content_html, isset($_GET['vuehtml']));
//		$html2pdf->createIndex('Sommaire', 25, 12, false, true, 1);
		$html2pdf->Output('../../facturacion/pdf/'.$NombrePDF, 'F');
		//$html2pdf->Output('../../facturacion/pdf/'.$NombrePDF);
	}
	catch(HTML2PDF_exception $e) { $e; }

?>

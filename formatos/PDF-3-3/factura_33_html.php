<?
set_time_limit(0);
//error_reporting(0);

include('../../includes/db.php');
//include('../../includes/session.php');
include('../../includes/funciones.php');
include('../num_letra.php');
include('catalogosSAT.php');


$id_factura = mysqli_real_escape_string($db,$_GET['id']);

if(!is_numeric($id_factura)) exit('ID incorrecto.');

$sql = "SELECT * FROM facturacion WHERE id_facturacion = $id_factura";
$q = mysqli_query($db, $sql);
$n = mysqli_num_rows($q);
if(!$n) exit('Error.');

$data = mysqli_fetch_assoc($q);
//$uuid = $data['uuid'];
//$rfc_e = $data['rfc'];

	$ruta_xml = $data['url_factura'];
	$link_xml = $data['url_factura'];
	$link_pdf = $data['url_pdf'];
	$link_zip = $data['url_zip'];

//$archivo_xml="https://s3.amazonaws.com/cfdi-vault/xml/DOC160429N55/48E11A0E-4B00-4B31-B4AE-630061C7E00A.xml";

require 'vendor/autoload.php';
use CFDIReader\CFDICleaner;
use CFDIReader\CFDICleanerException;
function procesaXML($archivo_xml){

	try {
		$xml_content = file_get_contents($archivo_xml);
		$reader = new \CFDIReader\CFDIReader($xml_content);
		$cfdi = $reader->comprobante();

		unset($data);

		if(isset($cfdi->complemento->pagos['version'])):
			return false;
			//echo "pedos";
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
		$data['confirmacion']		= (string)$cfdi['Confirmacion'];
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
		$data['totalImpuestosRetenidos']= (float)$cfdi->impuestos['totalImpuestosRetenidos'];

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
		//echo "Entra";
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

			//Retenciones
			$data['productos'][$c]['retencion_impuesto']		= (float)$tr->impuestos->retenciones->retencion['impuesto'];
			$data['productos'][$c]['retencion_cuota']		= (float)$tr->impuestos->retenciones->retencion['tasaOCuota'];
			$data['productos'][$c]['retencion_importe']		= (float)$tr->impuestos->retenciones->retencion['importe'];

			//Complemento Educativo
			$data['productos'][$c]['alumno']		= (string)$tr->complementoConcepto->instEducativas['nombreAlumno'];
			$data['productos'][$c]['curp']		= (string)$tr->complementoConcepto->instEducativas['CURP'];
			$data['productos'][$c]['nivelEducativo']		= (string)$tr->complementoConcepto->instEducativas['nivelEducativo'];
			$data['productos'][$c]['rvoe']		= (string)$tr->complementoConcepto->instEducativas['autRVOE'];
			$data['productos'][$c]['rfcPago']		= (string)$tr->complementoConcepto->instEducativas['rfcPago'];


			$c++;
		endforeach;

	return $data;

	}catch(InvalidArgumentException $e){
		return 'Error al leer el XML.';
	}

}

$datos=procesaXML($ruta_xml);

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
/*creamos un Array*/

//CFDI Relacionado
$tipoRelacion="";
$cfdiRelacionado="";

$importeLetra=mb_strtoupper(NumLet($datos['total']));
$numeroSerie=$datos['noCertificado'];
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
?>


	<style>
		.titulos{
			background-color: #003a5d;
			color: #FFF;
			/*padding-left: 5px;*/
		}
		.borde-azul{
			border: #003a5d 1px solid ;
		}
		.borde-iz{
			border-left: #003a5d 1px solid;
		}
		.borde-der{
			border-right: #003a5d 1px solid;
		}
		.borde-bot{
			border-bottom: #003a5d 1px solid;
		}
		.borde-top{
			border-top: #003a5d 1px solid;
		}

		.f11{
			font-family: 'Arial';
			font-size: 11px;
		}
		.f10{
			font-family: 'Arial';
			font-size: 10px;
		}
	</style>

	<div class="modal-footer">
		<a role="button" data-log="14" class="log btn red-thunderbird" href="<?=$link_zip?>" target="_blank" >Descargar XML y PDF</a>
		<a role="button" data-log="14" class="log btn red-thunderbird" href="<?=$link_xml?>" target="_blank" >Descargar XML</a>
		<a role="button" data-log="13" class="log btn red-thunderbird" href="<?=$link_pdf?>" target="_blank" >Descargar PDF</a>
		<button type="button" class="btn blue" data-dismiss="modal" id="btn_cierra_modal">Cerrar</button>
	</div>

	<table width="780" border="0" cellpadding="0" cellspacing="0" class="f11" align="center">
		<tr>

			<td width="500" valign="top">
				<img src="LOGO_CEILOR.png" border="0" style="height:90px;" />
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
			<table width="795" border="0" cellpadding="0" cellspacing="0" class="borde-azul f11" align="center">
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
			<table width="795" border="0" cellpadding="0" cellspacing="0" class="borde-azul f11" align="center">
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
			<table width="795" border="0" cellpadding="0" cellspacing="0" class="borde-azul f11" align="center">
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

			<!-- Partidas del comprobante (los productos coneo) -->
			<table width="798" border="0" cellpadding="0" cellspacing="0" class="borde-azul f11" style="border-bottom: 1px solid #FFF;" align="center">
				<tr>
					<td width="798" valign="middle" class="titulos f12" align="center" >PARTIDAS DEL COMPROBANTE</td>
				</tr>
			</table>

			<table width="795" cellpadding="0" cellspacing="0" class="borde-azul f11" align="center">
				<thead>
			    	<tr class="titulos">
						<th width="70" height="25" class="f10 borde-iz-titulo" align="center">ClaveProdServ</th>
						<th width="60" height="25" class="f10 borde-iz-titulo" align="center">Número Identificación</th>
						<th width="40" height="25" class="f10 borde-iz-titulo" align="center">Cantidad</th>
						<th width="40" height="25" class="f10 borde-iz-titulo" align="center">Clave Unidad</th>
						<th width="50" height="25" class="f10 borde-iz-titulo" align="center">Unidad</th>
						<th width="155" height="25" class="f10 borde-iz-titulo" align="center">Descripción</th>
						<th width="70" height="25" class="f10 borde-iz-titulo" align="center">Valor Unitario</th>
						
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
						<!--
						<td width="50" class="f10 borde-der" align="right"><? //echo number_format((double)$res['descuento'],2) ?>&nbsp;</td>
						<td width="60" class="f10 borde-der" align="center">
							<?
							if($res['impuesto']){
								echo $res['impuesto']." - ".dameImpuesto($res['impuesto']);
							}
							if($res['retencion_impuesto']){
								echo $res['retencion_impuesto']." - ".dameImpuesto($res['retencion_impuesto']);
							}
							?>
						</td>
						<td width="55" class="f10 borde-der" align="right">
							<?
							if($res['impuesto_importe']){
								echo number_format((double)$res['impuesto_importe'],2);
							}

							if($res['retencion_importe']){
								echo number_format((double)$res['retencion_importe'],2);
							}

							?>
						</td>-->
						<td width="80" class="f10" align="right"><?=number_format((double)$res['importe'],2)?></td>
					</tr>
					<tr>
						<td class="f10 borde-top" style="padding-left: 10px;" colspan="8">
						<br>
							<b>COMPLEMENTO INSTITUCIONES EDUCATIVAS</b><br>
							ALUMNO: <?=$res['alumno']?><br>
							CURP: <?=$res['curp']?><br>
							NIVEL EDUCATIVO: <?=$res['nivelEducativo']?><br>
							RVOE: <?=$res['rvoe']?><br>
							RFC SOLICITANTE: <?=$res['rfcPago']?><br><br>
						</td>
					</tr>
				<? endforeach; ?>
				</tbody>
			</table>


			<!-- Tipos de relaciones y deducciones -->
			<table width="795" border="0" cellpadding="0" cellspacing="0" class="f11" align="center">
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
								<td width="395" valign="middle" class=""><b class="indice">Número de Serie del Certificado: </b></td>
							</tr>
							<tr>
								<td width="395" valign="middle" class=""><?=$numeroSerie?></td>
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
							<!--
							<tr>
								<td width="290" valign="middle" align="right"><b class="indice">Descuento: </b>&nbsp;</td>
								<td width="100" valign="middle" align="right"><?//$descuento?></td>
							</tr>
							<tr>
								<td width="290" valign="middle" align="right"><b class="indice">Total Impuestos Trasladados: </b>&nbsp;</td>
								<td width="100" valign="middle" align="right"><?=$impuestoTrasladado?></td>
							</tr>
							<tr>
								<td width="290" valign="middle" align="right"><b class="indice">Total Impuestos Retenidos: </b>&nbsp;</td>
								<td width="100" valign="middle" align="right"><?=$descuento?></td>
							</tr>-->
							<tr>
								<td width="290" valign="middle" align="right"><b class="indice">Total Comprobante: </b>&nbsp;</td>
								<td width="100" valign="middle" align="right"><?=$total?></td>
							</tr>
						</table>
					</td>
				</tr>
			</table>



<div class="modal-footer">

</div>

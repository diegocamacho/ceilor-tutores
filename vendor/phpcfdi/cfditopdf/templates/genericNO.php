<?php

declare(strict_types=1);

/** @noinspection PhpFullyQualifiedNameUsageInspection */
/** @var \League\Plates\Template\Template $this */
/** @var \PhpCfdi\CfdiToPdf\CfdiData $cfdiData */
$comprobante = $cfdiData->comprobante();
$emisor = $cfdiData->emisor();
$receptor = $cfdiData->receptor();
$tfd = $cfdiData->timbreFiscalDigital();
$relacionados = $comprobante->searchNode('cfdi:CfdiRelacionados');
$impuestos = $comprobante->searchNode('cfdi:Impuestos');
$totalImpuestosTrasladados = $comprobante->searchAttribute('cfdi:Impuestos', 'TotalImpuestosTrasladados');
$totalImpuestosRetenidos = $comprobante->searchAttribute('cfdi:Impuestos', 'TotalImpuestosRetenidos');
$conceptos = $comprobante->searchNodes('cfdi:Conceptos', 'cfdi:Concepto');
$pagos = $comprobante->searchNodes('cfdi:Complemento', 'pago10:Pagos', 'pago10:Pago');
$conceptoCounter = 0;
$conceptoCount = $conceptos->count();
$pagoCounter = 0;
$pagoCount = $pagos->count();

$logo="http://ceilor.us-east-2.elasticbeanstalk.com/app/LOGO_CEILOR.png";
$color="#07470a";

?>



<page footer="page">


        
    
        <page_header>
            <table width="795" border="0" cellpadding="0" cellspacing="0" class="f11">
                <tr>
                    <td width="495" valign="top">
                        <table width="495" border="0" cellpadding="0" cellspacing="0">
                            <tr>
                                <td width="495" height="100" valign="middle">
                                    <img src="<?=$logo?>" height="80" />
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td width="280" valign="top">
                        <table width="280" border="0" cellpadding="0" cellspacing="0">
                            <tr>
                                <td width="150" height="20" valign="top" style="text-align:right;" valign="middle" >Serie: &nbsp;</td>
                                <td width="143" height="20" valign="top" valign="middle"><?=$this->e($comprobante['Serie'])?></td>
                            </tr>
                            <tr class="strip">
                                <td width="150" height="20" valign="top" style="text-align:right;" valign="middle">Folio: &nbsp;</td>
                                <td width="143" height="20" valign="top" valign="middle"><?=$this->e($comprobante['Folio'])?></td>
                            </tr>
                            <tr>
                                <td width="150" height="20" valign="top" style="text-align:right;" valign="middle">Fecha: &nbsp;</td>
                                <td width="143" height="20" valign="top" valign="middle"><?=$this->e($comprobante['Fecha'])?></td>
                            </tr>
                            <tr class="strip">
                                <td width="150" height="20" valign="top" style="text-align:right;" valign="middle">Lugar Expedición: &nbsp;</td>
                                <td width="143" height="20" valign="top" valign="middle"><?=$this->e($comprobante['LugarExpedicion'])?></td>
                            </tr>
                            <tr>
                                <td width="150" height="20" valign="top" style="text-align:right;" valign="middle">Tipo de Comprobante: &nbsp;</td>
                                <td width="143" height="20" valign="top" valign="middle"><?=$this->e($comprobante['TipoDeComprobante'])?></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
    
            <table width="795" border="0" cellpadding="0" cellspacing="0" class="borde-azul f11">
                <tr>
                    <td width="795" valign="middle" class="titulos f12" align="center" colspan="2">EMISOR</td>
                </tr>
                <tr>
                    <td width="295" valign="middle" class=""><b class="indice">RFC: </b><?=$this->e($emisor['Rfc'])?> </td>
                    <td width="500" valign="middle" class=""><b class="indice">Nombre: </b> <?=$this->e($emisor['Nombre'] ? : 'No se especificó el nombre del emisor')?></td>
                </tr>
                <tr>
                    <td width="795" valign="middle" colspan="2"><b class="indice">Régimen Fiscal: </b> <?=$this->e($emisor['RegimenFiscal'])?></td>
                </tr>
            </table>
    
            <table width="795" border="0" cellpadding="0" cellspacing="0" class="borde-azul f11">
                <tr>
                    <td width="795" valign="middle" class="titulos f12" align="center" colspan="2">RECEPTOR</td>
                </tr>
                <tr>
                    <td width="295" valign="middle" class=""><b class="indice">RFC: </b> <?=$this->e($receptor['Rfc'])?></td>
                    <td width="500" valign="middle" class=""><b class="indice">Nombre: </b> <?=$this->e($receptor['Nombre'] ? : '(No se especificó el nombre del receptor)')?></td>
                </tr>
                <tr>
                    <td width="295" valign="middle" class=""><?php if ('' !== $receptor['ResidenciaFiscal']) : ?>
                        <b class="indice">Residencia fiscal: </b><?=$this->e($receptor['ResidenciaFiscal'])?>
                    <?php endif; ?>
                    <?php if ('' !== $receptor['NumRegIdTrib']) : ?>
                        <b class="indice">Residencia fiscal: </b><?=$this->e($receptor['NumRegIdTrib'])?>
                    <?php endif; ?></td>
                    <td width="500" valign="middle" class=""><b class="indice">Uso CFDI: </b> <?=$this->e($receptor['UsoCFDI'])?></td>
                </tr>
                
                <tr>
                    <td width="795" valign="middle" colspan="2"><b class="indice">NumRegIdTrib: </b> </td>
                </tr>
                
            </table>
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
                    <td width="595" height="60" valign="middle"><b class="indice">Sello CFDI: </b>
                        <?=$this->e(chunk_split($tfd['SelloCFD'], 100))?>
                    </td>
                </tr>
                <tr>
                    <td width="595" height="60" valign="middle"><b class="indice">Sello del SAT: </b>
                        <?=$this->e(chunk_split($tfd['SelloSAT'], 100))?>
                    </td>
                </tr>
                <tr>
                    <td width="595" height="60" valign="middle"><b class="indice">Cadena TFD:</b>
                        <?=$this->e(chunk_split($cfdiData->tfdSourceString(), 100))?>
                    </td>
                </tr>
                <tr>
                    <td width="595" height="60" valign="middle"><b class="indice">Verificación:</b>
                        <a href="<?=$this->e($cfdiData->qrUrl())?>">
                        <?=$this->e(str_replace('?', "\n?", $cfdiData->qrUrl()))?>
                        </a>
                    </td>
                </tr>
            </table>
        
            <!-- Firma rey -->
            <table width="780" border="0" cellpadding="0" cellspacing="0" class="f11">
                <tr>
                    <td width="300" style="padding-top: 10px;padding-bottom: 16px;padding-left:20px;">POWERED BY FILÁNTROPICA Y EDUCATIVA DEL SUR DE QUINTANA ROO AC</td>
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
                    
                    <th width="80" height="25" class="f10" align="right" style="padding-right: 5px;">Importe</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($conceptos as $concepto) :
                    $conceptoCounter = $conceptoCounter + 1;
                    $conceptoTraslados = $concepto->searchNodes('cfdi:Impuestos', 'cfdi:Traslados', 'cfdi:Traslado');
                    $conceptoRetenciones = $concepto->searchNodes('cfdi:Impuestos', 'cfdi:Retenciones', 'cfdi:Retencion');
                ?>
                <tr class="row<?php echo($i++ & 1 );?>">
                    <td width="70" class="f10 borde-der" align="center"><?=$this->e($concepto['ClaveProdServ'])?></td>
                    <td width="60" class="f10 borde-der" align="center"><?=$this->e($concepto['NoIdentificacion'] ? : 'N/A')?></td>
                    <td width="40" class="f10 borde-der" align="center"><?=$this->e($concepto['Cantidad'])?></td>
                    <td width="40" class="f10 borde-der" align="center"><?=$this->e($concepto['ClaveUnidad'])?></td>
                    <td width="50" class="f10 borde-der" align="center"><?=$this->e($concepto['Unidad'] ? : 'N/A')?></td>
                    <td width="155" class="f10 borde-der"><?=$this->e($concepto['Descripcion'])?></td>
                    <td width="70" class="f10 borde-der" align="right"><?=$this->e($concepto['ValorUnitario']) ?></td>
                    <td width="50" class="f10 borde-der" align="right"></td>
                    <td width="80" class="f10" align="right"> <?=$this->e($parte['Importe'] ? : '0')?></td>
                </tr>
                <?php foreach ($concepto->searchNodes('cfdi:InformacionAduanera') as $informacionAduanera) : ?>
                    <tr><td colspan="11" class="f10" align="center">Pedimento: <?=$this->e($informacionAduanera['NumeroPedimento'])?></td></tr>
                <?php endforeach; ?>
                <?php foreach ($concepto->searchNodes('cfdi:CuentaPedial') as $cuentaPredial) : ?>
                    <tr><td colspan="11" class="f10" align="center">Cuenta predial: <?=$this->e($cuentaPredial['Numero'])?></td></tr>
                <?php endforeach; ?>
                <?php foreach ($concepto->searchNodes('cfdi:Parte') as $parte) : ?>
                    <tr><td colspan="11" class="f10" align="center">
                        <strong>Parte: <?=$this->e($parte['Descripcion'])?></strong>,
                        <br/>
                        <span>Clave SAT: <?=$this->e($parte['ClaveProdServ'])?>,</span>
                        <span>No identificación: <?=$this->e($parte['NoIdentificacion'] ? : '(ninguno)')?>,</span>
                        <span>Cantidad: <?=$this->e($parte['Cantidad'])?>,</span>
                        <span>Unidad: <?=$this->e($parte['Unidad'] ? : '(ninguna)')?>,</span>
                        <span>Valor unitario: <?=$this->e($parte['ValorUnitario'] ? : '0')?></span>,
                        <span>Importe: <?=$this->e($parte['Importe'] ? : '0')?></span>
                        <?php foreach ($parte->searchNodes('cfdi:InformacionAduanera') as $informacionAduanera) : ?>
                            <br/>Pedimento: <?=$this->e($informacionAduanera['NumeroPedimento'])?>
                        <?php endforeach; ?>
                    </td></tr>
                <?php endforeach; ?>
                <?php foreach ($conceptoTraslados as $impuesto) : ?>
                    <tr><td colspan="11" class="f10" align="left">
                        <strong>Traslado</strong>
                        Impuesto: <?=$this->e($impuesto['Impuesto'])?>,
                        Base: <?=$this->e($impuesto['Base'])?>,
                        Tipo factor: <?=$this->e($impuesto['TipoFactor'])?>,
                        Tasa o cuota: <?=$this->e($impuesto['TasaOCuota'])?>,
                        <strong>Importe: <?=$this->e($impuesto['Importe'])?></strong>
                    </td></tr>
                <?php endforeach; ?>
            <? endforeach; ?>
            </tbody>
        </table>
        
        <!-- CFDI Relacionado -->
        <?php if (null !== $relacionados) : ?>
        <table width="795" border="0" cellpadding="0" cellspacing="0" class=" f11">
            <tr>
                <td width="795" valign="middle" class="titulos f12" align="center" colspan="2">CFDI Relacionados (Tipo de relación: <?=$this->e($relacionados['TipoRelacion'])?>)</td>
            </tr>
            <?php foreach ($relacionados->searchNodes('cfdi:CfdiRelacionado') as $relacionado) : ?>
            <tr>
                <td width="795" valign="middle" class=""><b class="indice">UUID: <?=$relacionado['UUID']?></td>
            </tr>
            <? endforeach; ?>
        </table>
        <hr style="border: <?=$color?> 0.5px solid;">
        <?php endif; ?>
        <!-- Tipos de relaciones y deducciones -->
        <table width="795" border="0" cellpadding="0" cellspacing="0" class="f11">
            <tr>
                <td width="395" valign="top">
                    <table width="395" border="0" cellpadding="0" cellspacing="0">
                        <!--
                        <tr>
                            <td width="395" valign="middle" class=""><b class="indice">Importe con letra: </b></td>
                        </tr>
                        <tr>
                            <td width="395" valign="middle" class=""><?=$importeLetra?></td>
                        </tr>
                        -->
                        <tr>
                            <td width="395" valign="middle" class=""><b class="indice">Certificado SAT:</b></td>
                        </tr>
                        <tr>
                            <td width="395" valign="middle" class=""><?=$this->e($tfd['NoCertificadoSAT'])?></td>
                        </tr>
                        <tr>
                            <td width="395" valign="middle" class=""><b class="indice">Certificado emisor: </b></td>
                        </tr>
                        <tr>
                            <td width="395" valign="middle" class=""><?=$this->e($comprobante['NoCertificado'])?></td>
                        </tr>
                        <tr>
                            <td width="395" valign="middle" class=""><b class="indice">Fecha de Certificación: </b></td>
                        </tr>
                        <tr>
                            <td width="395" valign="middle" class=""><?=$this->e($tfd['FechaTimbrado'])?></td>
                        </tr>
                        <tr>
                            <td width="395" valign="middle" class=""><b class="indice">Folio Fiscal - UUID: </b></td>
                        </tr>
                        <tr>
                            <td width="395" valign="middle" class=""><?=$this->e($tfd['UUID'])?></td>
                        </tr>
                    </table>
                </td>
                <td width="400" valign="top">
                    <table width="400" border="0" cellpadding="0" cellspacing="0">
                        <!--
                        <tr>
                            <td width="290" valign="middle" align="right"><b class="indice">Sub Total: </b>&nbsp;</td>
                            <td width="100" valign="middle" align="right"><?=$subtotal?></td>
                        </tr>
                        <tr>
                            <td width="290" valign="middle" align="right"><b class="indice">Descuento: </b>&nbsp;</td>
                            <td width="100" valign="middle" align="right"><?=$descuento?></td>
                        </tr>
                        -->
                        <?php
                        $traslados = $impuestos->searchNodes('cfdi:Traslados', 'cfdi:Traslado');
                        $retenciones = $impuestos->searchNodes('cfdi:Retenciones', 'cfdi:Retencion');
                        ?>
                        <table style="width: 94%">
                            <tr>
                                <th style="width: 20%">Tipo</th>
                                <th style="width: 20%">Impuesto</th>
                                <th style="width: 20%">Tipo factor</th>
                                <th style="width: 20%">Tasa o cuota</th>
                                <th style="width: 20%">Importe</th>
                            </tr>
                            <?php foreach ($traslados as $impuesto) : ?>
                                <tr>
                                    <th>Traslado</th>
                                    <td><?=$this->e($impuesto['Impuesto'])?></td>
                                    <td><?=$this->e($impuesto['TipoFactor'])?></td>
                                    <td><?=$this->e($impuesto['TasaOCuota'])?></td>
                                    <td><?=$this->e($impuesto['Importe'])?></td>
                                </tr>
                            <?php endforeach; ?>
                            <?php foreach ($retenciones as $impuesto) : ?>
                                <tr>
                                    <th>Retención</th>
                                    <td><?=$this->e($impuesto['Impuesto'])?></td>
                                    <td><?=$this->e($impuesto['TipoFactor'])?></td>
                                    <td><?=$this->e($impuesto['TasaOCuota'])?></td>
                                    <td><?=$this->e($impuesto['Importe'])?></td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    </table>
                </td>
            </tr>
        </table>
    
    
    



</page>










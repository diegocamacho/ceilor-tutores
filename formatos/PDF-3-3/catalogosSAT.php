<?php

function dameUsoCFDI($id){

    $id=strtoupper($id);

	switch($id):

		case 'G01':
		$descripcion="Adquisición de mercancias.";
		break;

        case 'G02':
		$descripcion="Devoluciones, descuentos o bonificaciones.";
		break;

        case 'G03':
		$descripcion="Gastos en General.";
		break;

        case 'I01':
		$descripcion="Construcciones.";
		break;

        case 'I02':
		$descripcion="Mobilario y equipo de oficina por inversiones.";
		break;

        case 'I03':
		$descripcion="Equipo de transporte.";
		break;

        case 'I04':
		$descripcion="Equipo de computo y accesorios.";
		break;

        case 'I05':
		$descripcion="Dados, troqueles, moldes, matrices y herramental.";
		break;

        case 'I06':
		$descripcion="Comunicaciones telefónicas.";
		break;

        case 'I07':
		$descripcion="Comunicaciones satelitales.";
		break;

        case 'I08':
		$descripcion="Otra maquinaria y equipo.";
		break;

        case 'D01':
		$descripcion="Honorarios médicos, dentales y gastos hospitalarios.";
		break;

        case 'D02':
		$descripcion="Gastos médicos por incapacidad o discapacidad.";
		break;

        case 'D03':
		$descripcion="Gastos funerales.";
		break;

        case 'D04':
		$descripcion="Donativos.";
		break;

        case 'D05':
		$descripcion="Intereses reales efectivamente pagados por créditos hipotecarios (casa habitación).";
		break;

        case 'D06':
		$descripcion="Aportaciones voluntarias al SAR.";
		break;

        case 'D07':
		$descripcion="Primas por seguros de gastos médicos.";
		break;

        case 'D08':
		$descripcion="Gastos de transportación escolar obligatoria.";
		break;

        case 'D09':
		$descripcion="Depósitos en cuentas para el ahorro, primas que tengan como base planes de pensiones.";
		break;

        case 'D10':
		$descripcion="Pagos por servicios educativos (colegiaturas).";
		break;

        case 'P01':
		$descripcion="Por definir.";
		break;

	endswitch;

    return $descripcion;
}

function dameRegimenFiscal($id){

    $id=strtoupper($id);

	switch($id):

		case '601':
		$descripcion="General de Ley de Personas Morales";
		break;

        case '603':
		$descripcion="Personas Morales con Fines no Lucrativos";
		break;

        case '605':
		$descripcion="Sueldos y Salarios e Ingresos Asimilados a Salarios";
		break;

        case '606':
		$descripcion="Arrendamiento";
		break;

        case '608':
		$descripcion="Demás ingresos";
		break;

        case '609':
		$descripcion="Consolidación";
		break;

        case '610':
		$descripcion="Residentes en el Extranjero sin Establecimiento Permanente en México";
		break;

        case '611':
		$descripcion="Ingresos por Dividendos (socios y accionistas)";
		break;

        case '612':
		$descripcion="Personas Físicas con Actividades Empresariales y Profesionales";
		break;

        case '614':
		$descripcion="Ingresos por intereses";
		break;

        case '616':
		$descripcion="Sin obligaciones fiscales";
		break;

        case '620':
		$descripcion="Sociedades Cooperativas de Producción que optan por diferir sus ingresos";
		break;

        case '621':
		$descripcion="Incorporación Fiscal";
		break;

        case '622':
		$descripcion="Actividades Agrícolas, Ganaderas, Silvícolas y Pesqueras";
		break;

        case '623':
		$descripcion="Opcional para Grupos de Sociedades";
		break;

        case '624':
		$descripcion="Coordinados";
		break;

        case '628':
		$descripcion="Hidrocarburos";
		break;

        case '607':
		$descripcion="Régimen de Enajenación o Adquisición de Bienes";
		break;

        case '629':
		$descripcion="De los Regímenes Fiscales Preferentes y de las Empresas Multinacionales";
		break;

        case '630':
		$descripcion="Enajenación de acciones en bolsa de valores";
		break;

        case '615':
		$descripcion="Régimen de los ingresos por obtención de premios";
		break;

	endswitch;

    return $descripcion;
}

function dameMoneda($id){

    $id=strtoupper($id);

	switch($id):

        case 'AED':
		$descripcion="Dirham de EAU";
		break;

        case 'AFN':
		$descripcion="Afghani";
		break;

        case 'ALL':
		$descripcion="Lek";
		break;

        case 'AMD':
		$descripcion="Dram armenio";
		break;

        case 'ANG':
		$descripcion="Florín antillano neerlandés";
		break;

        case 'AOA':
		$descripcion="Kwanza";
		break;

        case 'ARS':
		$descripcion="Peso Argentino";
		break;

        case 'AUD':
		$descripcion="Dólar Australiano";
		break;

        case 'AWG':
		$descripcion="Aruba Florin";
		break;

        case 'AZN':
		$descripcion="Azerbaijanian Manat";
		break;

        case 'BAM':
		$descripcion="Convertibles marca";
		break;

        case 'BBD':
		$descripcion="Dólar de Barbados";
		break;

        case 'BDT':
		$descripcion="Taka";
		break;

        case 'BGN':
		$descripcion="Lev búlgaro";
		break;

        case 'BHD':
		$descripcion="Dinar de Bahrein";
		break;

        case 'BIF':
		$descripcion="Burundi Franc";
		break;

        case 'BLZ':
		$descripcion="Belice";
		break;

        case 'BMD':
		$descripcion="Dólar de Bermudas";
		break;

        case 'BND':
		$descripcion="Dólar de Brunei";
		break;

        case 'BOB':
		$descripcion="Boliviano";
		break;

        case 'BOV':
		$descripcion="Mvdol";
		break;

        case 'BRL':
		$descripcion="Real brasileño";
		break;

        case 'BSD':
		$descripcion="Dólar de las Bahamas";
		break;

        case 'BTN':
		$descripcion="Ngultrum";
		break;

        case 'BWP':
		$descripcion="Pula";
		break;

        case 'BYR':
		$descripcion="Rublo bielorruso";
		break;

        case 'BZD':
		$descripcion="Dólar de Belice";
		break;

        case 'CAD':
		$descripcion="Dolar Canadiense";
		break;

        case 'CDF':
		$descripcion="Franco congoleño";
		break;

        case 'CHE':
		$descripcion="WIR Euro";
		break;

        case 'CHF':
		$descripcion="Franco Suizo";
		break;

        case 'CHW':
		$descripcion="Franc WIR";
		break;

        case 'CLF':
		$descripcion="Unidad de Fomento";
		break;

        case 'CLP':
		$descripcion="Peso chileno";
		break;

        case 'CNY':
		$descripcion="Yuan Renminbi";
		break;

        case 'COP':
		$descripcion="Peso Colombiano";
		break;

        case 'COU':
		$descripcion="Unidad de Valor real";
		break;

        case 'CRC':
		$descripcion="Colón costarricense";
		break;

        case 'CUC':
		$descripcion="Peso Convertible";
		break;

        case 'CUP':
		$descripcion="Peso Cubano";
		break;

        case 'CVE':
		$descripcion="Cabo Verde Escudo";
		break;

        case 'CZK':
		$descripcion="Corona checa";
		break;

        case 'DJF':
		$descripcion="Franco de Djibouti";
		break;

        case 'DKK':
		$descripcion="Corona danesa";
		break;

        case 'DOP':
		$descripcion="Peso Dominicano";
		break;

        case 'DZD':
		$descripcion="Dinar argelino";
		break;

        case 'EGP':
		$descripcion="Libra egipcia";
		break;

        case 'ERN':
		$descripcion="Nakfa";
		break;

        case 'ETB':
		$descripcion="Birr etíope";
		break;

        case 'EUR':
		$descripcion="Euro";
		break;

        case 'FJD':
		$descripcion="Dólar de Fiji";
		break;

        case 'FKP':
		$descripcion="Libra malvinense";
		break;

        case 'GBP':
		$descripcion="Libra Esterlina";
		break;

        case 'GEL':
		$descripcion="Lari";
		break;

        case 'GHS':
		$descripcion="Cedi de Ghana";
		break;

        case 'GIP':
		$descripcion="Libra de Gibraltar";
		break;

        case 'GMD':
		$descripcion="Dalasi";
		break;

        case 'GNF':
		$descripcion="Franco guineano";
		break;

        case 'GTQ':
		$descripcion="Quetzal";
		break;

        case 'GYD':
		$descripcion="Dólar guyanés";
		break;

        case 'HKD':
		$descripcion="Dolar De Hong Kong";
		break;

        case 'HNL':
		$descripcion="Lempira";
		break;

        case 'HRK':
		$descripcion="Kuna";
		break;

        case 'HTG':
		$descripcion="Gourde";
		break;

        case 'HUF':
		$descripcion="Florín";
		break;

        case 'IDR':
		$descripcion="Rupia";
		break;

        case 'ILS':
		$descripcion="Nuevo Shekel Israelí";
		break;

        case 'INR':
		$descripcion="Rupia india";
		break;

        case 'IQD':
		$descripcion="Dinar iraquí";
		break;

        case 'IRR':
		$descripcion="Rial iraní";
		break;

        case 'ISK':
		$descripcion="Corona islandesa";
		break;

        case 'JMD':
		$descripcion="Dólar Jamaiquino";
		break;

        case 'JOD':
		$descripcion="Dinar jordano";
		break;

        case 'JPY':
		$descripcion="Yen";
		break;

        case 'KES':
		$descripcion="Chelín keniano";
		break;

        case 'KGS':
		$descripcion="Som";
		break;

        case 'KHR':
		$descripcion="Riel";
		break;

        case 'KMF':
		$descripcion="Franco Comoro";
		break;

        case 'KPW':
		$descripcion="Corea del Norte ganó";
		break;

        case 'KRW':
		$descripcion="Won";
		break;

        case 'KWD':
		$descripcion="Dinar kuwaití";
		break;

        case 'KYD':
		$descripcion="Dólar de las Islas Caimán";
		break;

        case 'KZT':
		$descripcion="Tenge";
		break;

        case 'LAK':
		$descripcion="Kip";
		break;

        case 'LBP':
		$descripcion="Libra libanesa";
		break;

        case 'LKR':
		$descripcion="Rupia de Sri Lanka";
		break;

        case 'LRD':
		$descripcion="Dólar liberiano";
		break;

        case 'LSL':
		$descripcion="Loti";
		break;

        case 'LYD':
		$descripcion="Dinar libio";
		break;

        case 'MAD':
		$descripcion="Dirham marroquí";
		break;

        case 'MDL':
		$descripcion="Leu moldavo";
		break;

        case 'MGA':
		$descripcion="Ariary malgache";
		break;

        case 'MKD':
		$descripcion="Denar";
		break;

        case 'MMK':
		$descripcion="Kyat";
		break;

        case 'MNT':
		$descripcion="Tugrik";
		break;

        case 'MOP':
		$descripcion="Pataca";
		break;

        case 'MRO':
		$descripcion="Ouguiya";
		break;

        case 'MUR':
		$descripcion="Rupia de Mauricio";
		break;

        case 'MVR':
		$descripcion="Rupia";
		break;

        case 'MWK':
		$descripcion="Kwacha";
		break;

		case 'MXN':
		$descripcion="Peso Mexicano";
		break;

        case 'MXV':
		$descripcion="México Unidad de Inversión (UDI)";
		break;

        case 'MYR':
		$descripcion="Ringgit malayo";
		break;

        case 'MZN':
		$descripcion="Mozambique Metical";
		break;

        case 'NAD':
		$descripcion="Dólar de Namibia";
		break;

        case 'NGN':
		$descripcion="Naira";
		break;

        case 'NIO':
		$descripcion="Córdoba Oro";
		break;

        case 'NOK':
		$descripcion="Corona noruega";
		break;

        case 'NPR':
		$descripcion="Rupia nepalí";
		break;

        case 'NZD':
		$descripcion="Dólar de Nueva Zelanda";
		break;

        case 'OMR':
		$descripcion="Rial omaní";
		break;

        case 'PAB':
		$descripcion="Balboa";
		break;

        case 'PEN':
		$descripcion="Nuevo Sol";
		break;

        case 'PGK':
		$descripcion="Kina";
		break;

        case 'PHP':
		$descripcion="Peso filipino";
		break;

        case 'PKR':
		$descripcion="Rupia de Pakistán";
		break;

        case 'PLN':
		$descripcion="Zloty";
		break;

        case 'PYG':
		$descripcion="Guaraní";
		break;

        case 'QAR':
		$descripcion="Qatar Rial";
		break;

        case 'RON':
		$descripcion="Leu rumano";
		break;

        case 'RSD':
		$descripcion="Dinar serbio";
		break;

        case 'RUB':
		$descripcion="Rublo ruso";
		break;

        case 'RWF':
		$descripcion="Franco ruandés";
		break;

        case 'SAR':
		$descripcion="Riyal saudí";
		break;

        case 'SBD':
		$descripcion="Dólar de las Islas Salomón";
		break;

        case 'SCR':
		$descripcion="Rupia de Seychelles";
		break;

        case 'SDG':
		$descripcion="Libra sudanesa";
		break;

        case 'SEK':
		$descripcion="Corona sueca";
		break;

        case 'SGD':
		$descripcion="Dolar De Singapur";
		break;

        case 'SHP':
		$descripcion="Libra de Santa Helena";
		break;

        case 'SLL':
		$descripcion="Leona";
		break;

        case 'SOS':
		$descripcion="Chelín somalí";
		break;

        case 'SRD':
		$descripcion="Dólar de Suriname";
		break;

        case 'SSP':
		$descripcion="Libra sudanesa Sur";
		break;

        case 'STD':
		$descripcion="Dobra";
		break;

        case 'SVC':
		$descripcion="Colon El Salvador";
		break;

        case 'SYP':
		$descripcion="Libra Siria";
		break;

        case 'SZL':
		$descripcion="Lilangeni";
		break;

        case 'THB':
		$descripcion="Baht";
		break;

        case 'TJS':
		$descripcion="Somoni";
		break;

        case 'TMT':
		$descripcion="Turkmenistán nuevo manat";
		break;

        case 'TND':
		$descripcion="Dinar tunecino";
		break;

        case 'TOP':
		$descripcion="Pa'anga";
		break;

        case 'TRY':
		$descripcion="Lira turca";
		break;

        case 'TTD':
		$descripcion="Dólar de Trinidad y Tobago";
		break;

        case 'TWD':
		$descripcion="Nuevo dólar de Taiwán";
		break;

        case 'TZS':
		$descripcion="Shilling tanzano";
		break;

        case 'UAH':
		$descripcion="Hryvnia";
		break;

        case 'UGX':
		$descripcion="Shilling de Uganda";
		break;

        case 'USD':
		$descripcion="Dolar americano";
		break;

        case 'USN':
		$descripcion="Dólar estadounidense (día siguiente)";
		break;

        case 'UYI':
		$descripcion="Peso Uruguay en Unidades Indexadas (URUIURUI)";
		break;

        case 'UYU':
		$descripcion="Peso Uruguayo";
		break;

        case 'UZS':
		$descripcion="Uzbekistán Sum";
		break;

        case 'VEF':
		$descripcion="Bolívar";
		break;

        case 'VND':
		$descripcion="Dong";
		break;

        case 'VUV':
		$descripcion="Vatu";
		break;

        case 'WST':
		$descripcion="Tala";
		break;

        case 'XAF':
		$descripcion="Franco CFA BEAC";
		break;

        case 'XAG':
		$descripcion="Plata";
		break;

        case 'XAU':
		$descripcion="Oro";
		break;

        case 'XBA':
		$descripcion="Unidad de Mercados de Bonos Unidad Europea Composite (EURCO)";
		break;

        case 'XBB':
		$descripcion="Unidad Monetaria de Bonos de Mercados Unidad Europea (UEM-6)";
		break;

        case 'XBC':
		$descripcion="Mercados de Bonos Unidad Europea unidad de cuenta a 9 (UCE-9)";
		break;

        case 'XBD':
		$descripcion="Mercados de Bonos Unidad Europea unidad de cuenta a 17 (UCE-17)";
		break;

        case 'XCD':
		$descripcion="Dólar del Caribe Oriental";
		break;

        case 'XDR':
		$descripcion="DEG (Derechos Especiales de Giro)";
		break;

        case 'XOF':
		$descripcion="Franco CFA BCEAO";
		break;

        case 'XPD':
		$descripcion="Paladio";
		break;

        case 'XPF':
		$descripcion="Franco CFP";
		break;

        case 'XPT':
		$descripcion="Platino";
		break;

        case 'XSU':
		$descripcion="Sucre";
		break;

        case 'XTS':
		$descripcion="Códigos reservados específicamente para propósitos de prueba";
		break;

        case 'XUA':
		$descripcion="Unidad ADB de Cuenta";
		break;

        case 'XXX':
		$descripcion="Los códigos asignados para las transacciones en que intervenga ninguna moneda";
		break;

        case 'YER':
		$descripcion="Rial yemení";
		break;

        case 'ZAR':
		$descripcion="Rand";
		break;

        case 'ZMW':
		$descripcion="Kwacha zambiano";
		break;

        case 'ZWL':
		$descripcion="Zimbabwe Dólar";
		break;

        default:
        $descripcion="";

	endswitch;

    return $descripcion;
}

function dameFormaPago($id){

    $id=strtoupper($id);

	switch($id):

		case '01':
		$descripcion="Efectivo";
		break;

        case '02':
		$descripcion="Cheque nominativo";
		break;

        case '03':
		$descripcion="Transferencia electrónica de fondos";
		break;

        case '04':
		$descripcion="Tarjeta de crédito";
		break;

        case '05':
		$descripcion="Monedero electrónico";
		break;

        case '06':
		$descripcion="Dinero electrónico";
		break;

        case '08':
		$descripcion="Vales de despensa";
		break;

        case '12':
		$descripcion="Dación en pago";
		break;

        case '13':
		$descripcion="Pago por subrogación";
		break;

        case '14':
		$descripcion="Pago por consignación";
		break;

        case '15':
		$descripcion="Condonación";
		break;

        case '17':
		$descripcion="Compensación";
		break;

        case '23':
		$descripcion="Novación";
		break;

        case '24':
		$descripcion="Confusión";
		break;

        case '25':
		$descripcion="Remisión de deuda";
		break;

        case '26':
		$descripcion="Prescripción o caducidad";
		break;

        case '27':
		$descripcion="A satisfacción del acreedor";
		break;

        case '28':
		$descripcion="Tarjeta de débito";
		break;

        case '29':
		$descripcion="Tarjeta de servicios";
		break;

        case '30':
		$descripcion="Aplicación de anticipos";
		break;

        case '99':
		$descripcion="Por definir";
		break;

	endswitch;

    return $descripcion;
}

function dameMetodoPago($id){

    $id=strtoupper($id);

	switch($id):

		case 'PUE':
		$descripcion="Pago en una sola exhibición";
		break;

        case 'PPD':
		$descripcion="Pago en parcialidades o diferido";
		break;

	endswitch;

    return $descripcion;
}

function dameTipoRelacion($id){

    $id=strtoupper($id);

	switch($id):

        case '01':
		$descripcion="Nota de crédito de los documentos relacionados";
		break;

        case '02':
		$descripcion="Nota de débito de los documentos relacionados";
		break;

        case '02':
		$descripcion="Devolución de mercancía sobre facturas o traslados previos";
		break;

		case '04':
		$descripcion="Sustitución de los CFDI previos";
		break;

        case '05':
		$descripcion="Traslados de mercancias facturados previamente";
		break;

        case '06':
		$descripcion="Factura generada por los traslados previos";
		break;

        case '07':
		$descripcion="CFDI por aplicación de anticipo";
		break;

	endswitch;

    return $descripcion;
}

function dameTipoComprobante($id){

    $id=strtoupper($id);

	switch($id):

		case 'I':
		$descripcion="Ingreso";
		break;

        case 'E':
		$descripcion="Egreso";
		break;

        case 'T':
		$descripcion="Traslado";
		break;

        case 'N':
		$descripcion="Nómina";
		break;

        case 'P':
		$descripcion="Pago";
		break;

	endswitch;

    return $descripcion;
}

function dameImpuesto($id){

    $id=strtoupper($id);

	switch($id):

		case '001':
		$descripcion="ISR";
		break;

        case '002':
		$descripcion="IVA";
		break;

        case '003':
		$descripcion="IEPS";
		break;

	endswitch;

    return $descripcion;
}

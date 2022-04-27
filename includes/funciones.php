<?
//Utilerias
date_default_timezone_set("America/Mexico_City");
$fechahora=date("Y-m-d H:i:s");
$fecha_actual=date("Y-m-d");
$hora_actual=date("H:i");

function acentos($cadena){
    $originales =  'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿŔŕ';
    $modificadas = 'AAAAAAACEEEEIIIIDNOOOOOOUUUUYbsaaaaaaaceeeeiiiidnoooooouuuyybyRr';
    $cadena = utf8_decode($cadena);
    $cadena = strtr($cadena, utf8_decode($originales), $modificadas);
    return utf8_encode($cadena);
}
function eliminar_acentos($cadena){

	//Reemplazamos la A y a
	$cadena = str_replace(
	array('Á', 'À', 'Â', 'Ä', 'á', 'à', 'ä', 'â', 'ª'),
	array('A', 'A', 'A', 'A', 'a', 'a', 'a', 'a', 'a'),
	$cadena
	);

	//Reemplazamos la E y e
	$cadena = str_replace(
	array('É', 'È', 'Ê', 'Ë', 'é', 'è', 'ë', 'ê'),
	array('E', 'E', 'E', 'E', 'e', 'e', 'e', 'e'),
	$cadena );

	//Reemplazamos la I y i
	$cadena = str_replace(
	array('Í', 'Ì', 'Ï', 'Î', 'í', 'ì', 'ï', 'î'),
	array('I', 'I', 'I', 'I', 'i', 'i', 'i', 'i'),
	$cadena );

	//Reemplazamos la O y o
	$cadena = str_replace(
	array('Ó', 'Ò', 'Ö', 'Ô', 'ó', 'ò', 'ö', 'ô'),
	array('O', 'O', 'O', 'O', 'o', 'o', 'o', 'o'),
	$cadena );

	//Reemplazamos la U y u
	$cadena = str_replace(
	array('Ú', 'Ù', 'Û', 'Ü', 'ú', 'ù', 'ü', 'û'),
	array('U', 'U', 'U', 'U', 'u', 'u', 'u', 'u'),
	$cadena );

	//Reemplazamos la N, n, C y c
	$cadena = str_replace(
	array('Ñ', 'ñ', 'Ç', 'ç'),
	array('N', 'n', 'C', 'c'),
	$cadena
	);

	return $cadena;
}
//Valida cadena de fecha
function validaStrFecha($fecha,$ano=false){
	if(!$ano){
		if( (is_numeric($fecha)) && (strlen((string)$fecha)==2) ){
			return true;
		}else{
			return false;
		}
	}else{
		if( (is_numeric($fecha)) && (strlen((string)$fecha)==4) ){
			return true;
		}else{
			return false;
		}
	}
}
//Encripta contraseña
function contrasena($contrasena){
	return md5($contrasena);
}
//Valida código postal
function validarCP($cp){
	if( (is_numeric($cp)) && (strlen($cp)==5) ){
		return true;
	}else{
		return false;
	}
}
//Valida teléfono
function validarTelefono($telefono){
	if( (is_numeric($telefono)) && (strlen($telefono)==10) ){
		return true;
	}else{
		return false;
	}
}
//Validar email
function validarEmail($email){
	return filter_var($email, FILTER_VALIDATE_EMAIL);
}
//Formatear cadenas
function limpiaStr($v,$base=false,$m=false){
    global $db;
 if($m){
 	$v =  mb_convert_case($v, MB_CASE_UPPER, "UTF-8");
 }else{
	$v =  mb_convert_case($v, MB_CASE_TITLE, "UTF-8");
 }
 if($base){
	 $v = mysqli_real_escape_string($db, strip_tags($v));
 }
 return  $v;
}
//Funcion para escapar
function escapar($cadena,$numerico=false){

	global $db;

	if($numerico){
		if(is_numeric($cadena)){
			return mysqli_real_escape_string($db,$cadena);
		}else{
			return false;
		}
	}else{
		return mysqli_real_escape_string($db,strip_tags($cadena));
	}
}
//Comprobamos una cadena de texto para un nombre
function comprobarNombre($nombre){
	if(ereg("^[a-zA-Z0-9\-_]{3,20}$+", $nombre)) {
	   return true;
   	}else{
	   	return false;
   	}
}
function fechaBase($fecha){
	list($mes,$dia,$anio)=explode("/",$fecha);

	$dia=(string)(int)$dia;
	return $anio."-".$mes."-".$dia;
}
function fechaBase2($fecha){
	list($mes,$dia,$anio)=explode("/",$fecha);

	$dia=(string)(int)$dia;
	return $anio."-".$mes."-".$dia;
}
function fechaBase3($fecha){
	list($dia,$mes,$anio)=explode("/",$fecha);

	$dia=(string)(int)$dia;
	return $anio."-".$mes."-".$dia;
}
function fechaCorta($fecha){
	list($anio,$mes,$dia)=explode("-",$fecha);

	$dia=(string)(int)$dia;
	return str_pad($dia, 2, "0", STR_PAD_LEFT)."/".$mes."/".$anio;
}
/*function newFechaCorta($fecha){
    $temp = explode("-",$fecha);
    $n_fecha = $temp[2]."/".$temp[1]."/".$temp[0];
    return $n_fecha;
}*/
//Para mostrar fecha
function fechaSinHora($fecha){
	return $fecha=substr($fecha,0,11);
}
function horaSinFecha($fecha){
	return $fecha=substr($fecha,11,5);
	//2017-12-13 18:59:01
}
//Fecha sin hora
function fechaLetra($fecha){

    $mest="";
	list($anio,$mes,$dia)=@explode("-",$fecha);
	switch($mes){
	case 1:
	$mest="ENE";
	break;
	case 2:
	$mest="FEB";
	break;
	case 3:
	$mest="MAR";
	break;
	case 4:
	$mest="ABR";
	break;
	case 5:
	$mest="MAY";
	break;
	case 6:
	$mest="JUN";
	break;
	case 7:
	$mest="JUL";
	break;
	case 8:
	$mest="AGO";
	break;
	case 9:
	$mest="SEP";
	break;
	case 10:
	$mest="OCT";
	break;
	case 11:
	$mest="NOV";
	break;
	case 12:
	$mest="DIC";
	break;

	}
	$dia=(string)(int)$dia;
	return $dia." ".$mest." ".$anio;
}

function fechaLetraAlt($fecha){

	list($anio,$mes,$dia)=explode("-",$fecha);
	switch($mes){
	case 1:
	$mest="ENE";
	break;
	case 2:
	$mest="FEB";
	break;
	case 3:
	$mest="MAR";
	break;
	case 4:
	$mest="ABR";
	break;
	case 5:
	$mest="MAY";
	break;
	case 6:
	$mest="JUN";
	break;
	case 7:
	$mest="JUL";
	break;
	case 8:
	$mest="AGO";
	break;
	case 9:
	$mest="SEP";
	break;
	case 10:
	$mest="OCT";
	break;
	case 11:
	$mest="NOV";
	break;
	case 12:
	$mest="DIC";
	break;

	}
	$dia=(string)(int)$dia;
	return $dia." ".$mest;
}

function fechaLetraAltAnio($fecha){

	list($anio,$mes,$dia)=explode("-",$fecha);
	switch($mes){
	case 1:
	$mest="ENE";
	break;
	case 2:
	$mest="FEB";
	break;
	case 3:
	$mest="MAR";
	break;
	case 4:
	$mest="ABR";
	break;
	case 5:
	$mest="MAY";
	break;
	case 6:
	$mest="JUN";
	break;
	case 7:
	$mest="JUL";
	break;
	case 8:
	$mest="AGO";
	break;
	case 9:
	$mest="SEP";
	break;
	case 10:
	$mest="OCT";
	break;
	case 11:
	$mest="NOV";
	break;
	case 12:
	$mest="DIC";
	break;

	}
	$dia=(string)(int)$dia;
	return $dia." ".$mest." ".substr($anio,2,4);
}


function fechaLetraDos($fecha){

	list($anio,$mes,$dia)=explode("-",$fecha);
	switch($mes){
	case 1:
	$mest="ENE";
	break;
	case 2:
	$mest="FEB";
	break;
	case 3:
	$mest="MAR";
	break;
	case 4:
	$mest="ABR";
	break;
	case 5:
	$mest="MAY";
	break;
	case 6:
	$mest="JUN";
	break;
	case 7:
	$mest="JUL";
	break;
	case 8:
	$mest="AGO";
	break;
	case 9:
	$mest="SEP";
	break;
	case 10:
	$mest="OCT";
	break;
	case 11:
	$mest="NOV";
	break;
	case 12:
	$mest="DIC";
	break;

	}
	$dia=$dia;
	return $dia."/".$mest."/".$anio;
}

function fechaLetraTres($fecha){

	list($anio,$mes,$dia)=explode("-",$fecha);
	switch($mes){
	case 1:
	$mest="Enero";
	break;
	case 2:
	$mest="Febrero";
	break;
	case 3:
	$mest="Marzo";
	break;
	case 4:
	$mest="Abril";
	break;
	case 5:
	$mest="Mayo";
	break;
	case 6:
	$mest="Junio";
	break;
	case 7:
	$mest="Julio";
	break;
	case 8:
	$mest="Agosto";
	break;
	case 9:
	$mest="Septiembre";
	break;
	case 10:
	$mest="Octubre";
	break;
	case 11:
	$mest="Noviembre";
	break;
	case 12:
	$mest="Diciembre";
	break;

	}
	$dia=$dia;
	return $dia." ".$mest." ".$anio;
}

function fechaLetraCuatro($fecha){

	list($anio,$mes,$dia)=explode("-",$fecha);
	switch($mes){
	case 1:
	$mest="Enero";
	break;
	case 2:
	$mest="Febrero";
	break;
	case 3:
	$mest="Marzo";
	break;
	case 4:
	$mest="Abril";
	break;
	case 5:
	$mest="Mayo";
	break;
	case 6:
	$mest="Junio";
	break;
	case 7:
	$mest="Julio";
	break;
	case 8:
	$mest="Agosto";
	break;
	case 9:
	$mest="Septiembre";
	break;
	case 10:
	$mest="Octubre";
	break;
	case 11:
	$mest="Noviembre";
	break;
	case 12:
	$mest="Diciembre";
	break;

	}
	$dia=$dia;
	return $mest." ".$anio;
}



//Obtener el mes
function soloMesNumero($fecha){

	$x=explode("-",$fecha);
	return $x[1];
}
function soloMes($mes){

	switch($mes){
	case 1:
	$mest="Enero";
	break;
	case 2:
	$mest="Febrero";
	break;
	case 3:
	$mest="Marzo";
	break;
	case 4:
	$mest="Abril";
	break;
	case 5:
	$mest="Mayo";
	break;
	case 6:
	$mest="Junio";
	break;
	case 7:
	$mest="Julio";
	break;
	case 8:
	$mest="Agosto";
	break;
	case 9:
	$mest="Septiembre";
	break;
	case 10:
	$mest="Octubre";
	break;
	case 11:
	$mest="Noviembre";
	break;
	case 12:
	$mest="Diciembre";
	break;

	}
	return $mest;
}
function devuelveFechaHora($fecha_hora){
	$data = explode(' ', $fecha_hora);
	return fechaLetraDos($data[0]).' - '.substr($data[1], 0,5);
}

function fechaHoraMeridian($fecha_hora){
	$data = explode(' ', $fecha_hora);
	return fechaLetraTres($data[0]).' - '.date('h:i A', strtotime($fecha_hora));
}

function fechaHoraMeridian2($fecha_hora){
	$data = explode('T', $fecha_hora);
	return fechaLetraTres($data[0]).' - '.date('h:i A', strtotime($fecha_hora));
}
function limpiaNumero($telefono){
	$telefono = str_replace(' ', '', $telefono);
	$telefono = str_replace('(', '', $telefono);
	$telefono = str_replace(')', '', $telefono);
	$telefono = str_replace('-', '', $telefono);
	return $telefono;
}

function fnum($num,$sinDecimales = false, $sinNumberFormat = false){

//SinDecimales = TRUE: envias: 1500.1234 devuelve: 1,500
//SinNumberFormat = TRUE: envias 1500.1234 devuelve 1500.12
//SinNumberFormat = TRUE && SinDecimales = TRUE: envias: 1500.1234 devuelve 1500

	if(is_numeric($num)){
		$roto = explode('.',$num);
		if($roto[1]){
			$dec = substr($roto[1],0,2);
		}else{
			$dec = "00";
		}

		if(is_numeric($roto[0])){
			if($sinDecimales){
				if($sinNumberFormat){
					return $roto[0];
				}else{
					return number_format($roto[0]);
				}
			}else{
				if($sinNumberFormat){
					return $roto[0].'.'.$dec;
				}else{
					return number_format($roto[0]).'.'.$dec;
				}
			}
		}else{
			if($sinDecimales){
				return '0';
			}else{
				return '0.'.$dec;
			}
		}
	}else{
		if($sinDecimales){
			return '0';
		}else{
			return '0.00';
		}
	}

}

/////NUEVAS FUNCIONES KRIS
//Fecha sin Año
function fechaDiaMes($fecha){

	list($anio,$mes,$dia)=explode("-",$fecha);
	switch($mes){
	case 1:
	$mest="Ene";
	break;
	case 2:
	$mest="Feb";
	break;
	case 3:
	$mest="Mar";
	break;
	case 4:
	$mest="Abr";
	break;
	case 5:
	$mest="May";
	break;
	case 6:
	$mest="Jun";
	break;
	case 7:
	$mest="Jul";
	break;
	case 8:
	$mest="Ago";
	break;
	case 9:
	$mest="Sep";
	break;
	case 10:
	$mest="Oct";
	break;
	case 11:
	$mest="Nov";
	break;
	case 12:
	$mest="Dic";
	break;

	}
	$dia=(string)(int)$dia;
	return $dia." ".$mest;
}

//Hora del dia en formato 24 hrs
function horaOficial($hora){
  $hora_oficial = date("H:i",strtotime($hora));
  return $hora_oficial;
}

function calculaEdad($fecha_nacimiento){

	$cumpleanos = new DateTime($fecha_nacimiento);
	$hoy = new DateTime();
	$annos = $hoy->diff($cumpleanos);
	return $annos->y." años /".$annos->m." meses /".$annos->d." días";
}

function calculaEdadAnos($fecha_nacimiento){

	$cumpleanos = new DateTime($fecha_nacimiento);
	$hoy = new DateTime();
	$annos = $hoy->diff($cumpleanos);
	return $annos->y." años";
}

function dameNombreDia($dia){

	switch($dia){
 	case 1:
 	$dian="LUNES";
 	break;

 	case 2:
 	$dian="MARTES";
 	break;

 	case 3:
 	$dian="MIÉRCOLES";
 	break;

 	case 4:
 	$dian="JUEVES";
 	break;

 	case 5:
 	$dian="VIERNES";
 	break;

 	case 6:
 	$dian="SÁBADO";
 	break;

 	case 7:
 	$dian="DOMINGO";
 	break;

 	}
 	return $dian;
}

function recuperaContrasena($id_credencial){

	require ('postmark.php');
	global $db;
	global $dominio;
    //Mandamos el correo
    $sql="SELECT email, nombre, token  FROM credenciales
	JOIN medicos ON medicos.id_medico=credenciales.id_usuario
	WHERE id_credencial=$id_credencial";
    $q=mysqli_query($db,$sql);
    $ft=mysqli_fetch_assoc($q);

	$nombre=ucwords(mb_strtolower($ft['nombre'],'UTF-8'));
	$email=$ft['email'];
	$token=$ft['token'];

	//id_sm/id_secre/id_doc
	//$token=base64_encode($id_sm."|".$id_secretaria."|".$id_medico);

	$vinculo=$dominio."/index.php?Seccion=Recupera&token=".$token;


    $html = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml"><head> <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/> <title>MedicApp</title> <meta name="viewport" content="width=device-width"/> <style type="text/css"> @media only screen and (max-width: 550px), screen and (max-device-width: 550px){body[yahoo] .buttonwrapper{background-color: transparent !important;}body[yahoo] .button{padding: 0 !important;}body[yahoo] .button a{background-color: #00b6ad; padding: 15px 25px !important;}}@media only screen and (min-device-width: 601px){.content{width: 600px !important;}.col387{width: 387px !important;}}.boton_personalizado{background-color: #00b6ad; -moz-border-radius: 28px; -webkit-border-radius: 28px; border-radius: 28px; border: 1px solid #707070; display: inline-block; cursor: pointer; color: #ffffff; font-family: Arial; font-size: 17px; padding: 16px 31px; text-decoration: none; text-shadow: 0px 1px 0px #2f6627;}.boton_personalizado:link{color: #ffffff;}.boton_personalizado:visited{background-color: #00b6ad; color: #ffffff;}.boton_personalizado:hover{background-color: #00b6ad; color: #ffffff;}.boton_personalizado:active{position: relative; top: 1px; background-color: #00b6ad; color: #ffffff;}</style></head><body bgcolor="#ffffff" style="margin: 0; padding: 0;" yahoo="fix"> <table align="center" border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse; width: 100%; max-width: 600px;" class="content"> <tr> <td align="center" bgcolor="#00b6ad" style="padding: 25px 20px 20px 20px; color: #fff; font-family: Arial, sans-serif; font-size: 22px; border-bottom: 1px solid #eeeeee;"> Solicitud de Contraseña </td></tr><tr> <td> <br></td></tr><tr> <td bgcolor="#ffffff" style="padding: 0 20px 20px 20px; color: #555555; font-family: Arial, sans-serif; font-size: 15px; line-height: 29px; border-bottom: 1px solid #f6f6f6;"> <p>Hola '.$nombre.', haz solicitado que te enviemos tu contraseña de acceso a <b>MedicApp</b>.<br>Recuerda que tu nombre de usuario es tu cuenta de correo: '.$email.' <br>Por motivos de seguridad no es posible enviar tu contraseña actual, pero puedes restablecerla haciendo click en el siguiente botón. <br><br></p><table width="100%" border="0" cellspacing="0" cellpadding="0"> <tr> <td align="center"> <div> <a href="'.$vinculo.'" style="background-color:#12af9a;border:1px solid #707070;border-radius:3px;color:#ffffff;display:inline-block;font-family:sans-serif;font-size:16px;line-height:44px;text-align:center;text-decoration:none;width:250px;-webkit-text-size-adjust:none;mso-hide:all;">Restablecer Contraseña</a> </div></td></tr></table> <br><center>*Si no solicitaste restablecer tu contraseña haz caso omiso a este correo.</center> </td></tr><tr> <td align="center" bgcolor="#e9e9e9" style="padding: 12px 10px 12px 10px; color: #888888; font-family: Arial, sans-serif; font-size: 12px; line-height: 18px;"> Copyright © 2020 MedicApp. Este es un producto de <b>Conexia</b> </td></tr></table></body></html>';

    $remite 			= "MedicApp Servicios <robot@medicapp.mx>";
    $destino 			= $email;
    $asunto 			= "Solicitud de Contraseña";
    $mensaje_html 		= $html;

    $postmark = new Postmark(null,$remite);
    $postmark->to($destino);
    $postmark->subject($asunto);
    $postmark->html_message($mensaje_html);
    //$postmark->adjunta_vato($adjuntos);

    //$postmark->send(); #SIN IF.

    $resultado=$postmark->send();
    //file_put_contents('log_postmark.txt',$resultado);
    $messageid=$resultado->MessageID;
    if($messageid){
        //mysqli_query($db,"UPDATE tareas SET message_id='$messageid', estado_email_entregado=0 WHERE id_tarea='$id_tarea'");
        //$error=false;
		//echo $messageid;
        return true;
    }else{
        return "Error al enviar su contraseña. Si el error persiste contacte a soporte.";
    }

}

function extContentType ($ext_archivo) {
	switch($ext_archivo):
		case 'pdf':
			$ContentType = "application/pdf";
		break;
		case 'jpge':
			$ContentType = "image/jpeg";
		break;
		case 'png':
			$ContentType = "image/png";
		break;
		case 'gif':
			$ContentType = "image/gif";
		break;
		case 'txt':
			$ContentType = "text/plain";
		break;
		case 'doc':
			$ContentType = "application/msword";
		break;
		case 'xls':
			$ContentType = "application/vnd.ms-excel";
		break;
		case 'ppt':
			$ContentType = "application/vnd.ms-powerpoint";
		break;
		case 'rar':
			$ContentType = "application/x-rar-compressed";
		break;
		case 'zip':
			$ContentType = "application/zip";
		break;
		case 'mp4':
			$ContentType = "video/mpeg";
		break;
		case 'mov':
			$ContentType = "video/mpeg";
		break;
		case 'avi':
			$ContentType = "video/x-msvideo";
		break;
		case 'mkv':
			$ContentType = "video/mpeg";
		break;
		case 'flv':
			$ContentType = "video/mpeg";
		break;
		case 'swf':
			$ContentType = "application/x-shockwave-flash";
		break;
		case 'm4v':
			$ContentType = "video/mpeg";
		break;
		case '3gp':
			$ContentType = "video/3gpp2";
		break;
		case 'mp3':
			$ContentType = "audio/aac";
		break;
		case 'mp2':
			$ContentType = "audio/aac";
		break;
		case 'aac':
			$ContentType = "audio/aac";
		break;
		case 'mpeg':
			$ContentType = "video/mpeg";
		break;
		case 'wav':
			$ContentType = "audio/x-wav";
		break;
		case 'ogv':
			$ContentType = "application/ogg";
		break;
		case 'midi':
			$ContentType = "audio/midi";
		break;
		default:
			$ContentType = "application/octet-stream";
		break;
	endswitch;
	return $ContentType;
}


function extContentIdType ($ext_archivo) {
	switch($ext_archivo):
		case 'pdf':
			$ContentType = 1;
		break;
		case 'jpge':
			$ContentType = 2;
		break;
		case 'png':
			$ContentType = 3;
		break;
		case 'gif':
			$ContentType = 4;
		break;
		case 'txt':
			$ContentType = 5;
		break;
		case 'doc':
			$ContentType = 6;
		break;
		case 'xls':
			$ContentType = 7;
		break;
		case 'ppt':
			$ContentType = 8;
		break;
		case 'rar':
			$ContentType = 9;
		break;
		case 'zip':
			$ContentType = 10;
		break;
		case 'mp4':
			$ContentType = 11;
		break;
		case 'mov':
			$ContentType = 12;
		break;
		case 'avi':
			$ContentType = 13;
		break;
		case 'mkv':
			$ContentType = 14;
		break;
		case 'flv':
			$ContentType = 15;
		break;
		case 'swf':
			$ContentType = 16;
		break;
		case 'm4v':
			$ContentType = 17;
		break;
		case '3gp':
			$ContentType = 18;
		break;
		case 'mp3':
			$ContentType = 19;
		break;
		case 'mp2':
			$ContentType = 20;
		break;
		case 'aac':
			$ContentType = 21;
		break;
		case 'mpeg':
			$ContentType = 22;
		break;
		case 'wav':
			$ContentType = 23;
		break;
		case 'ogv':
			$ContentType = 24;
		break;
		case 'midi':
			$ContentType = 25;
		break;
		default:
			$ContentType = 999;
		break;
	endswitch;
	return $ContentType;
}

function billete($number, $precision = 2, $separator = '.'){
    $numberParts = explode($separator, sprintf("%01.4f",$number));
    $response = number_format($numberParts[0]);
    if(count($numberParts)>1){
        $response .= $separator;
        $response .= substr($numberParts[1], 0, $precision);
    }
    return $response;
}
function horaAgendaVista($hora){
	$date = new DateTime($hora);
	$date->modify('+1 minute');
	return $date->format('H:i');
}
function dameNivel($nivel){
	if($nivel==1){
		return "Preescolar";
	}elseif($nivel==2){
		return "Primaria";
	}elseif($nivel==3){
		return "Secundaria";
	}elseif($nivel==4){
		return "Preparatoria";
	}else{
		return "N/A";
	}
}
function dameGrado($grado){
	if($grado==1){
		return "Primero";
	}elseif($grado==2){
		return "Segundo";
	}elseif($grado==3){
		return "Tercero";
	}elseif($grado==4){
		return "Cuarto";
	}elseif($grado==5){
		return "Quinto";
	}elseif($grado==6){
		return "Sexto";
	}else{
		return "N/A";
	}
}

function notificaVenta($id_venta){
	global $db;
	
	$sql="SELECT telefono, monto_total, serie,folio FROM ventas 
	JOIN tutores ON tutores.id_tutor=ventas.id_tutor
	WHERE id_venta=$id_venta";
	$q=mysqli_query($db,$sql);
	$ft=mysqli_fetch_assoc($q);
	
	$mensaje="ESTIMADO PADRE DE FAMILIA HEMOS RECIBIDO SU PAGO DE ".number_format($ft['monto_total'])." CON FOLIO ".$ft['serie']."-".$ft['folio'].". MUCHAS GRACIAS ATTE. CEILOR";
	
	mandaSms($ft['telefono'],$mensaje);
	
}

function mandaSms($numero,$mensaje) {
	$numero="52".$numero;
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://zjjew2.api.infobip.com/sms/2/text/advanced",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS =>"{\"messages\":[{\"from\":\"InfoSMS\",\"destinations\":[{\"to\":\"$numero\",\"messageId\":\"$id\"}],\"text\":\"$mensaje\",\"language\":{\"languageCode\":\"ES\"},\"transliteration\":\"SPANISH\",\"intermediateReport\":true,\"notifyUrl\":\"https://medicapp.mx/webhooks/sms.php\",\"notifyContentType\":\"application/json\",\"callbackData\":\"DLR callback data\",\"validityPeriod\":720}]}",
        CURLOPT_HTTPHEADER => array(
            "Authorization: Basic Q29uZXhpYTE6RC5jYW1hY2hvMDI4Ng==",
            "Content-Type: application/json",
            "Accept: application/json"
        ),
    ));

    $response = curl_exec($curl);
    curl_close($curl);
    //echo $response;
    return $response;
}
function notificaPago($id_venta){

	require ('postmark.php');
	global $db;
	
	$sql="SELECT telefono, monto_total, serie,folio, fechahora, nombre, email FROM ventas 
	JOIN tutores ON tutores.id_tutor=ventas.id_tutor 
	WHERE id_venta=$id_venta";
	$q=mysqli_query($db,$sql);
	$dt=mysqli_fetch_assoc($q);
	if(validarEmail($dt['email'])){
		$email=$dt['email'];

		$sql = "SELECT cantidad,venta_detalle.precio,nombre,apaterno,amaterno,producto,alumnos_colegiatura.fecha as fecha_colegiatura, venta_detalle.tipo, alumnos_colegiatura.monto, alumnos_colegiatura.tipo AS inscripcion, alumnos_colegiatura.pagado FROM venta_detalle
		LEFT JOIN alumnos ON alumnos.id_alumno=venta_detalle.id_alumno
		LEFT JOIN productos ON productos.id_producto=venta_detalle.id_producto
		LEFT JOIN alumnos_colegiatura ON alumnos_colegiatura.id_alumno_colegiatura=venta_detalle.id_alumno_colegiatura
		WHERE id_venta = $id_venta";
		$q = mysqli_query($db,$sql);
		while($ft=mysqli_fetch_assoc($q)){
			$nombre_alumno=acentos($ft['apaterno'].' '.$ft['amaterno'].' '.$ft['nombre']);
			if($ft['tipo']==2){
					/*
					if($ft['descuento']){
						$descuento=$ft['descuento'];
						$montoBase=
					}else{
						$montoBase=$ft['monto'];
					}
					*/
					if($ft['pagado']==0){
						$abono="ABONO A";
					}
					
					if($ft['inscripcion']==2){
						$nombre_item = $abono." PAGO DE INSCRIPCIÓN";
					}else{
						$nombre_item = $abono." COLEGIATURA DEL MES DE ".strtoupper(fechaLetraCuatro($ft['fecha_colegiatura']));
					}
					
			}else{
					$nombre_item = acentos($ft2['producto']);
			}
			$sub = $ft['cantidad']*$ft['precio'];

			$var.= '<tr bgcolor="#fafafa" style="border: 1px solid #e6e6e6;">
							<td mc:edit="text007" align="left" class="text_color_282828" style="padding-top: 25px; padding-bottom: 25px;padding-right: 10px;padding-left: 15px;color: #282828; font-size: 14px; font-weight: 500; font-family: Open Sans, Helvetica, sans-serif; mso-line-height-rule: exactly;">
							<div class="editable-text">
							<span class="text_container">
							<multiline>'.$nombre_item.' DE '.$nombre_alumno.'</multiline>
							</span>
							</div>
							</td>
							<td mc:edit="text007" width="30" align="left" class="text_color_303f9f" style="padding-top: 25px; padding-bottom: 25px; padding-right: 15px;padding-left: 15px;color: #0c440c; font-size: 12px; font-weight: 600; font-family: Open Sans, Helvetica, sans-serif; mso-line-height-rule: exactly;">
							<div class="editable-text">
							<span class="text_container">
							<multiline>'.number_format($sub,2).'</multiline>
							</span>
							</div>
							</td>
						</tr>';
			$g_total+=$sub;
		}
		$var.= '<tr bgcolor="#fafafa" style="border: 1px solid #e6e6e6;">
				<td mc:edit="text007" colspan="2" width="30" align="right" class="text_color_303f9f" style="border-top: 1px solid #e6e6e6; padding-top: 25px; padding-bottom: 25px; padding-right: 15px;padding-left: 15px;color: #333; font-size: 12px; font-weight: 600; font-family: Open Sans, Helvetica, sans-serif; mso-line-height-rule: exactly;">
				<div class="editable-text">TOTAL: 
				<span class="text_container">
				<multiline> '.number_format($g_total,2).'</multiline>
				</span>
				</div>
				</td>
				</tr>';

		$titulo="Confirmación de Pago";
		$fecha=fechaLetraTres(date("Y-m-d"));
		$despedida="¡Gracias por su pago!";
		$saludo="Estimado ".ucwords(strtolower($dt['nombre']));
		$mensaje="Hemos recibido su pago, a continuación le enviamos su comprobante digital.";
		$tabla='<table  width="100%" class="" align="left" border="0" cellspacing="0" cellpadding="0" style="border: 1px solid #e6e6e6; padding-bottom: 0px; border-radius: 5px">'.$var.'</table>';

		$html='<table class="table_full editable-bg-color bg_color_e6e6e6 editable-bg-image" bgcolor="#e6e6e6" width="100%" align="center" mc:repeatable="castellab" mc:variant="Header" cellspacing="0" cellpadding="0" border="0"><tr><td><table width="600" align="center" border="0" cellspacing="0" cellpadding="0" style="margin: 0 auto;background-color: #0c440c;background-image: url(http://app.ceilor.mx/cubes.png);"><tr><td height="25"></td></tr><tr><td><table class="table1" width="520" align="center" border="0" cellspacing="0" cellpadding="0" style="margin: 0 auto;"><tr><td><table width="30%" align="left" border="0" cellspacing="0" cellpadding="0"><tr><td align="left"><a href="#" class="editable-img"><img editable="true" mc:edit="image001" src="http://app.ceilor.mx/LOGO_CEILOR.png" width="88" style="display:block; line-height:0; font-size:0; border:0;" border="0" alt="logo"/></a></td></tr><tr><td height="22"></td></tr></table> <table width="70%" align="right" border="0" cellspacing="0" cellpadding="0"><tr><td mc:edit="text002" align="right" style="color: #ffffff; font-size: 11px; font-weight: 200; font-family: lato, Helvetica, sans-serif; mso-line-height-rule: exactly;"><div class="editable-text"><span class="text_container"><multiline>FILÁNTROPICA Y EDUCATIVA DEL SUR DE QUINTANA ROO AC<br>CENTRO EDUCATIVO IGNACIO LÓPEZ RAYÓN<br>AV 16 DE SEPTIEMBRE #65 COL. CENTRO <br>CHETUMAL QUINTANA ROO C.P. 77000<br>TEL: (983) 127 8841 RFC: FES151204QJ1</multiline></span></div></td></tr><tr><td height="22"></td></tr></table></td></tr><tr><td mc:edit="text001" align="center" class="text_color_ffffff" style="color: #ffffff; font-size: 30px; font-weight: 700; font-family: lato, Helvetica, sans-serif; mso-line-height-rule: exactly;"><div class="editable-text"><span class="text_container"><multiline>'.$titulo.'</multiline></span></div></td></tr><tr><td height="30"></td></tr><tr><td mc:edit="text002" align="center" class="text_color_ffffff" style="color: #ffffff; font-size: 12px; font-weight: 300; font-family: lato, Helvetica, sans-serif; mso-line-height-rule: exactly;"><div class="editable-text"><span class="text_container"><multiline>'.$fecha.'</multiline></span></div></td></tr></table></td></tr><tr><td height="60"></td></tr></table></td></tr><tr><td><table class="table1 editable-bg-color bg_color_ffffff" bgcolor="#ffffff" width="600" align="center" border="0" cellspacing="0" cellpadding="0" style="margin: 0 auto;"><tr><td height="60"></td></tr><tr><td><table class="table1" width="520" align="center" border="0" cellspacing="0" cellpadding="0" style="margin: 0 auto;"><tr><td mc:edit="text003" align="left" class="center_content text_color_282828" style="color: #282828; font-size: 14px; font-weight: 900; font-family: lato, Helvetica, sans-serif; mso-line-height-rule: exactly;"><div class="editable-text"><span class="text_container"><multiline>'.$saludo.'</multiline></span></div></td></tr><tr><td height="15"></td></tr><tr><td mc:edit="text004" align="left" class="center_content text_color_282828" style="color: #282828; font-size: 14px;line-height: 2; font-weight: 500; font-family: lato, Helvetica, sans-serif; mso-line-height-rule: exactly;"><div class="editable-text" style="line-height: 2;"><span class="text_container"><multiline>'.$mensaje.'</multiline></span></div></td></tr><tr><td height="40"></td></tr><tr><td>'.$tabla.'</td></tr><tr><td height="30"></td></tr><tr><td><table class="table1-2" width="270" align="left" border="0" cellspacing="0" cellpadding="0"><tr><td mc:edit="text003" align="left" class="center_content text_color_282828" style="color: #282828; font-size: 14px; font-weight: 700; font-family: lato, Helvetica, sans-serif; mso-line-height-rule: exactly;"><div class="editable-text"><span class="text_container"><multiline>'.$despedida.'</multiline></span></div></td></tr><tr><td height="5"></td></tr><tr><td mc:edit="text004" align="left" class="center_content text_color_b0b0b0" style="color: #b0b0b0; font-size: 14px;line-height: 2; font-weight: 300; font-family: lato, Helvetica, sans-serif; mso-line-height-rule: exactly;"><div class="editable-text" style="line-height: 2;"><span class="text_container"><multiline>Centro Educativo López Rayón <br>Enseñando el camino </multiline></span></div></td></tr><tr><td height="30"></td></tr></table><table class="tablet_hide" width="40" align="left" border="0" cellspacing="0" cellpadding="0"><tr><td height="1"></td></tr></table></td></tr></table></td></tr><tr><td height="30"></td></tr></table></td></tr><tr><td><table class="table1" width="600" align="center" border="0" cellspacing="0" cellpadding="0" style="margin: 0 auto;"> <tr><td height="70"></td></tr><tr><td mc:edit="text010" align="center" class="center_content text_color_929292" style="color: #929292; font-size: 14px; line-height: 2; font-weight: 400; font-family: lato, Helvetica, sans-serif; mso-line-height-rule: exactly;"><div class="editable-text" style="line-height: 2;"><span class="text_container"><multiline>Correo generado automáticamente, dudas o aclaraciones en: hola@ceilor.mx<br>Powered by <a href="https://conexia.mx" target="_blank">Conexia</a></multiline></span></div></td></tr><tr><td height="70"></td></tr></table></td></tr></table>';
		
		$remite 			= "CEILOR <robot@adminbooks.mx>";
		$destino 			= $email;
		$asunto 			= "Confirmación de Pago";
		$mensaje_html 		= $html;
		
		$postmark = new Postmark(null,$remite);
		$postmark->to($destino);
		$postmark->subject($asunto);
		$postmark->html_message($mensaje_html);
		//$postmark->adjunta_vato($adjuntos);
		
		//$postmark->send(); #SIN IF.
		
		$resultado=$postmark->send();
		//file_put_contents('log_postmark.txt',$resultado);
		$messageid=$resultado->MessageID;
		if($messageid){
			//mysqli_query($db,"UPDATE tareas SET message_id='$messageid', estado_email_entregado=0 WHERE id_tarea='$id_tarea'");
			//$error=false;
			//echo "pok";
			return true;
		}else{
			//echo "error1";
			return false;
		}
	}else{
		//echo "error2";
		return false;
	}
}


function errorMsg($msg,$tipo){
	return '<div class="page-content-wrapper"><div class="page-content"><div class="row"><div class="col-md-12"> <div class="alert alert-'.$tipo.'" role="alert" id="msg_error">'.$msg.'</div> </div></div></div></div>';
}

function tipoDescuento($tipo){

	switch($tipo){
		case 1:
		$tipoDescuento="SEYQ";
		break;

		case 2:
		$tipoDescuento="TRABAJO";
		break;

		case 3:
		$tipoDescuento="DOCENTE";
		break;

		case 4:
		$tipoDescuento="TEMPORAL";
		break;
	}
	
	return $tipoDescuento;
}

function calculaDescuento($monto,$descuento){
	$desc=100-$descuento;
	$condonado=$monto*100/$desc;

	return $condonado-$monto;
}

function descuento($monto,$descuento){
	$desc=$monto*$descuento/100;

	return $desc;
}

function dameCiclo($id_ciclo){
	global $db;
	$sql="SELECT ciclo FROM ciclos WHERE id_ciclo=$id_ciclo";
	$q=mysqli_query($db,$sql);
	$ft=mysqli_fetch_assoc($q);
	return $ft['ciclo'];
}

function recuperaPassNuevo($id_tutor){

	require ('postmark.php');
	global $db;
	
	$sql="SELECT token, nombre, email FROM tutores
	WHERE id_tutor=$id_tutor";
	$q=mysqli_query($db,$sql);
	$dt=mysqli_fetch_assoc($q);

	$nombreTutor=ucwords(strtolower($dt['nombre']));
	$emailTutor=$dt['email'];
	$token=$dt['token'];

	$vinculo="https://tutores.ceilor.mx/login.php?token=".$token;

	$titulo="Recuperación de contraseña";
	$fecha=fechaLetraTres(date("Y-m-d"));
	// $despedida="¡Gracias por su pago!";
	$saludo="Estimado ".$nombreTutor;
	$mensaje="Hemos recibido una solicitud de recuperación de contraseña, en el siguiente vínculo podrá generar una nueva contraseña.";
	$tabla='<table width="100%" border="0" cellspacing="0" cellpadding="0"><tbody><tr><td align="center"><div><a href="'.$vinculo.'" style="background-color: #0c440c; border: 1px solid #0c440c; border-radius: 3px; color: #ffffff; display: inline-block; font-family: sans-serif; font-size: 16px; line-height: 44px; text-align: center; text-decoration: none; width: 250px; -webkit-text-size-adjust: none; mso-hide: all;">Restablecer Contrase&ntilde;a</a></div></td></tr></tbody></table>';

	$html='<table class="table_full editable-bg-color bg_color_e6e6e6 editable-bg-image" bgcolor="#e6e6e6" width="100%" align="center" mc:repeatable="castellab" mc:variant="Header" cellspacing="0" cellpadding="0" border="0"><tr><td><table width="600" align="center" border="0" cellspacing="0" cellpadding="0" style="margin: 0 auto;background-color: #0c440c;background-image: url(http://app.ceilor.mx/cubes.png);"><tr><td height="25"></td></tr><tr><td><table class="table1" width="520" align="center" border="0" cellspacing="0" cellpadding="0" style="margin: 0 auto;"><tr><td><table width="30%" align="left" border="0" cellspacing="0" cellpadding="0"><tr><td align="left"><a href="#" class="editable-img"><img editable="true" mc:edit="image001" src="http://app.ceilor.mx/LOGO_CEILOR.png" width="88" style="display:block; line-height:0; font-size:0; border:0;" border="0" alt="logo"/></a></td></tr><tr><td height="22"></td></tr></table> <table width="70%" align="right" border="0" cellspacing="0" cellpadding="0"><tr><td mc:edit="text002" align="right" style="color: #ffffff; font-size: 11px; font-weight: 200; font-family: lato, Helvetica, sans-serif; mso-line-height-rule: exactly;"><div class="editable-text"><span class="text_container"><multiline>FILÁNTROPICA Y EDUCATIVA DEL SUR DE QUINTANA ROO AC<br>CENTRO EDUCATIVO IGNACIO LÓPEZ RAYÓN<br>AV 16 DE SEPTIEMBRE #65 COL. CENTRO <br>CHETUMAL QUINTANA ROO C.P. 77000<br>TEL: (983) 127 8841 RFC: FES151204QJ1</multiline></span></div></td></tr><tr><td height="22"></td></tr></table></td></tr><tr><td mc:edit="text001" align="center" class="text_color_ffffff" style="color: #ffffff; font-size: 30px; font-weight: 700; font-family: lato, Helvetica, sans-serif; mso-line-height-rule: exactly;"><div class="editable-text"><span class="text_container"><multiline>'.$titulo.'</multiline></span></div></td></tr><tr><td height="30"></td></tr><tr><td mc:edit="text002" align="center" class="text_color_ffffff" style="color: #ffffff; font-size: 12px; font-weight: 300; font-family: lato, Helvetica, sans-serif; mso-line-height-rule: exactly;"><div class="editable-text"><span class="text_container"><multiline>'.$fecha.'</multiline></span></div></td></tr></table></td></tr><tr><td height="60"></td></tr></table></td></tr><tr><td><table class="table1 editable-bg-color bg_color_ffffff" bgcolor="#ffffff" width="600" align="center" border="0" cellspacing="0" cellpadding="0" style="margin: 0 auto;"><tr><td height="60"></td></tr><tr><td><table class="table1" width="520" align="center" border="0" cellspacing="0" cellpadding="0" style="margin: 0 auto;"><tr><td mc:edit="text003" align="left" class="center_content text_color_282828" style="color: #282828; font-size: 14px; font-weight: 900; font-family: lato, Helvetica, sans-serif; mso-line-height-rule: exactly;"><div class="editable-text"><span class="text_container"><multiline>'.$saludo.'</multiline></span></div></td></tr><tr><td height="15"></td></tr><tr><td mc:edit="text004" align="left" class="center_content text_color_282828" style="color: #282828; font-size: 14px;line-height: 2; font-weight: 500; font-family: lato, Helvetica, sans-serif; mso-line-height-rule: exactly;"><div class="editable-text" style="line-height: 2;"><span class="text_container"><multiline>'.$mensaje.'</multiline></span></div></td></tr><tr><td height="40"></td></tr><tr><td>'.$tabla.'</td></tr><tr><td height="30"></td></tr><tr><td><table class="table1-2" width="270" align="left" border="0" cellspacing="0" cellpadding="0"><tr><td mc:edit="text003" align="left" class="center_content text_color_282828" style="color: #282828; font-size: 14px; font-weight: 700; font-family: lato, Helvetica, sans-serif; mso-line-height-rule: exactly;"><div class="editable-text"><span class="text_container"><multiline>'.$despedida.'</multiline></span></div></td></tr><tr><td height="5"></td></tr><tr><td mc:edit="text004" align="left" class="center_content text_color_b0b0b0" style="color: #b0b0b0; font-size: 14px;line-height: 2; font-weight: 300; font-family: lato, Helvetica, sans-serif; mso-line-height-rule: exactly;"><div class="editable-text" style="line-height: 2;"><span class="text_container"><multiline>Centro Educativo López Rayón <br>Enseñando el camino </multiline></span></div></td></tr><tr><td height="30"></td></tr></table><table class="tablet_hide" width="40" align="left" border="0" cellspacing="0" cellpadding="0"><tr><td height="1"></td></tr></table></td></tr></table></td></tr><tr><td height="30"></td></tr></table></td></tr><tr><td><table class="table1" width="600" align="center" border="0" cellspacing="0" cellpadding="0" style="margin: 0 auto;"> <tr><td height="70"></td></tr><tr><td mc:edit="text010" align="center" class="center_content text_color_929292" style="color: #929292; font-size: 14px; line-height: 2; font-weight: 400; font-family: lato, Helvetica, sans-serif; mso-line-height-rule: exactly;"><div class="editable-text" style="line-height: 2;"><span class="text_container"><multiline>Correo generado automáticamente, dudas o aclaraciones en: hola@ceilor.mx<br>Powered by <a href="https://conexia.mx" target="_blank">Conexia</a></multiline></span></div></td></tr><tr><td height="70"></td></tr></table></td></tr></table>';
	
	$remite 			= "Servicios Ceilor <hola@ceilor.mx>";
	$destino 			= $emailTutor;
	$asunto 			= "Recuperación de contraseña";
	$mensaje_html 		= $html;
	
	$postmark = new Postmark(null,$remite);
	$postmark->to($destino);
	$postmark->subject($asunto);
	$postmark->html_message($mensaje_html);
	//$postmark->adjunta_vato($adjuntos);
	
	//$postmark->send(); #SIN IF.
	//exit;
	$resultado=$postmark->send();
	//file_put_contents('log_postmark.txt',$resultado);
	$messageid=$resultado->MessageID;
	if($messageid){
		//mysqli_query($db,"UPDATE tareas SET message_id='$messageid', estado_email_entregado=0 WHERE id_tarea='$id_tarea'");
		//$error=false;
		//echo "pok";
		return true;
	}else{
		//echo "error1";
		return false;
	}
	
}
<?
include("../includes/session.php");
include('../includes/db.php');
include('../includes/funciones.php');
require '../vendor/autoload.php';
use Aws\S3\S3Client;
use Aws\CommandPool;
use Aws\CommandInterface;
use Aws\Exception\AwsException;
use Guzzle\Service\Exception\CommandTransferException;

function nameFile($archivo){
	$ext = pathinfo($archivo, PATHINFO_EXTENSION);
	$fileName = mt_rand(100,999)."_".date("Ymd").".".$ext;
	//$nameFolder = 'archivosAlumnos/'.$fileName;
	return $fileName;
}
function s3Document ($tmp, $nameFile, $ContentType) {
	$s3 = new S3Client([
		'region'  => 'us-east-2',
		'version' => 'latest',
		'credentials' => [
			'key'    => "AKIAINXAMVJ3AW7VXIPQ",
			'secret' => "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",
		]
	]);
	try {		
		$result = $s3->putObject([
			'Bucket' => 'ceilor',
			'Key'    => 'archivosAlumnos/'.$nameFile,
            'Body'   => 'this is the body!',
            'ACL' => 'public-read',
			'SourceFile' => $nameFile,
			'ContentType' => $ContentType
		]);
        return $result['ObjectURL'];
	} catch (S3Exception $e) {
		echo $e->getMessage() . PHP_EOL;
	}
}

$id_alumno = $_POST['token'];
if(isset($_FILES["cartaASD"])){
	$ret = array();

	$error = $_FILES["cartaASD"]["error"];
	if($error){
		$custom_error['jquery-upload-file-error']="Ocurrió un error, intente nuevamente.";
		echo json_encode($custom_error);
		exit;
	}
	
 	$nombre_real = $_FILES["cartaASD"]["name"];
	$tmp = $_FILES["files"]["tmp_name"];
	$nameFile = nameFile($nombre_real);
	move_uploaded_file($_FILES["cartaASD"]["tmp_name"],$nameFile);

	$ext_archivo = pathinfo($nombre_real, PATHINFO_EXTENSION);
	$ContentType = extContentType($ext_archivo);
	
	$url_nube =  s3Document($tmp, $nameFile, $ContentType);
    if($url_nube){
		$q = mysqli_query($db,"UPDATE alumnos SET cartaASD='$url_nube' WHERE id_alumno=$id_alumno") or exit('Error al actulizar.');
		if($q){
			unlink($nameFile);
			$ret[]= $url_nube;
			echo json_encode($ret);
			exit;
		}else{
			$custom_error['jquery-upload-file-error']="Ocurrió un error, intente nuevamente [8782].";
			echo json_encode($custom_error);
			exit;
		}
    }else{
        $custom_error['jquery-upload-file-error']="Ocurrió un error, intente nuevamente [4234].";
		echo json_encode($custom_error);
		exit;
    }
}

if(isset($_FILES["uploadINEMadre"])){
	$ret = array();

	$error = $_FILES["uploadINEMadre"]["error"];
	if($error){
		$custom_error['jquery-upload-file-error']="Ocurrió un error, intente nuevamente.";
		echo json_encode($custom_error);
		exit;
	}
	
 	$nombre_real = $_FILES["uploadINEMadre"]["name"];
	$tmp = $_FILES["files"]["tmp_name"];
	$nameFile = nameFile($nombre_real);
	move_uploaded_file($_FILES["uploadINEMadre"]["tmp_name"],$nameFile);

	$ext_archivo = pathinfo($nombre_real, PATHINFO_EXTENSION);
	$ContentType = extContentType($ext_archivo);
	
	$url_nube =  s3Document($tmp, $nameFile, $ContentType);
    if($url_nube){
		$q = mysqli_query($db,"UPDATE alumnos SET uploadINEMadre='$url_nube' WHERE id_alumno=$id_alumno") or exit('Error al actulizar.');
		if($q){
			unlink($nameFile);
			$ret[]= $url_nube;
			echo json_encode($ret);
			exit;
		}else{
			$custom_error['jquery-upload-file-error']="Ocurrió un error, intente nuevamente [8782].";
			echo json_encode($custom_error);
			exit;
		}
    }else{
        $custom_error['jquery-upload-file-error']="Ocurrió un error, intente nuevamente [4234].";
		echo json_encode($custom_error);
		exit;
    }
}


if(isset($_FILES["uploadINEPadre"])){
	$ret = array();

	$error = $_FILES["uploadINEPadre"]["error"];
	if($error){
		$custom_error['jquery-upload-file-error']="Ocurrió un error, intente nuevamente.";
		echo json_encode($custom_error);
		exit;
	}
	
 	$nombre_real = $_FILES["uploadINEPadre"]["name"];
	$tmp = $_FILES["files"]["tmp_name"];
	$nameFile = nameFile($nombre_real);
	move_uploaded_file($_FILES["uploadINEPadre"]["tmp_name"],$nameFile);

	$ext_archivo = pathinfo($nombre_real, PATHINFO_EXTENSION);
	$ContentType = extContentType($ext_archivo);
	
	$url_nube =  s3Document($tmp, $nameFile, $ContentType);
    if($url_nube){
		$q = mysqli_query($db,"UPDATE alumnos SET uploadINEPadre='$url_nube' WHERE id_alumno=$id_alumno") or exit('Error al actulizar.');
		if($q){
			unlink($nameFile);
			$ret[]= $url_nube;
			echo json_encode($ret);
			exit;
		}else{
			$custom_error['jquery-upload-file-error']="Ocurrió un error, intente nuevamente [8782].";
			echo json_encode($custom_error);
			exit;
		}
    }else{
        $custom_error['jquery-upload-file-error']="Ocurrió un error, intente nuevamente [4234].";
		echo json_encode($custom_error);
		exit;
    }
}



if(isset($_FILES["uploadCURP"])){
	$ret = array();

	$error = $_FILES["uploadCURP"]["error"];
	if($error){
		$custom_error['jquery-upload-file-error']="Ocurrió un error, intente nuevamente.";
		echo json_encode($custom_error);
		exit;
	}
	
 	$nombre_real = $_FILES["uploadCURP"]["name"];
	$tmp = $_FILES["files"]["tmp_name"];
	$nameFile = nameFile($nombre_real);
	move_uploaded_file($_FILES["uploadCURP"]["tmp_name"],$nameFile);

	$ext_archivo = pathinfo($nombre_real, PATHINFO_EXTENSION);
	$ContentType = extContentType($ext_archivo);
	
	$url_nube =  s3Document($tmp, $nameFile, $ContentType);
    if($url_nube){
		$q = mysqli_query($db,"UPDATE alumnos SET uploadCURP='$url_nube' WHERE id_alumno=$id_alumno") or exit('Error al actulizar.');
		if($q){
			unlink($nameFile);
			$ret[]= $url_nube;
			echo json_encode($ret);
			exit;
		}else{
			$custom_error['jquery-upload-file-error']="Ocurrió un error, intente nuevamente [8782].";
			echo json_encode($custom_error);
			exit;
		}
    }else{
        $custom_error['jquery-upload-file-error']="Ocurrió un error, intente nuevamente [4234].";
		echo json_encode($custom_error);
		exit;
    }
}



if(isset($_FILES["uploadActa"])){
	$ret = array();

	$error = $_FILES["uploadActa"]["error"];
	if($error){
		$custom_error['jquery-upload-file-error']="Ocurrió un error, intente nuevamente.";
		echo json_encode($custom_error);
		exit;
	}
	
 	$nombre_real = $_FILES["uploadActa"]["name"];
	$tmp = $_FILES["files"]["tmp_name"];
	$nameFile = nameFile($nombre_real);
	move_uploaded_file($_FILES["uploadActa"]["tmp_name"],$nameFile);

	$ext_archivo = pathinfo($nombre_real, PATHINFO_EXTENSION);
	$ContentType = extContentType($ext_archivo);
	
	$url_nube =  s3Document($tmp, $nameFile, $ContentType);
    if($url_nube){
		$q = mysqli_query($db,"UPDATE alumnos SET uploadActa='$url_nube' WHERE id_alumno=$id_alumno") or exit('Error al actulizar.');
		if($q){
			unlink($nameFile);
			$ret[]= $url_nube;
			echo json_encode($ret);
			exit;
		}else{
			$custom_error['jquery-upload-file-error']="Ocurrió un error, intente nuevamente [8782].";
			echo json_encode($custom_error);
			exit;
		}
    }else{
        $custom_error['jquery-upload-file-error']="Ocurrió un error, intente nuevamente [4234].";
		echo json_encode($custom_error);
		exit;
    }
}

$custom_error= array();
$custom_error['jquery-upload-file-error']="Error [2091]";
echo json_encode($custom_error);
exit;
?>
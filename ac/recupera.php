<?
require '../includes/db.php';
require '../includes/funciones.php';

extract($_POST);

	if(!$email) exit("Es necesario que escriba su dirección de E-mail.");
	//if(!validarEmail($email)) exit("El correo <strong>".escapar($email)."</strong> no es válido, verifique el formato.");

	$sq="SELECT * FROM tutores WHERE email='$email' AND activo=1";
	$q=mysqli_query($db,$sq);
	$val=mysqli_num_rows($q);
	if($val){
		$ft=mysqli_fetch_assoc($q);
		$id_tutor=$ft['id_tutor'];
		$token=md5("CEILOR".$id_tutor);
		//update token
		$sql="UPDATE tutores SET token='$token' WHERE id_tutor=$id_tutor";
		$q=mysqli_query($db,$sql) or exit("Ocurrió un error, intenta nuevamente.");

		if(recuperaPassNuevo($id_tutor)){
			echo "1";
		}else{
			exit("Ocurrió un error, intenta nuevamente [2432].");
		}

	}else{
		exit("El correo <strong>".escapar($email)."</strong> no existe en nuestros registros, puedes usarlo para crear una cuenta.");
	}

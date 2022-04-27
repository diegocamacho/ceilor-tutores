<?
session_start();
require '../includes/db.php';
require '../includes/funciones.php';

date_default_timezone_set ("America/Cancun");
$fecha_hora=date("Y-m-d H:i:s");



if(!$_POST['contrasena1']) exit("Debe escribir su usuario");
if(!$_POST['contrasena2']) exit("Debe escribir su contraseña");
if(!$_POST['token']) exit("Debe escribir su contraseña");

	if(isset ($_POST['contrasena1']) && ($_POST['token'])){

		$contrasena=mysqli_real_escape_string($db, $_POST['contrasena1']);
		$token=mysqli_real_escape_string($db, $_POST['token']);
		
		// Admin
 		$sql = "SELECT * FROM tutores WHERE token='$token' AND activo='1' LIMIT 1";
		$res = mysqli_query($db, $sql) or die ('Error en db');
		$val = mysqli_num_rows($res);
		if($val!=0){
			$dt=mysqli_fetch_assoc($res);
			$id_tutor=$dt['id_tutor'];
			$nombre=$dt['nombre'];
			$foto=$dt['foto'];

			$contrasena=contrasena($contrasena);
			
			mysqli_query($db,"UPDATE tutores SET contrasena='$contrasena', token='' WHERE id_tutor=$id_tutor");

			$sql="SELECT ciclo_activo FROM configuracion_empresa WHERE id_empresa=1";
			$q=mysqli_query($db,$sql);
			$ft=mysqli_fetch_assoc($q);
			$id_ciclo=$ft['ciclo_activo'];
			
			$_SESSION['s_id'] = $id_tutor;
			$_SESSION['s_tipo'] = 1;
			$_SESSION['s_nombre'] = $nombre;
			$_SESSION['s_display'] = $foto;
			$_SESSION['ceilorTutores'] = 1;
			$_SESSION['s_id_ciclo'] = $id_ciclo;
			
			mysqli_query($db,"UPDATE tutores SET ultimo_acceso='$fecha_hora' WHERE id_tutor=$id_tutor");

			echo "1";
		}else{
			exit('Ocurrió un error, comuniquesé a la escuela. ');
		}

	}

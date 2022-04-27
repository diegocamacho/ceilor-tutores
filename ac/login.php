<?
session_start();
require '../includes/db.php';
require '../includes/funciones.php';

date_default_timezone_set ("America/Mexico_City");
$fecha_hora=date("Y-m-d H:i:s");



if(!$_POST['email']) exit("Debe escribir su usuario");
if(!$_POST['pass']) exit("Debe escribir su contraseña");

	if(isset ($_POST['email']) && ($_POST['pass']))
	{

		$usuario=mysqli_real_escape_string($db, $_POST['email']);
		$contrasena=mysqli_real_escape_string($db, $_POST['pass']);
		$contrasena=contrasena($contrasena);
		// Admin
 		$sql = "SELECT * FROM tutores WHERE email='$usuario' AND contrasena='$contrasena' AND activo='1' LIMIT 1";
		$res = mysqli_query($db, $sql) or die ('Error en db');
		$num_result = mysqli_num_rows($res);
		if($num_result != 0){
			$sql="SELECT ciclo_activo FROM configuracion_empresa WHERE id_empresa=1";
			$q=mysqli_query($db,$sql);
			$ft=mysqli_fetch_assoc($q);
			$id_ciclo=$ft['ciclo_activo'];
			while ($row=mysqli_fetch_object($res))
				{
					$_SESSION['s_id'] = $row->id_tutor;
					$_SESSION['s_tipo'] = 1;
					$_SESSION['s_nombre'] = $row->nombre;
					$_SESSION['s_display'] = $row->foto;
					$_SESSION['ceilorTutores'] = 1;
					$_SESSION['s_id_ciclo'] = $id_ciclo;
				}
			// if(mysqli_query($db,"UPDATE tutores SET ultimo_acceso='$fecha_hora' WHERE id_tutor='".$_SESSION['s_id']."'")){
			// 	echo "1";
			// }
			echo "1";
		}else{
			exit('Datos de acceso incorrectos, por favor intente nuevamente. ');
		}

	}

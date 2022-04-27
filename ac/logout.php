<?

session_start();
unset($_SESSION['s_id']); 
unset($_SESSION['s_nombre']);
unset($_SESSION['s_tipo']);
unset($_SESSION['s_id_clinica']);
unset($_SESSION['s_display']);
	
session_destroy();
header("Location: ../login.php");
exit;

?>

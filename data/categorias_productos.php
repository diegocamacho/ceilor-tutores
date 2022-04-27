<?
include("../includes/session.php");
include("../includes/db.php");
include("../includes/funciones.php");
$id_producto=escapar($_GET['id_producto'],1);

$sql="SELECT * FROM categorias_productos";
$q=mysqli_query($db,$sql);
$val=mysqli_num_rows($q);
if($val){
    while($datos=mysqli_fetch_assoc($q)):
        $lista.="<option value='".$datos["id_categoria_producto"]."'>".$datos["categoria"]."</option>";
    endwhile;
    echo json_encode(array("error"=>false, "msg"=>'Good', "datos"=>$lista));
}else{
    echo json_encode(array("error"=>true, "msg"=>'Error al obtener las categorías para los productos, intente de nuevo más tarde.'));
}

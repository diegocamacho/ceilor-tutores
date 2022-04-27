<?php
include("../includes/session.php");
include("../includes/db.php");
include("../includes/funciones.php");
extract($_POST);
$id_ciclo = $_SESSION['ciclo'];
    switch($action):
        case 'getAlumnoxTutor':
            $tutor_id=escapar($tutor_id,1);
            $sql="SELECT * FROM alumnos WHERE id_tutor=$tutor_id and activo = 1";
            $q=mysqli_query($db,$sql);
            $val=mysqli_num_rows($q);
            if($q){
                if($val>0){
                    $lista.="<option value='0' selected disabled>Seleccione un alumno</option>";
                    while($datos=mysqli_fetch_assoc($q)):
                        $lista.="<option value='".$datos["id_alumno"]."'>".$datos["apaterno"]." ".$datos["amaterno"]." ".$datos["nombre"]."</option>";
                    endwhile;
                    echo json_encode(array("error"=>false, "msg"=>'Good', "data"=>$lista));
                }else {
                    echo json_encode(array("error"=>true, "msg"=>'El tutor no tiene alumnos asignados'));
                }
            }else{
                echo json_encode(array("error"=>true, "msg"=>'No se pudo obtener los datos de los alumnos para este tutor, intente de nuevo
                más tarde.'));
            }
        break;
        case 'getProductos':
            if($tipo == 2){
                $sql="SELECT * from alumnos_colegiatura where id_alumno = $id_alumno and id_ciclo = $id_ciclo and pagado = 0 ORDER BY fecha ASC";
                $q=mysqli_query($db,$sql);
                $val=mysqli_num_rows($q);
                if($q){
                    if($val>0){
                        $lista.="<option value='0' selected disabled>Seleccione una Colegiatura</option>";
                        while($datos=mysqli_fetch_assoc($q)):
                            $lista.="<option value='".$datos["id_alumno_colegiatura"]."'>".$datos["descripcion"]."</option>";
                        endwhile;
                        echo json_encode(array("error"=>false, "msg"=>'Good', "data"=>$lista));
                    }else {
                        echo json_encode(array("error"=>true, "msg"=>'No hay colegiatura adeudadas'));
                    }
                }else{
                    echo json_encode(array("error"=>true, "msg"=>'No se pudo obtener los datos de los alumnos para este tutor, intente de nuevo
                    más tarde.'));
                } 
            }else {
                $sql="SELECT * from productos where activo = 1 ORDER BY producto ASC";
                $q=mysqli_query($db,$sql);
                $val=mysqli_num_rows($q);
                if($q){
                    if($val>0){
                        $lista.="<option value='0' selected disabled>Seleccione un producto</option>";
                        while($datos=mysqli_fetch_assoc($q)):
                            $lista.="<option value='".$datos["id_producto"]."'>".$datos["producto"]."</option>";
                        endwhile;
                        echo json_encode(array("error"=>false, "msg"=>'Good', "data"=>$lista));
                    }else {
                        echo json_encode(array("error"=>true, "msg"=>'No hay producto'));
                    }
                }else{
                    echo json_encode(array("error"=>true, "msg"=>'No se pudo obtener los datos de los alumnos para este tutor, intente de nuevo
                    más tarde.'));
                }
            }
        break;
        case 'setProducto':
            if($tipo == 2){
                $sql="SELECT 
                    alumnos_colegiatura.id_alumno_colegiatura,
                    alumnos_colegiatura.id_alumno,
                    alumnos_colegiatura.descripcion,
                    alumnos_colegiatura.monto,
                    alumnos_colegiatura.fecha,
                    alumnos.nombre, 
                    alumnos.apaterno,
                    alumnos.amaterno
                from alumnos_colegiatura 
                inner join alumnos on alumnos.id_alumno = alumnos_colegiatura.id_alumno
                where id_alumno_colegiatura = $id_producto and pagado = 0";
                $q=mysqli_query($db,$sql);
                $ft=mysqli_fetch_assoc($q);
                $sql_abono="SELECT IFNULL(sum(precio), 0) as abonoTotal from venta_detalle where id_alumno_colegiatura = $id_producto";
                $q_abono=mysqli_query($db,$sql_abono);
                $ft_abono=mysqli_fetch_assoc($q_abono);
                if ($ft) {
                    echo json_encode(array(
                        "amaterno"=>$ft['amaterno'], 
                        "apaterno"=>$ft['apaterno'],
                        "nombre"=>$ft['nombre'], 
                        "descripcion"=>$ft['descripcion'], 
                        "id_alumno" => $ft['id_alumno'], 
                        "id_alumno_colegiatura"=>$ft['id_alumno_colegiatura'],
                        "monto"=>$ft['monto'],
                        "abono"=>$ft_abono['abonoTotal'],
                        "fechaCole"=>$ft['fecha']
                    ));
                } else {
                    echo json_encode(array("error"=>true, "mensaje"=>'Error problema persiste contacte a soporte técnico setProducto'));
                }
            }else {
                $sql_pro = "SELECT * from productos where id_producto = $id_producto";
                $q_pro=mysqli_query($db,$sql_pro);
                $ft_pro=mysqli_fetch_assoc($q_pro);

                $sql_alum="SELECT * from alumnos where id_alumno = $id_alumno";
                $q_alum=mysqli_query($db,$sql_alum);
                $ft_alum=mysqli_fetch_assoc($q_alum);
                if ($ft_alum) {
                    echo json_encode(array(
                        "amaterno"=>$ft_alum['amaterno'], 
                        "apaterno"=>$ft_alum['apaterno'],
                        "nombre"=>$ft_alum['nombre'], 
                        "descripcion"=>$ft_pro['producto'], 
                        "id_alumno" => $ft_alum['id_alumno'], 
                        "id_producto"=>$ft_pro['id_producto'],
                        "monto"=>$ft_pro['precio'],
                        "abono"=>"0"
                    ));
                } else {
                    echo json_encode(array("error"=>true, "mensaje"=>'Error problema persiste contacte a soporte técnico setProducto'));
                }
            }
        break;
        case 'getDescuento':
            $sql_aca ="SELECT * from descuentos where id_descuento = $descuento_id";
                $q_aca=mysqli_query($db,$sql_aca);
                $ft_aca=mysqli_fetch_assoc($q_aca);
            echo json_encode(array(
                "error"=> false,
                "descuento"=>$ft_aca['porcentaje']
            ));
        break;
        default:
        break;

    endswitch;
?>
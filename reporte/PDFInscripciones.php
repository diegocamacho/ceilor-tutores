<?php set_time_limit(0); 
ob_start(); 
include("../includes/session.php");
include("../includes/db.php");
include("../includes/funciones.php");


$id_nivel=$_GET['id_nivel'];
$id_alumno=$_GET['id_alumno'];

$consulta = " SELECT alumnos.apaterno, alumnos.amaterno, alumnos.nombre,
alumnos.fecha_nacimiento, alumnos.iglesia, denominaciones.denominacion,
distritos.distrito, alumnos.genero, alumnos.vive_con, alumnos.comentarios
FROM alumnos alumnos JOIN denominaciones denominaciones ON alumnos.id_denominacion = denominaciones.id_denominacion
JOIN distritos distritos ON alumnos.id_distrito = distritos.id_distrito WHERE alumnos.id_alumno = $id_alumno";
$consulta_padre = "SELECT alumnos_padre.padre_nombre, alumnos_padre.padre_ocupacion,
denominaciones.denominacion, alumnos_padre.padre_telefono, alumnos_padre.padre_direccion
FROM alumnos_padre alumnos_padre JOIN denominaciones denominaciones ON alumnos_padre.padre_id_denominacion = denominaciones.id_denominacion
 WHERE alumnos_padre.id_alumno = $id_alumno";
$consulta_madre = " SELECT alumnos_madre.madre_nombre, alumnos_madre.madre_ocupacion,
denominaciones.denominacion, alumnos_madre.madre_telefono, alumnos_madre.madre_direccion
FROM alumnos_madre alumnos_madre JOIN denominaciones denominaciones ON alumnos_madre.madre_id_denominacion = denominaciones.id_denominacion
WHERE alumnos_madre.id_alumno = $id_alumno";
$q_alumno=mysqli_query($db,$consulta);
$q_padre=mysqli_query($db,$consulta_padre);
$q_madre=mysqli_query($db,$consulta_madre);
while($ft=mysqli_fetch_assoc($q_alumno)) { 
    $nombre = $ft['nombre'];
    $apaterno = $ft['apaterno'];
    $amaterno = $ft['amaterno'];
    $fecha_nac = $ft['fecha_nacimiento'];
    $iglesia = $ft['iglesia'];
    $religion = $ft['denominacion'];
    $distrito = $ft['distrito'];
    $genero = $ft['genero'];
    $vive_con = $ft['vive_con'];
    $comentarios = $ft['comentarios'];
}
while($ft=mysqli_fetch_assoc($q_padre)) { 
    $padre_nombre = $ft['padre_nombre'];
    $padre_ocupacion = $ft['padre_ocupacion'];
    $padre_religion = $ft['denominacion'];
    $padre_telefono = $ft['padre_telefono'];
    $padre_direccion = $ft['padre_direccion'];
}
while($ft=mysqli_fetch_assoc($q_madre)) { 
    $madre_nombre = $ft['madre_nombre'];
    $madre_ocupacion = $ft['madre_ocupacion'];
    $madre_religion = $ft['denominacion'];
    $madre_telefono = $ft['madre_telefono'];
    $madre_direccion = $ft['madre_direccion'];
}
 
?>

<style type="text/css">
body {
    margin-left:0px;
    margin-right:0px;
    margin-top:0px;
    margin-bottom:0px;
    font-family: "Arial Narrow", Arial, serif;
  }
.info{ 
	font-size: 16px;
}
.info td{
	padding: 10px;
}
.cal{ 
	font-size: 10px;
}
.cal td{
	padding: 3px;
    font-size:12px;
}
table.page_header {width: 100%; border: none; padding-top: 2mm; font-size: 14px; font-weight: bold; }
table.page_footer {
	width: 100%; 
	padding: 2mm;
	font-size: 11px;
	padding-bottom: 10px;
}
.sansserif {
  font-family: Arial, Helvetica, sans-serif;
}
</style>


      
    
    <page backtop="22mm" backbottom="10mm" backleft="10mm" backright="10mm" footer="page">
    <page_header>
                <table style="padding-left:10px;margin-top:30px;">
                    <tr>
                        <td>
                            <table  width="300" align="left" border="0" cellpadding="0" cellspacing="0" class="cal">  
                                <tr>
                                    <td align="right" style="padding-left:50px;padding-top:0px;">
                                        <img src="../LOGO_CEILOR.png" width="90" />
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td>
                            <table  style="margin-left:100px;" width="500" align="left" border="0" cellpadding="0" cellspacing="0" class="cal">  
                                <tr>
                                    <td align="right" style="width: 100%;font-size: 15px;font-weight:bold;">FILANTR??PICA Y EDUCATIVA DEL SUR DE QUINTANA ROO A. C.</td>
                                </tr>
                                <tr>
                                    <td align="right" style="width: 100%;font-size: 14px;font-weight:bold;">CENTRO EDUCATIVO IGNACIO L??PEZ RAY??N</td>
                                </tr>
                                <tr>
                                    <td align="right" style="width: 100%;font-size: 11px;" class="sansserif">Av. 16 de septiembre No. 67, Chetumal, Q. R. Tel 83-31410</td>
                                </tr>
                                <tr>
                                    <td align="right" style="width: 100%;font-size: 14px;font-weight:bold;">PREESCOLAR</td>
                                </tr>           
                            </table>
                        </td>
                    </tr>
                </table>
        </page_header>
        <table style="width:100%;padding-left:0px;padding-right:0px;margin-top:100px;">
            <tr>
                <td align="center" style="width:100%; font-size:16px;font-weight:bold;">FINANZAS</td>
            </tr>
            <tr>
                <td align="left" style="width:100%; font-size:13px;">1.	<strong>Inscripci??n.</strong> Se paga al momento del registro y no es reembolsable ni transferible a persona o concepto alguno. No procede la inscripci??n de alumnos con adeudos financieros anteriores.</td>
            </tr>
            <tr>
                <td align="left" style="width:100%; font-size:13px;">2. <strong>Colegiaturas. </strong>Se pagan once meses, de agosto a junio 100%, y el pago debe realizarse. dentro de los primeros diez d??as del mes. Si por alguna eventualidad no puede cubrir el adeudo, deber?? firmar una promesa de pago. No se recomienda hacer arreglos verbales o por tel??fono.</td>
            </tr>
            <tr>
                <td align="left" style="width:100%; font-size:13px;">3. <strong>Baja.</strong> En caso que el alumno cause baja por cualquier motivo el padre o tutor deber?? cubrir las colegiaturas al cien por ciento hasta la fecha en que el alumno asisti?? a clases.</td>
            </tr>
            <tr>
                <td align="left" style="width:100%; font-size:13px;">4. <strong>	Actividades extracurriculares.</strong> En cualquier actividad extracurricular, el alumno participante deber?? cubrir los gastos de acuerdo a las indicaciones del colegio.</td>
            </tr>
            <tr>
                <td align="left" style="width:100%; font-size:13px;">5. <strong>	Graduaci??n. </strong>Los alumnos que egresan deber??n cubrir la cuota de graduaci??n la cual no es reembolsable y no est?? condicionada a la participaci??n del alumno en el mencionado evento.</td>
            </tr>
            <tr>
                <td align="left" style="width:100%; font-size:13px;">6. <strong>	Inasistencias.</strong> Las inasistencias m??s o menos prolongadas, no liberan al alumno del pago mensual de las colegiaturas.</td>
            </tr>
            <tr>
                <td align="left" style="width:100%; font-size:13px;">7.	<strong>Recibo. </strong>Todo pago debe hacerse en la caja donde se expedir?? al recibo correspondiente que presentar?? en su pr??ximo pago.</td>
            </tr>
            <tr>
                <td align="left" style="width:100%; font-size:13px;"> 8. <strong>Seguro. </strong>Este seguro cubre los gastos m??dicos por accidentes en d??as y horas h??biles. Los da??os ocasionados por desobediencia, negligencia, juegos bruscos o fuera del horario de clases ser??n pagados por el responsable de los mismos.</td>
            </tr>
            <tr>
                <td align="left" style="width:100%; font-size:13px;">9. <strong>	Requerimiento.</strong> La instituci??n se reserva el derecho de requerir el pago de adeudos por escrito y/o correo electr??nico</td>
            </tr>
            <tr>
                <td align="left" style="width:100%; font-size:13px;">10. <strong>Suspensi??n. </strong>El adeudo de tres meses ser?? motivo para que la instituci??n proceda a dar de baja al alumno entreg??ndole su documentaci??n completa para proseguir sus estudios en otra escuela.</td>
            </tr>
            <tr>
                <td align="left" style="width:100%; font-size:13px;">11. <strong>Becas.</strong> Los beneficiarios de becas deber??n estar conscientes de que en alg??n momento podr??n ser requeridos para algunas actividades de la Escuela.</td>
            </tr>
            <tr>
                <td align="left" style="width:100%; font-size:13px;">12. <strong>Descuentos. </strong>La instituci??n podr?? considerar la solicitud de descuento en colegiaturas al padre que tenga inscritos m??s de dos hijos y que no est?? recibiendo otro tipo de apoyo financiero.</td>
            </tr>
            <tr>
                <td align="left" style="width:100%; font-size:13px;">13. <strong>Expedici??n de documentos.</strong> Todo documento expedido por la instituci??n tendr?? un costo, exceptuando la documentaci??n de fin de cursos expedida a los alumnos que egresan.</td>
            </tr>
            <tr>
                <td align="left" style="width:100%; font-size:13px;">14. <strong>Cargos extraordinarios.</strong> La instituci??n podr?? hacer cargos al padre o tutor por llamadas telef??nicas por asuntos personales del alumno, o da??os materiales voluntarios o involuntarios ocasionados por el mismo.</td>
            </tr>
            <tr>
                <td align="left" style="width:100%; font-size:13px;">15. <strong>Imprevistos. </strong>Los casos no previstos ser??n resueltos por las instancias internas correspondientes.</td>
            </tr>
            <tr>
                <td align="left" style="width:100%; font-size:13px;">16. <strong>Beca SEQ. </strong>Si desea realizar el tr??mite de beca ante la Seq, la inscripci??n ser?? cubierta al 100%, no se podr?? aplicar beca sobre beca o alguna otra promoci??n.</td>
            </tr>
        </table> 
        <table style="width:100%;margin-top:40px;">
            <tr>
                <td align="left" style="width:100%; font-size:16px;">COMPROMISO DEL PADRE O TUTOR</td>
            </tr>
            <tr>
                <td align="left" style="width:100%; font-size:13px;">Acepto el reglamento financiero del colegio del cual poseo una copia y me comprometo a acatarlo en todas sus partes</td>
            </tr>
        </table> 
        <table style="width:100%;margin-top:100px;">
            <tr>
                <td align="center" style="width:100%; font-size:16px;">_______________________________________</td>
            </tr>
            <tr>
                <td align="center" style="width:100%; font-size:13px;">Nombre y firma</td>
            </tr>
        </table> 
    </page>


<?php
	$content_html = ob_get_clean();
	require_once(dirname(__FILE__).'/pdf/html2pdf.class.php');
	try
	{
		$html2pdf = new HTML2PDF('P','A4','es', true, 'UTF-8', array(0, 0, 0, 0));
		$html2pdf->pdf->SetDisplayMode('fullpage');
		$html2pdf->writeHTML($content_html, isset($_GET['vuehtml']));
		$html2pdf->Output('extracto_alumnos2.pdf');
	}
	catch(HTML2PDF_exception $e) { echo $e; }	
?>
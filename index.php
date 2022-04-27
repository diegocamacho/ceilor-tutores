<? include('includes/session_ui.php');
include('includes/db.php');
include('includes/funciones.php');
$menu = isset($_GET['Modulo']) ? $_GET['Modulo']: NULL;

$sql = "SELECT alumnos.id_alumno, nombre, apaterno, amaterno, id_nivel, id_grado, grupo, id_ciclo FROM alumnos
JOIN alumnos_academico ON alumnos_academico.id_alumno=alumnos.id_alumno
WHERE id_tutor=$id_tutor ORDER BY alumnos_academico.id_nivel,apaterno, amaterno, nombre ASC";
$q_alumnos=mysqli_query($db,$sql);
$valida=mysqli_num_rows($q_alumnos);
$alumnos = array();
while($datos=mysqli_fetch_object($q_alumnos)):
	$alumnos[] = $datos;
endwhile;

$sql="SELECT ciclo,ciclo_activo FROM configuracion_empresa 
JOIN ciclos ON ciclos.id_ciclo=configuracion_empresa.ciclo_activo
WHERE id_empresa=1";
$q=mysqli_query($db,$sql);
$ft=mysqli_fetch_assoc($q);
$cicloActivo=$ft['ciclo_activo'];

?>
<!DOCTYPE html>
<!-- Bootstrap 3.3.7 -->
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
    <!--<![endif]-->
    <!-- BEGIN HEAD -->

    <head>
        <meta charset="utf-8" />
        <title>Centro Educativo Ignacio López Rayón.</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta content="Acceso para tutores Centro Educativo Ignacio López Rayón." name="description" />
        <meta content="Diego Camacho para Conexia" name="author" />
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
        <link href="assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/global/css/components-rounded.min.css" rel="stylesheet" id="style_components" type="text/css" />
        <link href="assets/global/css/plugins.css" rel="stylesheet" type="text/css" />
        <link href="assets/layouts/layout4/css/layout.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/layouts/layout4/css/themes/default.min.css" rel="stylesheet" type="text/css" id="style_color" />
        <!--<link href="assets/layouts/layout4/css/themes/light.min.css" rel="stylesheet" type="text/css"/>-->
        <link href="assets/layouts/layout4/css/custom.min.css" rel="stylesheet" type="text/css" />

        <link href='assets/global/plugins/fullcalendar/core/main.css' rel='stylesheet' />
        <link href='assets/global/plugins/fullcalendar/daygrid/main.css' rel='stylesheet' />
        <link href='assets/global/plugins/fullcalendar/list/main.css' rel='stylesheet' />
        <link href='assets/global/plugins/fullcalendar/timegrid/main.css' rel='stylesheet' />

        <link rel="stylesheet" href="assets/global/plugins/selectize/dist/css/selectize.bootstrap3.css">

        <link href="assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/global/plugins/ladda/ladda-themeless.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/global/plugins/bootstrap-sweetalert/sweetalert.css" rel="stylesheet" type="text/css" />
        <link href="assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css" rel="stylesheet" type="text/css" />

        <link href="assets/global/css/components-rounded.min.css" rel="stylesheet" id="style_components" type="text/css" />
        <link href="assets/global/css/plugins.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/global/plugins/icheck/skins/all.css" rel="stylesheet" type="text/css" />
        <link href="assets/global/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />

        <script src="assets/global/plugins/jquery.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/icheck/icheck.min.js" type="text/javascript"></script>
        <link href="assets/global/plugins/bootstrap-sweetalert/sweetalert.css" rel="stylesheet" type="text/css" />
        

        <style>

        .fc-time-grid .fc-slats td {
            height: 30px;
            border-bottom: 0;
        }
        .fc-time span{
            float: left;
            padding-top: 2px;
        }
        .titulos_consulta{
            font-size: 16px;
        }
        .evento{
            background-color: #00b6ad;
            border-color: #00a79e;
            font-size: 1em;
            padding:5px;
            text-transform: capitalize;
            cursor: pointer;
            height: 20px;

        }
        .cerrado{
            background-color: #ed5466;
            border-color: #ec465a;
        }
        .oculto{
            display: none;
        }
        .click {
            cursor: pointer;
        }
        .lista-productos {
            padding-bottom: 10px;
            padding-top: 10px;
            border-bottom: 1px solid #dddddd;
        }
        </style>
        <link rel="shortcut icon" href="icon.png" />
    </head>

    <body class="page-container-bg-solid page-header-fixed page-sidebar-closed-hide-logo">
        <!-- BEGIN HEADER -->
        <div class="page-header navbar navbar-fixed-top">
            <!-- BEGIN HEADER INNER -->
            <div class="page-header-inner ">
                <!-- BEGIN LOGO -->
                <div class="page-logo"><center>
                    <a href="#"><img src="letras_ceilor_blanco.png" alt="Ceilor" class="logo-default" height="38" style="margin:22px;" /> </a>
                    <div class="menu-toggler sidebar-toggler">
                    <!-- DOC: Remove the above "hide" to enable the sidebar toggler button on header -->
                    </div></center>
                </div>
                <!-- END LOGO -->
                <!-- BEGIN RESPONSIVE MENU TOGGLER -->
                <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse"> </a>
                <!-- END RESPONSIVE MENU TOGGLER -->
                <!-- BEGIN PAGE ACTIONS -->
                <!-- DOC: Remove "hide" class to enable the page header actions -->


                <!-- END PAGE ACTIONS -->
                <!-- BEGIN PAGE TOP -->
                <div class="page-top">
                    <!-- BEGIN TOP NAVIGATION MENU -->
                    <div class="top-menu">
                        <ul class="nav navbar-nav pull-right">
                            <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                            <li class="dropdown dropdown-user dropdown-dark">
                                <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                    <span class="username username-hide-on-mobile">Bienvenido <?=ucwords(strtolower($s_nombre))?> </span>
                                    <!-- DOC: Do not remove below empty space(&nbsp;) as its purposely used -->
                                    <img alt="" class="img-circle" src="LOGO_CEILOR.png" /> </a>
                            </li>
                            <!-- END USER LOGIN DROPDOWN -->
                            <!-- BEGIN QUICK SIDEBAR TOGGLER -->
                            <li class="dropdown dropdown-extended quick-sidebar-toggler" onclick="cerrar_sesion()">
                            <span  class="sr-only" >Logout</span>
                                <i class="icon-logout"></i>                                
                            </li>
                            <!-- END QUICK SIDEBAR TOGGLER -->
                        </ul>
                    </div>
                    <!-- END TOP NAVIGATION MENU -->
                </div>
                <!-- END PAGE TOP -->
            </div>
            <!-- END HEADER INNER -->
        </div>
        <!-- END HEADER -->
        <!-- BEGIN HEADER & CONTENT DIVIDER -->
        <div class="clearfix"> </div>
        <!-- END HEADER & CONTENT DIVIDER -->
        <!-- BEGIN CONTAINER -->
        <div class="page-container">
            <!-- BEGIN SIDEBAR -->
            <? include("menu.php"); ?>
            <!-- END SIDEBAR -->
            <!-- BEGIN CONTENT -->
            <?php

    		switch($menu){

                //case 'NuevaInscripcion':
                //include("nueva_inscripcion.php");
                //break;
                
                case 'Alumnos':
                include("alumnos.php");
                break;

                case 'Alumno':
                include("alumno.php");
                break;
                
                case 'PagosPendientes':
                include("pagos.php");
                break;

                case 'Reinscripciones':
                include("reinscripciones.php");
                break;

                case 'Inscripcion':
                include("inscribir.php");
                break;

                case 'NuevoTutor':
                include("nuevo_tutor.php");
                break;
                
                default:
                include('alumnos.php');
                break;
    		}
    		?>
            <!-- END CONTENT -->

        </div>
        <!-- END CONTAINER -->
        <!-- BEGIN FOOTER -->
        <div class="page-footer">
            <div class="page-footer-inner"> 2021 © POWERED BY FILÁNTROPICA Y EDUCATIVA DEL SUR DE QUINTANA ROO AC.</div>
            <div class="scroll-to-top">
                <i class="icon-arrow-up"></i>
            </div>
        </div>
        <!-- END FOOTER -->

        <!--[if lt IE 9]>
        <script src="assets/global/plugins/respond.min.js"></script>
        <script src="assets/global/plugins/excanvas.min.js"></script>
        <script src="assets/global/plugins/ie8.fix.min.js"></script>
        <![endif]-->

        <script src="assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/js.cookie.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/moment.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>

        <script src="assets/global/scripts/app.js" type="text/javascript"></script>
        <script src="assets/pages/scripts/components-select2.min.js" type="text/javascript"></script>

        <script src="assets/layouts/layout4/scripts/layout.min.js" type="text/javascript"></script>
        <script src="assets/layouts/layout4/scripts/demo.min.js" type="text/javascript"></script>
        <script src="assets/layouts/global/scripts/quick-sidebar.min.js" type="text/javascript"></script>
        <script src="assets/layouts/global/scripts/quick-nav.min.js" type="text/javascript"></script>
        <script src="assets/jquery.alphanumeric.js" type="text/javascript"></script>
        <script src="assets/numeral.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/selectize/dist/js/standalone/selectize.min.js" type="text/javascript"></script>

        <script src="assets/global/plugins/bootstrap-daterangepicker/daterangepicker.js" type="text/javascript"></script>
        <script src="assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/bootstrap-datepicker/locales/bootstrap-datepicker.es.min.js" charset="UTF-8"></script>
        <script src="assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>

        <script src="assets/pages/scripts/components-date-time-pickers.min.js" type="text/javascript"></script>
        
        <script src="assets/global/plugins/bootstrap-sweetalert/sweetalert.min.js" type="text/javascript"></script>



        <script>
        $(function(){
            $('.numero').numeric();
        });
        function cerrar_sesion(){
            var r = confirm("¿Esta seguro que desea cerrar la sesión?");
            if(r==true){
                location.href = "ac/logout.php";
            }else{
                return false;
            }
            
        }
        </script>
    </body>

</html>
        


<!-- Visor de facturas -->
<div class="modal fade" id="verPago" role="basic" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body text-center">
               <br/><br/> <img src="assets/global/img/loading-spinner-grey.gif" alt="" class="loading">
                <span>&nbsp;&nbsp;Cargando... </span><br/><br/>
            </div>
        </div>
    </div>
</div>
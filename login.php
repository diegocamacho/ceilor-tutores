<?  session_start();
	session_destroy(); 
    require 'includes/db.php';
if($_GET['e']){
    $email=$_GET['e'];
}
?>
<!DOCTYPE html>
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
        <meta content="@conexiamx" name="author" />
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
        <link href="assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/global/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/global/css/components-rounded.min.css" rel="stylesheet" id="style_components" type="text/css" />
        <link href="assets/global/css/plugins.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/pages/css/login-5.min.css" rel="stylesheet" type="text/css" />
        <link rel="shortcut icon" href="favicon.ico" /> </head>

    <body class="login" id="contenido">
        <!-- BEGIN : LOGIN PAGE 5-1 -->
        <div class="user-login-5">
            <div class="row bs-reset">
                <div class="col-md-6 bs-reset mt-login-5-bsfix">
                    <div class="login-bg">
                        <!--<img class="login-logo" src="logo-adventista.png" width="50" />-->
                    </div>
                </div>
                <div class="col-md-6 login-container bs-reset mt-login-5-bsfix">
                    <center><img src="LOGO_CEILOR.png" style="padding-top:40px;" width="190" /></center>
                    <div class="login-content" style="margin-top: 5%;">
						
                        <h1 style="text-align:center;">Centro Educativo Ignacio López Rayón</h1>
                        <p style="text-align:center;"> Enseñando el Camino. </p><hr>
                        <? if($_GET['token']){
                            $token=mysqli_real_escape_string($db, $_GET['token']);
                            $sql = "SELECT * FROM tutores WHERE token='$token' AND activo='1' LIMIT 1";
                            $res = mysqli_query($db, $sql) or die ('Error en db');
                            $val = mysqli_num_rows($res);
                            if($val!=0){
                                $dt=mysqli_fetch_assoc($res);
                                $id_tutor=$dt['id_tutor'];
                                $nombre=$dt['nombre']; 
                                $email=$dt['email']; 
                        ?>
                            <form id="frm-nueva-contrasena">
                                <h3 class="font-blue-ebonyclay">Recuperación de contraseña</h3>
                                <p> Escriba una nueva contraseña para poder iniciar sesión, le recordamos que su correo es: <?=$email?> </p>
                                <div class="form-group">
                                    <input class="form-control placeholder-no-fix form-group" type="text" autocomplete="off" placeholder="Escriba su nueva contraseña" name="contrasena1" id="contrasena1"  /> 
                                    <input class="form-control placeholder-no-fix form-group" type="text" autocomplete="off" placeholder="Repita la nueva contraseña" name="contrasena2" id="contrasena2"  /> 
                                    <input type="hidden" name="token" value="<?=$_GET['token']?>" id="token" />
                                </div>
                                <div class="form-actions">
                                    <button type="button" class="btn blue-ebonyclay  pull-right" onclick="guardaContrasena()">Recuperar</button>
                                </div><br><br><br><br>
                                <div class="alert alert-danger display-hide" id="msg_error3"></div>
                            </form>
                        <? } ?>
                        <? }else{ ?>
                            <form class="login-form" id="frm_guarda">
                                <div class="alert alert-danger display-hide" id="msg_error"></div>
                                <? if($_GET['msg']==1){?>
                                    <div class="alert alert-info">Hemos enviado las instrucciones para recuperar su contraseña a su correo</div>
                                <? } ?>
                                <div class="row">
                                    <div class="col-xs-6">
                                        <input class="form-control form-control-solid placeholder-no-fix form-group" type="text" autocomplete="off" placeholder="Correo Electrónico" name="email" id="email" value="<?=$email?>" required/> </div>
                                    <div class="col-xs-6">
                                        <input class="form-control form-control-solid placeholder-no-fix form-group" type="password" autocomplete="off" placeholder="Contraseña" name="pass" id="pass" required/> </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                    <!--
                                        <div class="rem-password">
                                            <label class="rememberme mt-checkbox mt-checkbox-outline">
                                                <input type="checkbox" name="remember" value="1" /> Recordarme
                                                <span></span>
                                            </label>
                                        </div>-->
                                    </div>
                                    <div class="col-sm-8 text-right">
                                    
                                        <div class="forgot-password">
                                            <a href="javascript:;" id="forget-password" class="forget-password">¿Olvido su contraseña?</a>
                                        </div>
                                        <button class="btn blue-ebonyclay " type="button" onclick="javascript:login()">Iniciar Sesión</button>
                                        <div style="text-align: right;display: none;" id="load">
                                            <img src="assets/global/img/loading-spinner-grey.gif" />
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <!-- BEGIN FORGOT PASSWORD FORM -->
                            <form class="forget-form">
                                <h3 class="font-blue-ebonyclay">¿Olvidó su contraseña?</h3>
                                <p> Escriba su correo y le envíaremos los pasos para recuperar su contraseña. </p>
                                <div class="form-group">
                                    <input class="form-control placeholder-no-fix form-group" type="text" autocomplete="off" placeholder="Correo Electrónico" name="email2" id="email2" /> </div>
                                <div class="form-actions">
                                    <button type="button" id="back-btn" class="btn btn-default btn-outline">Regresar</button>
                                    <button type="button" class="btn blue-ebonyclay  pull-right" onclick="recuperarContrasena()">Recuperar</button>
                                </div><br><br><br><br>
                                <div class="alert alert-danger display-hide" id="msg_error2"></div>
                            </form>
                        <? } ?>
                        
                    </div>
                    <div class="login-footer">
                        <div class="row bs-reset">
                            <div class="col-xs-5 bs-reset">
								
                                <!-- <ul class="login-social">
                                    <li>
                                        <a href="javascript:;">
                                            <i class="icon-social-facebook"></i>
                                        </a>
                                    </li>

                                </ul> -->
								
                            </div>
                            <div class="col-xs-11 bs-reset">
                                <div class="login-copyright text-right">
                                    <p>2021 © POWERED BY FILÁNTROPICA Y EDUCATIVA DEL SUR DE QUINTANA ROO AC.</p>
                                    <!--<p>Hecho con  <i class="fa fa-heart font-red-thunderbird"></i> por &nbsp&nbsp&nbsp
                                    <a href="http://conexia.mx" border="0" target="_blank"><img src="https://conexia-documents.s3.us-east-2.amazonaws.com/identidad/conexiaColorNegro.png" border="0" width="90"></a></p>-->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END : LOGIN PAGE 5-1 -->
        <!--[if lt IE 9]>
<script src="assets/global/plugins/respond.min.js"></script>
<script src="assets/global/plugins/excanvas.min.js"></script>
<script src="assets/global/plugins/ie8.fix.min.js"></script>
<![endif]-->
        <!-- BEGIN CORE PLUGINS -->
        <script src="assets/global/plugins/jquery.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/js.cookie.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
        <!-- END CORE PLUGINS -->
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <script src="assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/backstretch/jquery.backstretch.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN THEME GLOBAL SCRIPTS -->
        <script src="assets/global/scripts/app.js" type="text/javascript"></script>
        <!-- END THEME GLOBAL SCRIPTS -->
        <!-- BEGIN PAGE LEVEL SCRIPTS -->


        <!-- END PAGE LEVEL SCRIPTS -->
        <!-- BEGIN THEME LAYOUT SCRIPTS -->
        <!-- END THEME LAYOUT SCRIPTS -->
        <script>
        $(function() {
			$('.login-bg').backstretch([
                "assets/pages/img/login/ceilor-1.jpg",
                "assets/pages/img/login/ceilor-2.jpg",
                "assets/pages/img/login/ceilor-3.jpg"
                ], {
                  fade: 1000,
                  duration: 5000
                }
            );
            $('.forget-form').hide();

        	$('form').submit(function(e){
        		e.preventDefault();
        	});

        	$('#pass').keyup(function(e) {

        			if(e.keyCode==13){
        				login();
        			}

        	});

			$('#email2').keyup(function(e) {

        			if(e.keyCode==13){
        				recuperarContrasena();
        			}

        	});

			$('#forget-password').click(function(){
	            $('.login-form').hide();
	            $('.forget-form').show();
	        });

	        $('#back-btn').click(function(){
	            $('.login-form').show();
	            $('.forget-form').hide();
	        });
        });
        function login(){
        	$('#msg_error').hide('Fast');
        	var user = $('#email').val();
        	var pass = $('#pass').val();
            App.blockUI(
        		{
        			target: '#contenido',
                    boxed: true,
                    message: 'Comprobando...'
                }
        	);
        	$.post('ac/login.php','email='+user+'&pass='+pass,function(data) {
                console.log(data);
        		if(data==1){
        			window.location = 'index.php';
        		}else{
        			$('#pass').focus();
        			$('#msg_error').html(data);
        			$('#msg_error').show('Fast');
        			App.unblockUI('#contenido');
        		}
        	});
        }

        function recuperarContrasena() {
            email = $("#email2").val();
            //$('#msg_error2').hide('Fast');
            App.blockUI(
        		{
        			target: '#contenido',
                    boxed: true,
                    message: 'Comprobando...'
                }
        	);
        	$.post('../ac/recupera.php','email='+email,function(data) {
        		console.log(data);
        		if(data==1){
        			window.location.href = 'login.php?msg=1';
        		}else{
                    $('#email2').focus();
        			$('#msg_error2').html(data);
        			$('#msg_error2').show();
                    App.unblockUI('#contenido');
        		}
        	});
        }
        function guardaContrasena(){

            var contrasena1     = $('#contrasena1').val();
        	var contrasena2     = $('#contrasena2').val();
            var token           = $('#token').val();
        	if(contrasena1!=contrasena2){
                alert("Las contraseñas no coinciden.");
                return false;
            }
            App.blockUI(
        		{
        			target: '#contenido',
                    boxed: true,
                    message: 'Comprobando...'
                }
        	);
        	$.post('ac/cambiaPass.php','contrasena1='+contrasena1+'&contrasena2='+contrasena2+'&token='+token,function(data){
                console.log(data);
        		if(data==1){
        			window.location = 'index.php';
        		}else{
        			$('#msg_error3').html(data);
        			$('#msg_error3').show('Fast');
        			App.unblockUI('#contenido');
        		}
        	});
        }
        </script>
    </body>

</html>

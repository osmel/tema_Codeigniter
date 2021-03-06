<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php $this->load->view( 'header_login' ); ?>

<style>
 .has-error .form-control{
    border-color: #e73d4a !important;
 }
.has-success .form-control {
    border-color: #27a4b0 !important;
}     

span.osmel {
    color: red;
}


.btn22 {
  display: inline-block;
  margin-bottom: 0;
  font-weight: normal;
  text-align: center;
  vertical-align: middle;
  touch-action: manipulation;
  cursor: pointer;
  background-image: none;
  border: 1px solid transparent;
  white-space: nowrap;
  padding: 6px 12px;
  font-size: 14px;
  line-height: 1.42857;
  border-radius: 4px;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
 }
 .btn22 .ladda-spinner,
 .btn22 .ladda-progress,
 .btn22 .ladda-spinner img {
    box-shadow: none !important;
    border: none !important;
 }

</style>
    <body class=" login">
        <!-- BEGIN LOGO -->


        <div class="col-md-12 text-center"> 
            <div class="logo">
                    <a style="height: 100%;padding: 8px;" href="/"> <!-- LOGO --> 
                        <img  style="height: 100%; margin: 0px 0 0 !important;" src="<?php echo base_url(); ?>img/logo-menu.svg" alt="logo" class="logo-default" /> 
                    </a>

            </div>
        </div>

        <!-- END LOGO -->
        <!-- BEGIN LOGIN -->
        <div class="content">
           
                
                    
                       
                       
                

            <!-- BEGIN LOGIN FORM -->
            <?php
                     $attr = array( 'id' => 'form_login','name'=>'form_login', 'class' => 'form-horizontal', 'method' => 'POST', 'autocomplete' => 'off', 'role' => 'form' );
                     echo form_open('validar_login', $attr);
                    ?>

                    <div class="form-body">
                        <h3 class="form-title font-green">Login</h3>
                        
                        <div class="alert alert-danger cliente display-hide">
                            <button class="close" data-close="alert"></button>
                            <span> Entra algun usuario y contraseña. </span>
                        </div>
                        
                        <div class="alert alert-success display-hide">
                                <button class="close" data-close="alert"></button> 
                                  Tu validacion es OK! 
                        </div>                

                        <div class="alert alert-danger server display-hide ">
                            <button class="close" data-close="alert"></button>
                            <span> Error de usuario y contraseña. </span>
                        </div>
                        
                     

                                <div class="form-group margin-top-20">
                                                <div class="input-icon right">
                                                    <i class="fa"></i>
                                                    <input type="text" class="form-control form-control-solid placeholder-no-fix"  autocomplete="off" placeholder="Correo" name="correo"/> 
                                                </div>
                                </div>                

                                            
                                <div class="form-group margin-top-20">
                                    <div class="input-icon right">
                                        <i class="fa"></i>
                                        <input class="form-control form-control-solid placeholder-no-fix" type="password" autocomplete="off" placeholder="Contraseña" name="contrasena" />
                                    </div>    
                                </div>        




                        <div class="form-actions">
                            

                            <div class="page-header-inner ">
                                <button type="submit" class="btn22 btn-primary mt-ladda-btn ladda-button" data-style="expand-right">
                                      <span class="ladda-label">Ingresar</span>
                                </button>
                                <!--
                                <label class="rememberme check mt-checkbox mt-checkbox-outline">
                                    <input type="checkbox" name="remember" value="1" />Recordar
                                    <span></span>
                                </label>
                                -->
                            </div>               

                            
                                             

                            <a href="javascript:;" id="forget-password" class="forget-password">¿Olvidaste tu contraseña?</a>
                        </div>

                    </div>     
                
                <!-- Logotipo de redes sociales
                <div class="login-options">
                    <h4>O login con</h4>
                    <ul class="social-icons">
                        <li>
                            <a class="social-icon-color facebook" data-original-title="facebook" href="javascript:;"></a>
                        </li>
                        <li>
                            <a class="social-icon-color twitter" data-original-title="Twitter" href="javascript:;"></a>
                        </li>
                        <li>
                            <a class="social-icon-color googleplus" data-original-title="Goole Plus" href="javascript:;"></a>
                        </li>
                        <li>
                            <a class="social-icon-color linkedin" data-original-title="Linkedin" href="javascript:;"></a>
                        </li>
                    </ul>
                </div>

                -->
                <!-- para crear una nueva cuenta
                    <div class="create-account">
                    <p>
                        <a href="javascript:;" id="register-btn" class="uppercase">Crea una nueva cuenta</a>
                    </p>
                </div> -->
            <?php echo form_close(); ?>
            <!-- END LOGIN FORM -->
            
            <!-- BEGIN FORGOT PASSWORD FORM -->
            <!--<form class="forget-form" action="index.html" method="post"> -->
            
            <?php echo form_open('/', array( 'id' => 'form_login', 'name' => 'form_login', 'class' => 'forget-form', 'method' => 'POST', 'autocomplete' => 'off', 'role' => 'form' ) ); ?>

                <h3 class="font-green">Recuperar contraseña?</h3>
                <p> Introduzca su dirección de correo electrónico a continuación para restablecer su contraseña. </p>
                <div class="form-group">
                    <input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Email" name="email" /> </div>
                <div class="form-actions">
                    <button type="button" id="back-btn" class="btn green btn-outline">Atraz</button>
                    <button type="submit" class="btn btn-success uppercase pull-right">Enviar</button>
                </div>
            <!--</form>-->
            <?php echo form_close(); ?>
            <!-- END FORGOT PASSWORD FORM -->

            <!-- comienzo para formulario de  registrarse y crear una nueva cuenta
            <form class="register-form" action="index.html" method="post">
                <h3 class="font-green">Sign Up</h3>
                <p class="hint"> Enter your personal details below: </p>
                <div class="form-group">
                    <label class="control-label visible-ie8 visible-ie9">Full Name</label>
                    <input class="form-control placeholder-no-fix" type="text" placeholder="Full Name" name="fullname" /> </div>
                <div class="form-group">
                    
                    <label class="control-label visible-ie8 visible-ie9">Email</label>
                    <input class="form-control placeholder-no-fix" type="text" placeholder="Email" name="email" /> </div>
                <div class="form-group">
                    <label class="control-label visible-ie8 visible-ie9">Address</label>
                    <input class="form-control placeholder-no-fix" type="text" placeholder="Address" name="address" /> </div>
                <div class="form-group">
                    <label class="control-label visible-ie8 visible-ie9">City/Town</label>
                    <input class="form-control placeholder-no-fix" type="text" placeholder="City/Town" name="city" /> </div>
                <div class="form-group">
                    <label class="control-label visible-ie8 visible-ie9">Country</label>
                    <select name="country" class="form-control">
                        <option value="">Country</option>
                        <option value="AF">México</option>
                        <option value="AL">USA</option>
                        
                    </select>
                </div>
                <p class="hint">Ingrese los detalles de su cuenta a continuación:</p>
                <div class="form-group">
                    <label class="control-label visible-ie8 visible-ie9">Usuario</label>
                    <input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Username" name="username" /> </div>
                <div class="form-group">
                    <label class="control-label visible-ie8 visible-ie9">Contraseña</label>
                    <input class="form-control placeholder-no-fix" type="password" autocomplete="off" id="register_password" placeholder="Password" name="password" /> </div>
                <div class="form-group">
                    <label class="control-label visible-ie8 visible-ie9">Repite tu contraseña</label>
                    <input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="Re-type Your Password" name="rpassword" /> </div>
                <div class="form-group margin-top-20 margin-bottom-20">
                    <label class="mt-checkbox mt-checkbox-outline">
                        <input type="checkbox" name="tnc" /> Acepto los Términos 
                        <a href="javascript:;">del servicio Política</a> &
                        <a href="javascript:;">de privacidad</a>
                        <span></span>
                    </label>
                    <div id="register_tnc_error"> </div>
                </div>
                <div class="form-actions">
                    <button type="button" id="register-back-btn" class="btn green btn-outline">Atraz</button>
                    <button type="submit" id="register-submit-btn" class="btn btn-success uppercase pull-right">Enviar</button>
                </div>
            </form>

            END REGISTRATION FORM -->
        </div>     <!-- Fin del  content -->


<?php $this->load->view( 'footer_login' ); ?>
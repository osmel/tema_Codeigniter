<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<!-- PORTLET MAIN -->
    <div class="portlet light profile-sidebar-portlet ">
        <!-- SIDEBAR USERPIC -->
        <div class="profile-userpic">
            <img src="<?php echo base_url(); ?>js/assets/pages/media/profile/profile_user.jpg" class="img-responsive" alt=""> </div>
        <!-- END SIDEBAR USERPIC -->
        <!-- SIDEBAR USER TITLE -->
        <div class="profile-usertitle">

            <div class="profile-usertitle-name"> <?php echo $dat_usuario->nombre.' '.$dat_usuario->apellidos; ?> </div>
            <div class="profile-usertitle-job"> <?php echo $dat_usuario->perfil?> </div>
        </div>
        <!-- END SIDEBAR USER TITLE -->
        <!-- SIDEBAR BUTTONS -->
        <div class="profile-userbuttons">
            <button type="button" class="btn btn-circle green btn-sm">Follow</button>
            <button type="button" class="btn btn-circle red btn-sm">Message</button>
        </div>
        <!-- END SIDEBAR BUTTONS -->
        <!-- SIDEBAR MENU -->
        <div class="profile-usermenu">
            <ul class="nav">
                <li class="active">
                    <a href="page_user_profile_1.html">
                        <i class="icon-home"></i> Inicio </a>
                </li>
                <li>
                    <a href="/tema/actualizar_perfil">
                        <i class="icon-settings"></i> Configuración de Cuenta </a>
                </li>
                <li>
                    <a href="page_user_profile_1_help.html">
                        <i class="icon-info"></i> Ayuda </a>
                </li>
            </ul>
        </div>
        <!-- END MENU -->
    </div>
<!-- END PORTLET MAIN -->
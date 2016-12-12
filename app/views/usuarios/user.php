<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<!-- BEGIN PAGE TITLE-->
<h1 class="page-title"> Perfil de Usuario
    <small></small>
</h1>
<!-- END PAGE TITLE-->
<!-- END PAGE HEADER-->
<div class="row">
    <div class="col-md-12">
        <!-- Imagen y datos adicionales BEGIN PROFILE SIDEBAR -->
        <div class="profile-sidebar">
            <?php  $this->load->view( 'usuarios/imagen_usuario'); ?>
            <?php  $this->load->view( 'usuarios/datos_adicionales'); ?>
        </div>
        <!-- END BEGIN PROFILE SIDEBAR -->


        <!-- BEGIN PROFILE CONTENT -->
        <div class="profile-content">
            <div class="row">
                <div class="col-md-6">
                   <?php  $this->load->view( 'usuarios/historico_accesos'); ?>
                </div>

                <div class="col-md-6">
                    <?php  $this->load->view( 'usuarios/tareas'); ?>
                </div>
            </div>


            <div class="row">
                <div class="col-md-6">
                     <?php  $this->load->view( 'usuarios/personalizar_soporte'); ?>
                </div>
                <div class="col-md-6">
                    <?php  $this->load->view( 'usuarios/tareas_pendiente'); ?>
                </div>
            </div>

            
        </div>
        <!-- END PROFILE CONTENT -->
    </div>
</div>

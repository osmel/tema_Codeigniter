<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<!-- 
Template Name: Metronic - Responsive Admin Dashboard Template build with Twitter Bootstrap 3.3.6
Version: 4.6
Author: KeenThemes
Website: http://www.keenthemes.com/
Contact: support@keenthemes.com
Follow: www.twitter.com/keenthemes
Dribbble: www.dribbble.com/keenthemes
Like: www.facebook.com/keenthemes
Purchase: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
Renew Support: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.
-->
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="es_MX">
    <!--<![endif]-->
    <!-- BEGIN HEAD -->

       <head>
        <meta charset="utf-8" />
        <title>Sistema de prueba</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta content="" name="description" />
        <meta content="" name="author" />
        <!-- Comienzo ESTILOS OBLIGATORIOS GLOBAL --> 
	        <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
	        <link href="<?php echo base_url(); ?>js/assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
	        <link href="<?php echo base_url(); ?>js/assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
	        <link href="<?php echo base_url(); ?>js/assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	        <link href="<?php echo base_url(); ?>js/assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />
	    <!-- fin ESTILOS OBLIGATORIOS GLOBAL --> 

        <!-- Comienzo de estilo de plugin a nivel de pagina --> 
	        <link href="<?php echo base_url(); ?>js/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css" rel="stylesheet" type="text/css" />
	        <link href="<?php echo base_url(); ?>js/assets/global/plugins/morris/morris.css" rel="stylesheet" type="text/css" />
	        <link href="<?php echo base_url(); ?>js/assets/global/plugins/fullcalendar/fullcalendar.min.css" rel="stylesheet" type="text/css" />
	        <link href="<?php echo base_url(); ?>js/assets/global/plugins/jqvmap/jqvmap/jqvmap.css" rel="stylesheet" type="text/css" />
        <!-- Fin de estilo de plugin a nivel de pagina --> 

        <!-- COMIENZO DE ESTILO GLOBAL DE TEMA -->
              <!-- maqueta para el perfil de Usuario-->  
            <link href="<?php echo base_url(); ?>js/assets/pages/css/profile.min.css" rel="stylesheet" type="text/css" />

	        <link href="<?php echo base_url(); ?>js/assets/global/css/components.min.css" rel="stylesheet" id="style_components" type="text/css" />
	        <link href="<?php echo base_url(); ?>js/assets/global/css/plugins.min.css" rel="stylesheet" type="text/css" />
        <!-- FIN DE ESTILO GLOBAL DE TEMA -->

        <!-- COMIENZO DE DISEÑO DE ESTILO DE TEMA  -->
	        <link href="<?php echo base_url(); ?>js/assets/layouts/layout/css/layout.min.css" rel="stylesheet" type="text/css" />
	        <link href="<?php echo base_url(); ?>js/assets/layouts/layout/css/themes/darkblue.min.css" rel="stylesheet" type="text/css" id="style_color" />
	        <link href="<?php echo base_url(); ?>js/assets/layouts/layout/css/custom.min.css" rel="stylesheet" type="text/css" />

        <!-- FIN DE DISEÑO DE ESTILO DE TEMA  -->
        <link rel="shortcut icon" href="favicon.ico" /> </head>

    <!-- END HEAD -->

    <body class="page-header-fixed page-sidebar-closed-hide-logo page-content-white">
        <div class="page-wrapper">
           
            <!-- Encabezado -->
               <?php $this->load->view( 'encabezado' ); ?>

            <!-- BEGIN HEADER & CONTENT DIVIDER -->
            <div class="clearfix"> </div>
            <!-- END HEADER & CONTENT DIVIDER -->
            


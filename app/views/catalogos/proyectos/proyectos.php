<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php $this->load->view( 'header' ); ?>

 
 <link href="<?php echo base_url(); ?>js/jstree/dist/themes/default/style.min.css" rel="stylesheet" type="text/css" />
 <link href="<?php echo base_url(); ?>js/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
 
 
 



            <!-- Comienzo del contenedor -->
	            <div class="page-container">
	                
	                <!--Menu Izquierdo-->	
	            		<?php $this->load->view( 'menu_izquierdo',$datos ); ?>	
	            	<!--Fin menu Izquierdo-->	

	                <!--Contenido de la pagina -->
		                <div class="page-content-wrapper">
		                	<div class="page-content">
									<?php $this->load->view( 'navegacion' ); ?>

									<?php $this->load->view( 'catalogos/proyectos/detalles'); ?>

		                	</div>
		                </div>
	                <!--Fin Contenido de la pagina-->
	                	
	                <!-- Barra lateral rapida de menu "que esta en esquina derecha superior"-->
	                	<?php $this->load->view( 'barra_lateral_rapida_menu' ); ?>
	                <!-- Fin Barra lateral rapida de menu "que esta en esquina derecha superior"-->

	            </div>
            <!-- Fin del Contenedor -->

<?php $this->load->view( 'footer' ); ?>
<script src="<?php echo base_url(); ?>js/jstree/dist/jstree.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>js/sistema_tree.js" type="text/javascript"></script>
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php $this->load->view( 'header' , $datos ); ?>
<style type="text/css">
	td.details-control {
	    background: url('../img/details_open.png') no-repeat center center;
	    cursor: pointer;
	}
	tr.shown td.details-control {
	    background: url('../img/details_close.png') no-repeat center center;
	}

</style>

<?php
 	if (!isset($retorno)) {
      	$retorno ="/";
    }
?>   

            <!-- Comienzo del contenedor -->
	            <div class="page-container">
	                
	                <!--Menu Izquierdo-->	
	            		<?php $this->load->view( 'menu_izquierdo',$datos ); ?>	
	            	<!--Fin menu Izquierdo-->	

	                <!--Contenido de la pagina -->
		                <div class="page-content-wrapper">
		                	<div class="page-content">
									<?php //$this->load->view( 'navegacion' ); ?>












		<!-- Aqui comienza filtro	-->
		<div class="row">      
			<div class="col-md-12 form-horizontal" id="tab_filtro">      
						
						
						<div class="col-md-12">
							<div class="table-responsive">

								<section>
									<table id="tabla_rep_balance_ganancia_perdida" class="display table table-striped table-bordered table-responsive" cellspacing="0" width="100%">
										<thead>
											<tr>
								                <th rowspan="2" width="20%" class="text-center">Proyecto</th>
								                <th rowspan="2" width="8%" class="text-center">Fecha</th>
								                <th rowspan="2" width="6%" class="text-center">Capital</th>
								                <th colspan="2" width="33%" class="text-center">Proyecciones</th>
								                <th colspan="2" width="33%" class="text-center">Reales</th>
								            </tr>									
											<tr>
												<th class="text-center"><strong>Costo</strong></th>
												<th class="text-center"><strong>Ganancia</strong></th>
												
												<th class="text-center"><strong>Costo</strong></th>
												<th class="text-center"><strong>Ganancia</strong></th>
												

											</tr>
										</thead>

										
									</table>
								</section>
							</div>
						</div>

		    </div>
		</div>    

<!-- Hasta aqui el filtro	-->




		
		
			













		                	</div>
		                </div>
	                <!--Fin Contenido de la pagina-->
	                	
	                <!-- Barra lateral rapida de menu "que esta en esquina derecha superior"-->
	                	<?php $this->load->view( 'barra_lateral_rapida_menu' ); ?>
	                <!-- Fin Barra lateral rapida de menu "que esta en esquina derecha superior"-->

	            </div>
            <!-- Fin del Contenedor -->

<?php $this->load->view( 'footer' ); ?>
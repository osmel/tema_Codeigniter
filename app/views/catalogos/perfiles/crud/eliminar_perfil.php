<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php
 	if (!isset($retorno)) {
      	$retorno ="entornos";
    }
 $hidden = array('id'=>$id, 'tabla'=>$entorno->tabla); ?>
<?php echo form_open('validar_eliminar_entorno', array('class' => 'form-horizontal','id'=>'form_entornos','name'=>$retorno, 'method' => 'POST', 'role' => 'form', 'autocomplete' => 'off' ) ,   $hidden ); ?>
	<div class="modal-header">
		<a class="close" data-dismiss="modal">&times;</a>
		<h3 class="text-left">Eliminar entornos</h3>
	</div>
	<div class="modal-body">
		
		<p>¿Está seguro de que desea eliminar el entorno <b><?php echo  $nombrecompleto ; ?></b>?</p>
		<p>Recuerde, este proceso es completamente irreversible.</p>
		<div class="alert" id="messagesModal"></div>
	</div>
	<div class="modal-footer">
		<button class="btn btn-danger" id="deleteUserSubmit">Aceptar</button>
		<button class="btn btn-default" data-dismiss="modal">Cancelar</button>
	</div>
	<input type="hidden" id="id" name="id" value="<?php echo $id; ?>">
<?php echo form_close(); ?>
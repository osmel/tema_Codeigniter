jQuery(document).ready(function($) {

//////////////////////////////////////////////////
//////////////////////////////////////////////////

	//logueo y recuperar contraseña
	jQuery("#form_login").submit(function(e){
		jQuery('#foo').css('display','block');
		//var spinner = new Spinner(opts).spin(target);
		jQuery(this).ajaxSubmit({
			success: function(data){
				if(data != true){
					//spinner.stop();
					jQuery('#foo').css('display','none');
					jQuery('#messages').css('display','block');
					jQuery('#messages').addClass('alert-danger');
					jQuery('#messages').html(data);
					jQuery('html,body').animate({
						'scrollTop': jQuery('#messages').offset().top
					}, 1000);
				}else{
						//spinner.stop();
						jQuery('#foo').css('display','none');
						window.location.href = '/';						
				}
			} 
		});
		return false;
		
	});


});

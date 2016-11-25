

var FormValidation = function () {

// Validación usando icono
    var handleValidation2 = function() {
            // http://docs.jquery.com/Plugins/Validation
            var form2 = $('#form_login');
            var error2 = $('.alert-danger', form2);
            var success2 = $('.alert-success', form2);

            form2.validate({
                errorElement: 'span', //Por defecto la entrada de mensaje de error contiene span. default input error message container
                
                /* errorClass y validClass: podemos especificar el nombre de la clase CSS que se agregará al elemento validado en caso de fracaso
                 o de éxito de la validación.
                */
                errorClass: 'osmel help-block help-block-error', // por defecto la entrada de mensaje de error tiene esta clase. default input error message class
				//validClass: 'help-block help-block-ok',                 
                focusInvalid: false, // tenga focus la ultima  invalidada. do not focus the last invalid input
                ignore: "",  // validando todos los campos incluyendo los hidden. validate all fields including form hidden input
                
                rules: {
                    nombre: {
                        minlength: 2,
                        required: true
                    },
                    contrasena: {
                        minlength: 6,
                        required: true
                    },                    
                    correo: {
                        required: true,
                        email: true
                    },
                    
                    url: {
                        required: true,
                        url: true
                    },
                    number: {
                        required: true,
                        number: true
                    },
                    digits: {
                        required: true,
                        digits: true
                    },
                    creditcard: {
                        required: true,
                        creditcard: true
                    },
                },
      
      //////////////////////////////////
                //errorPlacement: es una función que nos permite decidir donde situar los mensajes de "error generados".
                errorPlacement: function (error, element) { // render error placement for each input type
                    var icon = $(element).parent('.input-icon').children('i');
                    icon.removeClass('fa-check').addClass("fa-warning");  
                    icon.attr("data-original-title", error.text()).tooltip({'container': 'body'});
                },

                //higlight: determinan como resaltar los elementos que no han superado la validación. "fallo"
                highlight: function (element) { // hightlight error inputs
                    $(element).closest('.form-group').removeClass("has-success").addClass('has-error'); // set error class to the control group   
                },
      //////////////////////////////////
                // unhiglight: determinan como resaltar los elementos que "han superado la validación". "exito"
                unhighlight: function (element) { // revert the change done by hightlight
                    
                },

                //success: es una función que nos permite decidir donde situar los mensajes de "exito generados".
                success: function (label, element) {
                    var icon = $(element).parent('.input-icon').children('i');
                    $(element).closest('.form-group').removeClass('has-error').addClass('has-success'); // set success class to the control group
                    icon.removeClass("fa-warning").addClass("fa-check");
                },

      //////////////////////////////////
                
				//InvalidHandler: Es una función que "se llamará si la validación no ha tenido éxito".
                invalidHandler: function (event, validator) { //Mostrar errores en envio de formulario. display error alert on form submit              
                    success2.hide();
                    error2.show();
                    App.scrollTo(error2, -200);
                },
                
                /*
					submitHandler: nos permite especificar una función que se llamará cuando la validación haya tenido "éxito".
					En este función podemos incluir código de validación a nivel global y además será responsabilidad
					nuestra enviar definitivamente el formulario con form.submit().
                */
                submitHandler: function (form) {
                    success2.show();
                    error2.hide();
                    //form[0].submit(); // submit the form
                    
                    console.log(form[0]);

					jQuery.ajax({
						        url : 'validar_login',
						        data : { 
									formulario 	: $(form).serialize(), //JSON.stringify($(form)), //
						        },
						        type : 'POST',
						       // dataType : 'json',
						        success : function(data) {	
						        	if(data != true){
						        		console.log(data);
						        		alert(data);
						        	} else {
						        		alert('asd');
										window.location.href = '';        		
						        	}	
						        }
					});						        
					



					/*

//logueo y recuperar contraseña
	jQuery("#form_login").submit(function(e){
		jQuery('#foo').css('display','block');
		var spinner = new Spinner(opts).spin(target);
		jQuery(this).ajaxSubmit({
			success: function(data){
				if(data != true){
					spinner.stop();
					jQuery('#foo').css('display','none');
					jQuery('#messages').css('display','block');
					jQuery('#messages').addClass('alert-danger');
					jQuery('#messages').html(data);
					jQuery('html,body').animate({
						'scrollTop': jQuery('#messages').offset().top
					}, 1000);
				}else{
						spinner.stop();
						jQuery('#foo').css('display','none');
						window.location.href = '';						
				}
			} 
		});
		return false;
	});

					$(this).ajaxSubmit({
					    type : 'POST',
					    data : { 
									formulario 	: $(form).serialize(), //JSON.stringify($(form)), //
						        },
				        dataType : 'json',						
						success: function(data){
							alert(data);
						return false;
						}

					});
					return false;
					*/
					




                }
            
            }); //fin de   form2.validate({


    } //fin de  var handleValidation2 = function() {

    return {
        //Principal funcion para inicializar el modulo
        init: function () {

           // handleWysihtml5();
            //handleValidation1();
            handleValidation2();
            //handleValidation3();

        }

    };

}();


jQuery(document).ready(function($) {

 	FormValidation.init();
//////////////////////////////////////////////////
//////////////////////////////////////////////////

	//logueo y recuperar contraseña
	jQuery("#form_login1").submit(function(e){
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

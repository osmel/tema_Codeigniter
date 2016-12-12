var graficos = function () {

 var initSparklineCharts = function() {
            if (!jQuery().sparkline) {
                return;
            }


       // $('#sparkline_bar12').sparkline();
        var values = [1, 3,null, 5,0, 3.6, 8,6,-4];
        //$('#sparkline_bar12').sparkline(values, {

        $('#sparkline_bar12, #sparkline_bar22').sparkline('html', {
            type: 'bar',
            //interactividad o eventos

            disableInteraction: false, //true = "desactivar todas las interactividad(eventos)"
            disableTooltips: false, //true = "desactivar todos los tooltips"
            disableHighlight: false, //true = "desactivar todos los Highlight(resaltados de las barras)"
            highlightLighten:1.4,  //Controla cantidad aclarar u oscurecer. 
                                  //1.5: aclarará en un 50%,
                                  //0.5: oscurece en un 50%.   
                                  //El valor predeterminado es 1,4
            //highlightColor:'#f36a5b', // Será el color que toma las varas cuando se hace mouse-over
            
            
            //tooltipOffsetX:50, //número de píxeles de distancia del puntero del ratón para presentar el tooltip en el eje X
            //tooltipOffsetY:50, //número de píxeles de distancia del puntero del ratón para presentar el tooltip en el eje Y

            tooltipChartTitle: 'titulo',
            tooltipSkipNull: false, //true=>  "valores nulos" no tendrán un tooltip a mostrar

            //FORMATO DE NUMERO
            numberDigitGroupCount:3,  //Número de dígitos entre el separador de grupo de números. predeterminado es 3.
            NumberDigitGroupSep:'*', //separador de grupos miles
            numberDecimalMark:'.', //Caracteres para usar para el punto decimal


            width: '100',
            barWidth: 3, //Tamaño de cada barra, en pixels
            barSpacing: 2, //Separación entre barras, en pixels.

            height: '55',
            nullColor:'#008000', //color usado para valores iguales a null
            zeroColor:'#000000', //Color de los valores ceros
            barColor: '#f36a5b', //Color de los valores positivos
            negBarColor: '#2499a3', //Color de los valores negativos
            //colorMap: { '1:2': '#33cc33', '3:6': '#668cff', '7:': '#ff3385' }, // mapa de rango para asignar valores específicos a los colores seleccionados
            
            
            //tooltipFormat: $.spformat('{{value}}', 'tooltip-class'),
            tooltipFormat: '{{value:levels}} - {{value}}',  //level es el valor que va tomando abajo
            tooltipValueLookups: {  //Traduce los "nombres de campos" y "valores" a otras cadenas arbitrarias utilizando esta opción
                levels: $.range_map({ ':2': 'Bajo', '3:6': 'Medio', '7:': 'Alto','null': 'Valor nulo' })
                //:2 -> Núm desde -infinito hasta 2
                //3:6 -> Núm desde 3 hasta 6
                //7: -> Núm desde 7 hasta  +infinito 
            },

              
        });



        $('#sparkline_bar').bind('sparklineRegionChange', function(ev) {
            var sparkline = ev.sparklines[0],
                region = sparkline.getCurrentRegionFields(),
                value = region.y;
                console.log(region);
                console.log(region[0].offset);
                //$('.mouseoverregion').text("x="+region.x+" y="+region.y);
        }).bind('mouseleave', function() {
            $('.mouseoverregion').text('');
            console.log("osmel");
        }).bind('sparklineClick', function(ev) {  //click sobre 
            console.log("adg");
            var sparkline = ev.sparklines[0],
                    region = sparkline.getCurrentRegionFields();
                //alert("Clicked on x="+region.x+" y="+region.y);            
        });




 
            $("#sparkline_bar1").sparkline(
                //[1,2,3,4,5,6,7, 8, 9, 10, 20, 1,2,3,4,5,6,7, 8, 9, 10, 11, 12, 13,14, 15,16,17,18,19,20], 
                //[  [1,4], [2, 3], [3, 2], [4, 1] ],
                {

                    type: 'bar', //'common' con 'line', 'bar', 'tristate', 'discrete', 'bullet', 'pie' or 'box'
                    width: '100',
                    barWidth: 5,
                    height: '55',
                    barColor: '#f36a5b',
                    negBarColor: '#e02222'
                }
            );

            $("#sparkline_bar2").sparkline([9, 11, 12, 13, 12, 13, 10, 14, 13, 11, 11, 12, 11, 11, 10, 12, 11, 10], {
                type: 'bar',
                width: '100',
                barWidth: 5,
                height: '55',
                barColor: '#5c9bd1',
                negBarColor: '#e02222'
            });

            $("#sparkline_bar5").sparkline([8, 9, 10, 11, 10, 10, 12, 10, 10, 11, 9, 12, 11, 10, 9, 11, 13, 13, 12], {
                type: 'bar',
                width: '100',
                barWidth: 5,
                height: '55',
                barColor: '#35aa47',
                negBarColor: '#e02222'
            });

            $("#sparkline_bar6").sparkline([9, 11, 12, 13, 12, 13, 10, 14, 13, 11, 11, 12, 11, 11, 10, 12, 11, 10], {
                type: 'bar',
                width: '100',
                barWidth: 5,
                height: '55',
                barColor: '#ffb848',
                negBarColor: '#e02222'
            });

            $("#sparkline_line").sparkline([9, 10, 9, 10, 10, 11, 12, 10, 10, 11, 11, 12, 11, 10, 12, 11, 10, 12], {
                type: 'line',
                width: '100',
                height: '55',
                lineColor: '#ffb848'
            });
  } //fin de  var handleValidation2 = function() {

    return {
        //Principal funcion para inicializar el modulo
        init: function () {

           
            initSparklineCharts();
           

        }

    };

}();


var FormValidation = function () {

// Validación usando icono
    var handleValidation2 = function() {
            // http://docs.jquery.com/Plugins/Validation
            var form2 = $('#form_login');
            var error2 = $('.alert-danger.cliente', form2);
            var success2 = $('.alert-success', form2);
            var error_server = $('.alert-danger.server', form2);


            form2.validate({
                errorElement: 'span', //Por defecto la entrada de mensaje de error contiene span. default input error message container
                
                /* errorClass y validClass: podemos especificar el nombre de la clase CSS que se agregará al elemento validado en caso de fracaso
                 o de éxito de la validación.
                */
                errorClass: 'help-block help-block-error', // por defecto la entrada de mensaje de error tiene esta clase. default input error message class
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
                    error_server.hide();
                    error2.show();
                    App.scrollTo(error2, -200);
                },
                
                /*
					submitHandler: nos permite especificar una función que se llamará cuando la validación haya tenido "éxito".
					En este función podemos incluir código de validación a nivel global y además será responsabilidad
					nuestra enviar definitivamente el formulario con form.submit().
                */
                submitHandler: function (form) {

                    //form[0].submit(); // submit the form
                    
                    //console.log(form[0]);

					jQuery.ajax({
						        url : 'validar_login',
						        data : { 
									formulario 	: $(form).serialize(), //JSON.stringify($(form)), //
						        },
						        type : 'POST',
						       // dataType : 'json',
						        success : function(data) {	
						        	if(data != true){
						        		//fallo
					  					error_server.show();
					                    success2.hide();
					                    error2.hide();						        		
						        	} else {
						        		//exito
						        		success2.show();
						        		error_server.hide();
					                    error2.hide();						        		

										window.location.href = '';        		
						        	}	
						        }
					});						        

                },

                /*
                	showErrors: es una función que nos permite tratar con todos los mensajes de errores encontrados para visualizar
                	 de una forma concreta o realizar la operación que creamos oportuna.
                */
				showErrors: function(errorMap, errorList) {
				 	jQuery.each(errorList, function(e) {
				 		 //console.log(e);
				 	});
				 	//http://stackoverflow.com/questions/285428/how-to-display-jquery-validation-error-container-only-on-submit
				 	this.defaultShowErrors();
				  },                  

            
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


    graficos.init();

// 	FormValidation.init();
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

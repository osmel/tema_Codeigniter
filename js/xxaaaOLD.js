/*
                                                                    var date1 = new Date;
                                                                    date1.setHours(0, 0, 0, 0);
                                                                    date1.setDate(10);
                                                                    var date2 = new Date;
                                                                    date2.setHours(0, 0, 0, 0);
                                                                    date2.setDate(23);
                                                                    */
                                                                    //console.log(e.target.name);
                                                                    //console.log(e.attr('name'));


.on('show', function(ee) {
//console.log('show');
//this.setStartDate('15-03-2017');
//jQuery('.input-daterange').attr('data-start-date','15-03-2017');
//jQuery(this).datepicker('setStartDate','15-03-2017');
//jQuery('#fecha_inicial').datepicker('setEndDate','15-03-2017');

//jQuery(this).datepicker('setStartDate', (e.target.name == 'fecha_inicial') ? datum.suma.inicial_start : datum.suma.final_start);  // a partir de -3 días 
//jQuery(this).datepicker('setEndDate', (e.target.name == 'fecha_inicial') ? ((datum.suma.inicial_end != null ) ?  datum.suma.inicial_end : "+10000d") : ((datum.suma.final_end != null ) ?  datum.suma.final_end : "+10000d")  );
//jQuery(this).datepicker('update');


//jQuery('#ficha_inicial').setStartDate('15-03-2017');
//console.log('show');
//$('#fecha1').attr('data-start-date','-120y');
});



 /*

                                                                        defaultViewDate: 'today', //today

                                                                        multidate: true,  //poder elegir multiples fechas
                                                                        multidateSeparator: "*", //separador de multiples fechas
                                                                        toggleActive: true,

                                                                        
                                                                        

                                                                        
                                                                        calendarWeeks: true, //Si muestra o no los números de semana a la izquierda de las filas 
                                                                        clearBtn: true, //botón "Clear" en la parte inferior, si autoclose:true tambien se cerrará automaticamente
                                                                            
                                                                        
                                                                        datesDisabled: ['06-03-2017', '21-03-2017'],    
                                                                        daysOfWeekHighlighted: [4],   //Días de la semana en que debe ser destacado(highlighted)
                                                                        //defaultViewDate: { year: 1977, month: 04, day: 25 }, // con que fecha abre inicialmente objeto
                                                                        
                                                                        //defaultViewDate: '06-03-2017', //en que fecha se abre inicialmente



                                                                        //endDate: "21-03-2017", //última fecha en la que se puede seleccionar; todas las fechas posteriores serán desactivados.
                                                                        //endDate: "0d", // a partir de hoy
                                                                        endDate: "+3d", // a partir de 3 días 
                                                                        startDate: "-3d", // a partir de -3 días 

                                                                        keyboardNavigation: true, //si va a permitir navegación por teclado
                                                                        orientation: "top auto", //orientacion en que se mostrara el datapicker
                                                                        showOnFocus:true,  //false: no se muestra el picker cuando recibe el foco

                                                                        showWeekDays: true, //false: el datepicker no añadirá los nombres de los días de semana a su view.

                                                                        
                                                                      
                                                                        todayBtn: "linked",  //boton hoy

                                                                        weekStart: 5, //1er día de la semana que se presentará( 5 comenzaría por Viernes )
                                                                        
                                                                        

                                                                        beforeShowCentury: function(date) { //siglo
                                                                                //console.log(date);
                                                                        },

                                                                        
                                                                        beforeShowDecade: function(date) {  //decada
                                                                                //console.log(date);
                                                                        },

                                                                        beforeShowYear: function(date) { //año
                                                                                //console.log(date);
                                                                        },


                                                                        beforeShowMonth: function(date) { //mes
                                                                               // console.log(date);
                                                                        },

                                                                        
                                                                        

                                                                        beforeShowDay: function(date) { //day
                                                                             if (date.getMonth() == (new Date()).getMonth()) //mes presente
                                                                                switch (date.getDate()){
                                                                                      case 4:
                                                                                        return {
                                                                                          tooltip: 'Example tooltip',
                                                                                          classes: 'active'
                                                                                        };
                                                                                      case 8:
                                                                                        return false;
                                                                                      case 12:
                                                                                        return "green";
                                                                                }
                                                                                hoy tengo pensado pasarla tranquilo, quizas salir a cenar, y aprovechar el proximo fin de 
                                                                                semana q es puente, para salir a veracruz o algún lugar de playa            
                                                                        }
                                                                  */
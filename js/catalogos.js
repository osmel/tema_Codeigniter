jQuery(document).ready(function($) {

  var horas_pesos= jQuery('.horas_pesos') ? jQuery('.horas_pesos').text() : '';
  //alert(horas_pesos);

  jQuery('body').on('click','.horas_pesos', function (e) {
      jQuery(this).text(jQuery(this).text() == "Horas" ? "Pesos" : "Horas");

      horas_pesos = jQuery(this).text();      
      var hash_url = window.location.pathname;
      switch (hash_url) {  
                case "/balance_ganancia_perdida": //general
                    var oTable =jQuery('#tabla_rep_balance_ganancia_perdida').dataTable();
                break;
                case "/balance_area_ganancia_perdida": //por area
                    var oTable =jQuery('#tabla_rep_balance_area_ganancia_perdida').dataTable();
                break;
                case "/balance_usuario_ganancia_perdida"://por usuario
                    var oTable =jQuery('#tabla_rep_balance_usuario_ganancia_perdida').dataTable();
                break;
                case "/general":                   
                    var oTable =jQuery('#tabla_rep_general').dataTable();
                break;
                case "/horas_personas":                   
                    var oTable =jQuery('#tabla_rep_horas_personas').dataTable();
                break;                  
                
                default:
                   break;
      }            
      oTable._fnAjaxUpdate(); 
  });

  jQuery('#tabla_rep_balance_ganancia_perdida').dataTable({
           "pagingType": "full_numbers",
          "orderClasses": false, // para quitarle las clases que lleva el orenamiento  "sorting_1"
          "processing": true,
          "serverSide": true,
          "ajax": {
                    "url" : "procesando_balance_ganancia_perdida",
                    "type": "POST",
                    "data": function ( d ) {
                        d.id_proyecto = (jQuery('#id_proyecto_gasto').val()!=null) ? jQuery('#id_proyecto_gasto').val() : 0;    
                        d.id_usuario = (jQuery('#id_usuario_gasto').val()!=null) ? jQuery('#id_usuario_gasto').val() : 0;    
                        d.id_area = (jQuery('#id_area_gasto').val()!=null) ? jQuery('#id_area_gasto').val() : 0;    
                        d.horas_pesos= horas_pesos;
                    }
         },   
       
        "language": {  //tratamiento de lenguaje
            "lengthMenu": "Mostrar _MENU_ registros por página",
            "zeroRecords": "No hay registros",
            "info": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "infoEmpty": "No hay registros disponibles",
            "infoFiltered": "(Mostrando _TOTAL_ de _MAX_ registros totales)",  
            "emptyTable":     "No hay registros",
            "infoPostFix":    "",
            "thousands":      ",",
            "loadingRecords": "Leyendo...",
            "processing":     "Procesando...",
            "search":         "Buscar:",
            "paginate": {
                "first":      "Primero",
                "last":       "Último",
                "next":       "Siguiente",
                "previous":   "Anterior"
            },
            "aria": {
                "sortAscending":  ": Activando para ordenar columnas ascendentes",
                "sortDescending": ": Activando para ordenar columnas descendentes"
            },
        },
     
    

  "infoCallback": function( settings, start, end, max, total, pre ) {

 if (settings.json.subtotales) {
        
      jQuery('#Capital').html( 'Capital: $'+number_format(settings.json.subtotales.capital, 2, '.', ','));
      jQuery('#presupuesto').html( 'Presupuesto: $'+number_format(settings.json.subtotales.presupuesto, 2, '.', ','));
      jQuery('#presupuesto_hora').html( 'Presupuesto: '+number_format(settings.json.subtotales.presupuesto_hora, 2, '.', ',')+' hrs');
      jQuery('#ganancia_presupuesto').html( 'Gan. presupuesto: $'+number_format(settings.json.subtotales.capital-settings.json.subtotales.presupuesto, 2, '.', ','));
      jQuery('#utilizado').html( 'Utilizado: $'+number_format(settings.json.subtotales.utilizado, 2, '.', ','));
      jQuery('#utilizado_hora').html( 'Utilizado: '+number_format(settings.json.subtotales.utilizado_hora, 2, '.', ',')+' hrs');
      jQuery('#ganancia_real').html( 'Gan. Real: $'+number_format(settings.json.subtotales.capital-settings.json.subtotales.utilizado, 2, '.', ','));

    } else {
      jQuery('#Capital').html( 'Capital: 0.00');
      jQuery('#presupuesto').html( 'Presupuesto: 0.00');
      jQuery('#presupuesto_hora').html( 'Presupuesto: 0.00 hrs');
      jQuery('#ganancia_presupuesto').html( 'Gan. presupuesto: 0.00');
      jQuery('#utilizado').html( 'Utilizado: 0.00');
      jQuery('#utilizado_hora').html( 'Utilizado: 0.00 hrs');
      jQuery('#ganancia_real').html( 'Gan. Real: 0.00');
    }

    if (settings.json.totales) {
        
      jQuery('#t_Capital').html( 'Capital: $'+number_format(settings.json.totales.capital, 2, '.', ','));
      jQuery('#t_presupuesto').html( 'Presupuesto: $'+number_format(settings.json.totales.presupuesto, 2, '.', ','));
      jQuery('#t_presupuesto_hora').html( 'Presupuesto: '+number_format(settings.json.totales.presupuesto_hora, 2, '.', ',')+' hrs');
      jQuery('#t_ganancia_presupuesto').html( 'Gan. presupuesto: $'+number_format(settings.json.totales.capital-settings.json.totales.presupuesto, 2, '.', ','));
      jQuery('#t_utilizado').html( 'Utilizado: $'+number_format(settings.json.totales.utilizado, 2, '.', ','));
      jQuery('#t_utilizado_hora').html( 'Utilizado: '+number_format(settings.json.totales.utilizado_hora, 2, '.', ',')+' hrs');
      jQuery('#t_ganancia_real').html( 'Gan. Real: $'+number_format(settings.json.totales.capital-settings.json.totales.utilizado, 2, '.', ','));

    } else {
      jQuery('#t_Capital').html( 'Capital: 0.00');
      jQuery('#t_presupuesto').html( 'Presupuesto: 0.00');
      jQuery('#t_presupuesto_hora').html( 'Presupuesto: 0.00 hrs');
      jQuery('#t_ganancia_presupuesto').html( 'Gan. presupuesto: 0.00');
      jQuery('#t_utilizado').html( 'Utilizado: 0.00');
      jQuery('#t_utilizado_hora').html( 'Utilizado: 0.00 hrs');
      jQuery('#t_ganancia_real').html( 'Gan. Real: 0.00');
    }
 
      return pre
  },    



        "columnDefs": [ 

                       { //proyecto                        
                        "render": function ( data, type, row ) {
                                return row[1] ;
                        },
                        "targets": [0] 
                      },
                      { //fecha
                        "render": function ( data, type, row ) {
                                return row[3] ;
                        },
                        "targets": [1] 
                      },
                      { // capital               
                        "render": function ( data, type, row ) {
                                 return (row[2]!=0)?'$'+number_format(row[2], 2, '.', ','):0 ;
                        },
                        "targets": [2] 
                      },
                      { //proyeccion costo *     
                        "render": function ( data, type, row ) {
                                 if (horas_pesos=="Pesos"){
                                    return (row[5]!=0)? '$'+number_format(row[5], 2, '.', ','):0 ; 
                                 } else {
                                    return (row[8]!=0)? number_format(row[8], 2, '.', ',')+' hrs':0 ;
                                 }
                                 
                        },
                        "targets": [3] 
                      },                      
                      { //proyeccion ganancia      
                        "render": function ( data, type, row ) {
                                 return (row[4]!=0)?'$'+number_format(row[4], 2, '.', ','):0 ;
                        },
                        "targets": [4] 
                      },
                      { //reales costo    *                    
                        "render": function ( data, type, row ) {
                                 
                                 if (horas_pesos=="Pesos"){
                                    return (row[6]!=0)? '$'+number_format(row[6], 2, '.', ','):0 ;
                                 } else {
                                    return (row[9]!=0)? number_format(row[9], 2, '.', ',')+' hrs':0 ;
                                 }


                        },
                        "targets": [5] 
                      },

                      { //reales ganancia                          
                        "render": function ( data, type, row ) {
                                 return (row[7]!=0)?'$'+number_format(row[7], 2, '.', ','):0 ;
                        },
                        "targets": [6] 
                      },                            
         ],
         
  });  




jQuery('#id_proyecto_gasto[modulo="general"], #id_area_gasto[modulo="general"], #id_usuario_gasto[modulo="general"]').on('change', function(e) {
        var campo = jQuery(this).attr("name");   
        var id_proyecto = jQuery('#id_proyecto_gasto').val();
        var id_area = jQuery('#id_area_gasto').val();
        var id_usuario = jQuery('#id_usuario_gasto').val();

        cargarDependencia_balance_general(campo,id_proyecto, id_area, id_usuario);
        //cuando cambie uno que refresh tabla
        var hash_url = window.location.pathname;

        switch (hash_url) {  //ver cual es el nivel seleccionado?
              case "/balance_ganancia_perdida":                   
                  var oTable =jQuery('#tabla_rep_balance_ganancia_perdida').dataTable();
              break;
              default:
                 break;
        }            
        oTable._fnAjaxUpdate(); 
});

function cargarDependencia_balance_general(campo,id_proyecto, id_area, id_usuario) {
        var url = 'cargarDependencia_balance_usuario'; 
        jQuery.ajax({
                url : '/cargarDependencia_balance_usuario',
                data:{
                    campo:campo,
                    id_proyecto:id_proyecto,
                    id_area: id_area,
                    id_usuario:id_usuario
                },
                type : 'POST',
                dataType : 'json',
                success : function(data) {
                        jQuery.each(data, function (dep, valor) {
                            jQuery("#"+dep).html(''); 
                            jQuery("#"+dep).append('<option value="-1" >Todos</option>'); 
                                jQuery.each(valor, function (i, value) {
                                    jQuery("#"+dep).append('<option '+ ( ((value.identificador).toString()==(value.activo).toString()) ? 'selected' : '') +' value="' + value.identificador + '" >' + value.nombre + '</option>');                                        
                                });
                        });
                    return false;
                },
                error : function(jqXHR, status, error) {
                },
                complete : function(jqXHR, status) {
                }
            }); 
    }




jQuery('#tabla_rep_balance_area_ganancia_perdida').dataTable({
           "pagingType": "full_numbers",
          "orderClasses": false, // para quitarle las clases que lleva el orenamiento  "sorting_1"
          "processing": true,
          "serverSide": true,
          "ajax": {
                    "url" : "procesando_balance_area_ganancia_perdida",
                    "type": "POST",
                    "data": function ( d ) {
                        d.id_proyecto = (jQuery('#id_proyecto_gasto').val()!=null) ? jQuery('#id_proyecto_gasto').val() : 0;    
                        d.id_area = (jQuery('#id_area_gasto').val()!=null) ? jQuery('#id_area_gasto').val() : 0;    
                        d.horas_pesos = horas_pesos;
                    }
         },   
       
        "language": {  //tratamiento de lenguaje
            "lengthMenu": "Mostrar _MENU_ registros por página",
            "zeroRecords": "No hay registros",
            "info": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "infoEmpty": "No hay registros disponibles",
            "infoFiltered": "(Mostrando _TOTAL_ de _MAX_ registros totales)",  
            "emptyTable":     "No hay registros",
            "infoPostFix":    "",
            "thousands":      ",",
            "loadingRecords": "Leyendo...",
            "processing":     "Procesando...",
            "search":         "Buscar:",
            "paginate": {
                "first":      "Primero",
                "last":       "Último",
                "next":       "Siguiente",
                "previous":   "Anterior"
            },
            "aria": {
                "sortAscending":  ": Activando para ordenar columnas ascendentes",
                "sortDescending": ": Activando para ordenar columnas descendentes"
            },
        },
             
      "infoCallback": function( settings, start, end, max, total, pre ) {
        if (settings.json.subtotales) {
                
              jQuery('#Capital').html( 'Capital: $'+number_format(settings.json.subtotales.capital, 2, '.', ','));
              jQuery('#presupuesto').html( 'Presupuesto: $'+number_format(settings.json.subtotales.presupuesto, 2, '.', ','));
              jQuery('#presupuesto_hora').html( 'Presupuesto: '+number_format(settings.json.subtotales.presupuesto_hora, 2, '.', ',')+' hrs');
              jQuery('#ganancia_presupuesto').html( 'Gan. presupuesto: $'+number_format(settings.json.subtotales.capital-settings.json.subtotales.presupuesto, 2, '.', ','));
              jQuery('#utilizado').html( 'Utilizado: $'+number_format(settings.json.subtotales.utilizado, 2, '.', ','));
              jQuery('#utilizado_hora').html( 'Utilizado: '+number_format(settings.json.subtotales.utilizado_hora, 2, '.', ',')+' hrs');
              jQuery('#ganancia_real').html( 'Gan. Real: $'+number_format(settings.json.subtotales.capital-settings.json.subtotales.utilizado, 2, '.', ','));

            } else {
              jQuery('#Capital').html( 'Capital: 0.00');
              jQuery('#presupuesto').html( 'Presupuesto: 0.00');
              jQuery('#presupuesto_hora').html( 'Presupuesto: 0.00 hrs');
              jQuery('#ganancia_presupuesto').html( 'Gan. presupuesto: 0.00');
              jQuery('#utilizado').html( 'Utilizado: 0.00');
              jQuery('#utilizado_hora').html( 'Utilizado: 0.00 hrs');
              jQuery('#ganancia_real').html( 'Gan. Real: 0.00');
            }

            if (settings.json.totales) {
                
              jQuery('#t_Capital').html( 'Capital: $'+number_format(settings.json.totales.capital, 2, '.', ','));
              jQuery('#t_presupuesto').html( 'Presupuesto: $'+number_format(settings.json.totales.presupuesto, 2, '.', ','));
              jQuery('#t_presupuesto_hora').html( 'Presupuesto: '+number_format(settings.json.totales.presupuesto_hora, 2, '.', ',')+' hrs');
              jQuery('#t_ganancia_presupuesto').html( 'Gan. presupuesto: $'+number_format(settings.json.totales.capital-settings.json.totales.presupuesto, 2, '.', ','));
              jQuery('#t_utilizado').html( 'Utilizado: $'+number_format(settings.json.totales.utilizado, 2, '.', ','));
              jQuery('#t_utilizado_hora').html( 'Utilizado: '+number_format(settings.json.totales.utilizado_hora, 2, '.', ',')+' hrs');
              jQuery('#t_ganancia_real').html( 'Gan. Real: $'+number_format(settings.json.totales.capital-settings.json.totales.utilizado, 2, '.', ','));

            } else {
              jQuery('#t_Capital').html( 'Capital: 0.00');
              jQuery('#t_presupuesto').html( 'Presupuesto: 0.00');
              jQuery('#t_presupuesto_hora').html( 'Presupuesto: 0.00 hrs');
              jQuery('#t_ganancia_presupuesto').html( 'Gan. presupuesto: 0.00');
              jQuery('#t_utilizado').html( 'Utilizado: 0.00');
              jQuery('#t_utilizado_hora').html( 'Utilizado: 0.00 hrs');
              jQuery('#t_ganancia_real').html( 'Gan. Real: 0.00');
            }
         
              return pre
          },       
        "columnDefs": [ 

                       { 
                        "className":      'details-control detalle_balance_area',
                        "orderable":      false,
                        "data":           null,
                        "defaultContent": '',
                        "targets": [0] 
                      },

                      { //proyecto                        
                        "render": function ( data, type, row ) {
                                return row[1] ;
                        },
                        "targets": [1] 
                      },
                      { //fecha
                        "render": function ( data, type, row ) {
                                return row[3] ;
                        },
                        "targets": [2] 
                      },
                      { // capital               
                        "render": function ( data, type, row ) {
                                 return (row[2]!=0)?'$'+number_format(row[2], 2, '.', ','):0 ;
                        },
                        "targets": [3] 
                      },
                      { //proyeccion costo *                   
                        "render": function ( data, type, row ) {
                                 if (horas_pesos=="Pesos"){
                                    return (row[5]!=0)? '$'+number_format(row[5], 2, '.', ','):0 ;
                                 } else {
                                    return (row[8]!=0)? number_format(row[8], 2, '.', ',')+' hrs':0 ;
                                 }
                        },
                        "targets": [4] 
                      },
                      { //proyeccion ganancia      
                        "render": function ( data, type, row ) {
                                 return (row[4]!=0)?'$'+number_format(row[4], 2, '.', ','):0 ;
                        },
                        "targets": [5] 
                      },

                      { //reales costo    *                    
                        "render": function ( data, type, row ) {
                                 if (horas_pesos=="Pesos"){
                                    return (row[6]!=0)? '$'+number_format(row[6], 2, '.', ','):0 ;
                                 } else {
                                    return (row[9]!=0)? number_format(row[9], 2, '.', ',')+' hrs':0 ;
                                 }
                        },
                        "targets": [6] 
                      },
                      { //reales ganancia                          
                        "render": function ( data, type, row ) {
                                 return (row[7]!=0)?'$'+number_format(row[7], 2, '.', ','):0 ;
                        },
                        "targets": [7] 
                      },
         ],
         
  });  


//dependencia de balance area

jQuery('#id_proyecto_gasto[modulo="area"], #id_area_gasto[modulo="area"]').on('change', function(e) {
        var campo = jQuery(this).attr("name");   
        var id_proyecto = jQuery('#id_proyecto_gasto').val();
        var id_area = jQuery('#id_area_gasto').val();
        
        cargarDependencia_balance_area(campo,id_proyecto, id_area);
        //cuando cambie uno que refresh tabla
        var hash_url = window.location.pathname;

        switch (hash_url) {  //ver cual es el nivel seleccionado?
              case "/balance_area_ganancia_perdida":                   
                  var oTable =jQuery('#tabla_rep_balance_area_ganancia_perdida').dataTable();
              break;
              default:
                 break;
        }            
        oTable._fnAjaxUpdate(); 
});

function cargarDependencia_balance_area(campo,id_proyecto, id_area) {
        var url = 'cargarDependencia_balance_area'; 
        jQuery.ajax({
                url : '/cargarDependencia_balance_area',
                data:{
                    campo:campo,
                    id_proyecto:id_proyecto,
                    id_area: id_area,
                },
                type : 'POST',
                dataType : 'json',
                success : function(data) {
                        jQuery.each(data, function (dep, valor) {
                            jQuery("#"+dep).html(''); 
                            jQuery("#"+dep).append('<option value="-1" >Todos</option>'); 
                                jQuery.each(valor, function (i, value) {
                                    jQuery("#"+dep).append('<option '+ ( ((value.identificador).toString()==(value.activo).toString()) ? 'selected' : '') +' value="' + value.identificador + '" >' + value.nombre + '</option>');                                        
                                });
                        });
                    return false;
                },
                error : function(jqXHR, status, error) {
                },
                complete : function(jqXHR, status) {
                }
            }); 
    }



jQuery('#tabla_rep_balance_area_ganancia_perdida tbody').on('click', 'td.detalle_balance_area', function () {

        var tr = $(this).closest('tr');
        var td = $(this).closest('tr > td');
        var row = jQuery('#tabla_rep_balance_area_ganancia_perdida').DataTable().row( tr );
        if ( row.child.isShown() ) { //si la fila esta "abierta" entonces "cerrarla"
            row.child.hide();
            tr.removeClass('shown');
        } else {


            //si la fila esta "cerrada" entonces "abrirla"
            var d= row.data();

                 $.ajax({
                        url: "/procesando_balance_area_ganancia_perdida_detalle",
                        type: 'POST',
                        dataType: "json",
                        data: {
                            
                            id_proyecto: d[0], 
                            id_area : (jQuery('#id_area_gasto').val()!=null) ? jQuery('#id_area_gasto').val() : 0, 
                            horas_pesos: horas_pesos
                         },
                        success: function(datos){
                            $cad='<table  class="tabla_hija display table table-striped table-bordered table-responsive dataTable"  role="grid" style="width: 100%; border:1px solid #2ab4c0;" >';
                                if (datos.data) {
                                      $cad +='<tr>';
                                          $cad +='<td class="text-center cursora" width="22%"><span style="font-weight:bold;">Área</span></td>';
                                          $cad +='<td class="text-center cursora" width="22%"><span style="font-weight:bold;">'+'Proyección Costo'+'</span></td>';
                                          $cad +='<td class="text-center cursora" width="22%"><span style="font-weight:bold;">'+'Costo Real'+'</span></td>';
                                          $cad +='<td class="text-center cursora" width="22%"><span style="font-weight:bold;">'+'Ganancia'+'</span></td>';
                                      $cad +='</tr>';  

                                      $.each(datos.data, function( i, value ) {
                                            $cad +='<tr>';
                                                $cad +='<td class="text-center cursora" width="22%"><span>'+value[3]+'</span></td>';
                                                if (horas_pesos=="Pesos"){
                                                  $cad +='<td class="text-center cursora" width="22%"><span>'+((value[5]!=0)?'$'+number_format(value[5], 2, '.', ','):0)+'</span></td>';
                                                  $cad +='<td class="text-center cursora" width="22%"><span>'+((value[6]!=0)?'$'+number_format(value[6], 2, '.', ','):0)+'</span></td>';
                                                 } else {
                                                    $cad +='<td class="text-center cursora" width="22%"><span>'+((value[8]!=0)? number_format(value[8], 2, '.', ',')+' hrs' :0)+'</span></td>';
                                                    $cad +='<td class="text-center cursora" width="22%"><span>'+((value[9]!=0)? number_format(value[9], 2, '.', ',')+' hrs' :0)+'</span></td>';
                                                 }  



                                                $cad +='<td class="text-center cursora" width="22%"><span>'+((value[5]-value[6]!=0)?'$'+number_format(value[5]-value[6], 2, '.', ','):0)+'</span></td>';




                                            $cad +='</tr>';  
                                     });   
                                }
                            $cad+='</table>';  
                            if (datos!=false) {
                                  row.child( $cad ).show();
                                  tr.addClass('shown');
                            }      

                        } //fin del success
                  });

        } //fin del else
} );



jQuery('#tabla_rep_balance_usuario_ganancia_perdida').dataTable({
           "pagingType": "full_numbers",
          "orderClasses": false, // para quitarle las clases que lleva el orenamiento  "sorting_1"
          "processing": true,
          "serverSide": true,
          "ajax": {
                    "url" : "procesando_balance_usuario_ganancia_perdida",
                    "type": "POST",
                    "data": function ( d ) {
                        d.id_proyecto = (jQuery('#id_proyecto_gasto').val()!=null) ? jQuery('#id_proyecto_gasto').val() : 0;    
                        d.id_usuario = (jQuery('#id_usuario_gasto').val()!=null) ? jQuery('#id_usuario_gasto').val() : 0;    
                        d.id_area = (jQuery('#id_area_gasto').val()!=null) ? jQuery('#id_area_gasto').val() : 0;    
                        d.horas_pesos = horas_pesos;
                    }
         },   
       
        "language": {  //tratamiento de lenguaje
            "lengthMenu": "Mostrar _MENU_ registros por página",
            "zeroRecords": "No hay registros",
            "info": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "infoEmpty": "No hay registros disponibles",
            "infoFiltered": "(Mostrando _TOTAL_ de _MAX_ registros totales)",  
            "emptyTable":     "No hay registros",
            "infoPostFix":    "",
            "thousands":      ",",
            "loadingRecords": "Leyendo...",
            "processing":     "Procesando...",
            "search":         "Buscar:",
            "paginate": {
                "first":      "Primero",
                "last":       "Último",
                "next":       "Siguiente",
                "previous":   "Anterior"
            },
            "aria": {
                "sortAscending":  ": Activando para ordenar columnas ascendentes",
                "sortDescending": ": Activando para ordenar columnas descendentes"
            },
        },

         "infoCallback": function( settings, start, end, max, total, pre ) {
            if (settings.json.subtotales) {
                    
                  jQuery('#Capital').html( 'Capital: $'+number_format(settings.json.subtotales.capital, 2, '.', ','));
                  jQuery('#presupuesto').html( 'Presupuesto: $'+number_format(settings.json.subtotales.presupuesto, 2, '.', ','));
                  jQuery('#presupuesto_hora').html( 'Presupuesto: '+number_format(settings.json.subtotales.presupuesto_hora, 2, '.', ',')+' hrs');
                  jQuery('#ganancia_presupuesto').html( 'Gan. presupuesto: $'+number_format(settings.json.subtotales.capital-settings.json.subtotales.presupuesto, 2, '.', ','));
                  jQuery('#utilizado').html( 'Utilizado: $'+number_format(settings.json.subtotales.utilizado, 2, '.', ','));
                  jQuery('#utilizado_hora').html( 'Utilizado: '+number_format(settings.json.subtotales.utilizado_hora, 2, '.', ',')+' hrs');
                  jQuery('#ganancia_real').html( 'Gan. Real: $'+number_format(settings.json.subtotales.capital-settings.json.subtotales.utilizado, 2, '.', ','));

                } else {
                  jQuery('#Capital').html( 'Capital: 0.00');
                  jQuery('#presupuesto').html( 'Presupuesto: 0.00');
                  jQuery('#presupuesto_hora').html( 'Presupuesto: 0.00 hrs');
                  jQuery('#ganancia_presupuesto').html( 'Gan. presupuesto: 0.00');
                  jQuery('#utilizado').html( 'Utilizado: 0.00');
                  jQuery('#utilizado_hora').html( 'Utilizado: 0.00 hrs');
                  jQuery('#ganancia_real').html( 'Gan. Real: 0.00');
                }

                if (settings.json.totales) {
                    
                  jQuery('#t_Capital').html( 'Capital: $'+number_format(settings.json.totales.capital, 2, '.', ','));
                  jQuery('#t_presupuesto').html( 'Presupuesto: $'+number_format(settings.json.totales.presupuesto, 2, '.', ','));
                  jQuery('#t_presupuesto_hora').html( 'Presupuesto: '+number_format(settings.json.totales.presupuesto_hora, 2, '.', ',')+' hrs');
                  jQuery('#t_ganancia_presupuesto').html( 'Gan. presupuesto: $'+number_format(settings.json.totales.capital-settings.json.totales.presupuesto, 2, '.', ','));
                  jQuery('#t_utilizado').html( 'Utilizado: $'+number_format(settings.json.totales.utilizado, 2, '.', ','));
                  jQuery('#t_utilizado_hora').html( 'Utilizado: '+number_format(settings.json.totales.utilizado_hora, 2, '.', ',')+' hrs');
                  jQuery('#t_ganancia_real').html( 'Gan. Real: $'+number_format(settings.json.totales.capital-settings.json.totales.utilizado, 2, '.', ','));

                } else {
                  jQuery('#t_Capital').html( 'Capital: 0.00');
                  jQuery('#t_presupuesto').html( 'Presupuesto: 0.00');
                  jQuery('#t_presupuesto_hora').html( 'Presupuesto: 0.00 hrs');
                  jQuery('#t_ganancia_presupuesto').html( 'Gan. presupuesto: 0.00');
                  jQuery('#t_utilizado').html( 'Utilizado: 0.00');
                  jQuery('#t_utilizado_hora').html( 'Utilizado: 0.00 hrs');
                  jQuery('#t_ganancia_real').html( 'Gan. Real: 0.00');
                }
             
                  return pre
              },               
     
        "columnDefs": [ 

                       { 
                        "className":      'details-control detalle_balance_usuario',
                        "orderable":      false,
                        "data":           null,
                        "defaultContent": '',
                        "targets": [0] 
                      },

                      { //proyecto                        
                        "render": function ( data, type, row ) {
                                return row[1] ;
                        },
                        "targets": [1] 
                      },
                      { //fecha
                        "render": function ( data, type, row ) {
                                return row[3] ;
                        },
                        "targets": [2] 
                      },
                      { // capital               
                        "render": function ( data, type, row ) {
                                 return (row[2]!=0)?'$'+number_format(row[2], 2, '.', ','):0 ;
                        },
                        "targets": [3] 
                      },
                      { //proyeccion costo *
                        "render": function ( data, type, row ) {
                                 if (horas_pesos=="Pesos"){
                                    return (row[5]!=0)?'$'+number_format(row[5], 2, '.', ','):0 ;
                                 } else {
                                    return (row[8]!=0)? number_format(row[8], 2, '.', ',')+' hrs':0 ;
                                 }                          
                        },
                        "targets": [4] 
                      },                      
                      { //proyeccion ganancia      
                        "render": function ( data, type, row ) {
                                 return (row[4]!=0)?'$'+number_format(row[4], 2, '.', ','):0 ;
                        },
                        "targets": [5] 
                      },
                      { //reales costo  *                       
                        "render": function ( data, type, row ) {
                                 if (horas_pesos=="Pesos"){
                                    return (row[6]!=0)?'$'+number_format(row[6], 2, '.', ','):0 ;
                                 } else {
                                    return (row[9]!=0)? number_format(row[9], 2, '.', ',')+' hrs':0 ;
                                 }                          
                        },
                        "targets": [6] 
                      },

                      { //reales ganancia                          
                        "render": function ( data, type, row ) {
                                 return (row[7]!=0)?'$'+number_format(row[7], 2, '.', ','):0 ;
                        },
                        "targets": [7] 
                      },
         ],
         
  });  



jQuery('#id_proyecto_gasto[modulo="usuario"], #id_area_gasto[modulo="usuario"], #id_usuario_gasto[modulo="usuario"]').on('change', function(e) {
        var campo = jQuery(this).attr("name");   
        var id_proyecto = jQuery('#id_proyecto_gasto').val();
        var id_area = jQuery('#id_area_gasto').val();
        var id_usuario = jQuery('#id_usuario_gasto').val();
        
        cargarDependencia_balance_usuario(campo,id_proyecto, id_area, id_usuario);
        //cuando cambie uno que refresh tabla
        var hash_url = window.location.pathname;
        switch (hash_url) {  //ver cual es el nivel seleccionado?
              case "/balance_usuario_ganancia_perdida":                   
                  var oTable =jQuery('#tabla_rep_balance_usuario_ganancia_perdida').dataTable();
              break;
              default:
                 break;
        }            
        oTable._fnAjaxUpdate(); 
});

function cargarDependencia_balance_usuario(campo,id_proyecto, id_area, id_usuario) {
        var url = 'cargarDependencia_balance_usuario'; 
        jQuery.ajax({
                url : '/cargarDependencia_balance_usuario',
                data:{
                    campo:campo,
                    id_proyecto:id_proyecto,
                    id_area: id_area,
                    id_usuario:id_usuario
                },
                type : 'POST',
                dataType : 'json',
                success : function(data) {
                        jQuery.each(data, function (dep, valor) {
                            jQuery("#"+dep).html(''); 
                            jQuery("#"+dep).append('<option value="-1" >Todos</option>'); 
                                jQuery.each(valor, function (i, value) {
                                    jQuery("#"+dep).append('<option '+ ( ((value.identificador).toString()==(value.activo).toString()) ? 'selected' : '') +' value="' + value.identificador + '" >' + value.nombre + '</option>');                                        
                                });
                        });
                    return false;
                },
                error : function(jqXHR, status, error) {
                },
                complete : function(jqXHR, status) {
                }
            }); 
    }


jQuery('#tabla_rep_balance_usuario_ganancia_perdida tbody').on('click', 'td.detalle_balance_usuario', function () {

        var tr = $(this).closest('tr');
        var td = $(this).closest('tr > td');
        var row = jQuery('#tabla_rep_balance_usuario_ganancia_perdida').DataTable().row( tr );
        if ( row.child.isShown() ) { //si la fila esta "abierta" entonces "cerrarla"
            row.child.hide();
            tr.removeClass('shown');
        } else {


            //si la fila esta "cerrada" entonces "abrirla"
            var d= row.data();

                 $.ajax({
                        url: "/procesando_balance_usuario_ganancia_perdida_detalle",
                        type: 'POST',
                        dataType: "json",
                        data: {
                            
                            id_proyecto: d[0], 
                            id_usuario : (jQuery('#id_usuario_gasto').val()!=null) ? jQuery('#id_usuario_gasto').val() : 0,
                            id_area : (jQuery('#id_area_gasto').val()!=null) ? jQuery('#id_area_gasto').val() : 0,
                            horas_pesos: horas_pesos
                         },
                        success: function(datos){
                            $cad='<table  class="tabla_hija display table table-striped table-bordered table-responsive dataTable"  role="grid" style="width: 100%; border:1px solid #2ab4c0;" >';
                                if (datos.data) {
                                      $cad +='<tr>';
                                          $cad +='<td class="text-center cursora" width="22%"><span style="font-weight:bold;">Usuario</span></td>';
                                          $cad +='<td class="text-center cursora" width="22%"><span style="font-weight:bold;">'+'Proyección Costo'+'</span></td>';
                                          $cad +='<td class="text-center cursora" width="22%"><span style="font-weight:bold;">'+'Costo Real'+'</span></td>';
                                          $cad +='<td class="text-center cursora" width="22%"><span style="font-weight:bold;">'+'Ganancia'+'</span></td>';
                                      $cad +='</tr>';  

                                      $.each(datos.data, function( i, value ) {
                                            $cad +='<tr>';
                                                $cad +='<td class="text-center cursora" width="22%"><span>'+value[3]+'</span></td>';
                                                if (horas_pesos=="Pesos"){
                                                  $cad +='<td class="text-center cursora" width="22%"><span>'+((value[5]!=0)?'$'+number_format(value[5], 2, '.', ','):0)+'</span></td>';
                                                  $cad +='<td class="text-center cursora" width="22%"><span>'+((value[6]!=0)?'$'+number_format(value[6], 2, '.', ','):0)+'</span></td>';
                                                 } else {
                                                    $cad +='<td class="text-center cursora" width="22%"><span>'+((value[8]!=0)? number_format(value[8], 2, '.', ',')+' hrs' :0)+'</span></td>';
                                                    $cad +='<td class="text-center cursora" width="22%"><span>'+((value[9]!=0)? number_format(value[9], 2, '.', ',')+' hrs' :0)+'</span></td>';
                                                 }  
                                                $cad +='<td class="text-center cursora" width="22%"><span>'+((value[5]-value[6]!=0)?'$'+number_format(value[5]-value[6], 2, '.', ','):0)+'</span></td>';

                                            $cad +='</tr>';  
                                     });   
                                }
                            $cad+='</table>';  
                            if (datos!=false) {
                                  row.child( $cad ).show();
                                  tr.addClass('shown');
                            }      

                        } //fin del success
                  });

        } //fin del else
} );



/////////////////



var tabla =  jQuery('#tabla_rep_horas_personas').dataTable( {
        "pagingType": "full_numbers",
        "processing": true,
        "serverSide": true,
         "ordering": false,
        "ajax": {
                    "url" : "procesando_rep_horas_personas",
                    "type": "POST",
                    "data": function ( d ) {
                        var fecha = (jQuery('.fecha_reporte').val()).split(' / ');
                        d.fecha_inicial = fecha[0];
                        d.fecha_final = fecha[1];
                        d.id_proyecto = (jQuery('#id_proyecto').val()!=null) ? jQuery('#id_proyecto').val() : 0;    
                        d.id_profundidad = (jQuery('#id_profundidad').val()!=null) ? (jQuery('#id_profundidad').val()) : -1;    
                        d.id_area = (jQuery('#id_area').val()!=null) ? jQuery('#id_area').val() : 0;    
                        d.id_usuario = (jQuery('#id_usuario').val()!=null) ? jQuery('#id_usuario').val() : 0;    
                        d.horas_pesos = horas_pesos;
                    }
         },   
        "language": {  //tratamiento de lenguaje
            "lengthMenu": "Mostrar _MENU_ registros por página",
            "zeroRecords": "No hay registros",
            "info": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "infoEmpty": "No hay registros disponibles",
            "infoFiltered": "(Mostrando _TOTAL_ de _MAX_ registros totales)",  
            "emptyTable":     "No hay registros",
            "infoPostFix":    "",
            "thousands":      ",",
            "loadingRecords": "Leyendo...",
            "processing":     "Procesando...",
            "search":         "Buscar:",
            "paginate": {
                "first":      "Primero",
                "last":       "Último",
                "next":       "Siguiente",
                "previous":   "Anterior"
            },
            "aria": {
                "sortAscending":  ": Activando para ordenar columnas ascendentes",
                "sortDescending": ": Activando para ordenar columnas descendentes"
            },
        },
        "infoCallback": function( settings, start, end, max, total, pre ) {
             var api = this.api(), data;
                  var intVal = function ( i ) {
                      return typeof i === 'string' ?
                          i.replace(/[\$,]/g, '')*1 :
                          typeof i === 'number' ?
                              i : 0;
                  };

              //las fechas y horas ("QUE SE MUESTRAN U OCULTAN")   
              for (var i = 9; i <= (intVal(settings.json.intervalo)+10); i++) {
                      api.column(i).visible(true);      
                  }        
              for (var i = (intVal(settings.json.intervalo)+10); i <= 40; i++) {
                      api.column(i).visible(false);      
                  }    
              return pre
        },
        "columnDefs": [ 
                      {
                        "render": function ( data, type, row ) {    
                          var color;
                          if (data=="Sab" || data=="Dom" ) {
                            color="#bbbab3;font-weight:bold;text-decoration:line-through;";
                          } else {
                            color=(data==0) ? "red;font-weight:bold;" : ((data==8) ? "black;" : ((data<8) ? "blue;font-weight:200;" : "green;font-weight:200;") );
                          }  

                          return '<span style="color:'+color+';">'+data+'</span>';
                        },
                          "targets": [9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40]                       
                      },
                      { 
                        "className":      'details-control detalle_horas_personas',
                        "orderable":      false,
                        "data":           null,
                        "defaultContent": '',
                        "targets": [0] 
                      },
                      { 
                        "render": function ( data, type, row ) {    
                          var color= "black";
                          return '<span style="color:'+color+';">'+row[4]+'</span>';
                        },
                        "targets": [1] 
                      },
                      { 
                        "render": function ( data, type, row ) {
                                return '('+row[5]+')' ;
                      },
                        "targets": [2] 
                      },     
                      {
                             "visible": false,
                            "targets": [3,4,5,6,7,8]
                      }
        ],
        "fnHeaderCallback": function( nHead, aData, iStart, iEnd, aiDisplay ) {
            var d = new Date();
            var n = d.getMonth()+1;
            var arreglo = ['','Usuarios', 'Proyectos Asociados','1/'+n, '2/'+n,'3/'+n,'4/'+n,'5/'+n,'6/'+n,'7/'+n, '8/'+n,'9/'+n,'10/'+n, '11/'+n,'12/'+n,'13/'+n, '14/'+n,'15/'+n,'16/'+n, '17/'+n,'18/'+n,'19/'+n, '20/'+n,'21/'+n,'22/'+n, '23/'+n,'24/'+n,'25/'+n, '26/'+n,'27/'+n,'28/'+n,'29/'+n,'30/'+n,'31/'+n]; 
            var fecha = (jQuery('.fecha_reporte').val()).split(' / ');
            var   fecha_inicial = fecha[0];
            var   fecha_final = fecha[1];
             if (fecha[0].length !=0) {
                     var fi = fecha[0]; //"28-02-2017 0:00";
                     var fo = fecha[1]; //"02-03-2017 0:00";
                     var dateArray =  getDates(new Date( fi.replace( /(\d{2})-(\d{2})-(\d{4})/, "$2-$1-$3") ), new Date( fo.replace( /(\d{2})-(\d{2})-(\d{4})/, "$2-$1-$3") )  );    
                     for (i = 0; i < dateArray.length; i ++ ) {
                          arreglo[i+3] = dateArray[i].getUTCDate()+'/'+ (parseInt(dateArray[i].getMonth())+1);
                      }    
             }
            var encabezado ='';
            if (aData.length !=0) {
                for (var i=0; i<=arreglo.length-(31-aData[0][8]); i++) { //cant_colum
                         encabezado +='<th class="text-center cursora" width="22%">'+arreglo[i]+'</th>';
                }
                    nHead.innerHTML='<tr role="row">'+encabezado+'</tr>'
            }    
        },       
  });  



jQuery('#tabla_rep_horas_personas tbody').on('click', 'td.detalle_horas_personas', function () {

        var tr = $(this).closest('tr');
        var td = $(this).closest('tr > td');
        var row = jQuery('#tabla_rep_horas_personas').DataTable().row( tr );
        if ( row.child.isShown() ) { //si la fila esta "abierta" entonces "cerrarla"
            row.child.hide();
            tr.removeClass('shown');
        } else {
            //si la fila esta "cerrada" entonces "abrirla"
            var d= row.data();
            var fecha = (jQuery('.fecha_reporte').val()).split(' / ');
                 $.ajax({
                        url: "/procesando_rep_horas_personas_detalle",
                        type: 'POST',
                        dataType: "json",
                        data: {
                            fecha_inicial : fecha[0],
                            fecha_final : fecha[1],
                            id_proyecto: (jQuery('#id_proyecto').val()!=null) ? jQuery('#id_proyecto').val() : 0,
                            id_profundidad: (jQuery('#id_profundidad').val()!=null) ? jQuery('#id_profundidad').val() : 0,
                            id_area : (jQuery('#id_area').val()!=null) ? jQuery('#id_area').val() : 0,
                            id_usuario : d[6], 
                            horas_pesos: horas_pesos
                            
                         },
                        success: function(datos){
                            
                            $cad='<table  class="tabla_hija display table table-striped table-bordered table-responsive dataTable"  role="grid" style="width: 100%; border:1px solid #2ab4c0;" >';
                                if (datos.data) {
                                     var d = new Date();
                                     var n = d.getMonth()+1;
                                     var arreglo = ['','', '','1/'+n, '2/'+n,'3/'+n,'4/'+n,'5/'+n,'6/'+n,'7/'+n, '8/'+n,'9/'+n,'10/'+n, '11/'+n,'12/'+n,'13/'+n, '14/'+n,'15/'+n,'16/'+n, '17/'+n,'18/'+n,'19/'+n, '20/'+n,'21/'+n,'22/'+n, '23/'+n,'24/'+n,'25/'+n, '26/'+n,'27/'+n,'28/'+n,'29/'+n,'30/'+n,'31/'+n]; 
                                     var fecha = (jQuery('.fecha_reporte').val()).split(' / ');
                                     var   fecha_inicial = fecha[0];
                                     var   fecha_final = fecha[1];
                                     if (fecha[0].length !=0) {
                                             var fi = fecha[0]; //"28-02-2017 0:00";
                                             var fo = fecha[1]; //"02-03-2017 0:00";
                                              var dateArray =  getDates(new Date( fi.replace( /(\d{2})-(\d{2})-(\d{4})/, "$2-$1-$3") ), new Date( fo.replace( /(\d{2})-(\d{2})-(\d{4})/, "$2-$1-$3") )  );    
                                              for (i = 0; i < dateArray.length; i ++ ) {
                                                   arreglo[i+3] = dateArray[i].getUTCDate()+'/'+ (parseInt(dateArray[i].getMonth())+1);
                                              }    
                                     }
                                    var encabezado ='';
                                    for (var i=0; i<=arreglo.length-(31-datos.intervalo); i++) { //cant_colum
                                          if (i<2) {  //quitar border 
                                              encabezado +='<th class="text-center cursora" style="border:0px;" width="22%">'+arreglo[i]+'</th>';
                                          } else {
                                            encabezado +='<th class="text-center cursora" width="22%">'+arreglo[i]+'</th>';
                                          }
                                    }
                                    $cad+='<tr style="color:#2ab4c0;" role="row">'+encabezado+'</tr>';
                                      $.each(datos.data, function( i, value ) {
                                          if (value[5]!=null){
                                              $cad +='<tr>';
                                                     $cad +='<td  class="text-center cursora" style="border:0px;" width="22%"></td>';
                                                     $cad +='<td  class="text-center cursora" style="border:0px;" width="22%"></td>';
                                                     $cad +='<td class="text-center cursora" width="22%"><span>';
                                                     $cad +='<as class="ttip" title="'+value[41]+'">'+value[4]+'</as>'; 
                                                     $cad +='<h6 class="help-block" style="color:#666;">'+(value[41].substr(0, value[41].indexOf("/") ))+'</h6>';
                                                     

                                                     $cad +='</span></td>';
                                                      for (var i=9; i<=9+parseInt(value[8]); i++) { //cant_colum
                                                               $cad +='<td class="text-center cursora" width="22%"><span>'+value[i]+'</span></td>';
                                                      }
                                              $cad +='</tr>';  
                                          }
                                     });   
                                }
                            $cad+='</table>';  
                            if (datos.data[0][5]!="") {
                                  row.child( $cad ).show();
                                  tr.addClass('shown');
                            }      

                            

                        }
                  });
        }
} );



/////////////////////////Submit nuevo proyecto
    jQuery('body').on('submit','#form_catalogos', function (e) {
            jQuery(this).ajaxSubmit({
                success: function(data){
                    if(data != true){
                        jQuery('#foo').css('display','none');
                        jQuery('#messages').css('display','block');
                        jQuery('#messages').addClass('alert-danger');
                        jQuery('#messages').html(data);
                    }else{
                            $catalogo = e.target.name;
                            window.location.href = '/'+$catalogo;   
                    }
                } 
            });
            return false;
    }); 
    jQuery('.fecha_reporte').daterangepicker({ 
            locale: { cancelLabel: 'Cancelar',
                      applyLabel: 'Aceptar',
                      fromLabel : 'Desde',
                      toLabel: 'Hasta',
                      monthNames : "ene._feb._mar_abr._may_jun_jul._ago_sep._oct._nov._dec.".split("_"),
                      daysOfWeek: "Do_Lu_Ma_Mi_Ju_Vi_Sa".split("_"),
                      customRangeLabel: "Personalizar rango",
                      //format: 'DD-MM-YYYY',
             } , 
             ranges: {
                   'Hoy': [moment(), moment()],
                   'Ayer': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                   'Ultimos 7 dias': [moment().subtract(6, 'days'), moment()],
                   'Ultimos 30 dias': [moment().subtract(29, 'days'), moment()],
                   'Este mes': [moment().startOf('month'), moment()], //moment().endOf('month')
                   'Ultimo Mes': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
              },
              format: 'DD-MM-YYYY',
               "dateLimit": {
                    "days": 30   //0--30(31dias) http://www.daterangepicker.com/
                },
               //"startDate": "22-02-2017", //"endDate": "28-02-2017",   //minDate: "01-02-2017",
               //maxDate: "+3d", //maxDate: moment(),    //http://www.daterangepicker.com/
               maxDate: moment(), //"28-02-2017",
            separator: ' / ',
    });
    jQuery('.fecha_reporte').on('apply.daterangepicker', function(ev, picker) {

        comienzo=true; 
        switch (jQuery(this).attr('tipo')) {  //ver cual es el nivel seleccionado?
              case "general":         
                  var oTable =jQuery('#tabla_rep_general').dataTable();
              break;
              case "horas_personas":         
                  var oTable =jQuery('#tabla_rep_horas_personas').dataTable();
              break;
               default:
                      break;
        }            

        
       oTable._fnAjaxUpdate();
    });

jQuery("#id_proyecto, #id_profundidad, #id_area, #id_usuario").on('change', function(e) {
        var campo = jQuery(this).attr("name");   
        var id_proyecto = jQuery('#id_proyecto').val();
        var id_profundidad = jQuery('#id_profundidad').val();
        var id_area = jQuery('#id_area').val();
        var id_usuario = jQuery('#id_usuario').val();
        var dependencia = jQuery(this).attr("dependencia"); 
        cargarDependencia_reporte(campo,id_proyecto,id_profundidad, id_area, id_usuario,dependencia);
        //cuando cambie uno que refresh tabla
        var hash_url = window.location.pathname;
        //if  ( (hash_url=="/general") )   {  

        switch (hash_url) {  //ver cual es el nivel seleccionado?
              case "/general":                   
                  var oTable =jQuery('#tabla_rep_general').dataTable();
              break;
              case "/horas_personas":                   
                  var oTable =jQuery('#tabla_rep_horas_personas').dataTable();
              break;                  
              default:
                 break;
        }            
        oTable._fnAjaxUpdate(); 
});

function cargarDependencia_reporte(campo,id_proyecto,id_profundidad, id_area, id_usuario,dependencia) {
        var url = 'cargar_dependencia_totales'; 
        jQuery.ajax({
                url : '/cargar_dependencia_reportes',
                data:{
                    campo:campo,
                    id_proyecto:id_proyecto,
                    id_profundidad:id_profundidad,
                    id_area: id_area,
                    id_usuario:id_usuario,                    
                    dependencia:dependencia
                },
                type : 'POST',
                dataType : 'json',
                success : function(data) {
                        jQuery.each(data, function (dep, valor) {
                            jQuery("#"+dep).html(''); 
                            jQuery("#"+dep).append('<option value="-1" >Todos</option>'); //+valor.nombre+   '+$elArray[dep]+'
                                jQuery.each(valor, function (i, value) {
                                    jQuery("#"+dep).append('<option '+ ( ((value.identificador).toString()==(value.activo).toString()) ? 'selected' : '') +' value="' + value.identificador + '" >' + value.nombre + '</option>');                                        
                                });
                        });
                    return false;
                },
                error : function(jqXHR, status, error) {
                },
                complete : function(jqXHR, status) {
                }
            }); 
    }






var tabla =  jQuery('#tabla_rep_general').dataTable( {
        "pagingType": "full_numbers",
        "processing": true,
        "serverSide": true,
         "ordering": false,
        "ajax": {
                    "url" : "procesando_rep_general",
                    "type": "POST",
                    "data": function ( d ) {
                        var fecha = (jQuery('.fecha_reporte').val()).split(' / ');
                        d.fecha_inicial = fecha[0];
                        d.fecha_final = fecha[1];
                        d.id_proyecto = (jQuery('#id_proyecto').val()!=null) ? jQuery('#id_proyecto').val() : 0;    
                        d.id_profundidad = (jQuery('#id_profundidad').val()!=null) ? (jQuery('#id_profundidad').val()) : -1;    
                        d.id_area = (jQuery('#id_area').val()!=null) ? jQuery('#id_area').val() : 0;    
                        d.id_usuario = (jQuery('#id_usuario').val()!=null) ? jQuery('#id_usuario').val() : 0;    
                        d.horas_pesos = horas_pesos;
                    }
         },   
        "language": {  //tratamiento de lenguaje
            "lengthMenu": "Mostrar _MENU_ registros por página",
            "zeroRecords": "No hay registros",
            "info": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "infoEmpty": "No hay registros disponibles",
            "infoFiltered": "(Mostrando _TOTAL_ de _MAX_ registros totales)",  
            "emptyTable":     "No hay registros",
            "infoPostFix":    "",
            "thousands":      ",",
            "loadingRecords": "Leyendo...",
            "processing":     "Procesando...",
            "search":         "Buscar:",
            "paginate": {
                "first":      "Primero",
                "last":       "Último",
                "next":       "Siguiente",
                "previous":   "Anterior"
            },
            "aria": {
                "sortAscending":  ": Activando para ordenar columnas ascendentes",
                "sortDescending": ": Activando para ordenar columnas descendentes"
            },
        },
"infoCallback": function( settings, start, end, max, total, pre ) {
     var api = this.api(), data;
          var intVal = function ( i ) {
              return typeof i === 'string' ?
                  i.replace(/[\$,]/g, '')*1 :
                  typeof i === 'number' ?
                      i : 0;
          };
      for (var i = 9; i <= (intVal(settings.json.intervalo)+10); i++) {
              api.column(i).visible(true);      
          }        
      for (var i = (intVal(settings.json.intervalo)+10); i <= 40; i++) {
              api.column(i).visible(false);      
          }    
      return pre
},
        "columnDefs": [ 
                      {
                          "targets": 40, //(jQuery('#tabla_rep_general').dataTable().fnSettings().aoData[0]._aData.length-1  !== 'undefined') ? (jQuery('#tabla_rep_general').dataTable().fnSettings().aoData[0]._aData.length-1) : 9 ,
                      },
                      { 
                        "className":      'details-control',
                        "orderable":      false,
                        "data":           null,
                        "defaultContent": '',
                        "targets": [0] 
                      },
                      { 
                        "render": function ( data, type, row ) {    
                          var color=(row[0]==1) ? "red" : "black";
                          return '<span style="color:'+color+';">'+'-'.repeat(row[3])+''+row[4]+'</span>';
                        },
                        "targets": [1] 
                      },
                      { 
                        "render": function ( data, type, row ) {
                                //return row[5]+' '+row[6] ;
                                return '('+row[5]+')' ;
                        },
                        "targets": [2] 
                      },     
                      { 
                             "visible": false,
                            "targets": [3,4,5,6,7,8]
                       }                                   
         ],
        "fnHeaderCallback": function( nHead, aData, iStart, iEnd, aiDisplay ) {
            var d = new Date();
            var n = d.getMonth()+1;
            var arreglo = ['','Proyectos', 'Usuarios Asociados','1/'+n, '2/'+n,'3/'+n,'4/'+n,'5/'+n,'6/'+n,'7/'+n, '8/'+n,'9/'+n,'10/'+n, '11/'+n,'12/'+n,'13/'+n, '14/'+n,'15/'+n,'16/'+n, '17/'+n,'18/'+n,'19/'+n, '20/'+n,'21/'+n,'22/'+n, '23/'+n,'24/'+n,'25/'+n, '26/'+n,'27/'+n,'28/'+n,'29/'+n,'30/'+n,'31/'+n]; 
            var fecha = (jQuery('.fecha_reporte').val()).split(' / ');
            var   fecha_inicial = fecha[0];
            var   fecha_final = fecha[1];
             if (fecha[0].length !=0) {
                     var fi = fecha[0]; //"28-02-2017 0:00";
                     var fo = fecha[1]; //"02-03-2017 0:00";
                     var dateArray =  getDates(new Date( fi.replace( /(\d{2})-(\d{2})-(\d{4})/, "$2-$1-$3") ), new Date( fo.replace( /(\d{2})-(\d{2})-(\d{4})/, "$2-$1-$3") )  );    
                     for (i = 0; i < dateArray.length; i ++ ) {
                          arreglo[i+3] = dateArray[i].getUTCDate()+'/'+ (parseInt(dateArray[i].getMonth())+1);
                      }    
             }
            var encabezado ='';
            if (aData.length !=0) {
                for (var i=0; i<=arreglo.length-(31-aData[0][8]); i++) { //cant_colum
                         encabezado +='<th class="text-center cursora" width="22%">'+arreglo[i]+'</th>';
                }
                    nHead.innerHTML='<tr role="row">'+encabezado+'</tr>'
            }    
        },       
  });  



var hash_url = window.location.pathname;
if  ( (hash_url=="/general") || (hash_url=="/horas_personas") )   {  
    jQuery("#id_proyecto").trigger('change');
}  

jQuery('#tabla_rep_general tbody').on('click', 'td.details-control', function () {
        var tr = $(this).closest('tr');
        var td = $(this).closest('tr > td');
        var row = jQuery('#tabla_rep_general').DataTable().row( tr );
        if ( row.child.isShown() ) { //si la fila esta "abierta" entonces "cerrarla"
            row.child.hide();
            tr.removeClass('shown');
        } else {
            //si la fila esta "cerrada" entonces "abrirla"
            var d= row.data();
            var fecha = (jQuery('.fecha_reporte').val()).split(' / ');
                 $.ajax({
                        url: "/procesando_rep_general_detalle",
                        type: 'POST',
                        dataType: "json",
                        data: {
                            fecha_inicial : fecha[0],
                            fecha_final : fecha[1],
                            id_proyecto: d[2],
                            id_profundidad: d[3],
                            id_proy: d[6], //id_nivel
                            id_usuario : (jQuery('#id_usuario').val()!=null) ? jQuery('#id_usuario').val() : 0, 
                            id_area : (jQuery('#id_area').val()!=null) ? jQuery('#id_area').val() : 0,
                            horas_pesos: horas_pesos
                         },
                        success: function(datos){
                            $cad='<table  class="tabla_hija display table table-striped table-bordered table-responsive dataTable"  role="grid" style="width: 100%; border:1px solid #2ab4c0;" >';
                                if (datos.data) {
                                     var d = new Date();
                                     var n = d.getMonth()+1;
                                     var arreglo = ['','', '','1/'+n, '2/'+n,'3/'+n,'4/'+n,'5/'+n,'6/'+n,'7/'+n, '8/'+n,'9/'+n,'10/'+n, '11/'+n,'12/'+n,'13/'+n, '14/'+n,'15/'+n,'16/'+n, '17/'+n,'18/'+n,'19/'+n, '20/'+n,'21/'+n,'22/'+n, '23/'+n,'24/'+n,'25/'+n, '26/'+n,'27/'+n,'28/'+n,'29/'+n,'30/'+n,'31/'+n]; 
                                     var fecha = (jQuery('.fecha_reporte').val()).split(' / ');
                                     var   fecha_inicial = fecha[0];
                                     var   fecha_final = fecha[1];
                                     if (fecha[0].length !=0) {
                                             var fi = fecha[0]; //"28-02-2017 0:00";
                                             var fo = fecha[1]; //"02-03-2017 0:00";
                                              var dateArray =  getDates(new Date( fi.replace( /(\d{2})-(\d{2})-(\d{4})/, "$2-$1-$3") ), new Date( fo.replace( /(\d{2})-(\d{2})-(\d{4})/, "$2-$1-$3") )  );    
                                              for (i = 0; i < dateArray.length; i ++ ) {
                                                   arreglo[i+3] = dateArray[i].getUTCDate()+'/'+ (parseInt(dateArray[i].getMonth())+1);
                                              }    
                                     }
                                    var encabezado ='';
                                    for (var i=0; i<=arreglo.length-(31-datos.intervalo); i++) { //cant_colum
                                          if (i<2) {  //quitar border 
                                              encabezado +='<th class="text-center cursora" style="border:0px;" width="22%">'+arreglo[i]+'</th>';
                                          } else {
                                            encabezado +='<th class="text-center cursora" width="22%">'+arreglo[i]+'</th>';
                                          }
                                    }
                                    $cad+='<tr style="color:#2ab4c0;" role="row">'+encabezado+'</tr>';
                                      $.each(datos.data, function( i, value ) {
                                          if (value[5]!=null){
                                              $cad +='<tr>';
                                                     $cad +='<td  class="text-center cursora" style="border:0px;" width="22%"></td>';
                                                     $cad +='<td  class="text-center cursora" style="border:0px;" width="22%"></td>';
                                                     $cad +='<td class="text-center cursora" width="22%"><span>'+value[5]+' '+value[6]+'</span></td>';
                                                      for (var i=9; i<=9+parseInt(value[8]); i++) { //cant_colum
                                                               $cad +='<td class="text-center cursora" width="22%"><span>'+value[i]+'</span></td>';
                                                      }
                                              $cad +='</tr>';  
                                          }
                                     });   
                                }
                            $cad+='</table>';  
                            if (datos.data[0][5]!="") {
                                  row.child( $cad ).show();
                                  tr.addClass('shown');
                            }      
                        }
                  });
        }
    } );


   Date.prototype.addDays = function(days) {
       var dat = new Date(this.valueOf())
       dat.setDate(dat.getDate() + days);
       return dat;
   }
   function getDates(startDate, stopDate) {
      var dateArray = new Array();
      var currentDate = startDate;
      while (currentDate <= stopDate) {
        dateArray.push(currentDate)
        currentDate = currentDate.addDays(1);
      }
      return dateArray;
    }
//areas
jQuery('#tabla_cat_areas').dataTable( {
        "pagingType": "full_numbers",
        "processing": true,
        "serverSide": true,
        "ajax": {
                    "url" : "procesando_cat_areas",
                    "type": "POST",
         },   
        "language": {  //tratamiento de lenguaje
            "lengthMenu": "Mostrar _MENU_ registros por página",
            "zeroRecords": "No hay registros",
            "info": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "infoEmpty": "No hay registros disponibles",
            "infoFiltered": "(Mostrando _TOTAL_ de _MAX_ registros totales)",  
            "emptyTable":     "No hay registros",
            "infoPostFix":    "",
            "thousands":      ",",
            "loadingRecords": "Leyendo...",
            "processing":     "Procesando...",
            "search":         "Buscar:",
            "paginate": {
                "first":      "Primero",
                "last":       "Último",
                "next":       "Siguiente",
                "previous":   "Anterior"
            },
            "aria": {
                "sortAscending":  ": Activando para ordenar columnas ascendentes",
                "sortDescending": ": Activando para ordenar columnas descendentes"
            },
        },
        "columnDefs": [
                    { 
                        "render": function ( data, type, row ) {
                                return row[1];
                        },
                        "targets": [0] 
                    },
                    { 
                        "render": function ( data, type, row ) {
                                return row[2];
                        },
                        "targets": [1] 
                    },
                    { 
                        "render": function ( data, type, row ) {
                                return row[3];
                        },
                        "targets": [2] 
                    },
                    {
                        "render": function ( data, type, row ) {
                        texto='<td>';
                            texto+='<a href="editar_area/'+jQuery.base64.encode(row[0])+'" type="button"'; 
                            texto+=' class="btn btn-warning btn-sm btn-block" >';
                                texto+=' <span class="glyphicon glyphicon-edit"></span>';
                            texto+=' </a>';
                        texto+=' </td>';
                            return texto;   
                        },
                        "targets": 3
                    },
                    {
                        "render": function ( data, type, row ) {
                            if (row[4]==0) {
                                texto=' <td>';                              
                                    texto+=' <a href="eliminar_area/'+jQuery.base64.encode(row[0])+'/'+jQuery.base64.encode(row[1])+ '"'; 
                                    texto+=' class="btn btn-danger btn-sm btn-block" data-toggle="modal" data-target="#modalMessage">';
                                    texto+=' <span class="glyphicon glyphicon-remove"></span>';
                                    texto+=' </a>';
                                texto+=' </td>';
                           } else {
                                texto=' <fieldset disabled> <td>';                              
                                    texto+=' <a href="#"'; 
                                    texto+=' class="btn btn-danger btn-sm btn-block">';
                                    texto+=' <span class="glyphicon glyphicon-remove"></span>';
                                    texto+=' </a>';
                                texto+=' </td></fieldset>'; 
                            }
                            return texto;   
                        },
                        "targets": 4
                    },
                ],
    });  
//cargos
jQuery('#tabla_cat_cargos').dataTable( {
        "pagingType": "full_numbers",
        "processing": true,
        "serverSide": true,
        "ajax": {
                    "url" : "procesando_cat_cargos",
                    "type": "POST",
         },   
        "language": {  //tratamiento de lenguaje
            "lengthMenu": "Mostrar _MENU_ registros por página",
            "zeroRecords": "No hay registros",
            "info": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "infoEmpty": "No hay registros disponibles",
            "infoFiltered": "(Mostrando _TOTAL_ de _MAX_ registros totales)",  
            "emptyTable":     "No hay registros",
            "infoPostFix":    "",
            "thousands":      ",",
            "loadingRecords": "Leyendo...",
            "processing":     "Procesando...",
            "search":         "Buscar:",
            "paginate": {
                "first":      "Primero",
                "last":       "Último",
                "next":       "Siguiente",
                "previous":   "Anterior"
            },
            "aria": {
                "sortAscending":  ": Activando para ordenar columnas ascendentes",
                "sortDescending": ": Activando para ordenar columnas descendentes"
            },
        },
        "columnDefs": [
                    { 
                        "render": function ( data, type, row ) {
                                return row[1];
                        },
                        "targets": [0] 
                    },
                    { 
                        "render": function ( data, type, row ) {
                            var checado = ((row[2] == 1) ? "checked" : ""); 
                            texto='<td><fieldset disabled>';
                                texto+='<input type="checkbox" '+checado+' class="check_activo" identificador='+row[2]+' style="margin: 33px 33px 0px;" name="lider[]" value="1">'; 
                            texto+=' </td>';                         
                            return texto;                                   
                        },
                        "targets": [1] 
                    },
                    { 
                        "render": function ( data, type, row ) {
                            var checado = ((row[3] == 1) ? "checked" : ""); 
                            texto='<td><fieldset disabled>';
                                texto+='<input type="checkbox" '+checado+' class="check_activo" identificador='+row[3]+' style="margin: 33px 33px 0px;" name="activo[]" value="1">'; 
                            texto+=' </td>';                         
                            return texto;                                   
                        },
                        "targets": [2] 
                    },
                    {
                        "render": function ( data, type, row ) {
                        texto=' <td>'; 
                            texto+='<a href="editar_cargo/'+jQuery.base64.encode(row[0])+'" type="button"'; 
                            texto+=' class="btn btn-warning btn-sm btn-block" >';
                                texto+=' <span class="glyphicon glyphicon-edit"></span>';
                            texto+=' </a>';
                        texto+=' </td>';
                            return texto;   
                        },
                        "targets": 3
                    },
                    {
                        "render": function ( data, type, row ) {
                            if (row[4]==0) {                           
                                texto=' <td>';                              
                                    texto+=' <a href="eliminar_cargo/'+jQuery.base64.encode(row[0])+'/'+jQuery.base64.encode(row[1])+ '"'; 
                                    texto+=' class="btn btn-danger btn-sm btn-block" data-toggle="modal" data-target="#modalMessage">';
                                    texto+=' <span class="glyphicon glyphicon-remove"></span>';
                                    texto+=' </a>';
                                texto+=' </td>';
                            } else {
                                texto=' <fieldset disabled> <td>';                              
                                    texto+=' <a href="#"'; 
                                    texto+=' class="btn btn-danger btn-sm btn-block">';
                                    texto+=' <span class="glyphicon glyphicon-remove"></span>';
                                    texto+=' </a>';
                                texto+=' </td></fieldset>'; 
                            }
                            return texto;   
                        },
                        "targets": 4
                    },
                ],
    });     
//perfiles
jQuery('#tabla_cat_perfiles').dataTable( {
        "pagingType": "full_numbers",
        "processing": true,
        "serverSide": true,
        "ajax": {
                    "url" : "procesando_cat_perfiles",
                    "type": "POST",
         },   
        "language": {  //tratamiento de lenguaje
            "lengthMenu": "Mostrar _MENU_ registros por página",
            "zeroRecords": "No hay registros",
            "info": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "infoEmpty": "No hay registros disponibles",
            "infoFiltered": "(Mostrando _TOTAL_ de _MAX_ registros totales)",  
            "emptyTable":     "No hay registros",
            "infoPostFix":    "",
            "thousands":      ",",
            "loadingRecords": "Leyendo...",
            "processing":     "Procesando...",
            "search":         "Buscar:",
            "paginate": {
                "first":      "Primero",
                "last":       "Último",
                "next":       "Siguiente",
                "previous":   "Anterior"
            },
            "aria": {
                "sortAscending":  ": Activando para ordenar columnas ascendentes",
                "sortDescending": ": Activando para ordenar columnas descendentes"
            },
        },
        "columnDefs": [
                    { 
                        "render": function ( data, type, row ) {
                                return row[1];  //perfil
                        },
                        "targets": [0] 
                    },
                    { 
                        "render": function ( data, type, row ) { //operacion CRUDFGM
                                return row[2];
                        },
                        "targets": [1] 
                    },
                    {
                        "render": function ( data, type, row ) {
                        texto=' <td>';  
                            texto+='<a href="editar_perfil/'+jQuery.base64.encode(row[0])+'" type="button"'; 
                            texto+=' class="btn btn-warning btn-sm btn-block" >';
                                texto+=' <span class="glyphicon glyphicon-edit"></span>';
                            texto+=' </a>';
                       texto+=' </td>';
                            return texto;   
                       },
                        "targets": 2
                    },
                    {
                        "render": function ( data, type, row ) {
                            if (row[3]==0) {
                                texto=' <td>';                              
                                    texto+=' <a href="eliminar_perfil/'+jQuery.base64.encode(row[0])+'/'+jQuery.base64.encode(row[1])+ '"'; 
                                    texto+=' class="btn btn-danger btn-sm btn-block" data-toggle="modal" data-target="#modalMessage">';
                                    texto+=' <span class="glyphicon glyphicon-remove"></span>';
                                    texto+=' </a>';
                                texto+=' </td>';
                            } else {
                                texto=' <fieldset disabled> <td>';                              
                                    texto+=' <a href="#"'; 
                                    texto+=' class="btn btn-danger btn-sm btn-block">';
                                    texto+=' <span class="glyphicon glyphicon-remove"></span>';
                                    texto+=' </a>';
                                texto+=' </td></fieldset>'; 
                            }                                
                            return texto;   
                        },
                        "targets": 3
                    },
                ],
    });  
//configuraciones
jQuery('#tabla_cat_configuraciones').dataTable( {
        "pagingType": "full_numbers",
        "processing": true,
        "serverSide": true,
        "ajax": {
                    "url" : "procesando_cat_configuraciones",
                    "type": "POST",
         },   
        "language": {  //tratamiento de lenguaje
            "lengthMenu": "Mostrar _MENU_ registros por página",
            "zeroRecords": "No hay registros",
            "info": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "infoEmpty": "No hay registros disponibles",
            "infoFiltered": "(Mostrando _TOTAL_ de _MAX_ registros totales)",  
            "emptyTable":     "No hay registros",
            "infoPostFix":    "",
            "thousands":      ",",
            "loadingRecords": "Leyendo...",
            "processing":     "Procesando...",
            "search":         "Buscar:",
            "paginate": {
                "first":      "Primero",
                "last":       "Último",
                "next":       "Siguiente",
                "previous":   "Anterior"
            },
            "aria": {
                "sortAscending":  ": Activando para ordenar columnas ascendentes",
                "sortDescending": ": Activando para ordenar columnas descendentes"
            },
        },
        "columnDefs": [
                    { 
                        "render": function ( data, type, row ) {  //configuracion
                                return row[1];
                        },
                        "targets": [0] 
                    },
                    { 
                        "render": function ( data, type, row ) { //valor
                                return row[2];
                        },
                        "targets": [1] 
                    },
                    { 
                        "render": function ( data, type, row ) { //activo
                            var checado = ((row[3] == 1) ? "checked" : ""); 
                            texto='<td><fieldset disabled>';
                                texto+='<input type="checkbox" '+checado+' class="check_activo" identificador='+row[3]+' style="margin: 33px 33px 0px;" name="lider[]" value="1">'; 
                            texto+=' </td>';                         
                            return texto;   
                        },
                        "targets": [2] 
                    },
                    {
                        "render": function ( data, type, row ) {
                        texto=' <td>'; 
                            texto+='<a href="editar_configuracion/'+jQuery.base64.encode(row[0])+'" type="button"'; 
                            texto+=' class="btn btn-warning btn-sm btn-block" >';
                                texto+=' <span class="glyphicon glyphicon-edit"></span>';
                            texto+=' </a>';
                        texto+=' </td>';
                            return texto;   
                        },
                        "targets": 3
                    },
                    {
                        "render": function ( data, type, row ) {
                            if (row[4]==0) {    
                                texto=' <td>';                              
                                    texto+=' <a href="eliminar_configuracion/'+jQuery.base64.encode(row[0])+'/'+jQuery.base64.encode(row[1])+ '"'; 
                                    texto+=' class="btn btn-danger btn-sm btn-block" data-toggle="modal" data-target="#modalMessage">';
                                    texto+=' <span class="glyphicon glyphicon-remove"></span>';
                                    texto+=' </a>';
                                texto+=' </td>';
                            } else {
                                texto=' <fieldset disabled> <td>';                              
                                    texto+=' <a href="#"'; 
                                    texto+=' class="btn btn-danger btn-sm btn-block">';
                                    texto+=' <span class="glyphicon glyphicon-remove"></span>';
                                    texto+=' </a>';
                                texto+=' </td></fieldset>'; 
                            }    
                            return texto;   
                        },
                        "targets": 4
                    },
                ],
    });


//categ_gastos
jQuery('#tabla_cat_categ_gastos').dataTable( {
        "pagingType": "full_numbers",
        "processing": true,
        "serverSide": true,
        "ajax": {
                    "url" : "procesando_cat_categ_gastos",
                    "type": "POST",
         },   
        "language": {  //tratamiento de lenguaje
            "lengthMenu": "Mostrar _MENU_ registros por página",
            "zeroRecords": "No hay registros",
            "info": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "infoEmpty": "No hay registros disponibles",
            "infoFiltered": "(Mostrando _TOTAL_ de _MAX_ registros totales)",  
            "emptyTable":     "No hay registros",
            "infoPostFix":    "",
            "thousands":      ",",
            "loadingRecords": "Leyendo...",
            "processing":     "Procesando...",
            "search":         "Buscar:",
            "paginate": {
                "first":      "Primero",
                "last":       "Último",
                "next":       "Siguiente",
                "previous":   "Anterior"
            },
            "aria": {
                "sortAscending":  ": Activando para ordenar columnas ascendentes",
                "sortDescending": ": Activando para ordenar columnas descendentes"
            },
        },
        "columnDefs": [
                    {  //nombre
                        "render": function ( data, type, row ) {
                                return row[1]; 
                        },
                        "targets": [0] 
                    },
                    {  //activo
                        "render": function ( data, type, row ) {
                            var checado = ((row[2] == 1) ? "checked" : ""); 
                            texto='<td><fieldset disabled>';
                                texto+='<input type="checkbox" '+checado+' class="check_activo" identificador='+row[2]+' style="margin: 33px 33px 0px;" name="activo[]" value="1">'; 
                            texto+=' </td>';                         
                            return texto;                                   
                        },
                        "targets": [1] 
                    },
                    {
                        "render": function ( data, type, row ) {
                        texto=' <td>'; 
                            texto+='<a href="editar_categ_gasto/'+jQuery.base64.encode(row[0])+'" type="button"'; 
                            texto+=' class="btn btn-warning btn-sm btn-block" >';
                                texto+=' <span class="glyphicon glyphicon-edit"></span>';
                            texto+=' </a>';
                        texto+=' </td>';
                            return texto;   
                        },
                        "targets": 2
                    },
                    {
                        "render": function ( data, type, row ) {
                            if (row[3]==0) {                           
                                texto=' <td>';                              
                                    texto+=' <a href="eliminar_categ_gasto/'+jQuery.base64.encode(row[0])+'/'+jQuery.base64.encode(row[1])+ '"'; 
                                    texto+=' class="btn btn-danger btn-sm btn-block" data-toggle="modal" data-target="#modalMessage">';
                                    texto+=' <span class="glyphicon glyphicon-remove"></span>';
                                    texto+=' </a>';
                                texto+=' </td>';
                            } else {
                                texto=' <fieldset disabled> <td>';                              
                                    texto+=' <a href="#"'; 
                                    texto+=' class="btn btn-danger btn-sm btn-block">';
                                    texto+=' <span class="glyphicon glyphicon-remove"></span>';
                                    texto+=' </a>';
                                texto+=' </td></fieldset>'; 
                            }
                            return texto;   
                        },
                        "targets": 3
                    },
                ],
    });   



//gastos
jQuery('#tabla_cat_gastos').dataTable( {
        "pagingType": "full_numbers",
        "processing": true,
        "serverSide": true,
        "ajax": {
                    "url" : "procesando_cat_gastos",
                    "type": "POST",
         },   
        "language": {  //tratamiento de lenguaje
            "lengthMenu": "Mostrar _MENU_ registros por página",
            "zeroRecords": "No hay registros",
            "info": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "infoEmpty": "No hay registros disponibles",
            "infoFiltered": "(Mostrando _TOTAL_ de _MAX_ registros totales)",  
            "emptyTable":     "No hay registros",
            "infoPostFix":    "",
            "thousands":      ",",
            "loadingRecords": "Leyendo...",
            "processing":     "Procesando...",
            "search":         "Buscar:",
            "paginate": {
                "first":      "Primero",
                "last":       "Último",
                "next":       "Siguiente",
                "previous":   "Anterior"
            },
            "aria": {
                "sortAscending":  ": Activando para ordenar columnas ascendentes",
                "sortDescending": ": Activando para ordenar columnas descendentes"
            },
        },
        "columnDefs": [
                    {  //nombre
                        "render": function ( data, type, row ) {
                                return row[1]; 
                        },
                        "targets": [0] 
                    },
                    {  //activo
                        "render": function ( data, type, row ) {
                            var checado = ((row[2] == 1) ? "checked" : ""); 
                            texto='<td><fieldset disabled>';
                                texto+='<input type="checkbox" '+checado+' class="check_activo" identificador='+row[2]+' style="margin: 33px 33px 0px;" name="activo[]" value="1">'; 
                            texto+=' </td>';                         
                            return texto;                                   
                        },
                        "targets": [1] 
                    },
                    {
                        "render": function ( data, type, row ) {
                        texto=' <td>'; 
                            texto+='<a href="editar_gasto/'+jQuery.base64.encode(row[0])+'" type="button"'; 
                            texto+=' class="btn btn-warning btn-sm btn-block" >';
                                texto+=' <span class="glyphicon glyphicon-edit"></span>';
                            texto+=' </a>';
                        texto+=' </td>';
                            return texto;   
                        },
                        "targets": 2
                    },
                    {
                        "render": function ( data, type, row ) {
                            if (row[3]==0) {                           
                                texto=' <td>';                              
                                    texto+=' <a href="eliminar_gasto/'+jQuery.base64.encode(row[0])+'/'+jQuery.base64.encode(row[1])+ '"'; 
                                    texto+=' class="btn btn-danger btn-sm btn-block" data-toggle="modal" data-target="#modalMessage">';
                                    texto+=' <span class="glyphicon glyphicon-remove"></span>';
                                    texto+=' </a>';
                                texto+=' </td>';
                            } else {
                                texto=' <fieldset disabled> <td>';                              
                                    texto+=' <a href="#"'; 
                                    texto+=' class="btn btn-danger btn-sm btn-block">';
                                    texto+=' <span class="glyphicon glyphicon-remove"></span>';
                                    texto+=' </a>';
                                texto+=' </td></fieldset>'; 
                            }
                            return texto;   
                        },
                        "targets": 3
                    },
                ],
    });           
///////////////////////Formatear 
          //http://phpjs.org/functions/number_format/
function number_format(number, decimals, dec_point, thousands_sep) {
  number = (number + '')
    .replace(/[^0-9+\-Ee.]/g, '');
  var n = !isFinite(+number) ? 0 : +number,
    prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
    sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
    dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
    s = '',
    toFixedFix = function(n, prec) {
      var k = Math.pow(10, prec);
      return '' + (Math.round(n * k) / k)
        .toFixed(prec);
    };
  // Fix for IE parseFloat(0.55).toFixed(0) = 0;
  s = (prec ? toFixedFix(n, prec) : '' + Math.round(n))
    .split('.');
  if (s[0].length > 3) {
    s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
  }
  if ((s[1] || '')
    .length < prec) {
    s[1] = s[1] || '';
    s[1] += new Array(prec - s[1].length + 1)
      .join('0');
  }
  return s.join(dec);
}
});
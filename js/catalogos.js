jQuery(document).ready(function($) {



                 


    jQuery('body').on('submit','#form_entornos', function (e) {

           // jQuery('#foo').css('display','block');
            //var spinner = new Spinner(opts).spin(target);
            jQuery(this).ajaxSubmit({
                success: function(data){
                    
                    if(data != true){
                        
                        //spinner.stop();
                        jQuery('#foo').css('display','none');
                        jQuery('#messages').css('display','block');
                        jQuery('#messages').addClass('alert-danger');
                        jQuery('#messages').html(data);
                        /*
                        jQuery('html,body').animate({
                            'scrollTop': jQuery('#messages').offset().top
                        }, 1000);
                        */
                    

                    }else{
                        
                            $catalogo = e.target.name;
                            //spinner.stop();
                           // jQuery('#foo').css('display','none');
                            //e.preventDefault();
                            window.location.href = '/'+$catalogo;   
                            
                    }

                } 
            });
            return false;
    }); 




jQuery('#tabla_cat_entornos').dataTable( {
    
      "pagingType": "full_numbers",
        
        "processing": true,
        "serverSide": true,
        "ajax": {
                    "url" : "procesando_cat_entornos",
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
                        "targets": [0] //,2,3,4
                    },

                    { 
                        "render": function ( data, type, row ) {
                                return row[2];
                        },
                        "targets": [1] //,2,3,4
                    },

                    { 
                        "render": function ( data, type, row ) {
                                return row[3];
                        },
                        "targets": [2] //,2,3,4
                    },

                    { 
                        "render": function ( data, type, row ) {
                                return row[4];
                        },
                        "targets": [3] //,2,3,4
                    },



                    {
                        "render": function ( data, type, row ) {

                        texto='<td>';
                            texto+='<a href="editar_entorno/'+jQuery.base64.encode(row[0])+'" type="button"'; 
                            texto+=' class="btn btn-warning btn-sm btn-block" >';
                                texto+=' <span class="glyphicon glyphicon-edit"></span>';
                            texto+=' </a>';
                        texto+='</td>';



                            return texto;   
                        },
                        "targets": 4
                    },

                    
                    {
                        "render": function ( data, type, row ) {

                            if (row[4]==0) {
                                texto=' <td>';                              
                                    texto+=' <a href="eliminar_entorno/'+jQuery.base64.encode(row[0])+'/'+jQuery.base64.encode(row[1])+ '"'; 
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


                                texto=' <td>';                              
                                    texto+=' <a href="eliminar_entorno/'+jQuery.base64.encode(row[0])+'/'+jQuery.base64.encode(row[1])+ '"'; 
                                    texto+=' class="btn btn-danger btn-sm btn-block" data-toggle="modal" data-target="#modalMessage">';
                                    texto+=' <span class="glyphicon glyphicon-remove"></span>';
                                    texto+=' </a>';
                                texto+=' </td>';  
                                    


                            return texto;   
                        },
                        "targets": 5
                    },
                   
                    
                ],
    });     



});
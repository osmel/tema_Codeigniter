jQuery(document).ready(function($) {
submit_forzado =false;



/////////////////////////Submit nuevo proyecto
    jQuery('body').on('submit','#form_usuarios', function (e) {

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

/*

Francisco 45ba2895-d01a-11e5-b036-04015a6da701 pedidos@iniciativatextil.com NULL
Gabriela a4a2510d-d02c-11e5-b036-04015a6da701 ventas@impactotextil.com NULL 
ana 65350f7e-d031-11e5-b036-04015a6da701 ana@hotmail.com 123456789
Veronica 1f5af5d1-d034-11e5-b036-04015a6da701 ventas@iniciativatextil.com NULL
Jorge 32683212-21d2-11e5-aa7c-04015a6da701 jorge_espinosa@iniciativatextil.com NULL

*/



    var fechapaginador = new Date();
    var fechapaginador_anterior = new Date();

    $('#fecha_paginador').datepaginator({
                
            
            //dias que aparecerán en gris
            showOffDays: true, //!0,    activa o desactiva el "offDays"
            offDaysFormat: "ddd",  //formato utilizado para que se evalue "offDays" -> "ddd"=dia de la semana Sat,Sun,Wed
            offDays: "Sat,Sun", //estos días apareceran en gris porque estan como "DESCANSO"
    
            showCalendar: true, //!0,        


            //Inicio de semana "línea divisoria"
            showStartOfWeek: true, //!0, //Activar "startOfWeek"
            startOfWeekFormat: "ddd", //formato utilizado en la evaluación de startOfWeek
            startOfWeek: "Mon", //Marca el "comienzo de la semana", por una línea divisoria más gruesa entre fechas.

            
            //formato para "todos los elementos" y para "texto seleccionado"
            text: "ddd<br/>Do", // Formato utilizado para el elemento texto.  
            textSelected: "dddd<br/>Do, MMMM YYYY", // Formato utilizado para el texto del elemento seleccionado. 
            

            //Altura y ancho del componente
            size: 'small',  //Altura del componente paginador."small, normal, large".
            //width: 200, //ancho del contenedo. 


            //anchuras 
            itemWidth: 60, //anchura para cada de "elemento"
            selectedItemWidth: 140, //anchura para "elemento seleccionado"
            navItemWidth: 40, //Anchura para los "elementos de navegación" flechas izquierda y derecha(left and right arrows)
                
            
            //resaltar fecha "hoy" y "seleccionada"
            highlightToday:true,  //resaltar la "fecha de hoy". Es la fecha q pasa con el cuadrito azul
            highlightSelectedDate: true, //resaltar la "fecha seleccionada.".

            //fecha más reciente que puede seleccionarse
            endDate: moment().clone().startOf("day"), 

            onSelectedDateChanged: function(event, date) {
                 fechapaginador = moment(date).format("YYYY-MM-DD");
                        submit_forzado =true;    
                        jQuery('form').trigger('submit');
                        fechapaginador_anterior = moment(date).format("YYYY-MM-DD");  

                   $.ajax({
                        url: "/ajax_user_proy_json",
                        type: 'POST',
                        dataType: "json",

                        
                        dataType: "json",
                        data: {
                             fechapaginador: fechapaginador //.toString() 
                         },
                        success: function(data){
                            //console.log(data);
                            //fecha anterior de donde viene
                          //console.log($('#fecha_paginador .dp-selected').attr('data-moment'));
                          //console.log($('#fecha_paginador .dp-selected'));
                            total=0;                          
                            $.each(data, function( i, value ) {
                                //console.log(i+' '+value.reg_user.descripcion);
                                //console.log(i+' '+value.reg_user.id);
                                $('.id_user_proy'+(i)).val( (value.reg_user!=null) ? value.reg_user.id : null  ) ;

                                $('.id_entorno'+(i)).val( value.id_activo ) ;
                                $('.id_proyecto'+(i)).val( value.id ) ;

                                $('.hr_anterior'+(i)).val( (value.anterior!=null) ? (value.anterior.hr_anterior) : 0 ) ;

                                $('.hora'+(i)).val( (value.reg_user!=null) ? value.reg_user.horas : 0 ) ;
                                $('.descripcion'+(i)).val( (value.reg_user!=null) ? value.reg_user.descripcion : null ) ;

                                total=total+ parseFloat(( (value.reg_user!=null) ? value.reg_user.horas : 0 )); 
                        
                        

                     
                            });

                            $('#total').text( number_format(total, 2, '.', ','));
                        } 
                    });
                                  
                 
            }

    });


    


             fechapaginador = moment( $.now()).format("YYYY-MM-DD");
    fechapaginador_anterior = moment( $.now()).format("YYYY-MM-DD");


    //$('#fecha_paginador').trigger( "onSelectedDateChanged" );

/////////////////////////Submit nuevo proyecto
    jQuery('body').on('submit','#form_registro_usuario', function (e) {
  
          if (!submit_forzado) {
                jQuery(this).ajaxSubmit({
                    dataType: "json",
                    data: {
                         fechapaginador: fechapaginador //.toString() 
                     },
                    success: function(data){
                       total =0;   
                        for (var i = 0; i < data.id_user_proy.length; i++) {
                            console.log(data.id_user_proy[i]);
                            console.log( $('.id_user_proy'+(i)).val() );

                            //oculto
                            $('.id_user_proy'+(i)).val( data.id_user_proy[i] ) ;
                            $('.id_entorno'+(i)).val( data.id_entorno[i] ) ;
                            $('.id_proyecto'+(i)).val( data.id_proyecto[i] ) ;

                            
                            $('.hora'+(i)).val( data.hora[i] ) ;
                            $('.descripcion'+(i)).val( data.descripcion[i] ) ;

                            total=total+ parseFloat(data.hora[i]); 
                        }
                        $('#total').text( number_format(total, 2, '.', ','));
                    } 
                });
                return false;
           } else {

                jQuery(this).ajaxSubmit({
                    dataType: "json",
                    data: {
                         fechapaginador: fechapaginador_anterior //.toString() 
                     },
                    success: function(data){
                    } 
                });
                return false;            

           }
    }); 




/////////////////////////Submit nuevo proyecto
    jQuery('body').on('submit','#form_nuevo_proyectos', function (e) {
            
            var $element = $("#etiq_usuarios");
            var val = $element.val();

                 id_val = (JSON.stringify(val));
            json_items =(JSON.stringify($element.tagsinput('items')));

        

            jQuery(this).ajaxSubmit({
                data: {
                         id_val: id_val, 
                     json_items: json_items 
                 },
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


/////////////////////////validar costo

var reg = /^[0-9]{1,10}(\.[0-9]{0,2})?$/;

jQuery('#costo[restriccion="decimal"]').bind('keypress paste', function (e) {
    var nn = jQuery('#costo[restriccion="decimal"]');
    var strValue = nn[0].value.toString() + String.fromCharCode(e.which);
    strValue = jQuery.trim(strValue);
    var bool = reg.test(strValue);
    if (bool) {
        return true;
    }
    else { 
        e.preventDefault();
    }
});




jQuery('.hora_decimal[restriccion="decimal"]').bind('keypress paste', function (e) {
    var iden=jQuery(this).attr('id');
    //var nn = jQuery('.hora_decimal[restriccion="decimal"]');
    var nn = jQuery('#'+iden+'[restriccion="decimal"]');
    var strValue = nn[0].value.toString() + String.fromCharCode(e.which);
    strValue = jQuery.trim(strValue);
    var bool = reg.test(strValue);
    if (bool) {
        return true;
    }
    else { 
        e.preventDefault();
    }
});



            $.ajax({
                url: "/listado_usuarios_json",
                type: 'POST',
                dataType: "json",
                data: {
                         id: $("#id_proy").val(), 
                 },
                success: function(data){
                    
                    if(data != false){
                        //console.log(data);
                        //console.log(data);
                        $.each(data, function( index, value ) {
                          elt.tagsinput('add', {"id":value.id ,"nombre":value.nombre});
                        });
                    }
                } 
            });

/////////////////////////buscar usuarios

    var consulta_usuarios = new Bloodhound({
       datumTokenizer: Bloodhound.tokenizers.obj.whitespace('nombre'), //'text'
       queryTokenizer: Bloodhound.tokenizers.whitespace,
      remote: {
            url:  '/buscador?key=%QUERY', 
            replace: function () {
                var q = '/buscador?key='+encodeURIComponent(jQuery('.bs-etiquetas_usuarios .tt-input').typeahead("val")); 
                    //q += '&nombre='+encodeURIComponent(jQuery('#etiq_usuarios.tt-input').attr("name"));
                return  q;
            }
        },   

    });


   consulta_usuarios.initialize();

    elt = $('.objeto_como_tags > > input');
    elt.tagsinput({
      itemValue: 'id', //id
      itemText: 'nombre',  //nombre
      typeaheadjs: {
        name: 'usuarios',
        displayKey: 'nombre',
        source: consulta_usuarios.ttAdapter()
      }
    });

    //elt.tagsinput('add', {"id":"ad5cdc8b-33f9-11e6-b036-04015a6da701","nombre":"Antonio"});

            

       

    //console.log(( jQuery("#json_items").val() ) );        
    //console.log(eval( $("#json_items").val() ) );



jQuery('.fecha').datepicker({ format: 'dd-mm-yyyy'});



//Menu contextual de "ENTORNOS"
jQuery('.contexto_entorno').contextmenu({
      target: "#context-menu_entorno",
      before: function(e, element, target) {
        this.getMenu().find("li").eq(0).find('a').attr('href',"/editar_entorno/"+element.attr('identificador'));
         return true;
      },
      onItem: function(context, e) {
        window.location.href = jQuery(e.target).attr('href');
      }  

});


//Menu contextual de "PROYECTOS"
jQuery('.context').contextmenu({
  target: "#context-menu",
  before: function(e, element, target) {
    this.getMenu().find("li").eq(0).find('a').attr('href',"/editar_proyecto/"+element.attr('identificador'));
     return true;
  },

  onItem: function(context, e) {
    window.location.href = jQuery(e.target).attr('href');
  }  
});

                 


    jQuery('body').on('submit','#form_entornos', function (e) {
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

  jQuery('body').on('submit','#form_proyectos', function (e) {
            jQuery(this).ajaxSubmit({
                success: function(data){
                    
                    if(data != true){
                        
                        //spinner.stop();
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

                            if (row[0]!=1) {
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



                            return texto;   
                        },
                        "targets": 5
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
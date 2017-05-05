jQuery(document).ready(function($) {

    
/////////////////////////Scrollers
    //http://rocha.la/jQuery-slimScroll
       
   jQuery('.scrollers.proyectos').slimScroll({
        //width: '300px', //Anchura en píxeles del área scroll visible. Estirar hasta el padre si no se establece. Por defecto: none
        height: '150px',   //Altura en píxeles del área scroll visible. También es compatible automático para ajustar la altura a igual contenedor primario. Defecto: 250px
        
        size: '10px', //Ancho en píxeles de la barra de desplazamiento. Defecto: 7px
        position: 'left', //left o right. Establece la posición de la barra de desplazamiento. Defecto: right
        color: '#ffcc00', // Color en hexadecimal de la barra de desplazamiento. Defecto: #000000
        //alwaysVisible: true, //Desactiva u ocultar la barra de desplazamiento. Defecto: false
        disableFadeOut: true,   //Desactiva la barra scroll automáticamente . true barra scroll no desaparece después de algún tiempo cuando el ratón está sobre el div slimscroll. 
                                //Defecto: false
        allowPageScroll: false, //Comprueba si la rueda del ratón deben desplazarse a la página cuando la barra llega a la parte superior o inferior del contenedor. 
                               //Cuando se establece en true es desplaza la página. Defecto: false

        //distance: '30px', //distancia en píxeles desde el borde del elemento padre que desea que aparezca la barra de desplazamiento. 
                          //Se utiliza junto con la posición de la propiedad. Defecto:1px                               
       
        start: (  ($('input[name="id_scroll_proy"]').val() !=undefined ) ?  $('li.'+ $('input[name="id_scroll_proy"]').val()  )   : 'top' )
        /*
        
        

        
        
        railColor: '#222',
        railOpacity: 0.3,
        wheelStep: 10,
        
        
        */
    });

  // console.log( $('input[name="id_scroll_user"]').val() );


   jQuery('.scrollers.usuarios').slimScroll({
        height: '150px',   //Altura en píxeles del área scroll visible. También es compatible automático para ajustar la altura a igual contenedor primario. Defecto: 250px
        
        size: '10px', //Ancho en píxeles de la barra de desplazamiento. Defecto: 7px
        position: 'left', //left o right. Establece la posición de la barra de desplazamiento. Defecto: right
        color: '#ffcc00', // Color en hexadecimal de la barra de desplazamiento. Defecto: #000000
        disableFadeOut: true,   //Desactiva la barra scroll automáticamente . true barra scroll no desaparece después de algún tiempo cuando el ratón está sobre el div slimscroll. 
                                //Defecto: false
        allowPageScroll: false, //Comprueba si la rueda del ratón deben desplazarse a la página cuando la barra llega a la parte superior o inferior del contenedor. 
                               //Cuando se establece en true es desplaza la página. Defecto: false
        start: (  ($('input[name="id_scroll_user"]').val() !=undefined ) ?  $('li.'+$('input[name="id_scroll_user"]').val())   : 'top' ),
       
    });






/////////////////////////buscador proytectos

//buscador proyectos

    var consulta_elemento = new Bloodhound({
       datumTokenizer: Bloodhound.tokenizers.obj.whitespace('nombre'),
       queryTokenizer: Bloodhound.tokenizers.whitespace,
       remote: {
            url: '/busqueda_predictiva?key=%QUERY',
            replace: function ( e ) {
                var q = '/busqueda_predictiva?key='+encodeURIComponent(jQuery('.buscar_elemento').typeahead("val"));
                    q += '&nombre='+encodeURIComponent(jQuery('.buscar_elemento.tt-input').attr("name"));
                    q += '&idusuario='+encodeURIComponent(jQuery('.buscar_elemento.tt-input').attr("idusuario"));
                return  q;
            }
        },   
    });



    consulta_elemento.initialize();

    jQuery('.buscar_elemento').typeahead(
        {
              hint: true,
          highlight: true,
          minLength: 1
        },

         {
      
      name: 'buscar_elemento',
      displayKey: 'descripcion', //
      source: consulta_elemento.ttAdapter(),
       templates: {
                //header: '<h4>'+jQuery('.buscar_proveedor_reporte').attr("name")+'</h4>',
                suggestion: function (data) {  
                    return '<p><strong>' + data.descripcion + '</strong></p>'; //+
                    // '<div style="background-color:'+ '#'+data.hexadecimal_color + ';display:block;width:15px;height:15px;margin:0 auto;"></div>';

           }
        
      }
    });

    jQuery('.buscar_elemento').on('typeahead:selected', function (e, datum,otro) {
        key = datum.key;
        //console.log(datum);
        if  (datum.valor=='proyectos') {
            window.location.href = '/'+'editar_proyecto/'+jQuery.base64.encode(key);  
        } else {  //usuarios
            //console.log(datum);
        }
        //
    }); 

    jQuery('.buscar_elemento').on('typeahead:closed', function (e) {

        /*
        comienzo=true;  //para indicar que start comience en 0;
        var oTable =jQuery('#tabla_reporte').dataTable();
        oTable._fnAjaxUpdate();
        */

    }); 




//buscador usuarios

    var consulta_usuarios = new Bloodhound({
       datumTokenizer: Bloodhound.tokenizers.obj.whitespace('nombre'),
       queryTokenizer: Bloodhound.tokenizers.whitespace,
       remote: {
            url: '/busqueda_predictiva?key=%QUERY',
            replace: function ( e ) {
                var q = '/busqueda_predictiva?key='+encodeURIComponent(jQuery('.buscar_usuarios').typeahead("val"));
                    q += '&nombre='+encodeURIComponent(jQuery('.buscar_usuarios.tt-input').attr("name"));
                    q += '&idusuario='+encodeURIComponent(jQuery('.buscar_usuarios.tt-input').attr("idusuario"));
                return  q;
            }
        },   
    });



    consulta_usuarios.initialize();

    jQuery('.buscar_usuarios').typeahead(
        {
              hint: true,
          highlight: true,
          minLength: 1
        },

         {
      
      name: 'buscar_usuarios',
      displayKey: 'descripcion', //
      source: consulta_usuarios.ttAdapter(),
       templates: {
                //header: '<h4>'+jQuery('.buscar_proveedor_reporte').attr("name")+'</h4>',
                suggestion: function (data) {  
                    return '<p><strong>' + data.descripcion + '</strong></p>'; //+
                    // '<div style="background-color:'+ '#'+data.hexadecimal_color + ';display:block;width:15px;height:15px;margin:0 auto;"></div>';

           }
        
      }
    });

    jQuery('.buscar_usuarios').on('typeahead:selected', function (e, datum,otro) {
        key = datum.key;
        //console.log(datum);
        if  (datum.valor=='proyectos') {
            window.location.href = '/'+'editar_proyecto/'+jQuery.base64.encode(key);  
        } else {  //usuarios
            window.location.href = '/'+'editar_usuario/'+key;  
        }
        //
    }); 

    jQuery('.buscar_usuarios').on('typeahead:closed', function (e) {

        /*
        comienzo=true;  //para indicar que start comience en 0;
        var oTable =jQuery('#tabla_reporte').dataTable();
        oTable._fnAjaxUpdate();
        */

    }); 



////////////////// Fin de reportes////////////////////////////////////////////////////////////



submit_forzado =false;

   jQuery('body').on('click','.eliminar', function (e) { 
      e.preventDefault(); //
      jQuery(this).parent().parent().parent().parent().css('display','none');    
      jQuery(this).parent().parent().parent().parent().siblings().removeClass( "col-sm-6 col-md-6" );
      jQuery(this).parent().parent().parent().parent().siblings().addClass( "col-sm-12 col-md-12" );
   }); 


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

    var ocurre_evento = false;

    $('#fecha_paginador').datepaginator({
                
            
            //dias que aparecerán en gris
            showOffDays: true, //!0,    activa o desactiva el "offDays"
            offDaysFormat: "ddd",  //formato utilizado para que se evalue "offDays" -> "ddd"=dia de la semana Sat,Sun,Wed
            offDays: "sáb.,dom.", //estos días apareceran en gris porque estan como "DESCANSO"
    
            showCalendar: true, //!0,        


            //Inicio de semana "línea divisoria"
            showStartOfWeek: true, //!0, //Activar "startOfWeek"
            startOfWeekFormat: "ddd", //formato utilizado en la evaluación de startOfWeek
            startOfWeek: "lun.", //Marca el "comienzo de la semana", por una línea divisoria más gruesa entre fechas.

            
            //formato para "todos los elementos" y para "texto seleccionado"
            text: "ddd<br/>Do", // Formato utilizado para el elemento texto.  
            textSelected: "dddd<br/>Do, MMMM YYYY", // Formato utilizado para el texto del elemento seleccionado. 
            

            //Altura y ancho del componente
            size: 'large',  //Altura del componente paginador."small, normal, large".
            //width: 200, //ancho del contenedo. 


            //anchuras 
            itemWidth: 60, //anchura para cada de "elemento"
            selectedItemWidth: 140, //anchura para "elemento seleccionado"
            navItemWidth: 30, //Anchura para los "elementos de navegación" flechas izquierda y derecha(left and right arrows)
                
            
            //resaltar fecha "hoy" y "seleccionada"
            highlightToday:true,  //resaltar la "fecha de hoy". Es la fecha q pasa con el cuadrito azul
            highlightSelectedDate: true, //resaltar la "fecha seleccionada.".

            //fecha más reciente que puede seleccionarse
            endDate: moment().clone().startOf("day"), 
            //injectStyle:false,


            /*fechapag: function(fecha) {
                return 'osmel';

            },*/



    });



  
  
    fechapaginador = moment( $.now()).format("YYYY-MM-DD");
    fechapaginador_anterior = moment( $.now()).format("YYYY-MM-DD");


 $.ajax({
        url: "/horas_paginador",
        type: 'POST',
        dataType: "json",
        data: {
             fechapaginador: fechapaginador //.toString() 
         },
        success: function(datos){

            if (datos) {
                 $.each(datos, function( i, value ) {
                        $('a[data-moment="'+value.fecha+'"]').html($('a[data-moment="'+value.fecha+'"]').html()+'<br/>'+value.sum_horas);
                 });   

            }
        }
  });       


$('#fecha_paginador').on('datosEnVivo', function(event, date) {

                  //console.log(date);

});

$('#fecha_paginador').on('selectedDateChanged', function(event, date) {
                  fechapaginador = moment(date).format("YYYY-MM-DD");
                  submit_forzado =true;    
                  jQuery('form').trigger('submit');
                  fechapaginador_anterior = moment(date).format("YYYY-MM-DD");  
                  //console.log(date);

});



    


   

    //$('#fecha_paginador').trigger( "onSelectedDateChanged" );

/////////////////////////Submit nuevo proyecto
    jQuery('body').on('submit','#form_registro_usuario', function (e) {
        jQuery('#fecha_paginador').css('pointer-events','none');

          if (!submit_forzado) {

                jQuery(this).ajaxSubmit({
                    dataType: "json",
                    data: {
                         fechapaginador: fechapaginador, //.toString() 
                         fechapaginador_anterior: fechapaginador_anterior,
                         forzado : 0,
                     },
                    success: function(data){
                       total =0;   
                        for (var i = 0; i < data.id_user_proy.length; i++) {
                            
                            //oculto
                            //alert(data.id_user_proy[i]);
                            $('.id_user_proy'+(i)).val( data.id_user_proy[i] ) ;
                            $('.id_entorno'+(i)).val( data.id_entorno[i] ) ;
                            $('.id_proyecto'+(i)).val( data.id_proyecto[i] ) ;
                            
                            $('.identificador'+(i)).val( data.identificador[i] ) ;
                            $('.id_nivel'+(i)).val( data.id_nivel[i] ) ;
                            $('.profundidad'+(i)).val( data.profundidad[i] ) ;
                            

                            
                            $('.hora'+(i)).val( data.hora[i] ) ;
                            $('.descripcion'+(i)).val( data.descripcion[i] ) ;

                            total=total+ parseFloat(data.hora[i]); 
                        }
                        $('#total').text( number_format(total, 2, '.', ','));

                        jQuery('#fecha_paginador').css('pointer-events','inherit');
                    } 
                });
                return false;
           } else {

               // console.log("a"+fechapaginador);  //actual
                //console.log("b"+fechapaginador_anterior);  //anterior

                if (fechapaginador!=fechapaginador_anterior)
                jQuery(this).ajaxSubmit({
                    dataType: "json",
                    data: {
                         fechapaginador: fechapaginador, //.toString() 
                         fechapaginador_anterior: fechapaginador_anterior,
                         forzado : 1,
                     },
                    success: function(data){

                         total=0;                          
                                        $.each(data.proyectos, function( i, value ) {
                                            $('.id_user_proy'+(i)).val( (value.reg_user!=null) ? value.reg_user.id : null  ) ;

                                            $('.id_entorno'+(i)).val( value.id_activo ) ;
                                            $('.id_proyecto'+(i)).val( value.id_proyecto ) ;

                                            $('.id_nivel'+(i)).val( value.id_nivel ) ;
                                            $('.profundidad'+(i)).val( value.profundidad ) ;

                                            $('.hr_anterior'+(i)).val( (value.anterior!=null) ? (value.anterior.hr_anterior) : 0 ) ;

                                            $('.hora'+(i)).val( (value.reg_user!=null) ? value.reg_user.horas : 0 ) ;
                                            $('.descripcion'+(i)).val( (value.reg_user!=null) ? value.reg_user.descripcion : null ) ;

                                            total=total+ parseFloat(( (value.reg_user!=null) ? value.reg_user.horas : 0 )); 
                                    

                                        });

                                        $('#total').text( number_format(total, 2, '.', ','));



                                        submit_forzado =false; 

                                        if (data.fecha_pag) {
                                             $.each(data.fecha_pag, function( i, value ) {
                                                    //$('a[data-moment="'+value.fecha+'"]').html($('a[data-moment="'+value.fecha+'"]').html()+'<br/><span style="color:red;">'+value.sum_horas+'</span>');
                                                    //$('a[data-moment="'+value.fecha+'"]').html($('a[data-moment="'+value.fecha+'"]').html()+'<br/><p style="color:red;">'+value.sum_horas+'</p>');
                                                    $('a[data-moment="'+value.fecha+'"]').html($('a[data-moment="'+value.fecha+'"]').html()+'<br/>'+value.sum_horas);
                                             });   

                                        }

                                jQuery('#fecha_paginador').css('pointer-events','inherit');

                                return false;


                    } 
                });
                return false;            

           }


    }); 


//$('a').click(function(e){e.preventDefault();});



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


jQuery('#tiempo_disponible[restriccion="decimal"]').bind('keypress paste', function (e) {
    var nn = jQuery('#tiempo_disponible[restriccion="decimal"]');
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

//salario usuarios
jQuery('#salario[restriccion="decimal"]').bind('keypress paste', function (e) {
    var nn = jQuery('#salario[restriccion="decimal"]');
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


//importe del proyecto
jQuery('#importe[restriccion="decimal"]').bind('keypress paste', function (e) {
    var nn = jQuery('#importe[restriccion="decimal"]');
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
                          elt.tagsinput('add', {"id":value.id ,"nombre":value.nombre,"num":value.num}); ////elt.tagsinput('add', {"id":"ad5cdc8b-33f9-11e6-b036-04015a6da701","nombre":"Antonio"});
                        });
                    }
                } 
            });

/////////////////////////buscar usuarios
//https://www.npmjs.com/package/ng2-tag-input  este es para angular

    var consulta_usuarios = new Bloodhound({
       datumTokenizer: Bloodhound.tokenizers.obj.whitespace('nombre'), //'text'
       queryTokenizer: Bloodhound.tokenizers.whitespace,
      remote: {
            url:  '/buscador?key=%QUERY', 
            replace: function () {
              //console.log(jQuery('.objeto_como_tags > > .bootstrap-tagsinput > span.label').size());
              var num = jQuery('.objeto_como_tags > > .bootstrap-tagsinput > span.label').size();
                var q = '/buscador?key='+encodeURIComponent(jQuery('.bs-etiquetas_usuarios .tt-input').typeahead("val")); 
                    q += '&num='+num;
                return  q;
            }
        },   

    });


   consulta_usuarios.initialize();

    elt = $('.objeto_como_tags > > input');
    elt.tagsinput({
      itemValue: 'id', //id
      itemText: 'nombre',  //nombre
      itemNum: 'num',  //nombre
       //focusClass: 'my-focus-osmel',

      tagClass: function(item) {
                                                              
            return (  item.num == parseInt(jQuery('.objeto_como_tags > > .bootstrap-tagsinput > span.label').size())-1 ? 'tag label label-danger etiqactiva' : 'tag label label label-info');
        /*  switch (item.nombre) {
            case 'Osmel'   : return 'tag label label-info label-danger';
            default:
               return 'tag label label label-info';

          }
          */
      },       


      
      typeaheadjs: {
        name: 'usuarios',
        displayKey: 'nombre',
        source: consulta_usuarios.ttAdapter()
      }

    });


jQuery('body').on('click','span.label', function (e) {
    jQuery('form').submit();

    jQuery('span.label').removeClass('label-danger etiqactiva');
    jQuery('span.label').removeClass('label-info');
    jQuery('span.label').addClass('label-info');
    jQuery(this).addClass('label-danger etiqactiva');

    //console.log(  parseInt(jQuery('.objeto_como_tags > > .bootstrap-tagsinput > span.label').size())-1   );
    //console.log( jQuery(this).itemValue );
    //console.log(  jQuery(this).index()   );

    var indice = jQuery(this).index();
    var arreglo = jQuery(this).parent().siblings("input").val().split(",");
    //console.log( arreglo[indice]  );

      $.ajax({
                url: "/busqueda_costo",
                type: 'POST',
                dataType: "json",
                data: {
                    id_user_seleccion: arreglo[indice], 
                    id_registro: jQuery("#id_proy").val(),
                    id_nivel: jQuery("#id_nivel").val(),
                 },
                success: function(data){
                    
                    if  (data.costo != false ) {
                        
                        jQuery("#costo").val(data.costo.costo);
                        jQuery("#tiempo_disponible").val(data.costo.tiempo_disponible);
                        jQuery("#fecha_inicial").val(data.costo.fecha_inicial);
                        jQuery("#fecha_final").val(data.costo.fecha_final);
                        
                       

                    } else {
                      
                        jQuery("#costo").val("");
                        jQuery("#tiempo_disponible").val("");
                        jQuery("#fecha_inicial").val("");
                        jQuery("#fecha_final").val("");
                        
                    }


                    
                } 
            });



    
  });







  //Durante la inicialización, las etiquetas predefinidas que se añaden harán que este evento,  se dispare
  jQuery('body').on('itemAddedOnInit',elt, function (e) {
    // event.item: contiene el elemento
    //console.log('actualizando');

  });


  //Se dispara justo antes que un elemento se agregue.
  jQuery('body').on('beforeItemAdd',elt, function (e) {
    // event.item: contiene el elemento
    // event.cancel: establece en true para evitar que se agregue el elemento
        
  
  });


  //Se dispara justo despues que un elemento se agrega.
  jQuery('body').on('itemAdded',elt, function (e) {
    // event.item: contiene el elemento

    /*jQuery('span.label').removeClass('label-danger etiqactiva');
    jQuery('span.label').removeClass('label-info');
    jQuery('span.label').addClass('label-info');*/
    //jQuery(this).addClass('label-danger etiqactiva');


    //jQuery('form').submit();
    elt.tagsinput('refresh');

       
  });
      

  var id_user_sel ='';

  //Se dispara justo antes que un elemento se elimina.
  jQuery('body').on('beforeItemRemove',elt, function (e) {
    // event.item: contiene el elemento
    // event.cancel: establece en true para evitar que se elimine el elemento

    //Antes de remover lo pinto de rojo para que sea el objetivo señalado para hacer submit
  /*
    jQuery('span.label').removeClass('label-danger etiqactiva');
    jQuery('span.label').removeClass('label-info');
    jQuery('span.label').addClass('label-info');
    jQuery(this).addClass('label-danger etiqactiva');

      id_user_sel = e.item.id;
*/
      

   //jQuery('form').submit();

    var data = {};
    $("form").serializeArray().map(function(x){
        data[x.name] = x.value;}
      ); 

     var $element = $("#etiq_usuarios");
            var val = $element.val();

                 id_val = (JSON.stringify(val));
            json_items =(JSON.stringify($element.tagsinput('items')));


    
         var arreglo = elt.val().split(",");

             var span = elt.siblings("div.bootstrap-tagsinput").find(".etiqactiva");
             //console.log(arreglo[span.index()] );
             //var id_user_seleccion = (arreglo[span.index()] !=undefined) ? arreglo[span.index()] : id_user_sel;
             var id_user_seleccion =  arreglo[span.index()];




          //actualizando primero el elemento donde estoy parado
          if (id_user_seleccion!=e.item.id)
         $.ajax({
              url: "/actualizando_elem",
              type: 'POST',
              dataType: "json",
              data: {

                form: data, //$.param(jQuery('form').serializeArray()) //JSON.stringify(jQuery('form')), // jQuery('form').serialize(), //
                id_val: id_val, 
                json_items: json_items,  
                fecha_creacion: jQuery('fecha_creacion').val(),  
                proyecto: jQuery('proyecto').val(),  
                id_user_seleccion: id_user_seleccion, //e.item.id,
                    /*
                    id:
                    crea_multiple_simple:
                    depth_arbol:
                    ambito_app:
                    profundidad:
                    id_nivel:
                    dueno:
                    id_proy:
                    nombre:
                    id_scroll_proy:
                    proyecto:
                    fecha_creacion:
                    importe:
                    descripcion:
                    costo:
                    tiempo_disponible:
                    fecha_inicial:
                    fecha_final:
                    id_val:
                    json_items:
                    id_user_seleccion:
                    */
               },
              success: function(datos){

                  /*if (datos) {
                       $.each(datos, function( i, value ) {
                              $('a[data-moment="'+value.fecha+'"]').html($('a[data-moment="'+value.fecha+'"]').html()+'<br/>'+value.sum_horas);
                       });   

                  }*/
              }
        });       

   

    

    
    
      
        
  });

  //Se dispara justo despues que un elemento se elimina.
  jQuery('body').on('itemRemoved',elt, function (e) {
    // event.item: contiene el elemento
      //jQuery('form').submit();

    var $element = $("#etiq_usuarios");
            var val = $element.val();

                 id_val = (JSON.stringify(val));
            json_items =(JSON.stringify($element.tagsinput('items')));

     /*       
    console.log(id_val);        
    console.log(json_items);
    console.log(e.item.id);
    */
    
    //eliminar elemento

    //console.log(  JSON.parse(JSON.stringify({json_items}))  );
    //console.log(  JSON.parse(json_items).length  );

   // elt.tagsinput('refresh');


 jQuery('span.label').removeClass('label-danger etiqactiva');
                              jQuery('span.label').removeClass('label-info');
                              jQuery('span.label').addClass('label-info');
   console.log(parseInt(jQuery('.objeto_como_tags > > .bootstrap-tagsinput > span.label').size())-1);

var pos = (parseInt(jQuery('.objeto_como_tags > > .bootstrap-tagsinput > span.label').size()));
//:nth-child(pos)
var elem = jQuery('.objeto_como_tags > > .bootstrap-tagsinput > span:nth-child('+pos+')') ;
elem.addClass('label-danger etiqactiva');


    if (false)
    
    $.ajax({
              url: "/eliminar_elem",
              type: 'POST',
              dataType: "json",
              data: {

                         id: jQuery('#id_scroll_proy').val(),  
                    id_proy: jQuery('#id_proy').val(),  
                   id_nivel: jQuery('#id_nivel').val(),  
                profundidad: jQuery('#profundidad').val(),  
                
                id_val: id_val, 
                json_items: json_items,  
                id_user_seleccion: e.item.id,
               },
              success: function(data){
                //console.log(datos);
                //elt.tagsinput('refresh');

                            /*
                            elt.tagsinput('refresh');

                             var arreglo = elt.val().split(",");
                             var span = elt.siblings("div.bootstrap-tagsinput").find(".etiqactiva");
                             var id_user_seleccion =  arreglo[span.index()];
                             */
    


                              jQuery('span.label').removeClass('label-danger etiqactiva');
                              jQuery('span.label').removeClass('label-info');
                              jQuery('span.label').addClass('label-info');
                              //jQuery('span.label').index(JSON.parse(json_items).length-1).addClass('label-danger etiqactiva');
                              

                              var pos = JSON.parse(json_items).length-1;
                              //var pos=0;
                              //console.log(  jQuery('span.label:gt('+pos+')')   );
                              var elem = jQuery('.objeto_como_tags > > .bootstrap-tagsinput > span.label-info:gt('+pos+')') ;
                              elem.addClass('label-danger etiqactiva');



                            /* 
                            $.ajax({
                                url: "/busqueda_costo",
                                type: 'POST',
                                dataType: "json",
                                data: {
                                    id_user_seleccion: id_user_seleccion, 
                                    id_registro: jQuery("#id_proy").val(),
                                    id_nivel: jQuery("#id_nivel").val(),
                                 },
                                success: function(data){
                                    
                                    if  (data.costo != false ) {
                                        
                                        jQuery("#costo").val(data.costo.costo);
                                        jQuery("#tiempo_disponible").val(data.costo.tiempo_disponible);
                                        jQuery("#fecha_inicial").val(data.costo.fecha_inicial);
                                        jQuery("#fecha_final").val(data.costo.fecha_final);
                                        
                                       

                                    } else {
                                      
                                        jQuery("#costo").val("");
                                        jQuery("#tiempo_disponible").val("");
                                        jQuery("#fecha_inicial").val("");
                                        jQuery("#fecha_final").val("");
                                        
                                    }


                                    
                                } 
                            });



                            */


                
              }
        });   



       
  });
            
elt.tagsinput('focus');            







/////////////////////////Submit nuevo proyecto
    jQuery('body').on('submit','#form_nuevo_proyectos', function (e) {
            
            var $element = $("#etiq_usuarios");
            var val = $element.val();

                 id_val = (JSON.stringify(val));
            json_items =(JSON.stringify($element.tagsinput('items')));


             var arreglo = elt.val().split(",");

             var span = elt.siblings("div.bootstrap-tagsinput").find(".etiqactiva");
             console.log(arreglo[span.index()] );
             //var id_user_seleccion = (arreglo[span.index()] !=undefined) ? arreglo[span.index()] : id_user_sel;
             var id_user_seleccion =  arreglo[span.index()];

              console.log(id_user_seleccion);
              //alert('');

            jQuery(this).ajaxSubmit({
                dataType : "json",
                data: {
                         id_val: id_val, 
                     json_items: json_items,
                      id_user_seleccion: id_user_seleccion,
                 },
                success: function(data){
                    
                    if(data.exito != true){
                        jQuery('#foo').css('display','none');
                        jQuery('#messages').css('display','block');
                        jQuery('#messages').addClass('alert-danger');
                        jQuery('#messages').html(data);
                        return "error";
                    }else{
                            $catalogo = e.target.name;
                            
                             if (!(e.isTrigger)) { //si fue una presion real del boton guardar
                                window.location.href = '/'+$catalogo;   
                             }  else {  //si fue provocado

                                 //elt.tagsinput('refresh');
                                    
                             } 
                    }

                    //elt.tagsinput('refresh');
                } 
            });
            return false;
    }); 




//jQuery('.fecha').datepicker({ dateFormat: 'dd-mm-yyyy'});

/*
jQuery('form').on('focusin','.fecha', function (e) {
    jQuery(this).datepicker({ 
        //inline: true, 
        Format: 'dd-mm-yyyy',
         //startDate: '-1d'
    });
});*/

/*
jQuery('form').on('datepicker','.fecha', function (e) {
    //format: 'dd-mm-yyyy'
    console.log(e);

});    */


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

                            //si no es general y (super_admin o dueño) row[5]=dueno
                            if ((row[0]!=1)  &&  ( ($("#perfil_activo").val() ==1) || (row[5] ==1) )  ) {
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
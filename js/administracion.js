jQuery(document).ready(function($) {
//////////////////////////////////////////////////////////
////////////////////////OPERACIONES CON CUADRANTE 2///////
//////////////////////////////////////////////////////////
//Cuando se refresca o abre un proyecto. Poner los nombres que pertenecen a un nivel
var elt = $('.objeto_como_tags > > input');
  

//Cerrar con X "cuadrante 2" de proyectos. Se abrirá dandole click a los proyectos o niveles de este.
submit_forzado =false;
jQuery('body').on('click','.eliminar', function (e) {   
  e.preventDefault(); //
  jQuery(this).parent().parent().parent().parent().css('display','none');    
  jQuery(this).parent().parent().parent().parent().siblings().removeClass( "col-sm-6 col-md-6" );
  jQuery(this).parent().parent().parent().parent().siblings().addClass( "col-sm-12 col-md-12" );
}); 


//////////////////////////////////////////////////////////
///////////////////////////ENTORNOS////////////////////////
//////////////////////////////////////////////////////////
//Listado de entornos
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

//Guardo un entorno
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


/////////////////////////////////////////////////////////
///////////////////////////PERFIL DE USUARIO/////////////
/////////////////////////////////////////////////////////
/////////////////////////Submit crear/editar y eliminar usuario
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

//////////////////////////////////////////////////////////////////////////////
//////////////////////////////HOME/////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////
/*
mayo
https://docs.google.com/spreadsheets/d/1ELcpavkeulNBRHQ4-kjPueQ4SDjbWrFrsOfddUTIooU/edit#gid=1165817805
abril
https://docs.google.com/spreadsheets/d/1qbvPZlhAs2GxDZJoMNGQm5g81GcEX0OU_3Fm13qOS_4/edit#gid=1165817805
marzo
https://docs.google.com/spreadsheets/d/1HPpDbup0KguyRubFbGQfcSYjtVsnCNDYiuClEeZkudw/edit#gid=1165817805
febrero
https://docs.google.com/spreadsheets/d/1US4JFXvm7f9CGFs7PBpih9nSDLncNzGJrumGo67gCY4/edit#gid=1165817805
Enero
https://docs.google.com/spreadsheets/d/135uE1ysrFvZ4GtAJFHomkaj96ofD6JunagQxBVZte7M/edit#gid=1165817805
*/

//GUARDA CUANDO SE LLENAN LAS HORAS
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




    var fechapaginador = new Date();
    var fechapaginador_anterior = new Date();
    //var ocurre_evento = false;
    $('#fecha_paginador').datepaginator({  //como inicializo el paginador de fecha
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
    });
    $('#fecha_paginador').on('selectedDateChanged', function(event, date) {
                        fechapaginador = moment(date).format("YYYY-MM-DD");
                        submit_forzado =true;    
                        jQuery('form').trigger('submit');
                        fechapaginador_anterior = moment(date).format("YYYY-MM-DD");  
    });
//////////////////////////////////////////////////////////
///////////////////////////MENU IZQ///////////////////////
//////////////////////////////////////////////////////////
//Scrollers de proyecto y usuario que aparecen en el menu izquierdo
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
    /*railColor: '#222',
    railOpacity: 0.3,
    wheelStep: 10,*/
});

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

//Buscador de proyecto que aparece en el menu
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
jQuery('.buscar_elemento').typeahead({
           hint: true,
      highlight: true,
      minLength: 1
    },
    {
        name: 'buscar_elemento',
        displayKey: 'descripcion', //
        source: consulta_elemento.ttAdapter(),
         templates: {
                  suggestion: function (data) {  
                      return '<p><strong>' + data.descripcion + '</strong></p>'; //+
    }
  }
});
jQuery('.buscar_elemento').on('typeahead:selected', function (e, datum,otro) {
    key = datum.key;
    if  (datum.valor=='proyectos') {
        window.location.href = '/'+'editar_proyecto/'+jQuery.base64.encode(key);  
    } else {  //usuarios
    }
}); 
jQuery('.buscar_elemento').on('typeahead:closed', function (e) {
}); 

//Buscador de usuarios que aparece en el menu
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
jQuery('.buscar_usuarios').typeahead({
           hint: true,
      highlight: true,
      minLength: 1
    },
     {
  name: 'buscar_usuarios',
  displayKey: 'descripcion', //
  source: consulta_usuarios.ttAdapter(),
   templates: {
            suggestion: function (data) {  
                return '<p><strong>' + data.descripcion + '</strong></p>'; //+
             }
   }
});
jQuery('.buscar_usuarios').on('typeahead:selected', function (e, datum,otro) {
    key = datum.key;
    if  (datum.valor=='proyectos') {
        window.location.href = '/'+'editar_proyecto/'+jQuery.base64.encode(key);  
    } else {  //usuarios
        window.location.href = '/'+'editar_usuario/'+key;  
    }
}); 

jQuery('.buscar_usuarios').on('typeahead:closed', function (e) {
}); 


//Menu contextual de "PROYECTOS". Cdo da click sobre un "proyecto" le aparece un menu contextual
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


//Menu contextual de "ENTORNOS". Cdo da click sobre un "entorno" le aparece un menu contextual
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
//////////////////////////////////////////////////////////
/////////////////////YA NO SE UTILIZAN////////////////////
//////////////////////////////////////////////////////////
jQuery('body').on('submit','#form_proyectos', function (e) {
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
    } else { 
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
    } else { 
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
    } else { 
        e.preventDefault();
    }
});
jQuery('.hora_decimal[restriccion="decimal"]').bind('keypress paste', function (e) {
    var iden=jQuery(this).attr('id');
    var nn = jQuery('#'+iden+'[restriccion="decimal"]');
    var strValue = nn[0].value.toString() + String.fromCharCode(e.which);
    strValue = jQuery.trim(strValue);
    var bool = reg.test(strValue);
    if (bool) {
        return true;
    } else { 
        e.preventDefault();
    }
});

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
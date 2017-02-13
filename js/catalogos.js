jQuery(document).ready(function($) {

//Comienzo del tagsinput

var cities = new Bloodhound({
  datumTokenizer: Bloodhound.tokenizers.obj.whitespace('text'),
  queryTokenizer: Bloodhound.tokenizers.whitespace,
  prefetch: '/js/assets/cities.json'
});
cities.initialize();

/**
 * Objects as tags
 */
elt = $('.objeto_como_tags > > input');
elt.tagsinput({
  itemValue: 'value',
  itemText: 'text',
  typeaheadjs: {
    name: 'cities',
    displayKey: 'text',
    source: cities.ttAdapter()
  }
});



  $('input, select').on('change', function(event) {
    var $element = $(event.target);
    var val = $element.val();

    console.log(JSON.stringify(val));
    console.log(JSON.stringify($element.tagsinput('items')));



    console.log((val));
    console.log(($element.tagsinput('items')));


  });
  /*
  $('input, select').on('change', function(event) {
    var $element = $(event.target),
      $container = $element.closest('.etiquetas_usuarios');

    if (!$element.data('tagsinput'))
      return;

    var val = $element.val();
    console.log(JSON.stringify(val));
    console.log(JSON.stringify($element.tagsinput('items')));

    if (val === null)
      val = "null";
    $('code', $('pre.val', $container)).html( ($.isArray(val) ? JSON.stringify(val) : "\"" + val.replace('"', '\\"') + "\"") );
    $('code', $('pre.items', $container)).html(JSON.stringify($element.tagsinput('items')));
  }); //.trigger('change');
*/
//Fin del tagsinput


jQuery('.fecha').datepicker({ format: 'dd-mm-yyyy'});


//Menu contextual de "ENTORNOS"
jQuery('.contexto_entorno').contextmenu({
      target: "#context-menu_entorno",
      before: function(e, element, target) {
        this.getMenu().find("li").eq(0).find('a').attr('href',"/editar_entorno/"+element.attr('identificador'));
//        this.getMenu().find("li").eq(2).find('a').attr('href',"/eliminar_entorno/"+element.attr('identificador')+"/"+element.attr('nombre'));
        /* 
    this.getMenu().find("li").eq(2).find('a').html(
        '<a href="/eliminar_entorno/'+element.attr('identificador')+'/'+element.attr('nombre')+'" class="btn btn-danger btn-sm btn-block" data-toggle="modal" data-target="#modalMessage">  <span class="glyphicon glyphicon-remove"></span>  </a>'
    );
    */




         return true;
      },
      onItem: function(context, e) {
        window.location.href = jQuery(e.target).attr('href');
        //jQuery('#modalMessage').modal('show');
        
        //return true;
      }  

});


//Menu contextual de "PROYECTOS"
jQuery('.context').contextmenu({
//jQuery('body').on('contextmenu','.context', function (ee) {

  target: "#context-menu",
  before: function(e, element, target) {
    /*
        console.log(e); //evento
        console.log(element);
        console.log(element.html());
        console.log(element.attr('identificador'));
        console.log(this.getMenu().find("li").eq(0).find('a').attr('href'));
        console.log(this.getMenu().find("li").eq(2).find('a').html());
    */
     //e.preventDefault();
    this.getMenu().find("li").eq(0).find('a').attr('href',"/editar_proyecto/"+element.attr('identificador'));
    //this.getMenu().find("li").eq(2).find('a').attr('href',"/eliminar_proyecto/"+element.attr('identificador')+"/"+element.attr('nombre'));
    
     //window.location.href = '/'+$catalogo;       
     return true;
  },

  onItem: function(context, e) {
    //alert(jQuery(e.target).text());
    window.location.href = jQuery(e.target).attr('href');
  }  

});

                 


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

  jQuery('body').on('submit','#form_proyectos', function (e) {

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



});
jQuery(document).ready(function($) {
evento = '';
        //modulo para buscar dentro del tree    
        var to = false;
        jQuery('#buscar').keyup(function () {
            if (to) { clearTimeout(to); }
            to = setTimeout(function () {
                var v = jQuery('#buscar').val();
                jQuery('#tree').jstree(true).search(v); //esta es la funcion
            }, 250);
        });
        //modulo para menu contextual
        function customMenu(node) {
            var items = {
                createItem: { // The "create" menu item
                    label: "Crear",
                    action: function (data) {
                        var inst = jQuery.jstree.reference(data.reference), //instancia o referencia
                            ref = jQuery('#tree').jstree(true),  //instancia o referencia
                            referencia = data.reference,
                            posicion = data.position,
                            elemento  = data.element, 
                            item = data.item,
                            obj = inst.get_node(data.reference), //objeto(nodo) que estoy manipulando
                            sel = inst.get_selected();
                           //crear: solo el dueno o el super_administrador aunque no sea el dueno        
                           if   ( ($('#proyecto').val() !="") || ($('#proyecto').val().length > 0) )
                            if ( ($("#dueno").val() ==1) || ($("#perfil_activo").val() ==1)  ) {
                                    if ( parseInt($("#crea_multiple_simple").val())==0)    { //entornos es simple
                                        if (obj.children.length==0)    { //pueda crear nodo solo si no tiene hijos
                                                inst.create_node(sel, {"text": "osmel", "data" : {  } }, "last", //"file" : false
                                                    function (new_node) {
                                                        new_node.icon = "fa fa-coffee";
                                                        new_node.text = "nuevo Nombre";
                                                        inst.edit(new_node);
                                                    }
                                                );
                                        }
                                    } else {  //proyectos pueden tener multiples hijos
                                            inst.create_node(sel, {"text": "osmel", "data" : {  } }, "last", //"file" : false
                                                function (new_node) {
                                                    new_node.icon = "fa fa-coffee";
                                                    new_node.text = "nuevo Nombre";
                                                    inst.edit(new_node);
                                                }
                                            );
                                    }                          
                            }
                        if(sel) {
                               // inst.edit(sel);
                        }
                    }
                },
                renameItem: { 
                    label: "Renombrar",
                    action: function (data) {
                        var inst = jQuery.jstree.reference(data.reference),
                            obj = inst.get_node(data.reference);
                        //renombrar: solo el dueno o el super_administrador aunque no sea el dueno        
                        if ( ($("#dueno").val() ==1) || ($("#perfil_activo").val() ==1)  ) {    
                            inst.edit(obj);
                        }    
                    }
                },
                deleteItem: { 
                    label: "Eliminar",
                    action: function (data) {
                        var inst = jQuery.jstree.reference(data.reference),
                            obj = inst.get_node(data.reference);
                                //eliminar: solo el dueno o el super_administrador aunque no sea el dueno        
                                /* Aqui activo eliminar
                                if ( ($("#dueno").val() ==1) || ($("#perfil_activo").val() ==1)  ) {
                                    if (obj.id!=1) { //sino es la raiz puede eliminarlo
                                        if(inst.is_selected(obj)) {
                                            inst.delete_node(inst.get_selected());
                                        }
                                        else {
                                            inst.delete_node(obj);
                                        }
                                    }
                                }   */
                    }
                }
            };
            /*if (node.data.file) {
                delete items.createItem;
            }
            else{
                delete items.deleteItem;
                delete items.renameItem;
            }*/
            return items;
        }
        jQuery('#tree').jstree({
            'core': {
                'check_callback': true, //hace posible q el menu contextual haga su tatea
                 'themes' : {
                            'responsive' : false
                        },
            'data' : {
                            'url' : '/obtener_nodo?operation=obtener_nodo',
                            'data' : function (node) {
                                return { 'id' : node.id };
                            },
                            "dataType" : "json"
                        }
            },
            "types" : {
                "#" : { 
                         "max_children" : 1, //maximos hijos
                         "max_depth" : parseInt($("#depth_arbol").val()) ,  //maxima profundidad
                         "valid_children" : ["root"] 
                     },
                "root" : { "icon":"fa fa-tree", "valid_children" : ["default"] },
                "file" : { "icon":"fa fa-pagelines", "valid_children" : [] },
                "default" : {  "icon":"fa fa-check-square-o", "valid_children" : ["default"] },
            },
            "plugins" : [ "contextmenu","search", "state", "types", "wholerow" ], // "dnd", 
            //dnd: arrastrar y soltar
            //types: añadir tipos predefinidos para grupos de nodos
            //state: guarda todos los nodos abiertos y seleccionados 
            //Wholerow: Hace que cada nodo aparezca a nivel de bloque que hace que sea más fácil la selección
            "contextmenu": {items: customMenu}
        })
    //**** faltan por completar  "copy_node" y "analyze" ****
        .on('delete_node.jstree', function (e, data) { //Eliminar nodos y sus hijos
            $.get('/eliminar_nodo?operation=delete_node', { 'id' : data.node.id })
                .fail(function () {
                    data.instance.refresh();
                });
        })
        .on('create_node.jstree', function (e, data) { //crear un unico nodo
            $.get('/crear_nodo?operation=create_node', { 'id' : data.node.parent, 'position' : data.position, 'text' : data.node.text })
                .done(function (d) {
                    data.instance.set_id(data.node, d.id);
                })
                .fail(function () {
                    data.instance.refresh();
                });
        })
        .on('rename_node.jstree', function (e, data) { //renombrar un único nodo
            $.get('/renombrar_nodo?operation=rename_node', { 'id' : data.node.id, 'text' : data.text })
                .done(function (d) {
                    if ($("#ambito_app").val()==2)  {  //si es en el proyecto
                        if (data.node.id==1)  //si es la raiz
                          $("#proyecto").val(data.text);
                    }  

                    $("#nombre").val(data.text);
                })
                .fail(function () {
                    data.instance.refresh();
                });
        })
        .on('changed.jstree', function (e, data) { //cambio de arbol
          if(data && data.selected && data.selected.length) {
            evento = 'cambio';
            console.log(e);
                //niveles la raiz = proyecto = 1        
            if ($("#ambito_app").val()==2)  { //if estamos en proyectos
                $("#nombre").val(data.node.text);
                //console.log(location.host);
                    //var $element = $("#etiq_usuarios");
                    //json_items =($element.val()=='');
                    //console.log(json_items);
                   //UPDATE  `gestion_proyecto`.`inven_registro_proyecto` SET  `json_items` =  '[]' WHERE  `inven_registro_proyecto`.`id` =95;
                   //select * from inven_registro_proyecto where id =95;
                
                //dibujar el lado derecho si fue quitado por X
                jQuery(this).parent().parent().parent().removeClass( "col-sm-12 col-md-12" );
                jQuery(this).parent().parent().parent().addClass( "col-sm-6 col-md-6" );
                jQuery(this).parent().parent().parent().siblings().css('display','block');   
                
                jQuery('form').submit(); //guardar toda la información 

                 var arreglo = elt.val().split(",");
                 //console.log(arreglo);
                var span = elt.siblings("div.bootstrap-tagsinput").find(".etiqactiva");
                var id_user_seleccion =  arreglo[span.index()];
               // alert(id_user_seleccion);

                switch (data.node.parents.length) {  //ver cual es el nivel seleccionado?
                    case 1:    
                    case 2:
                    case 3:
                    case 4:
                        $.ajax({
                           url: "/listado_niveles",
                           type: 'POST',
                           dataType: "json",
                           data: {
                                    id_nivel: data.node.id, 
                                 profundidad: data.node.parents.length,
                                 id_cat_proy: $("input[name=id]").val(),
                                 id_reg_proy: $("#id_proy").val(),
                                 id_user_seleccion:id_user_seleccion,
                             },
                            success: function(datum){
                                $("#id_nivel").val(data.node.id);
                                $("#profundidad").val(data.node.parents.length);
                                //cuadrante 2
                                texto= '<div class="portlet light bordered">'; 
                                    texto+='<div class="portlet-title">';
                                        texto+='<div class="caption">';
                                            texto+='<i class="icon-equalizer font-dark hide"></i>';
                                            texto+='<span class="caption-subject font-dark bold uppercase">Detalles</span>';
                                            texto+='<span class="caption-helper"></span>';
                                        texto+='</div>';
                                        texto+='<div class="tools">';
                                            texto+='<a href="" class="eliminar" data-original-title="" title=""> </a>';
                                        texto+='</div>';
                                    texto+='</div>';
                                    texto+='<div class="portlet-body">';
                                        texto+='<div class="etiquetas_usuarios objeto_como_tags">';
                                              texto+='<h3>Participantes</h3>';
                                              texto+='<p>';
                                                texto+='Personas que participaran en el proyecto';
                                              texto+='</p>';
                                              texto+='<div class="bs-etiquetas_usuarios">';
                                                    texto+='<input id="etiq_usuarios" type="text" />';
                                              texto+='</div>';
                                        texto+='</div>';
                                        texto+='<div class="form-group">';
                                            texto+='<label for="descripcion" class="col-sm-3 col-md-2 control-label">Descripción</label>';
                                                   if(datum.datos != false){
                                                        $descripcion=datum.datos["descripcion"];
                                                    } else {
                                                        $descripcion='';
                                                    }
                                               texto+='<div class="col-sm-12 col-md-12">';
                                                    texto+='<textarea id="descripcion" name="descripcion" class="form-control" rows="3">'+$descripcion+'</textarea>';
                                                texto+='</div>';
                                        texto+='</div>';
                                        texto+='<div class="form-group" id="costos" >';
                                            texto+='<div class="col-sm-3 col-md-3">';
                                                    $costo=(datum.costo==false) ? "" : datum.costo.costo;
                                                texto+='<input value="'+$costo+'" restriccion="decimal" type="text" class="form-control ttip" ';
                                                        texto+='title="Números y puntos decimales." id="costo" name="costo" placeholder="0.00"> ';
                                                texto+='<em>Costo del proyecto.</em> ';
                                            texto+='</div> ';
                                            texto+='<div class="col-sm-3 col-md-3">';
                                                     $tiempo_disponible=(datum.costo==false) ? "" : datum.costo.tiempo_disponible;
                                                texto+='<input value="'+$tiempo_disponible+'" restriccion="decimal" type="text" class="form-control ttip" ';
                                                        texto+='title="Números y puntos decimales." id="tiempo_disponible" name="tiempo_disponible" placeholder="0.00"> ';
                                                texto+='<em>Tiempo disponible.</em>';
                                            texto+='</div> ';
                                            texto+='<div class="input-daterange input-group col-sm-3 col-md-3"" id="datepicker">';
                                                    $fecha_inicial= (datum.costo==false) ? "" : datum.costo.fecha_inicial;
                                                texto+='<input value="'+$fecha_inicial+'" type="text" class="fecha_ini input-sm form-control" id="fecha_inicial" name="fecha_inicial" placeholder="DD-MM-YYYY" />';
                                                texto+='<span class="input-group-addon">to</span>';
                                                   $fecha_final= (datum.costo==false) ? "" : datum.costo.fecha_final;
                                                texto+='<input value="'+$fecha_final+'" type="text" class="fecha_final input-sm form-control" id="fecha_final" name="fecha_final" placeholder="DD-MM-YYYY" />';
                                            texto+='</div>';
                                        texto+='</div> ';
                                    texto+='</div>  ';
                                texto+='</div>';   
                                //texto+='<em>'+datum.suma.total+'</em>';  //este era para imprimir el total de costo
                                $("#cuadrante2").html(texto);    
                                texto='';
                                $("#cuadrante3").html(texto);    
                                texto='';
                                $("#cuadrante4").html(texto);    
                                jQuery('.input-daterange').datepicker({ 
                                    autoclose: true, //Si se cierra o no el datepicker inmediatamente cuando se selecciona una fecha.
                                    format: "dd-mm-yyyy",
                                    language: "es",
                                   // daysOfWeekDisabled: [0,6],  //Días de la semana que se deben deshabilitar, 0->domingo, 6-sabado
                                    forceParse: true, //forzar a que sea correcta la entrada de fecha
                                    startView: 0 , //vista que inicia(0- dia, 1-mes, 2-año, 3-decada, 4-siglo)
                                    title: "",  //title: "hola probando",
                                    todayHighlight: true, // fecha actual destacada
                                    clearBtn: true, //botón "Clear" en la parte inferior, si autoclose:true tambien se cerrará automaticamente
                                    //startDate: (e.target.name == 'fecha_inicial') ? datum.suma.inicial_start : datum.suma.final_start , // a partir de -3 días 
                                    //endDate: (e.target.name == 'fecha_inicial') ? ((datum.suma.inicial_end != null ) ?  datum.suma.inicial_end : "+10000d") : ((datum.suma.final_end != null ) ?  datum.suma.final_end : "+10000d") ,   //  "+3d",a partir de 3 días 
                                })
                                jQuery('#fecha_inicial').datepicker('setStartDate', datum.suma.inicial_start );  // a partir de -3 días 
                                jQuery('#fecha_inicial').datepicker('setEndDate',  ((datum.suma.inicial_end != null ) ?  datum.suma.inicial_end : "+10000d")  );
                                jQuery('#fecha_final').datepicker('setStartDate', datum.suma.final_start );  // a partir de -3 días 
                                jQuery('#fecha_final').datepicker('setEndDate',  ((datum.suma.final_end != null ) ?  datum.suma.final_end : "+10000d")  );
                                //metodo "buscar nombre", dentro del nivel seleccionado, en el cuadrante 2
                                var consulta_niveles = new Bloodhound({
                                   datumTokenizer: Bloodhound.tokenizers.obj.whitespace('nombre'), //'text'
                                   queryTokenizer: Bloodhound.tokenizers.whitespace,
                                  remote: {
                                        url:  '/buscador?key=%QUERY', 
                                        replace: function () {
                                             var num = jQuery('.objeto_como_tags > > .bootstrap-tagsinput > span.label').size();
                                                var q = '/buscador?key='+encodeURIComponent(jQuery('.bs-etiquetas_usuarios .tt-input').typeahead("val")); 
                                                    q += '&num='+num;
                                            return  q;        
                                        }
                                    },   

                                });
                                consulta_niveles.initialize();
                                elt = $('.objeto_como_tags > > input');
                                elt.tagsinput({
                                    itemValue: 'id', //id
                                    itemText: 'nombre',  //nombre
                                    itemNum: 'num',  //nombre
                                    tagClass: function(item) {
                                         return (  item.num == parseInt(jQuery('.objeto_como_tags > > .bootstrap-tagsinput > span.label').size())-1 ? 'tag label label-danger etiqactiva' : 'tag label label label-info');
                                    },                                                                                 
                                    typeaheadjs: {
                                        name: 'usuarios',
                                        displayKey: 'nombre',
                                        source: consulta_niveles.ttAdapter()
                                    }
                                });
                                //Poner los nombres que pertenecen al nivel seleccionado
                                if(datum.datos != false){ 
                                    if (datum.datos.json_items!='') {
                                        $.each((jQuery.parseJSON(datum.datos.json_items)), function( index, value ) {
                                            elt.tagsinput('add', {"id":value.id ,"nombre":value.nombre,"num":value.num}); 
                                        });
                                        elt.tagsinput('refresh');
                                     }   
                                }

                                    //alert('');

                                    evento ='';
                                  //console.log("aaa:"+evento);  


                                //elt.tagsinput('focus');      
                            } //fin del sucess
                        });  //fin de $.ajax
                        break;
                   default:
                      break;
                } //fin del case

            } //fin de if (ambito_app=2) proyecto
          } else { //fin de if(data && data.selected && data.selected.length) {
                //cuando refresca y solo esta seleccionado el root
                $('#data .content').hide();
                //$('#data .default').text('Seleccione un nodo desde el arbol.').show();
          }
        });


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
elt = $('.objeto_como_tags > > input');


//////////////////////////////////////////////////////////
///////////////////////////PROYECTO////////////////////////
//////////////////////////////////////////////////////////
/////////////////////////Guarda un nuevo proyecto
    jQuery('body').on('submit','#form_nuevo_proyectos', function (e) {
            var $element = $("#etiq_usuarios");
           
            var val = $element.val();
                 id_val = (JSON.stringify(val));
                 console.log($element.val());
            json_items =($element.val()=='') ? '[]' : (JSON.stringify($element.tagsinput('items')));
            var arreglo = elt.val().split(",");
            var span = elt.siblings("div.bootstrap-tagsinput").find(".etiqactiva");
            var id_user_seleccion =  arreglo[span.index()];

            if ($element.val()=='')  { //sino hay nombre o no hay activo pues que no haga nada
            //if ( ($element.val()=='') || (span.index()<=0)) { //sino hay nombre o no hay activo pues que no haga nada    
                return false;     
            }
             console.log(id_val);
             console.log(json_items);
             console.log(arreglo);
             console.log(span.index());
             console.log(id_user_seleccion);  //

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
                             } 
                    }
                } 
            });
            return false;
    }); 

//elt.tagsinput('focus'); 

/*
cada vez que se agrega un elemento: 
  1- valida
  2- busca los costo y lo pone, sino tiene ninguno los pone vacio
*/
jQuery('body').on('itemAdded',elt, function (e) {
  if (evento!=''){  //cuando ocurre un evento de cambio, este provoca tambien a este evento, necesito que este evento no corra
        return true;  
  }
  jQuery('form').submit();//  este es para el caso en que agregue un nuevo elemento y no haya guardado el anterior, sin cambiar de nivel
  
  $.ajax({ //actualzar los datos seleccionados  
      url: "/busqueda_costo",
      type: 'POST',
      dataType: "json",
      data: {
          id_user_seleccion: e.item.id, //id_user_seleccion, 
          id_registro: jQuery("#id_proy").val(),
          id_nivel: jQuery("#id_nivel").val(),

          id_cat_proy: $("input[name=id]").val(),   
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
          elt.tagsinput('refresh'); //refresca para que el ultimo se ponga de color rojo


        jQuery('#fecha_inicial').datepicker('setStartDate', data.suma.inicial_start );  // a partir de -3 días 
        jQuery('#fecha_inicial').datepicker('setEndDate',  ((data.suma.inicial_end != null ) ?  data.suma.inicial_end : "+10000d")  );
        jQuery('#fecha_final').datepicker('setStartDate', data.suma.final_start );  // a partir de -3 días 
        jQuery('#fecha_final').datepicker('setEndDate',  ((data.suma.final_end != null ) ?  data.suma.final_end : "+10000d")  );
        
         
      } 
  });    
});


/*
Cdo le da click a un nombre:
     1- valida
     2- marca esa etiqueta como activa, 
     3- busca los costo y lo pone, sino tiene ninguno los pone vacio
*/    
jQuery('body').on('click','span.label', function (e) { 
    jQuery('form').submit(); //nos referimos al user de donde viene
    jQuery('span.label').removeClass('label-danger etiqactiva');
    jQuery('span.label').removeClass('label-info');
    jQuery('span.label').addClass('label-info');
    jQuery(this).addClass('label-danger etiqactiva');
    var indice = jQuery(this).index();
    var arreglo = jQuery(this).parent().siblings("input").val().split(",");
      $.ajax({
                url: "/busqueda_costo",
                type: 'POST',
                dataType: "json",
                data: {
                    id_user_seleccion: arreglo[indice], 
                    id_registro: jQuery("#id_proy").val(),
                    id_nivel: jQuery("#id_nivel").val(),

                    id_cat_proy: $("input[name=id]").val(),   

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

                    jQuery('#fecha_inicial').datepicker('setStartDate', data.suma.inicial_start );  // a partir de -3 días 
                    jQuery('#fecha_inicial').datepicker('setEndDate',  ((data.suma.inicial_end != null ) ?  data.suma.inicial_end : "+10000d")  );
                    jQuery('#fecha_final').datepicker('setStartDate', data.suma.final_start );  // a partir de -3 días 
                    jQuery('#fecha_final').datepicker('setEndDate',  ((data.suma.final_end != null ) ?  data.suma.final_end : "+10000d")  );


                } 
            });
});

/*
  Justo antes que un elemento se elimina:
    1- Actualiza el elemento, es decir yo supongo q??
*/  
jQuery('body').on('beforeItemRemove',elt, function (e) {
  // event.item: contiene el elemento
  // event.cancel: establece en true para evitar que se elimine el elemento
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
             },
            success: function(datos){
              //
            }
      });       
});

/*
 Justo despues que un elemento se elimina:
    1- Elimina el elemento fisicamente de la tabla
    2- busco los costo, para el nuevo elemento
*/  


jQuery('body').on('itemRemoved',elt, function (e) {
  // event.item: contiene el elemento
  var $element = $("#etiq_usuarios");
       var val = $element.val();
        id_val = (JSON.stringify(val));
    json_items =(JSON.stringify($element.tagsinput('items')));
      //señalar en rojo el ultimo elemento
      jQuery('span.label').removeClass('label-danger etiqactiva');
      jQuery('span.label').removeClass('label-info');
      jQuery('span.label').addClass('label-info');

      var pos = (parseInt(jQuery('.objeto_como_tags > > .bootstrap-tagsinput > span.label').size()));
     var elem = jQuery('.objeto_como_tags > > .bootstrap-tagsinput > span:nth-child('+pos+')') ;
     elem.addClass('label-danger etiqactiva');
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
           var arreglo = elt.val().split(",");
           var id_user_seleccion =  arreglo[pos-1];
          //actualzar los datos seleccionados  
          $.ajax({
              url: "/busqueda_costo",
              type: 'POST',
              dataType: "json",
              data: {
                  id_user_seleccion: id_user_seleccion, 
                  id_registro: jQuery("#id_proy").val(),
                  id_nivel: jQuery("#id_nivel").val(),

                  id_cat_proy: $("input[name=id]").val(),   
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

                jQuery('#fecha_inicial').datepicker('setStartDate', data.suma.inicial_start );  // a partir de -3 días 
                jQuery('#fecha_inicial').datepicker('setEndDate',  ((data.suma.inicial_end != null ) ?  data.suma.inicial_end : "+10000d")  );
                jQuery('#fecha_final').datepicker('setStartDate', data.suma.final_start );  // a partir de -3 días 
                jQuery('#fecha_final').datepicker('setEndDate',  ((data.suma.final_end != null ) ?  data.suma.final_end : "+10000d")  );
                  
              } 
          });
      }
  });   
}); //fin del evento






});
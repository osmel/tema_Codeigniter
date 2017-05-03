jQuery(document).ready(function($) {

        //modulo para buscar dentro del tree    
        var to = false;
        jQuery('#buscar').keyup(function () {
            if (to) { clearTimeout(to); }
            to = setTimeout(function () {
                var v = jQuery('#buscar').val();
                jQuery('#tree').jstree(true).search(v); //esta es la funcion
            }, 250);
        });

         //alert(parseInt($("#depth_arbol").val()));

        //modulo para menu contextual
        function customMenu(node) {
            // The default set of all items
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
                            
                            /*
                            console.log(ref);    
                            console.log(obj);    
                            console.log(obj.children.length);  

                            console.log(obj.id);  //identificador id=1 es la raiz
                            console.log(item);    
                            console.log(sel);    
                            console.log(elemento); 
                            */   
                            
                         //alert($("#ambito_app").val());   


                        //jQuery('form').trigger('submit');

                       //crear: solo el dueno o el super_administrador aunque no sea el dueno        
                       if   ( ($('#proyecto').val() !="") || ($('#proyecto').val().length > 0) )
                        if ( ($("#dueno").val() ==1) || ($("#perfil_activo").val() ==1)  ) {
                            //alert('as');
                                if ( parseInt($("#crea_multiple_simple").val())==0)    { //entornos es simple
                                    if (obj.children.length==0)    { //pueda crear nodo solo si no tiene hijos
                                            inst.create_node(sel, {"text": "osmel", "data" : {  } }, "last", //"file" : false
                                                function (new_node) {
                                                    //console.log(new_node);
                                                    new_node.icon = "fa fa-coffee";
                                                    new_node.text = "nuevo Nombre";
                                                    inst.edit(new_node);
                                                }
                                            );
                                    }
                                } else {  //proyectos pueden tener multiples hijos
                                        inst.create_node(sel, {"text": "osmel", "data" : {  } }, "last", //"file" : false
                                            function (new_node) {
                                                //console.log(new_node);
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

                renameItem: { // The "rename" menu item
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
                deleteItem: { // The "delete" menu item
                    label: "Eliminar",
                    action: function (data) {
                        var inst = jQuery.jstree.reference(data.reference),
                            obj = inst.get_node(data.reference);

                        //eliminar: solo el dueno o el super_administrador aunque no sea el dueno        
                        if ( ($("#dueno").val() ==1) || ($("#perfil_activo").val() ==1)  ) {
                            if (obj.id!=1) { //sino es la raiz puede eliminarlo
                                if(inst.is_selected(obj)) {
                                    inst.delete_node(inst.get_selected());
                                }
                                else {
                                    inst.delete_node(obj);
                                }
                            }
                        }   


                    }
                }
            };
            
            /*
            if (node.data.file) {
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




            "plugins" : [ "contextmenu", "dnd", "search", "state", "types", "wholerow" ],
            //dnd: arrastrar y soltar
            //types: añadir tipos predefinidos para grupos de nodos
            //state: guarda todos los nodos abiertos y seleccionados 
            //Wholerow: Hace que cada nodo aparezca a nivel de bloque que hace que sea más fácil la selección
            "contextmenu": {items: customMenu}
            
        })
                    //**** faltan por completar  "copy_node" y "analyze" ****

                        //Eliminar nodos y sus hijos
                        .on('delete_node.jstree', function (e, data) {
                            $.get('/eliminar_nodo?operation=delete_node', { 'id' : data.node.id })
                                    .fail(function () {
                                        data.instance.refresh();
                                    });
                        })
                        
                        //crear un unico nodo
                        .on('create_node.jstree', function (e, data) {
                            $.get('/crear_nodo?operation=create_node', { 'id' : data.node.parent, 'position' : data.position, 'text' : data.node.text })
                                .done(function (d) {
                                    data.instance.set_id(data.node, d.id);
                                    //$("#nombre").val(data.node.text);
                                })
                                .fail(function () {
                                    data.instance.refresh();
                                });
                        })

                        //renombrar un único nodo
                        .on('rename_node.jstree', function (e, data) {
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

                       

                        .on('changed.jstree', function (e, data) {
                            if(data && data.selected && data.selected.length) {
                                //console.log(data.node.parents.length);
                                //console.log(data.selected);
                                //console.log(data.selected.length);
                                //alert('asasd');
                                //niveles la raiz = proyecto = 1        
                            if ($("#ambito_app").val()==2)  { //if estamos en proyectos

                                $("#nombre").val(data.node.text);
                                
                                jQuery('form').submit();

                                //jQuery('form').trigger('submit:complete');
                                /*

                                     setTimeout(function() {
                                            $('#helloworld').get(0).submit();
                                     }, 1000);
                                */
                                
                                $( document ).ajaxComplete(function( event, xhr, settings ) {
                                    //console.log(settings.url);
                                     if ( settings.url == "http://tema.dev.com/validacion_edicion_nivel" ) {

                                           //alert(settings.url );
                                           //console.log(event);
                                           //console.log(xhr);
                                           //console.log(settings);
                                        }
                                });
                                


                                jQuery(this).parent().parent().parent().removeClass( "col-sm-12 col-md-12" );
                                jQuery(this).parent().parent().parent().addClass( "col-sm-6 col-md-6" );
                                jQuery(this).parent().parent().parent().siblings().css('display','block');   

                                switch (data.node.parents.length) {
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
                                                 },
                                                success: function(datum){

                                                            $("#id_nivel").val(data.node.id);
                                                            $("#profundidad").val(data.node.parents.length);

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


                                                                                //  datos de cada participante en el proyecto
                                                                                texto+='<div class="form-group" style="display:none;">';
                                                                                    
                                                                                    texto+='<div class="col-sm-3 col-md-3">';
                                                                                           if(datum.datos != false){
                                                                                                $costo=datum.datos["costo"];
                                                                                            } else {
                                                                                                $costo='';
                                                                                            }    

                                                                                        texto+='<input value="'+$costo+'" restriccion="decimal" type="text" class="form-control ttip" ';

                                                                                                texto+='title="Números y puntos decimales." id="costo" name="costo" placeholder="0.00"> ';

                                                                                        texto+='<em>Costo del proyecto.</em> ';
                                                                                    texto+='</div> ';



                                                                                    texto+='<div class="col-sm-3 col-md-3">';
                                                                                           if(datum.datos != false){
                                                                                                $tiempo_disponible=datum.datos["tiempo_disponible"];
                                                                                            } else {
                                                                                                $tiempo_disponible='';
                                                                                            }    
                                                                                        
                                                                                        texto+='<input value="'+$tiempo_disponible+'" restriccion="decimal" type="text" class="form-control ttip" ';
                                                                                                texto+='title="Números y puntos decimales." id="tiempo_disponible" name="tiempo_disponible" placeholder="0.00"> ';
                                                                                        texto+='<em>Tiempo disponible.</em>';
                                                                                    texto+='</div> ';


                                                                                    
                                                                                    texto+='<div class="input-daterange input-group col-sm-3 col-md-3"" id="datepicker">';
                                                                                     if(datum.datos != false){
                                                                                                $fecha_inicial=datum.datos["fecha_inicial"];
                                                                                            } else {
                                                                                                $fecha_inicial='';
                                                                                           }    
                                                                                        texto+='<input value="'+$fecha_inicial+'" type="text" class="fecha_ini input-sm form-control" id="fecha_inicial" name="fecha_inicial" placeholder="DD-MM-YYYY" />';

                                                                                        //texto+='<span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>';
                                                                                        texto+='<span class="input-group-addon">to</span>';

                                                                                        if(datum.datos != false){
                                                                                                $fecha_final=datum.datos["fecha_final"];
                                                                                            } else {
                                                                                                $fecha_final='';
                                                                                           }  
                                                                                        //texto+='<input type="text" class="input-sm form-control" name="end" />';
                                                                                        texto+='<input value="'+$fecha_final+'" type="text" class="fecha_final input-sm form-control" id="fecha_final" name="fecha_final" placeholder="DD-MM-YYYY" />';
                                                                                        //texto+='<span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>';

                                                                                    texto+='</div>';

                                                                                texto+='</div> ';





                                                                                
                                                                        texto+='</div>  ';
                                                            texto+='</div>';   


                                                            texto+='<em>'+datum.suma.total+'</em>';

                                                            
                                                           

                                                           // console.log(datum.suma.inicial_start);
                                            
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
                                                                    
                                                                    //jQuery('#fecha_inicial').datepicker('hide');
                                                                    //jQuery('#fecha_final').datepicker('hide');

                                                                    jQuery('#fecha_inicial').datepicker('setStartDate', datum.suma.inicial_start );  // a partir de -3 días 
                                                                    jQuery('#fecha_inicial').datepicker('setEndDate',  ((datum.suma.inicial_end != null ) ?  datum.suma.inicial_end : "+10000d")  );

                                                                    jQuery('#fecha_final').datepicker('setStartDate', datum.suma.final_start );  // a partir de -3 días 
                                                                    jQuery('#fecha_final').datepicker('setEndDate',  ((datum.suma.final_end != null ) ?  datum.suma.final_end : "+10000d")  );



                                                                    

                                                            //})

                                                                        

                                                    
                                                                        /////////////////////////buscar usuarios

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





                                                                         if(datum.datos != false){
                                                                            if (datum.datos.json_items!='') {
                                                                                //console.log(jQuery.parseJSON(datum.datos.json_items));
                                                                               
                                                                                $.each((jQuery.parseJSON(datum.datos.json_items)), function( index, value ) {
                                                                                  //elt.tagsinput('add', {"id":value.id ,"nombre":value.nombre});
                                                                                    elt.tagsinput('add', {"id":value.id ,"nombre":value.nombre,"num":value.num}); 


                                                                                });

                                                                                elt.tagsinput('refresh');
                                                                               
                                                                             }   
                                                                          }













                                                } 
                                            });
                                            

                                        

                                        
                                        
                                        


                                        
                                        break;
                                    
                                        
  
                                   default:
                                        //console.log('nose');
                                }

                            } //fin de ambito_app=2 proyecto
                                
                              


                            }
                            else {


                                //cuando refresca y solo esta seleccionado el root
                                $('#data .content').hide();
                                //$('#data .default').text('Seleccione un nodo desde el arbol.').show();
                            }
                        });
                        

  });




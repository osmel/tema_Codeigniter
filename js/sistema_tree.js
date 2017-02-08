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

                        inst.create_node(sel, {"text": "osmel", "data" : {  } }, "last", //"file" : false
                            function (new_node) {
                                //console.log(new_node);
                                new_node.icon = "fa fa-coffee";
                                new_node.text = "nuevo Nombre";
                                inst.edit(new_node);
                            }
                        );

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
                        inst.edit(obj);
                    }
                },
                deleteItem: { // The "delete" menu item
                    label: "Eliminar",
                    action: function (data) {
                        var inst = jQuery.jstree.reference(data.reference),
                            obj = inst.get_node(data.reference);
                        if(inst.is_selected(obj)) {
                            inst.delete_node(inst.get_selected());
                        }
                        else {
                            inst.delete_node(obj);
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
                          

                            'url' : 'obtener_nodo?operation=obtener_nodo',
                            'data' : function (node) {
                                return { 'id' : node.id };
                            },
                            "dataType" : "json"
                            

                            /*
                            'url' : 'get_node?operation=get_node',
                            'data' : function (node) {
                                return { 'id' : node.id };
                            },
                            "dataType" : "json"

                            */
                        }
                /*
                'data': [
                    { "id": "raiz_proyecto", "parent": "#", "text": "Proyectos", "state": {"opened": true}, "type":"root", "data" : { "file" : false } },
                ]*/
            },
            
            "types" : {
                "#" : { 
                         "max_children" : 1, //maximos hijos
                         "max_depth" : 5,  //maxima profundidad
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
                        //Eliminar nodos y sus hijos
                        .on('delete_node.jstree', function (e, data) {
                            $.get('eliminar_nodo?operation=delete_node', { 'id' : data.node.id })
                                    .fail(function () {
                                        data.instance.refresh();
                                    });
                        })
                        
                        //crear un unico nodo
                        .on('create_node.jstree', function (e, data) {
                            $.get('crear_nodo?operation=create_node', { 'id' : data.node.parent, 'position' : data.position, 'text' : data.node.text })
                                .done(function (d) {
                                    data.instance.set_id(data.node, d.id);
                                })
                                .fail(function () {
                                    data.instance.refresh();
                                });
                        })

                        //renombrar un único nodo
                        .on('rename_node.jstree', function (e, data) {
                            $.get('renombrar_nodo?operation=rename_node', { 'id' : data.node.id, 'text' : data.text })
                                .fail(function () {
                                    data.instance.refresh();
                                });
                        })


                        .on('move_node.jstree', function (e, data) {
                            $.get('get_node?operation=move_node', { 'id' : data.node.id, 'parent' : data.parent, 'position' : data.position })
                                .fail(function () {
                                    data.instance.refresh();
                                });
                        })
                        .on('copy_node.jstree', function (e, data) {
                            $.get('get_node?operation=copy_node', { 'id' : data.original.id, 'parent' : data.parent, 'position' : data.position })
                                .always(function () {
                                    data.instance.refresh();
                                });
                        })

                            //este es solo para obtener el recorrido seleccionado
                        .on('changed.jstree', function (e, data) {
                            if(data && data.selected && data.selected.length) {
                                $.get('obtener_contenido?operation=get_content&id=' + data.selected.join(':'), function (d) {
                                    $('#data .default').text(d.content).show();
                                });
                            }
                            else {
                                $('#data .content').hide();
                                $('#data .default').text('Seleccione un nodo desde el arbol.').show();
                            }
                        });

           
/*
            //evento crear Nodo
            .on('create_node.jstree', function (e, data) {
                    jQuery.ajax({
                                url : 'crear_nodo',
                                data : { 
                                          id : data.node.parent,
                                    position : data.position,
                                        text  : data.node.text
                                },
                                type : 'POST',
                                dataType : 'json',
                                success : function(respuesta) {  
                                    if(respuesta.exito != true){
                                        data.instance.refresh();
                                        console.log('fallo');
                                    } else {
                                        data.instance.set_id(data.node, respuesta.id); 
                                        console.log('exito');
                                    }   
                                }
                    });                             

            }); //fin evento crear nodo

*/
  });


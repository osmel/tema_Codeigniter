jQuery(document).ready(function($) {


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




    jQuery('.fecha_reporte').daterangepicker(
          { 
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
                   'Este mes': [moment().startOf('month'), moment().endOf('month')],
                   'Ultimo Mes': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
              },
              format: 'DD-MM-YYYY',

              
               //"startDate": "22-02-2017",
               //"endDate": "28-02-2017",
               //minDate: "01-02-2017",
               //maxDate: "28-02-2017",

              //http://www.daterangepicker.com/
              //maxDate: "-3d",
             //maxDate: moment(),
            separator: ' / ',
            
          }
    );

    jQuery('.fecha_reporte').on('apply.daterangepicker', function(ev, picker) {
        comienzo=true; 
        var oTable =jQuery('#tabla_rep_general').dataTable();
       oTable._fnAjaxUpdate();

    });



jQuery("#id_proyecto, #id_profundidad, #id_area, #id_usuario ").on('change', function(e) {
        
        var campo = jQuery(this).attr("name");   

        var id_proyecto = jQuery('#id_proyecto').val();
        var id_profundidad = jQuery('#id_profundidad').val();
        var id_area = jQuery('#id_area').val();
        var id_usuario = jQuery('#id_usuario').val();

        var dependencia = jQuery(this).attr("dependencia"); 


        if (dependencia !="") {     
            //limpiar la dependencia
            jQuery("#"+dependencia).html(''); 
            //cargar la dependencia
            cargarDependencia_reporte(campo,id_proyecto,id_profundidad, id_area, id_usuario,dependencia);
        }


    //cuando cambie uno que refresh tabla
    var hash_url = window.location.pathname;
    if  ( (hash_url=="/general") )   {  
       var oTable =jQuery('#tabla_rep_general').dataTable();
       oTable._fnAjaxUpdate();
    }   

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
                      //console.log(dependencia);
                      if (dependencia == "id_profundidad")  {
                        jQuery("#"+dependencia).append('<option value="-1" >Todos</option>'); //Seleccione '+nombre+'
                      } else {
                        jQuery("#"+dependencia).append('<option value="0" >Todos</option>'); //Seleccione '+nombre+'   
                      }
                     
                    
                    if (data != "[]") {
                        
                        jQuery.each(data, function (i, valor) {
                            if (valor.nombre !== null) {
                                 jQuery("#"+dependencia).append('<option value="' + valor.identificador + '">' + valor.nombre + '</option>');     
                            }
                        });

                    }   
                    
                    jQuery("#"+dependencia).trigger('change');

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


                //console.log(settings.json.intervalo);
            
            for (var i = 9; i <= (intVal(settings.json.intervalo)+10); i++) {
                    api.column(i).visible(true);      
                }        

            for (var i = (intVal(settings.json.intervalo)+10); i <= 39; i++) {
                    api.column(i).visible(false);      
                }    

                


    return pre
},

        "columnDefs": [ 

                      {
                          "targets": 39, //(jQuery('#tabla_rep_general').dataTable().fnSettings().aoData[0]._aData.length-1  !== 'undefined') ? (jQuery('#tabla_rep_general').dataTable().fnSettings().aoData[0]._aData.length-1) : 9 ,
                          
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

    
         //callback
    "fnHeaderCallback": function( nHead, aData, iStart, iEnd, aiDisplay ) {
        var d = new Date();
        var n = d.getMonth()+1;
        var arreglo = ['','Proyectos', 'Usuarios Asociados','1/'+n, '2/'+n,'3/'+n,'4/'+n,'5/'+n,'6/'+n,'7/'+n, '8/'+n,'9/'+n,'10/'+n, '11/'+n,'12/'+n,'13/'+n, '14/'+n,'15/'+n,'16/'+n, '17/'+n,'18/'+n,'19/'+n, '20/'+n,'21/'+n,'22/'+n, '23/'+n,'24/'+n,'25/'+n, '26/'+n,'27/'+n,'28/'+n,'29/'+n,'30/'+n,'31/'+n]; 
        
        
        var fecha = (jQuery('.fecha_reporte').val()).split(' / ');
         var   fecha_inicial = fecha[0];
         var   fecha_final = fecha[1];


        

       if (fecha[0].length !=0) {
        //console.log("asdas");

               var fi = fecha[0]; //"28-02-2017 0:00";
               var fo = fecha[1]; //"02-03-2017 0:00";

                var dateArray =  getDates(new Date( fi.replace( /(\d{2})-(\d{2})-(\d{4})/, "$2-$1-$3") ), new Date( fo.replace( /(\d{2})-(\d{2})-(\d{4})/, "$2-$1-$3") )  );    

                for (i = 0; i < dateArray.length; i ++ ) {
                    /*
                    console.log (dateArray[i]);
                    console.log (dateArray[i].getFullYear());
                    console.log (dateArray[i].getMonth());
                    console.log (dateArray[i].getDay());
                    console.log (dateArray[i].getUTCDate());
                    */
                    
                     arreglo[i+2] = dateArray[i].getUTCDate()+'/'+dateArray[i].getMonth();
                }    


       }



        var encabezado ='';
    
       // console.log(aData );
        if (aData.length !=0) {
            for (var i=0; i<=arreglo.length-(31-aData[0][8]); i++) { //cant_colum
                     encabezado +='<th class="text-center cursora" width="22%">'+arreglo[i]+'</th>';
            }

                nHead.innerHTML='<tr role="row">'+encabezado+'</tr>'
        }    

    },       


       
    });  



    // Add event listener for opening and closing details
    jQuery('#tabla_rep_general tbody').on('click', 'td.details-control', function () {
        var tr = $(this).closest('tr');
        var td = $(this).closest('tr > td');
        var row = jQuery('#tabla_rep_general').DataTable().row( tr );
        //console.log(row);
  
          //console.log($('#tabla_rep_general').DataTable().row( tr ).data());
          //console.log(tabla.row());

        
        if ( row.child.isShown() ) { //si la fila esta "abierta" entonces "cerrarla"
            row.child.hide();
            tr.removeClass('shown');
        }
        else {
            //si la fila esta "cerrada" entonces "abrirla"
            //row.child( format(row.data()) ).show();
            //tr.addClass('shown');

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

                         },
                        success: function(datos){
                          
                            //cellpadding="5" border="0"
                            $cad='<table  class="tabla_hija display table table-striped table-bordered table-responsive dataTable"  role="grid" style="width: 100%; border:1px solid #2ab4c0;" >';
                                if (datos.data) {

                                    //encabezado

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
                                                   arreglo[i+2] = dateArray[i].getUTCDate()+'/'+dateArray[i].getMonth();
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
                                    //console.log(encabezado);
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

                            row.child( $cad ).show();
                            //jQuery('.tabla_hija').parent().css('padding','12px 0px 12px 0px');
                            //jQuery('.tabla_hija').parent().css('margin','0px');
                            tr.addClass('shown');



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





/*
function Person( name, age, position ) {
    this._name     = name;
    this._age      = age;
    this._position = position;
 
    this.name = function () {
        return this._name;
    };
 
    this.age = function () {
        return this._age;
    };
 
    this.position = function () {
        return this._position;
    };
}

var table =  jQuery('#tabla_rep_general').dataTable( {
     columns: [
            { data: null, render: 'name' },
            { data: null, render: 'age' },
            { data: null, render: 'position' }
        ]

});


table.row.add( new Person( 'Airi Satou',     33, 'Accountant' ) );
table.draw();*/





/*

 0=>$row->id_nivel,
  1=>$row->id_entorno,
  2=>$row->id_proyecto,
  3=>$row->profundidad,
  4=>$row->nombre,
  5=>$row->nomb,
  6=>$row->apellidos,
  7=>$row->salario,
  8=>$row->a26,
  9=>$row->a27,
  10=>$row->a28,







var comenzar = false;
//jQuery('input[type="checkbox"][class="check_activo"]').click(function(e) {
    jQuery('body').on('click','input.check_activo[type="checkbox"]', function (e) {         

        var $this = $(this);
        // $this will contain a reference to the checkbox   
        var identificador = jQuery(this).attr('identificador');


        var activo = ( ($this.is(':checked')) ? 1 : 0 );

        jQuery.ajax({
                        url : 'marcando_activo',
                        data : { 
                            identificador: identificador,
                            activo: activo,
                        },
                        type : 'POST',
                        dataType : 'json',
                        success : function(data) {  
                            //console.log(data);
                            //comienzo = true;
                            comenzar = true; //para indicar que start comience en 0;
                            var oTable =jQuery('#tabla_cat_productos').dataTable();
                            oTable._fnAjaxUpdate();



                        }
            }); 


    });

    */

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
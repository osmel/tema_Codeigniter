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
               "startDate": "22-02-2017",
               "endDate": "28-02-2017",
               minDate: "01-02-2017",
               maxDate: "28-02-2017",

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



jQuery('#tabla_rep_general').dataTable( {
        "pagingType": "full_numbers",
        "processing": true,
        "serverSide": true,
        "ajax": {
                    "url" : "procesando_rep_general",
                    "type": "POST",
                    "data": function ( d ) {
                        var fecha = (jQuery('.fecha_reporte').val()).split(' / ');
                        d.fecha_inicial = fecha[0];
                        d.fecha_final = fecha[1];
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
        "columnDefs": [
                    { 
                        "render": function ( data, type, row ) {
                                return '-'.repeat(row[3])+''+row[4];
                        },
                        "targets": [0] 
                    },
                    { 
                        "render": function ( data, type, row ) {
                                return row[5]+' '+row[6] ;
                        },
                        "targets": [1] 
                    },
                    { 
                        "render": function ( data, type, row ) {
                                return row[8];
                        },
                        "targets": [2] 
                    },

                    { 
                        "render": function ( data, type, row ) {
                                return row[9];
                        },
                        "targets": [3] 
                    },

                    { 
                        "render": function ( data, type, row ) {
                                return row[10];
                        },
                        "targets": [4] 
                    },
                   
                   
                    
                ],
    });  


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
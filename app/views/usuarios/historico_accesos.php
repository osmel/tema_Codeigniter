<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php 


    /*
    //devuelve el día de la semana de la fecha actual
    $dia_hoy_semana = date('w',  mktime(0, 0, 0, date("m")  , date("d"), date("Y"))  );  
    
    

    $fecha = date('Y-m-j');
    $primer_dia_semana = date ( 'Y-m-j' ,strtotime ( '-'.$dia_hoy_semana.' day' , strtotime ( $fecha ) ) );
    $ultimo_dia_semana = date ( 'Y-m-j' ,strtotime ( '+'.(6-$dia_hoy_semana).' day' , strtotime ( $fecha ) ) );
     
    echo $primer_dia_semana.'<br/>';
    echo $ultimo_dia_semana;
//    die;


    // la primera semana empieza con 0, por lo tanto, la forma correcta de llamar la primera semana se logra de esta forma
    $semana = date('W',  mktime(0, 0, 0, date("m")  , date("d"), date("Y"))  );  

    for($i=1; $i<8; $i++){  //2--9 es de lunes a viernes 1--8 domingo a sabado
        echo date('Y-m-d', strtotime('01/01 +' . ($semana - 1) . ' weeks first day +' . $i . ' day')) . '<br />';
    }
    die;*/
 
?>
<!-- Fin PORTLET -->
    <div class="portlet light ">
        <div class="portlet-title">
            <div class="caption caption-md">
                <i class="icon-bar-chart theme-font hide"></i>
                <span class="caption-subject font-blue-madison bold uppercase">Historico de accesos</span>
                <span class="caption-helper hide">weekly stats...</span>
            </div>
            <div class="actions">
                <div class="btn-group btn-group-devided" data-toggle="buttons">
                    <label class="btn btn-transparent grey-salsa btn-circle btn-sm active">
                        <input type="radio" name="options" class="toggle" id="option1">Hoy</label>
                    <label class="btn btn-transparent grey-salsa btn-circle btn-sm">
                        <input type="radio" name="options" class="toggle" id="option2">Semana</label>
                    <label class="btn btn-transparent grey-salsa btn-circle btn-sm">
                        <input type="radio" name="options" class="toggle" id="option2">Mes</label>
                </div>
            </div>
        </div>
       
        <div class="portlet-body">
            <div class="row number-stats margin-bottom-30">
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <div class="stat-left">
                        <div class="stat-chart">
                            <!--  http://omnipotent.net/jquery.sparkline/#s-news
                            do not line break "sparkline_bar" div. sparkline chart has an issue when the container div has line break 
                            No rompe la línea "sparkline_bar" div. El gráfico Sparkline tiene un problema cuando la div del contenedor tiene salto de línea-->
                            <div id="sparkline_bar12" sparkBarColor="green">
                                <?php 
                                    foreach ($dat_historico_semana as $key => $value) {
                                            echo($value->cantidad.  (($key!=count($dat_historico_semana)-1) ? ',':'') );
                                    }   
                                ?>

                            </div>
                            <div class="mouseoverregion"></div>
                            
                        </div>
                        <div class="stat-number">
                            <div class="title"> Total </div>
                            <div class="number"> 2460 </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <div class="stat-right">
                        <div class="stat-chart">
                            <!-- do not line break "sparkline_bar" div. sparkline chart has an issue when the container div has line break -->
                            <div id="sparkline_bar22">
                                <?php 
                                    foreach ($dat_historico_mes as $key => $value) {
                                            echo($value->cantidad.  (($key!=count($dat_historico_mes)) ? ',':'') );
                                    }   
                                ?>

                            </div>
                        </div>
                        <div class="stat-number">
                            <div class="title"> Nuevos </div>
                            <div class="number"> 719 </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="table-scrollable table-scrollable-borderless">
                <table class="table table-hover table-light">
                    <thead>
                        <tr class="uppercase">
                            <th colspan="2"> MEMBER </th>
                            <th> Earnings </th>
                            <th> CASES </th>
                            <th> CLOSED </th>
                            <th> RATE </th>
                        </tr>
                    </thead>
                    <tr>
                        <td class="fit">
                            <img class="user-pic" src="<?php echo base_url(); ?>js/assets/pages/media/users/avatar4.jpg"> </td>
                        <td>
                            <a href="javascript:;" class="primary-link">Brain</a>
                        </td>
                        <td> $345 </td>
                        <td> 45 </td>
                        <td> 124 </td>
                        <td>
                            <span class="bold theme-font">80%</span>
                        </td>
                    </tr>
                    <tr>
                        <td class="fit">
                            <img class="user-pic" src="<?php echo base_url(); ?>js/assets/pages/media/users/avatar5.jpg"> </td>
                        <td>
                            <a href="javascript:;" class="primary-link">Nick</a>
                        </td>
                        <td> $560 </td>
                        <td> 12 </td>
                        <td> 24 </td>
                        <td>
                            <span class="bold theme-font">67%</span>
                        </td>
                    </tr>
                    <tr>
                        <td class="fit">
                            <img class="user-pic" src="<?php echo base_url(); ?>js/assets/pages/media/users/avatar6.jpg"> </td>
                        <td>
                            <a href="javascript:;" class="primary-link">Tim</a>
                        </td>
                        <td> $1,345 </td>
                        <td> 450 </td>
                        <td> 46 </td>
                        <td>
                            <span class="bold theme-font">98%</span>
                        </td>
                    </tr>
                    <tr>
                        <td class="fit">
                            <img class="user-pic" src="<?php echo base_url(); ?>js/assets/pages/media/users/avatar7.jpg"> </td>
                        <td>
                            <a href="javascript:;" class="primary-link">Tom</a>
                        </td>
                        <td> $645 </td>
                        <td> 50 </td>
                        <td> 89 </td>
                        <td>
                            <span class="bold theme-font">58%</span>
                        </td>
                    </tr>
                </table>
            </div> <!-- Fin tabla -->

        </div> <!-- Fin portlet-body -->
    </div>
    <!-- END PORTLET -->
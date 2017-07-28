<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<style>

  .scrollers > .nav-item > a {
    border-top: 1px solid #3d4957;
    color: #b4bcc8;
    background: #2b3643;
    position: relative;
    display: block;

    margin: 0;
    border: 0;
    padding: 10px 15px;
    text-decoration: none;
    font-size: 14px;
    font-weight: 300;

    }

</style>

<?php $id_perfil=$this->session->userdata('id_perfil');  ?>

<?php 
$coleccion_id_operaciones= json_decode($this->session->userdata('coleccion_id_operaciones')); 


                          if ( (count($coleccion_id_operaciones)==0) || (!($coleccion_id_operaciones)) )  {
                                    $coleccion_id_operaciones = array();
                          }     
?>

                <!-- BEGIN SIDEBAR -->
                <div class="page-sidebar-wrapper">
                    <!-- BEGIN SIDEBAR -->
                    <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
                    <!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
                    <div class="page-sidebar navbar-collapse collapse">
                        <!-- BEGIN SIDEBAR MENU -->
                            <!-- DOC: Apply "page-sidebar-menu-light" class right after "page-sidebar-menu" to enable light sidebar menu style(without borders) -->
                            <!-- DOC: Apply "page-sidebar-menu-hover-submenu" class right after "page-sidebar-menu" to enable hoverable(hover vs accordion) sub menu mode -->
                            <!-- DOC: Apply "page-sidebar-menu-closed" class right after "page-sidebar-menu" to collapse("page-sidebar-closed" class must be applied to the body element) the sidebar sub menu mode -->
                            <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
                            <!-- DOC: Set data-keep-expand="true" to keep the submenues expanded -->
                            <!-- DOC: Set data-auto-speed="200" to adjust the sub menu slide up/down speed -->
                            <ul class="page-sidebar-menu  page-header-fixed " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200" style="padding-top: 20px">
                                <!-- DOC: To remove the sidebar toggler from the sidebar you just need to completely remove the below "sidebar-toggler-wrapper" LI element -->
                                <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
                                <li class="sidebar-toggler-wrapper hide">
                                    <div class="sidebar-toggler">
                                        <span></span>
                                    </div>
                                </li>
                                <!-- END SIDEBAR TOGGLER BUTTON -->
                                <!-- DOC: To remove the search box from the sidebar you just need to completely remove the below "sidebar-search-wrapper" LI element -->
                        
                        <!-- Buscador
                                <li class="sidebar-search-wrapper">
                                 
                                      <form class="sidebar-search" action="page_general_search_3.html" method="POST">
                                        <a href="javascript:;" class="remove">
                                            <i class="icon-close"></i>
                                        </a>
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Search...">
                                            <span class="input-group-btn">
                                                <a href="javascript:;" class="btn submit">
                                                    <i class="icon-magnifier"></i>
                                                </a>
                                            </span>
                                        </div>
                                    </form>
                                    
                                </li>
                        Fin del buscador -->        

                        <!-- Dashboard       
                                <li class="nav-item start active open">
                                    <a href="javascript:;" class="nav-link nav-toggle">
                                        <i class="icon-home"></i>
                                        <span class="title">Inicio</span>
                                        <span class="selected"></span>
                                        <span class="arrow open"></span>
                                    </a>
                                    <ul class="sub-menu">
                                        <li class="nav-item start active open">
                                            <a href="/" class="nav-link ">
                                                <i class="icon-bar-chart"></i>
                                                <span class="title">Inicio</span>
                                                <span class="selected"></span>
                                            </a>
                                        </li>
                                        
                                    </ul>
                                </li>
                         Fin del dashboard-->        

                        <!-- encabezado Caracteristicas       
                                <li class="heading">
                                    <h3 class="uppercase">Caracteristicas</h3>
                                </li>
                                
                           
                                <li class="nav-item  ">
                                    <a href="javascript:;" class="nav-link nav-toggle">
                                        <i class="icon-diamond"></i>
                                        <span class="title">Interfaz de caracteristicas</span>
                                        <span class="arrow"></span>
                                    </a>
                                    <ul class="sub-menu">
                                        <li class="nav-item  ">
                                            <a href="components_bootstrap_switch.html" class="nav-link ">
                                                <span class="title">Bootstrap Switch</span>
                                                <span class="badge badge-success">6</span>
                                            </a>
                                        </li>
                                        <li class="nav-item  ">
                                            <a href="javascript:;" class="nav-link nav-toggle">
                                                <span class="title">Page Progress Bar</span>
                                                <span class="arrow"></span>
                                            </a>
                                            <ul class="sub-menu">
                                                <li class="nav-item  ">
                                                    <a href="components_color_pickers.html" class="nav-link ">
                                                        <span class="title">Color Pickers</span>
                                                        <span class="badge badge-danger">2</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </li>
                                        
                                    </ul>
                                </li>
                             Fin Caracteristicas -->     
                            <?php //if ($id_perfil==1) { ?>    
                            <?php //if (($id_perfil==1) || ($id_perfil==2) || ($id_perfil==3) ) { ?>   
                            <?php if ( ( $this->session->userdata( 'id_perfil' ) == 1  ) || (in_array(2, $coleccion_id_operaciones)) ) { ?>    
                                <!-- encabezado Caracteristicas -->        
                                <li class="heading">
                                        <h3 class="uppercase">Proyectos</h3>
                                    </li>

                                
                                    
                                    <li class="nav-item  ">
                                        <a href="<?php echo base_url(); ?>crear_proyecto" class="nav-link nav-toggle">
                                            <i class="fa fa-building"></i>
                                            <span class="title">Crear</span>
                                            <span class="badge badge-danger"><i class="fa fa-plus"></i></span>
                                        </a>
                                    </li>

                                <!--<li class="sidebar-search-wrapper">
                                 
                                      <form class="sidebar-search" action="page_general_search_3.html" method="POST">
                                        <a href="javascript:;" class="remove">
                                            <i class="icon-close"></i>
                                        </a>
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Buscar...">
                                            <span class="input-group-btn">
                                                <a href="javascript:;" class="btn submit">
                                                    <i class="icon-magnifier"></i>
                                                </a>
                                            </span>
                                        </div>
                                    </form>
                                    
                                </li>        

                                        <li class="sidebar-search-wrapper">
                                            <label class="col-sm-3 control-label"></label>
                                            <div class="col-sm-4">
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="fa fa-cogs"></i>
                                                    </span>
                                                    <input type="text" id="typeahead_example_31" name="typeahead_example_3" class="form-control" />
                                                </div>
                                                <p class="help-block"></code>
                                                </p>
                                            </div>
                                        </li>                    

                                    -->        


                                <li class="sidebar-search-wrapper">
                                    <div class="sidebar-search" >
                                        <div class="input-group">
                                            <!-- <input type="text" id="typeahead_example_31" name="typeahead_example_3" class="form-control" /> -->

                                            <input  type="text" name="editando_proyectos" idusuario="1" class="form-control buscar_elemento ttip" title="Campo predictivo. Escriba y seleccione el nombre de un proyecto." autocomplete="off" spellcheck="false" placeholder="Buscar Proyecto...">

                                            <span class="input-group-btn">
                                                <a class="btn submit">
                                                    <i class="icon-magnifier"></i>
                                                </a>
                                            </span>
                                        </div>
                                    </div>
                                    
                                </li>        


                                    <div  class="scrollers proyectos">
                                      
                                                <?php if ($proyectos) { ?>
                                                    <?php foreach ($proyectos as $proyecto) { ?>
                                                        <li nombre="<?php echo base64_encode($proyecto->proyecto); ?>" 
                                                     identificador="<?php echo base64_encode($proyecto->id); ?>" 

                                                     class="nav-item context <?php echo ($proyecto->id); ?>"  data-toggle="context" data-target="#context-menu">
                                                            <a href="<?php echo base_url(); ?>editar_proyecto/<?php echo base64_encode($proyecto->id); ?>" class="nav-link ">
                                                                    
                                                                    

                                                                <i class="fa fa-<?php echo ($proyecto->dueno_real==1) ? 'unlock' : 'unlock-alt' ?>"></i>
                                                                <span class="title"><?php echo $proyecto->proyecto; ?></span>
                                                                <span class="badge badge-success">6</span>
                                                            </a>
                                                        </li>
                                                    <?php } ?>    
                                                <?php } ?>     
                                      
                                       <!--menu contextual-->
                                                <div id="context-menu" style="position: absolute; z-index: 9999; top: 423px; left: 350px;" class="">
                                                    <ul class="dropdown-menu" role="menu">
                                                       <li><a tabindex="-1" href="">Modificar</a></li>
                                                       <li class="divider"></li>
                                                       <li><a tabindex="-1" href="">Eliminar</a></li>
                                                    </ul>
                                                </div>  


                                    </div>    
                                
        

                            <?php } ?>     
                                
                                
                                <!-- encabezado Caracteristicas -->        
                                <li class="heading">
                                    <h3 class="uppercase">Usuarios</h3>
                                </li>

                                 <li class="sidebar-search-wrapper">
                                    <div class="sidebar-search" >
                                        <div class="input-group">
                                            <!-- <input type="text" id="typeahead_example_31" name="typeahead_example_3" class="form-control" /> -->

                                            <input  type="text" name="editando_usuarios" idusuario="1" class="form-control buscar_usuarios ttip" title="Campo predictivo. Escriba y seleccione el nombre de un proyecto." autocomplete="off" spellcheck="false" placeholder="Buscar Usuarios...">

                                            <span class="input-group-btn">
                                                <a class="btn submit">
                                                    <i class="icon-magnifier"></i>
                                                </a>
                                            </span>
                                        </div>
                                    </div>
                                    
                                </li>                            


                                  
                                    <div  class="scrollers usuarios">
                                      

                                        <?php foreach ($usuarios as $usuario) { ?>
                                            <li class="nav-item <?php echo $usuario->id; ?>">
                                                <a href="<?php echo base_url(); ?>editar_usuario/<?php echo $usuario->id; ?>" class="nav-link nav-toggle">
                                                    <i class="icon-user"></i>
                                                    <span style="<?php echo 'text-decoration:'.(($usuario->activo==0) ? 'line-through' : 'none');?>" class="title"><?php echo $usuario->nombre.' '.$usuario->apellidos; ?></span>
                                                    <span class="badge badge-success">6</span>
                                                </a>
                                            </li>
                                        <?php } ?>    
                                      


                                    </div>    
                                
                           
                            <!--
                             

                                
                                <li class="nav-item  ">
                                    <a href="#" class="nav-link nav-toggle">
                                        <i class="icon-users"></i>
                                        <span class="title">Perfiles</span>                                        
                                    </a>
                                </li>-->
                                
                                <!-- http://keenthemes.com/preview/metronic/theme/admin_4/ui_icons.html-->

                                
                                 <?php if ( ( $this->session->userdata( 'id_perfil' ) == 1  ) || (in_array(6, $coleccion_id_operaciones)) ) { ?> 
                                     
                                    <li class="nav-item  ">
                                        <a href="<?php echo base_url(); ?>nuevo_usuario" class="nav-link nav-toggle">
                                                <i class="fa fa-user-plus" ></i>
                                                <span class="title">Agregar nuevo</span>   
                                        </a>
                                    </li>
                                <?php } ?>    

                               <!--
                               <li class="nav-item  ">
                                    <a href="#" class="nav-link nav-toggle">
                                        <i class="fa fa-history"></i>
                                        <span class="title">Histórico de accesos</span>
                                    </a>
                                </li>
                                -->
                                
                                
                             <!-- Fin Caracteristicas --> 



                            <!-- encabezado Reportes --> 

                            <?php if ( ( $this->session->userdata( 'id_perfil' ) == 1  ) || (in_array(5, $coleccion_id_operaciones)) ) { ?>    
                                    <li class="heading">

                                        <h3 class="uppercase">Reportes</h3>
                                    </li>
                                    

                                    <li class="nav-item  ">
                                        <a href="<?php echo base_url(); ?>general" class="nav-link nav-toggle">
                                            <i class="fa fa-archive"></i>
                                            <span class="title">General</span>
                                            <span class="badge"><i class="fa fa-print"></i></span>
                                            
                                        </a>
                                    </li>          


                                    <li class="nav-item  ">
                                        <a href="<?php echo base_url(); ?>horas_personas" class="nav-link nav-toggle">
                                            <i class="fa fa-archive"></i>
                                            <span class="title">horas personas</span>


                                            
                                            <span class="badge"><i class="fa fa-print"></i></span>
                                            
                                        </a>
                                    </li>                           
                                    
                                    <li class="nav-item  ">
                                        <a href="<?php echo base_url(); ?>balance_area_ganancia_perdida" class="nav-link nav-toggle">
                                            <i class="fa fa-archive"></i>
                                            <span class="title">Balance por Area ganancia-perdida</span>


                                            
                                            <span class="badge"><i class="fa fa-print"></i></span>
                                            
                                        </a>
                                    </li>  

                                     <li class="nav-item  ">
                                        <a href="<?php echo base_url(); ?>balance_usuario_ganancia_perdida" class="nav-link nav-toggle">
                                            <i class="fa fa-archive"></i>
                                            <span class="title">Balance por Usuario ganancia-perdida</span>


                                            
                                            <span class="badge"><i class="fa fa-print"></i></span>
                                            
                                        </a>
                                    </li>               

                                    <li class="nav-item  ">
                                        <a href="<?php echo base_url(); ?>balance_ganancia_perdida" class="nav-link nav-toggle">
                                            <i class="fa fa-archive"></i>
                                            <span class="title">Balance ganancia perdida</span>


                                            
                                            <span class="badge"><i class="fa fa-print"></i></span>
                                            
                                        </a>
                                    </li>                      
                                    
                                    

                            <?php } ?>   

                                <!-- encabezado Entornos -->     
                            <?php //if ($id_perfil==1) { ?>    
                            <?php //if (($id_perfil==1) || ($id_perfil==2) || ($id_perfil==3) ) { ?>   
                            <?php if ( ( $this->session->userdata( 'id_perfil' ) == 1  ) || (in_array(1, $coleccion_id_operaciones)) ) { ?>    
                                    <li class="heading">
                                        <h3 class="uppercase">Entornos</h3>
                                    </li>
                                    

                                    <li class="nav-item  ">
                                        <a href="<?php echo base_url(); ?>entornos" class="nav-link nav-toggle">
                                            <i class="fa fa-server"></i>
                                            <span class="title">Listado</span>
                                            <span class="badge badge-success"><i class="fa fa-eye"></i></span>
                                        </a>
                                    </li>
                               
                                    <li class="nav-item">
                                        <a href="javascript:;" class="nav-link nav-toggle">
                                            <i class="fa fa-newspaper-o"></i>
                                            <span class="title">Detalles</span>
                                            <span class="arrow"></span>
                                        </a>
                                        <ul class="sub-menu">
                                            <?php if ($entornos) { ?>
                                                <?php foreach ($entornos as $entorno) { ?>
                                                    <li >
                                                    <li nombre="<?php echo base64_encode($entorno->entorno); ?>" 
                                                     identificador="<?php echo base64_encode($entorno->id); ?>" 
                                                     class="nav-item contexto_entorno"  data-toggle="contexto_entorno" data-target="#context-menu_entorno">                                                
                                                        <a href="<?php echo base_url(); ?>editar_entorno/<?php echo base64_encode($entorno->id); ?>" class="nav-link ">
                                                            <i class="fa fa-<?php echo ($entorno->dueno==1) ? 'unlock' : 'lock' ?>"></i>
                                                            <span class="title"><?php echo $entorno->entorno; ?></span>
                                                            <span class="badge badge-success"><?php echo $entorno->profundidad; ?></span>
                                                        </a>
                                                    </li>
                                                <?php } ?>    
                                            <?php } ?>        
                                        </ul>

                                    <!--menu contextual entorno-->
                                    <div id="context-menu_entorno" style="position: absolute; z-index: 9999; top: 423px; left: 350px;" class="">
                                        <ul class="dropdown-menu" role="menu">
                                           <li><a tabindex="-1" href="">Modificar</a></li>
                                           <li class="divider"></li>
                                           <li><a tabindex="-1" href="">Eliminar</a></li>
                                        </ul>
                                    </div>      


                                    </li>
                            <?php } ?>            

                               
                                <!-- encabezado Catalogos --> 

                            <?php if ( ( $this->session->userdata( 'id_perfil' ) == 1  ) || (in_array(4, $coleccion_id_operaciones)) ) { ?>    
                                    <li class="heading">

                                        <h3 class="uppercase">Catálogos</h3>
                                    </li>
                                    

                                    <li class="nav-item  ">
                                        <a href="<?php echo base_url(); ?>areas" class="nav-link nav-toggle">
                                            <i class="fa fa-archive"></i>
                                            <span class="title">Áreas</span>
                                            <span class="badge"><i class="fa fa-eye"></i></span>
                                            
                                        </a>
                                    </li>                                    

                                    <li class="nav-item  ">
                                        <a href="<?php echo base_url(); ?>cargos" class="nav-link nav-toggle">
                                            <i class="fa fa-archive"></i>
                                            <span class="title">Cargos</span>
                                            <span class="badge"><i class="fa fa-eye"></i></span>
                                            
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="<?php echo base_url(); ?>perfiles" class="nav-link nav-toggle">
                                            <i class="fa fa-archive"></i>
                                            <span class="title">Roles</span>
                                            <span class="badge"><i class="fa fa-eye"></i></span>
                                            
                                        </a>
                                    </li>              

                                    <li class="nav-item  ">
                                        <a href="<?php echo base_url(); ?>configuraciones" class="nav-link nav-toggle">
                                            <i class="fa fa-archive"></i>
                                            <span class="title">Configuraciones</span>
                                            <span class="badge"><i class="fa fa-eye"></i></span>
                                            
                                        </a>
                                    </li>
                                    
                            <?php } ?>            


                            </ul>
                            <!-- END SIDEBAR MENU -->
                        <!-- END SIDEBAR MENU -->
                    </div>
                    <!-- END SIDEBAR -->
                </div>
                <!-- END SIDEBAR -->
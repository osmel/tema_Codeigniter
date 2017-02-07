<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>


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
                        
                        <!-- Buscador -->
                                <li class="sidebar-search-wrapper">
                                    <!-- BEGIN RESPONSIVE QUICK SEARCH FORM -->
                                    <!-- DOC: Apply "sidebar-search-bordered" class the below search form to have bordered search box -->
                                    <!-- DOC: Apply "sidebar-search-bordered sidebar-search-solid" class the below search form to have bordered & solid search box -->
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
                                    <!-- END RESPONSIVE QUICK SEARCH FORM -->
                                </li>
                        <!-- Fin del buscador -->        

                        <!-- Dashboard -->       
                                <li class="nav-item start active open">
                                    <a href="javascript:;" class="nav-link nav-toggle">
                                        <i class="icon-home"></i>
                                        <span class="title">Inicio</span>
                                        <span class="selected"></span>
                                        <span class="arrow open"></span>
                                    </a>
                                    <ul class="sub-menu">
                                        <li class="nav-item start active open">
                                            <a href="index.html" class="nav-link ">
                                                <i class="icon-bar-chart"></i>
                                                <span class="title">Inicio</span>
                                                <span class="selected"></span>
                                            </a>
                                        </li>
                                        
                                    </ul>
                                </li>
                        <!-- Fin del dashboard-->        

                        <!-- encabezado Caracteristicas -->        
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
                             <!-- Fin Caracteristicas -->     
                                
                                
                                <!-- encabezado Caracteristicas -->        
                                <li class="heading">
                                    <h3 class="uppercase">Usuarios</h3>
                                </li>
                                
                           
                                <li class="nav-item">
                                    <a href="javascript:;" class="nav-link nav-toggle">
                                        <i class="icon-user"></i>
                                        <span class="title">Listados</span>
                                        <span class="arrow"></span>
                                    </a>
                                    <ul class="sub-menu">
                                        <?php foreach ($usuarios as $usuario) { ?>
                                            <li class="nav-item  ">
                                                <a href="<?php echo base_url(); ?>editar_usuario/<?php echo $usuario->id; ?>" class="nav-link ">
                                                    <i class="icon-user"></i>
                                                    <span class="title"><?php echo $usuario->nombre.' '.$usuario->apellidos; ?></span>
                                                    <span class="badge badge-success">6</span>
                                                </a>
                                            </li>
                                        <?php } ?>    
                                    </ul>

                                </li>

                                <li class="nav-item  ">
                                    <a href="#" class="nav-link nav-toggle">
                                        <i class="icon-users"></i>
                                        <span class="title">Perfiles</span>                                        
                                    </a>
                                </li>
                                
                                <!-- http://keenthemes.com/preview/metronic/theme/admin_4/ui_icons.html-->
                                <li class="nav-item  ">
                                    <a href="#" class="nav-link nav-toggle">
                                        <i class="fa fa-user-plus" ></i>
                                        <span class="title">Agregar nuevo</span>                                        
                                    </a>
                                </li>

                               <li class="nav-item  ">
                                    <a href="#" class="nav-link nav-toggle">
                                        <i class="fa fa-history"></i>
                                        <span class="title">Histórico de accesos</span>
                                    </a>
                                </li>
                                
                                
                             <!-- Fin Caracteristicas --> 





                            <!-- encabezado Caracteristicas -->        
                            <li class="heading">
                                    <h3 class="uppercase">Catalogo de Proyectos</h3>
                                </li>
                                
                                <li class="nav-item  ">
                                    <a href="<?php echo base_url(); ?>crear_proyecto" class="nav-link nav-toggle">
                                        <i class="fa fa-history"></i>
                                        <span class="title">Crear Proyecto</span>
                                        <span class="badge badge-success">6</span>
                                    </a>
                                </li>


                            </ul>
                            <!-- END SIDEBAR MENU -->
                        <!-- END SIDEBAR MENU -->
                    </div>
                    <!-- END SIDEBAR -->
                </div>
                <!-- END SIDEBAR -->
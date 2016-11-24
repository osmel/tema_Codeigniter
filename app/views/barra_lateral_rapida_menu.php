<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<!-- Barra lateral rapida de menu que esta esquiza derecha superior BEGIN QUICK SIDEBAR -->
                <a href="javascript:;" class="page-quick-sidebar-toggler">
                    <i class="icon-login"></i>
                </a>
                <div class="page-quick-sidebar-wrapper" data-close-on-body-click="false">
                    <!-- cabecera y contenido-->
                        <div class="page-quick-sidebar">
                            <!--Cabecera -->
                            <ul class="nav nav-tabs">
                                <li class="active">
                                    <a href="javascript:;" data-target="#quick_sidebar_tab_1" data-toggle="tab"> Usuarios
                                        <span class="badge badge-danger">2</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:;" data-target="#quick_sidebar_tab_2" data-toggle="tab"> Alertas
                                        <span class="badge badge-success">7</span>
                                    </a>
                                </li>
                                <li class="dropdown">
                                    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown"> Mas
                                        <i class="fa fa-angle-down"></i>
                                    </a>
                                    <ul class="dropdown-menu pull-right">
                                        <li>
                                            <a href="javascript:;" data-target="#quick_sidebar_tab_3" data-toggle="tab">
                                                <i class="icon-bell"></i> Alertas </a>
                                        </li>
                                        <li>
                                            <a href="javascript:;" data-target="#quick_sidebar_tab_3" data-toggle="tab">
                                                <i class="icon-info"></i> Notificaciones </a>
                                        </li>
                                        <li>
                                            <a href="javascript:;" data-target="#quick_sidebar_tab_3" data-toggle="tab">
                                                <i class="icon-speech"></i> Actividades </a>
                                        </li>
                                        <li class="divider"></li>
                                        <li>
                                            <a href="javascript:;" data-target="#quick_sidebar_tab_3" data-toggle="tab">
                                                <i class="icon-settings"></i> Configuraciones </a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                            <!--Fin de la Cabecera -->

                            <!--Contenido -->
                                <div class="tab-content">
                                    
                                    <!-- Pagina Usuarios -->
                                        <div class="tab-pane active page-quick-sidebar-chat" id="quick_sidebar_tab_1">
                                            <!-- 1ra pagina Usuarios -->
                                                <div class="page-quick-sidebar-chat-users" data-rail-color="#ddd" data-wrapper-class="page-quick-sidebar-list">
                                                    <h3 class="list-heading">Staff</h3>
                                                    <ul class="media-list list-items">
                                                        <li class="media">
                                                            <div class="media-status">
                                                                <span class="badge badge-success">8</span>
                                                            </div>
                                                            <img class="media-object" src="../assets/layouts/layout/img/avatar3.jpg" alt="...">
                                                            <div class="media-body">
                                                                <h4 class="media-heading">Osmel Calderón</h4>
                                                                <div class="media-heading-sub"> desarrollador de proyectos </div>
                                                            </div>
                                                        </li>
                                                        
                                                    </ul>
                                                    <h3 class="list-heading">Personalizados</h3>
                                                    <ul class="media-list list-items">
                                                        <li class="media">
                                                            <div class="media-status">
                                                                <span class="badge badge-warning">2</span>
                                                            </div>
                                                            <img class="media-object" src="../assets/layouts/layout/img/avatar6.jpg" alt="...">
                                                            <div class="media-body">
                                                                <h4 class="media-heading">Adrian Guerrero</h4>
                                                                <div class="media-heading-sub"> Director General </div>
                                                                <div class="media-heading-small"> Ultima vez 03:10 AM </div>
                                                            </div>
                                                        </li>
                                                        <li class="media">
                                                            <div class="media-status">
                                                                <span class="label label-sm label-success">new</span>
                                                            </div>
                                                            <img class="media-object" src="../assets/layouts/layout/img/avatar7.jpg" alt="...">
                                                            <div class="media-body">
                                                                <h4 class="media-heading">Ulises Flores</h4>
                                                                <div class="media-heading-sub"> Director de proyectos,
                                                                    <br> estrategas digitales </div>
                                                            </div>
                                                        </li>
                                                        
                                                    </ul>
                                                </div>
                                            <!-- Fin 1ra pagina Usuarios -->

                                            <!-- 2da pagina Usuarios -->
                                                <div class="page-quick-sidebar-item">
                                                    <div class="page-quick-sidebar-chat-user">
                                                        <div class="page-quick-sidebar-nav">
                                                            <a href="javascript:;" class="page-quick-sidebar-back-to-list">
                                                                <i class="icon-arrow-left"></i>Atrás</a>
                                                        </div>
                                                        <div class="page-quick-sidebar-chat-user-messages">
                                                            <div class="post out">
                                                                <img class="avatar" alt="" src="../assets/layouts/layout/img/avatar3.jpg" />
                                                                <div class="message">
                                                                    <span class="arrow"></span>
                                                                    <a href="javascript:;" class="name">Ulises Flores</a>
                                                                    <span class="datetime">20:15</span>
                                                                    <span class="body"> Cuando usted puede enviar un reporte? </span>
                                                                </div>
                                                            </div>
                                                            <div class="post in">
                                                                <img class="avatar" alt="" src="../assets/layouts/layout/img/avatar2.jpg" />
                                                                <div class="message">
                                                                    <span class="arrow"></span>
                                                                    <a href="javascript:;" class="name">Adrian Guerrero</a>
                                                                    <span class="datetime">20:15</span>
                                                                    <span class="body"> En estos momentos estoy almorzando.</span>
                                                                </div>
                                                            </div>
                                                            <div class="post out">
                                                                <img class="avatar" alt="" src="../assets/layouts/layout/img/avatar3.jpg" />
                                                                <div class="message">
                                                                    <span class="arrow"></span>
                                                                    <a href="javascript:;" class="name">Ulises Flores</a>
                                                                    <span class="datetime">20:15</span>
                                                                    <span class="body"> Ahora. gracias! :) </span>
                                                                </div>
                                                            </div>
                                                           
                                                        </div>
                                                        <div class="page-quick-sidebar-chat-user-form">
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" placeholder="Type a message here...">
                                                                <div class="input-group-btn">
                                                                    <button type="button" class="btn green">
                                                                        <i class="icon-paper-clip"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <!-- Fin 2da pagina Usuarios -->
                                        </div>
                                    <!-- Fin Pagina Usuarios -->

                                    <!-- Pagina de Alertas -->
                                        <div class="tab-pane page-quick-sidebar-alerts" id="quick_sidebar_tab_2">
                                            <div class="page-quick-sidebar-alerts-list">
                                                <h3 class="list-heading">General</h3>
                                                <ul class="feeds list-items">
                                                   
                                                    <li>
                                                        <div class="col1">
                                                            <div class="cont">
                                                                <div class="cont-col1">
                                                                    <div class="label label-sm label-info">
                                                                        <i class="fa fa-check"></i>
                                                                    </div>
                                                                </div>
                                                                <div class="cont-col2">
                                                                    <div class="desc"> Tienes 4 tareas pendientes
                                                                        <span class="label label-sm label-warning "> Toma acción
                                                                            <i class="fa fa-share"></i>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col2">
                                                            <div class="date"> Justo Ahora </div>
                                                        </div>
                                                    </li>

                                                    <li>
                                                        <a href="javascript:;">
                                                            <div class="col1">
                                                                <div class="cont">
                                                                    <div class="cont-col1">
                                                                        <div class="label label-sm label-success">
                                                                            <i class="fa fa-bar-chart-o"></i>
                                                                        </div>
                                                                    </div>
                                                                    <div class="cont-col2">
                                                                        <div class="desc"> Las torres gemelas.... </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col2">
                                                                <div class="date"> Hace 20 mins </div>
                                                            </div>
                                                        </a>
                                                    </li>

                                                    
                                                </ul>

                                                <h3 class="list-heading">Sistema</h3>
                                                <ul class="feeds list-items">
                                                    <li>
                                                        <a href="javascript:;">
                                                            <div class="col1">
                                                                <div class="cont">
                                                                    <div class="cont-col1">
                                                                        <div class="label label-sm label-danger">
                                                                            <i class="fa fa-bar-chart-o"></i>
                                                                        </div>
                                                                    </div>
                                                                    <div class="cont-col2">
                                                                        <div class="desc"> El sistema esta en proceso
                                                                             <span class="label label-sm label-success "> Checalo </span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col2">
                                                                <div class="date"> 20 mins </div>
                                                            </div>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>

                                    <!--fin de pagina Alerta-->

                                    <!--Pagina Más-->
                                        <div class="tab-pane page-quick-sidebar-settings" id="quick_sidebar_tab_3">
                                            <div class="page-quick-sidebar-settings-list">
                                                <h3 class="list-heading">General Settings</h3>
                                                <ul class="list-items borderless">
                                                    <li> Habilitar Notificaciones
                                                        <input type="checkbox" class="make-switch" checked data-size="small" data-on-color="success" data-on-text="ON" data-off-color="default" data-off-text="OFF"> </li>
                                                    <li> Permitir Control
                                                        <input type="checkbox" class="make-switch" data-size="small" data-on-color="info" data-on-text="ON" data-off-color="default" data-off-text="OFF"> </li>
                                                </ul>

                                                <h3 class="list-heading">Configuración Sistema</h3>
                                                <ul class="list-items borderless">
                                                    <li> Nivel de seguridad
                                                        <select class="form-control input-inline input-sm input-small">
                                                            <option value="1">Normal</option>
                                                            <option value="2" selected>Medio</option>
                                                            <option value="e">Alto</option>
                                                        </select>
                                                    </li>
                                                    <li> SMTP Port
                                                        <input class="form-control input-inline input-sm input-small" value="3560" /> </li>
                                                    <li> Notificación de error
                                                        <input type="checkbox" class="make-switch" checked data-size="small" data-on-color="warning" data-on-text="ON" data-off-color="default" data-off-text="OFF"> </li>
                                                </ul>
                                                <div class="inner-content">
                                                    <button class="btn btn-success">
                                                        <i class="icon-settings"></i> Guardar Cambios</button>
                                                </div>
                                            </div>
                                        </div>
                                    <!--Fin Pagina Más-->    
                                </div>
                            <!--Fin del Contenido-->        
                        </div>
                    <!-- cabecera y contenido-->
                </div>
                <!-- END QUICK SIDEBAR -->

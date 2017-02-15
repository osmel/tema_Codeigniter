<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<!-- Comienzo de HEADER --> 
        <div class="page-header navbar navbar-fixed-top">
            <!-- Comienzo de HEADER interno--> 
                <div class="page-header-inner ">
                   <!-- Comienzo LOGO --> 
                        <div class="page-logo">
                             
                            <a href="index.html"> <!-- LOGO --> 
                                <img src="<?php echo base_url(); ?>img/logo.png" alt="logo" class="logo-default" /> 
                            </a>

                            <div class="menu-toggler sidebar-toggler"> <!-- menu toggler --> 
                                <span></span>
                            </div>
                        </div>
                    <!-- FIN LOGO -->
    
                    
                     <!-- Comienzo RESPONSIVE del MENU TOGGLER --> 
                        <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">
                            <span></span>
                        </a>
                     <!-- FIN RESPONSIVE del MENU TOGGLER --> 


                    <!-- Comienzo menu de navegacion de arriba top BEGIN TOP NAVIGATION MENU -->
                        <div class="top-menu">
                            <ul class="nav navbar-nav pull-right">



                                <!-- (Entornos)  -->
                                    <li class="dropdown dropdown-user">
                                        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                            <span class="badge badge-danger">  <?php echo $entornos[0]->profundidad_activo; ?> </span>
                                            <span class="username username-hide-on-mobile"> <?php echo $entornos[0]->nombre_activo; ?> </span>
                                            <i class="fa fa-angle-down"></i>

                                        </a>
                                        <ul class="dropdown-menu dropdown-menu-default">
                                           
                                            <?php foreach ($entornos as $entorno) { ?>
                                                <li>
                                                    <a href="<?php echo base_url(); ?>cambio_entorno/<?php echo base64_encode($entorno->id); ?>" >
                                                        <?php echo $entorno->entorno; ?>
                                                        <span class="badge badge-success"> <?php echo $entorno->profundidad; ?> </span>
                                                    </a>
                                                </li>
                                            <?php } ?>    

                                        </ul>
                                    </li>
                               <!-- (Fin de Entornos)  -->


                                
                                <!--(2) Comienzo DROPDOWN(desplegables) -->
                               
                                    <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                                    <li class="dropdown dropdown-extended dropdown-notification" id="header_notification_bar">
                                        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                            <i class="icon-bell"></i>
                                            <span class="badge badge-default"> 2 </span>
                                        </a>

                                        <ul class="dropdown-menu">
                                            <li class="external">
                                                <h3>
                                                    <span class="bold">2 pend.</span> Notificaciones</h3>
                                                <a href="page_user_profile_1.html">Mostrar todos</a>
                                            </li>
                                            <li>
                                                <ul class="dropdown-menu-list scroller" style="height: 250px;" data-handle-color="#637283">
                                                    <li>
                                                        <a href="javascript:;">
                                                            <span class="time">just now</span>
                                                            <span class="details">
                                                                <span class="label label-sm label-icon label-success">
                                                                    <i class="fa fa-plus"></i>
                                                                </span> Nuevo Usuario Registrado. </span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:;">
                                                            <span class="time">3 mins</span>
                                                            <span class="details">
                                                                <span class="label label-sm label-icon label-danger">
                                                                    <i class="fa fa-bolt"></i>
                                                                </span> Servidor Funcionando. </span>
                                                        </a>
                                                    </li>
                                                    
                                                    
                                                </ul>
                                            </li>
                                        </ul>
                                    </li>

                                <!-- Fin NOTIFICATION desplegables(DROPDOWN) -->


                                <!-- (3) COmienzo mensajeria desplegable(DROPDOWN) -->
                                    <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                                    <li class="dropdown dropdown-extended dropdown-inbox" id="header_inbox_bar">
                                        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                            <i class="icon-envelope-open"></i>
                                            <span class="badge badge-default"> 3</span>
                                        </a>
                                        <ul class="dropdown-menu">
                                            <li class="external">
                                                <h3>Tienes
                                                    <span class="bold">1 Nuevo</span> Mensaje</h3>
                                                <a href="app_inbox.html">Ver Todos</a>
                                            </li>
                                            <li>
                                                <ul class="dropdown-menu-list scroller" style="height: 275px;" data-handle-color="#637283">
                                                    <li>
                                                        <a href="#">
                                                            <span class="photo">
                                                                <img src="<?php echo base_url(); ?>js/assets/layouts/layout3/img/avatar3.jpg" class="img-circle" alt=""> </span>
                                                            <span class="subject">
                                                                <span class="from"> Ulises Flores </span>
                                                                <span class="time">Justo Ahora </span>
                                                            </span>
                                                            <span class="message"> Es un personaje de la edad media... </span>
                                                        </a>
                                                    </li>
                                                    
                                                    
                                                </ul>
                                            </li>
                                        </ul>
                                    </li>
                                <!-- END INBOX DROPDOWN -->



                                <!-- (3)  Comienzo tarea desplegable(DROPDOWN) -->
                                    <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                                    <li class="dropdown dropdown-extended dropdown-tasks" id="header_task_bar">
                                        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                            <i class="icon-calendar"></i>
                                            <span class="badge badge-default"> 2 </span>
                                        </a>
                                        <ul class="dropdown-menu extended tasks">
                                            <li class="external">
                                                <h3>Tu Tiene
                                                    <span class="bold">2 pend</span> Tarea</h3>
                                                <a href="app_todo.html">Ver Todo</a>
                                            </li>
                                            <li>
                                                <ul class="dropdown-menu-list scroller" style="height: 275px;" data-handle-color="#637283">
                                                    <li>
                                                        <a href="javascript:;">
                                                            <span class="task">
                                                                <span class="desc">Nueva versión 3.4 </span>
                                                                <span class="percent">40%</span>
                                                            </span>
                                                            <span class="progress">
                                                                <span style="width: 40%;" class="progress-bar progress-bar-success" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100">
                                                                    <span class="sr-only">40% Completo</span>
                                                                </span>
                                                            </span>
                                                        </a>
                                                    </li>
                                                    
                                                    <li>
                                                        <a href="javascript:;">
                                                            <span class="task">
                                                                <span class="desc">Database migration</span>
                                                                <span class="percent">10%</span>
                                                            </span>
                                                            <span class="progress">
                                                                <span style="width: 10%;" class="progress-bar progress-bar-warning" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100">
                                                                    <span class="sr-only">10% Complete</span>
                                                                </span>
                                                            </span>
                                                        </a>
                                                    </li>
                                                    
                                                </ul>
                                            </li>
                                        </ul>
                                    </li>
                                <!-- END TODO DROPDOWN -->


                                <!-- (Usuarios) BEGIN USER LOGIN DROPDOWN -->
                                <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                                    <li class="dropdown dropdown-user">
                                        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                            <img alt="" class="img-circle" src="<?php echo base_url(); ?>js/assets/layouts/layout/img/avatar3_small.jpg" />
                                            <span class="username username-hide-on-mobile"> Nick </span>
                                            <i class="fa fa-angle-down"></i>
                                        </a>
                                        <ul class="dropdown-menu dropdown-menu-default">
                                            <li>
                                                <a href="page_user_profile_1.html">
                                                    <i class="icon-user"></i> Mi perfil </a>
                                            </li>
                                            
                                            <li>
                                                <a href="app_inbox.html">
                                                    <i class="icon-envelope-open"></i> Mis Mensajes
                                                    <span class="badge badge-danger"> 3 </span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="app_todo.html">
                                                    <i class="icon-rocket"></i> Mis tareas
                                                    <span class="badge badge-success"> 7 </span>
                                                </a>
                                            </li>
                                            <li class="divider"> </li>
                                            
                                            <li>
                                                <a href="/salir">
                                                    <i class="icon-key"></i> Salir </a>
                                            </li>
                                        </ul>
                                    </li>
                                <!-- END USER LOGIN DROPDOWN -->


                                <!--(resumen de derecha) BEGIN QUICK SIDEBAR TOGGLER -->
                                    <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                                    <li class="dropdown dropdown-quick-sidebar-toggler">
                                        <a href="javascript:;" class="dropdown-toggle">
                                            <i class="icon-logout"></i>
                                        </a>
                                    </li>
                                <!-- END QUICK SIDEBAR TOGGLER -->
                            </ul>
                            
                        </div>

                    <!-- FIN menu de navegacion de arriba top END TOP NAVIGATION MENU -->

                </div>
            <!-- Fin de HEADER interno--> 
        </div>
<!-- Fin de HEADER --> 

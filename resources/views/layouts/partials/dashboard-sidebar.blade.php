        <!-- ========== Left Sidebar Start ========== -->
        <div class="left side-menu">
            <div class="slimscroll-menu" id="remove-scroll">

                <!--- Sidemenu -->
                <div id="sidebar-menu">
                    <!-- Left Menu Start -->
                    <ul class="metismenu" id="side-menu">
                        <li class="menu-title">Menu</li>
                        <li>
                            <a href="index.html" class="waves-effect">
                                <i class="icon-accelerator"></i><span class="badge badge-success badge-pill float-right">9+</span> <span> Dashboard </span>
                            </a>
                        </li>

                        
                        @role('superadmin')
                        <!-- ROLE start-->
                        <li>
                            <a href="javascript:void(0);" class="waves-effect"><i class="icon-mail-open"></i><span> ROLE <span class="float-right menu-arrow"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                            <ul class="submenu">
                                <li><a href="{{ route('roles.index') }}"> {{ __('Show All Roles') }}</a></li>
                                <li><a href="{{ route('roles.create') }}"> {{ __('Role Create') }}</a></li>
                            </ul>
                        </li>
                        <!-- Role end -->
                        
                        <!-- Permission start-->
                        <li>
                            <a href="javascript:void(0);" class="waves-effect"><i class="icon-mail-open"></i><span> PERMISSION <span class="float-right menu-arrow"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                            <ul class="submenu">
                                <li><a href="{{ route('permission.index') }}"> {{ __('Show All Permissions') }}</a></li>
                                <li><a href="{{ route('permission.create') }}"> {{ __('Permission Create') }}</a></li>
                            </ul>
                        </li>
                        <!-- Permission end -->

                        <!-- User Type start-->
                        <li>
                            <a href="javascript:void(0);" class="waves-effect"><i class="icon-mail-open"></i><span> USER TYPE <span class="float-right menu-arrow"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                            <ul class="submenu">
                                <li><a href="{{ route('UserType.index') }}"> {{ __('Show All User Type') }}</a></li>
                                <li><a href="{{ route('UserType.create') }}"> {{ __('Create User Type') }}</a></li>
                            </ul>
                        </li>
                        <!-- User Type end -->

                         <!-- Class start-->
                         <li>
                            <a href="javascript:void(0);" class="waves-effect"><i class="icon-mail-open"></i><span> Class <span class="float-right menu-arrow"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                            <ul class="submenu">
                                <li><a href="{{ route('class.index') }}"> {{ __('Show All Class') }}</a></li>
                                <li><a href="{{ route('class.create') }}"> {{ __('Create Class ') }}</a></li>
                            </ul>
                        </li>
                        <!-- Class end -->

                        <!-- Subject start-->
                        <li>
                            <a href="javascript:void(0);" class="waves-effect"><i class="icon-mail-open"></i><span> Subject <span class="float-right menu-arrow"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                            <ul class="submenu">
                                <li><a href="{{ route('subject.index') }}"> {{ __('Show All Subject') }}</a></li>
                                <li><a href="{{ route('subject.create') }}"> {{ __('Create Subject ') }}</a></li>
                            </ul>
                        </li>
                        <!-- Subject end -->
                       
                        @endrole

                        
                         

                        <!-- user start -->
                        <li>
                            <a href="javascript:void(0);" class="waves-effect"><i class="icon-pencil-ruler"></i> <span> USER <span class="float-right menu-arrow"><i class="mdi mdi-chevron-right"></i></span> </span> </a>
                            <ul class="submenu">
                                <li><a href="{{ route('user.index') }}"> {{ __('Show All Users') }}</a></li>
                                <li><a href="{{ route('user.create') }}"> {{ __('Create User') }}</a></li>
                                
                            </ul>
                        </li>
                        <!-- user end -->

                      
                        
                        <li class="menu-title">Components</li>

                        <li>
                            <a href="javascript:void(0);" class="waves-effect"><i class="icon-pencil-ruler"></i> <span> UI Elements <span class="float-right menu-arrow"><i class="mdi mdi-chevron-right"></i></span> </span> </a>
                            <ul class="submenu">
                                <li><a href="ui-alerts.html">Alerts</a></li>
                                <li><a href="ui-badge.html">Badge</a></li>
                                <li><a href="ui-buttons.html">Buttons</a></li>
                                <li><a href="ui-grid.html">Grid</a></li>
                            </ul>
                        </li>

                        
                        <li>
                            <a href="javascript:void(0);" class="waves-effect"><i class="icon-share"></i><span> Multi Level <span class="float-right menu-arrow"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                            <ul class="submenu">
                                <li><a href="javascript:void(0);"> Menu 1</a></li>
                                <li>
                                    <a href="javascript:void(0);">Menu 2  <span class="float-right menu-arrow"><i class="mdi mdi-chevron-right"></i></span></a>
                                    <ul class="submenu">
                                        <li><a href="javascript:void(0);">Menu 2.1</a></li>
                                        <li><a href="javascript:void(0);">Menu 2.1</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>

                    </ul>

                </div>
                <!-- Sidebar -->
                <div class="clearfix"></div>

            </div>
            <!-- Sidebar -left -->

        </div>
        <!-- Left Sidebar End -->
<!-- Top Bar Start -->
<div class="topbar">

<!-- LOGO -->
<div class="topbar-left">
    <a href="index.html" class="logo">
        <span class="logo-light">
                <i class="mdi mdi-camera-control"></i> advantedge tcms
            </span>
        <span class="logo-sm">
                <i class="mdi mdi-camera-control"></i>
            </span>
    </a>
</div>

<nav class="navbar-custom">
    <ul class="navbar-right list-inline float-right mb-0">

        <!-- full screen -->
        <li class="dropdown notification-list list-inline-item d-none d-md-inline-block">
            <a class="nav-link waves-effect" href="#" id="btn-fullscreen">
                <i class="mdi mdi-arrow-expand-all noti-icon"></i>
            </a>
        </li>
        <!-- full screen end-->
        
        <li class="dropdown notification-list list-inline-item">
            <div class="dropdown notification-list nav-pro-img">
                
                <a class="dropdown-toggle nav-link arrow-none nav-user" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                    @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                            
                                <button class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition duration-150 ease-in-out">
                                    <img class="h-8 w-8 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                                    
                                </button>
                            
                            @else
                                <span class="inline-flex rounded-md">
                                    <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                        {{ Auth::user()->name }}

                                        <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </span>
                    @endif
                </a>
                
                <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                    <!-- item-->
                    <a class="dropdown-item" href="{{ route('profile.show') }}"><i class="mdi mdi-account-circle"></i> Profile</a>
                    <div class="dropdown-divider"></div>

                 <!-- Authentication -->
                 <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <a class="dropdown-item text-danger" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                this.closest('form').submit();"><i class="mdi mdi-power text-danger"></i> Logout</a>

                 </form>
                 <div class="dropdown-divider"></div>
        
        
            @foreach (Auth::user()->allTeams() as $team)
            @if($team->id == 1)
          <!-- team start -->
              @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                  <!-- Team Management -->
                  <div class="block px-4 py-2 text-xs text-gray-400">
                                        {{ __('Manage Team') }}
                  </div>  

                  <!-- Team Settings -->
                  <a class="dropdown-item" href="{{ route('teams.show', Auth::user()->currentTeam->id) }}"><i class="mdi mdi-account-circle"></i> {{ __('Team Settings') }}</a>

                  @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                            <a class="dropdown-item" href="{{ route('teams.create') }}"><i class="mdi mdi-account-circle"></i> {{ __('Create New Team') }}</a>
                  @endcan
                  <div class="dropdown-divider"></div>

                  <!-- Role Settings -->
                  <!-- <a class="dropdown-item" href="{{ route('roles.create') }}"><i class="mdi mdi-account-circle"></i> {{ __('Role Create') }}</a>
                  <div class="dropdown-divider"></div> -->

                  <!-- Team Switcher -->
                  <div class="block px-4 py-2 text-xs text-gray-400">
                                        {{ __('Switch Teams') }}
                  </div>
                  
                  @foreach (Auth::user()->allTeams() as $team)
                  <a class="dropdown-item" href="{{ route('teams.create') }}"><i class="mdi mdi-account-circle"></i> {{ $team->name }}</a>
                  @endforeach
                  
            @endif
         <!-- team end -->
            @endif
            @endforeach  
                 
                </div>

            </div>
        </li>

    </ul>

    <ul class="list-inline menu-left mb-0">
        <li class="float-left">
            <button class="button-menu-mobile open-left waves-effect">
                <i class="mdi mdi-menu"></i>
            </button>
        </li>
        <li class="d-none d-md-inline-block">
            <form role="search" class="app-search">
                <div class="form-group mb-0">
                    <input type="text" class="form-control" placeholder="Search..">
                    <button type="submit"><i class="fa fa-search"></i></button>
                </div>
            </form>
        </li>
    </ul>

</nav>

</div>
<!-- Top Bar End -->
<!-- Sidebar -->
<aside class="navbar navbar-vertical navbar-expand-lg">
    <div class="container-fluid">
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sidebar-menu" aria-controls="sidebar-menu" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <h1 class="navbar-brand navbar-brand-autodark">
        <a href="{{url('/dashboard')}}">
          <img src="{{asset('assets/favicon.png')}}" width="110" height="32" alt="Tabler" class="navbar-brand-image">
        </a>
      </h1>
      <div class="navbar-nav flex-row d-lg-none">
        <div class="nav-item dropdown">
          <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown" aria-label="Open user menu">
            <span class="avatar avatar-sm">{{substr(auth()->user()->name,0,2)}}</span>
            <div class="d-none d-xl-block ps-2">
              <div>{{auth()->user()->name}}</div>
              <div class="mt-1 small text-muted">{{auth()->user()->getRoleNames()[0]}}</div>
            </div>
          </a>
          <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
            <a href="{{route('profile.edit')}}" class="dropdown-item">Profile</a>
            <a href="" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modal-logout">Logout</a>
          </div>
        </div>
      </div>
      <div class="collapse navbar-collapse" id="sidebar-menu">
        <ul class="navbar-nav pt-lg-3">
          <li class="nav-item {{ Request()->is('dashboard') ? 'active' : '' }}">
            <a class="nav-link" href="{{url('/dashboard')}}" >
              <span class="nav-link-icon d-md-none d-lg-inline-block">
                <i class="ti ti-home icon"></i>
              </span>
              <span class="nav-link-title">
                Home
              </span>
            </a>
          </li>

          @foreach (HelperMenu::getMenu() as $key => $val)
            @if (auth()->user()->hasRole('Administrator') ||  auth()->user()->can($val->menu))
                <li class="nav-item {{$val->submenu ? 'dropdown' : ''}} {{ Request()->is($val->route ? $val->route : '') ? 'active' : '' }} {{ Request()->is($val->group ? $val->group : '') ? 'active' : '' }}">
                    <a class="nav-link {{$val->submenu ? 'dropdown-toggle' : ''}} {{ Request()->is($val->group ? $val->group : '') ? 'show' : '' }}" href="{{url($val->route ? $val->route : '#')}}" {{$val->submenu ? "data-bs-toggle=dropdown data-bs-auto-close=false role=button" : ""}} aria-expanded="{{ Request()->is($val->group ? $val->group : '') ? 'true' : 'false' }}">

                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <i class="{{$val->icon}} icon" style="font-size: 1.25rem"></i>
                        </span>
                        <span class="nav-link-title">
                            {{$val->menu}}
                        </span>
                    </a>
                    @if ($val->submenu)
                    <div class="dropdown-menu {{ Request()->is($val->group ? $val->group : '') ? 'show' : '' }}" {{ Request()->is($val->group ? $val->group : '') ? "data-bs-popper='static'" : '' }}>
                        <div class="dropdown-menu-columns">
                          <div class="dropdown-menu-column">
                            @foreach ($val->submenu as $k=>$v)
                            <a class="dropdown-item {{Request()->is($val->route ? $val->route : '') ? 'active' : ''}}" href="{{url($v->route)}}">
                                {{$v->submenu}}
                            </a>
                            @endforeach
                          </div>
                        </div>
                    </div>
                    @endif
                </li>
            @endif
          @endforeach

          @if (auth()->user()->hasRole('Administrator') && auth()->user()->can('Pengaturan'))
          <li class="nav-item dropdown {{ Request()->is('dashboard/pengaturan/*') ? 'active' : '' }}">
            <a class="nav-link dropdown-toggle {{ Request()->is('dashboard/pengaturan/*') ? 'show' : '' }}" href="#" data-bs-toggle="dropdown" data-bs-auto-close="false" role="button" aria-expanded="{{ Request()->is('dashboard/pengaturan/*') ? 'true' : 'false' }}" >
              <span class="nav-link-icon d-md-none d-lg-inline-block">
                <i class="ti ti-settings icon"></i>
              </span>
              <span class="nav-link-title">
                Pengaturan
              </span>
            </a>
            <div class="dropdown-menu {{ Request()->is('dashboard/pengaturan/*') ? 'show' : '' }}" {{ Request()->is('dashboard/pengaturan/*') ? "data-bs-popper='static'" : '' }}>
              <div class="dropdown-menu-columns">
                <div class="dropdown-menu-column">
                  <a class="dropdown-item {{ Request()->is('dashboard/pengaturan/menu-managemen') ? 'active' : '' }}" href="{{route('dashboardpengaturanmenuindex')}}">
                  Menu Manajemen
                  </a>
                  <a class="dropdown-item {{ Request()->is('dashboard/pengaturan/role-managemen') ? 'active' : '' }}" href="{{route('dashboardpengaturanroleindex')}}">
                    Role Management
                  </a>
                </div>
              </div>
            </div>
          </li>
          @endif
        </ul>
      </div>
    </div>
</aside>
<!-- Navbar -->
<header class="navbar navbar-expand-md d-none d-lg-flex d-print-none" >
    <div class="container-xl">
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu" aria-controls="navbar-menu" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="navbar-nav flex-row order-md-last">
        <div class="d-none d-md-flex">
          <div class="nav-item dropdown d-none d-md-flex me-3">
            <a href="#" class="nav-link px-0" data-bs-toggle="dropdown" tabindex="-1" aria-label="Show notifications">
              <!-- Download SVG icon from http://tabler-icons.io/i/bell -->
              <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 5a2 2 0 1 1 4 0a7 7 0 0 1 4 6v3a4 4 0 0 0 2 3h-16a4 4 0 0 0 2 -3v-3a7 7 0 0 1 4 -6" /><path d="M9 17v1a3 3 0 0 0 6 0v-1" /></svg>
              <span class="badge bg-red"></span>
            </a>
            <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-end dropdown-menu-card">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Notification</h3>
                </div>
                <div class="list-group list-group-flush list-group-hoverable">
                  <div class="list-group-item">
                    <div class="row align-items-center">
                      <div class="col-auto"><span class="status-dot status-dot-animated bg-red d-block"></span></div>
                      <div class="col text-truncate">
                        <a href="#" class="text-body d-block">Example 1</a>
                        <div class="d-block text-muted text-truncate mt-n1">
                          Change deprecated html tags to text decoration classes (#29604)
                        </div>
                      </div>
                      <div class="col-auto">
                        <a href="#" class="list-group-item-actions">
                          <!-- Download SVG icon from http://tabler-icons.io/i/star -->
                          <svg xmlns="http://www.w3.org/2000/svg" class="icon text-muted" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 17.75l-6.172 3.245l1.179 -6.873l-5 -4.867l6.9 -1l3.086 -6.253l3.086 6.253l6.9 1l-5 4.867l1.179 6.873z" /></svg>
                        </a>
                      </div>
                    </div>
                  </div>
                  <div class="list-group-item">
                    <div class="row align-items-center">
                      <div class="col-auto"><span class="status-dot d-block"></span></div>
                      <div class="col text-truncate">
                        <a href="#" class="text-body d-block">Example 2</a>
                        <div class="d-block text-muted text-truncate mt-n1">
                          justify-content:between ⇒ justify-content:space-between (#29734)
                        </div>
                      </div>
                      <div class="col-auto">
                        <a href="#" class="list-group-item-actions show">
                          <!-- Download SVG icon from http://tabler-icons.io/i/star -->
                          <svg xmlns="http://www.w3.org/2000/svg" class="icon text-yellow" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 17.75l-6.172 3.245l1.179 -6.873l-5 -4.867l6.9 -1l3.086 -6.253l3.086 6.253l6.9 1l-5 4.867l1.179 6.873z" /></svg>
                        </a>
                      </div>
                    </div>
                  </div>
                  <div class="list-group-item">
                    <div class="row align-items-center">
                      <div class="col-auto"><span class="status-dot d-block"></span></div>
                      <div class="col text-truncate">
                        <a href="#" class="text-body d-block">Example 3</a>
                        <div class="d-block text-muted text-truncate mt-n1">
                          Update change-version.js (#29736)
                        </div>
                      </div>
                      <div class="col-auto">
                        <a href="#" class="list-group-item-actions">
                          <!-- Download SVG icon from http://tabler-icons.io/i/star -->
                          <svg xmlns="http://www.w3.org/2000/svg" class="icon text-muted" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 17.75l-6.172 3.245l1.179 -6.873l-5 -4.867l6.9 -1l3.086 -6.253l3.086 6.253l6.9 1l-5 4.867l1.179 6.873z" /></svg>
                        </a>
                      </div>
                    </div>
                  </div>
                  <div class="list-group-item">
                    <div class="row align-items-center">
                      <div class="col-auto"><span class="status-dot status-dot-animated bg-green d-block"></span></div>
                      <div class="col text-truncate">
                        <a href="#" class="text-body d-block">Example 4</a>
                        <div class="d-block text-muted text-truncate mt-n1">
                          Regenerate package-lock.json (#29730)
                        </div>
                      </div>
                      <div class="col-auto">
                        <a href="#" class="list-group-item-actions">
                          <!-- Download SVG icon from http://tabler-icons.io/i/star -->
                          <svg xmlns="http://www.w3.org/2000/svg" class="icon text-muted" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 17.75l-6.172 3.245l1.179 -6.873l-5 -4.867l6.9 -1l3.086 -6.253l3.086 6.253l6.9 1l-5 4.867l1.179 6.873z" /></svg>
                        </a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="nav-item dropdown">
          <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown" aria-label="Open user menu">
            <span class="avatar avatar-sm">{{substr(auth()->user()->name,0,2)}}</span>
            <div class="d-none d-xl-block ps-2">
              <div>{{auth()->user()->name}}</div>
              <div class="mt-1 small text-muted">{{auth()->user()->getRoleNames()[0]}}</div>
            </div>
          </a>
          <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
            <a href="{{route('profile.edit')}}" class="dropdown-item">Profile</a>
            <a href="" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modal-logout">Logout</a>
          </div>
        </div>
      </div>
      <div class="collapse navbar-collapse" id="navbar-menu">
        <div>
          <form action="./" method="get" autocomplete="off" novalidate>
            <div class="input-icon">
              <span class="input-icon-addon">
                <!-- Download SVG icon from http://tabler-icons.io/i/search -->
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" /><path d="M21 21l-6 -6" /></svg>
              </span>
              <input type="text" value="" class="form-control" placeholder="Search…" aria-label="Search in website">
            </div>
          </form>
        </div>
      </div>
    </div>
</header>

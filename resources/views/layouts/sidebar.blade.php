<!-- Main Sidebar Container -->
<aside class="main-sidebar main-sidebar-custom sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
        <img src="/images/seal_laguna.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
            style="opacity: .8">
        <span class="brand-text font-weight-dark">CSS SYSTEM</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="/images/user_old.png" class=" img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</a>
            </div>
        </div>

        <!-- SidebarSearch Form -->
        {{-- <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div> --}}

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="/dashboard" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                            <i class="right fas"></i>
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-list-alt"></i>
                        <p>
                            View Surveys
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="/view/css" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>CSS</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/view/pss" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>PSS</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/view/csm" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>CSM</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-comment"></i>
                        <p>
                            Comments
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="/comments/css" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>CSS</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/comments/pss" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>PSS</p>
                            </a>
                        </li>
                        <!-- <li class="nav-item">
                            <a href="/comments/csm" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>CSM</p>
                            </a>
                        </li> -->

                    </ul>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-table"></i>
                        <p>
                            Import Surveys
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="/import/css" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>CSS</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/import/pss" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>PSS</p>
                            </a>
                        </li>
                        <!-- <li class="nav-item">
                            <a href="/import/csm" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>CSM</p>
                            </a>
                        </li> -->
                    </ul>
                </li>


                <!-- <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-list-alt"></i>
              <p>
                Import / Export
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="/view/css" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>CSS</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/view/pss" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>PSS</p>
                </a>
              </li>
            </ul>
          </li> -->

                {{-- <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-graduation-cap"></i>
              <p>
                Enrolled Courses
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="/dashboard" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>DATA SCIENCE 101</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/dashboard" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>CSS 101</p>
                </a>
              </li>
            </ul>
          </li> --}}


                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-wrench"></i>
                        <p>
                            Site Administration
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item menu">
                            <a href="/user" class="nav-link">
                                <i class="nav-icon fas fa-users"></i>
                                <p>
                                    User
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="/user" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Accounts</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item menu">
                            <a href="/services" class="nav-link">
                                <i class="nav-icon fas fa-clipboard"></i>
                                <p>
                                    Service
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="/services" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>CSS</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/services/csm" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>CSM</p>
                            </a>
                        </li>
                    </ul>
                        </li>
                        <li class="nav-item menu">
                            <a href="/hospital" class="nav-link">
                                <i class="nav-icon fas fa-hospital"></i>
                                <p>
                                    Hospital
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                        </li>
                        <li class="nav-item menu">
                            <a href="/doctor" class="nav-link">
                                <i class="nav-icon fas fa-user-md"></i>
                                <p>
                                    Doctor
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                        </li>
                        <li class="nav-item menu">
                            <a href="/office" class="nav-link">
                                <i class="nav-icon fas fa-building"></i>
                                <p>
                                    Office
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>

                            <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="/office" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>CSS</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/office/csm" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>CSM</p>
                            </a>
                        </li>
                    </ul>
                        </li>
                        <li class="nav-item menu">
                            <a href="/manager" class="nav-link">
                                <i class="nav-icon fas fa-user-circle"></i>
                                <p>
                                    Manager
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                        </li>
                        <li class="nav-item menu">
                            <a href="/chart_settings" class="nav-link">
                                <i class="nav-icon fas fa-cog"></i>
                                <p>
                                    Chart Settings
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- <li class="nav-header">Create Module</li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon far fa-circle text-danger"></i>
              <p class="text">Important</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon far fa-circle text-warning"></i>
              <p>Warning</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon far fa-circle text-info"></i>
              <p>Informational</p>
            </a>
          </li> -->
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->

    <!-- <div class="sidebar-custom">
      <a href="#" class="btn btn-link"><i class="fas fa-cogs"></i></a>
      <a href="#" class="btn btn-secondary hide-on-collapse pos-right">Help</a>
    </div> -->
    <!-- /.sidebar-custom -->
</aside>

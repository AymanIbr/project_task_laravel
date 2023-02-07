  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="index3.html" class="brand-link">
          <img src="{{ asset('BackEnd/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo"
              class="brand-image img-circle elevation-3" style="opacity: .8">
          <span class="brand-text font-weight-light">{{ __('store.dashboard') }}</span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
          <!-- Sidebar user panel (optional) -->
          <div class="user-panel mt-3 pb-3 mb-3 d-flex">
              <div class="image">
                  <img src="{{ asset('BackEnd/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2"
                      alt="User Image">
              </div>
              <div class="info">
                  <a href="#" class="d-block">{{Auth::user()->name}}</a>
              </div>
          </div>

          <!-- SidebarSearch Form -->
          <div class="form-inline">
              <div class="input-group" data-widget="sidebar-search">
                  <input class="form-control form-control-sidebar" type="search" placeholder="Search"
                      aria-label="Search">
                  <div class="input-group-append">
                      <button class="btn btn-sidebar">
                          <i class="fas fa-search fa-fw"></i>
                      </button>
                  </div>
              </div>
          </div>

          <!-- Sidebar Menu -->
          <nav class="mt-2">
              <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                  data-accordion="false">
                  <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                  <li class="nav-item menu-open">
                      <a href="#" class="nav-link active">
                          <i class="nav-icon fas fa-tachometer-alt"></i>
                          <p>
                              Starter Pages
                              <i class="right fas fa-angle-left"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                          <li class="nav-item">
                              <a href="#" class="nav-link active">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Active Page</p>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a href="#" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Inactive Page</p>
                              </a>
                          </li>
                      </ul>
                  </li>
                  @canany(['Create-Admin', 'Read-Admins', 'Create-User','Read-Users'])
                  <li class="nav-header">Human Resources</li>
                  @canany(['Create-Admin', 'Read-Admins'])
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      <i class="fas fa-user nav-icon"></i>
                      <p>
                        Admins
                        <i class="fas fa-angle-left right"></i>
                      </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @can('Create-Admin')
                        <li class="nav-item">
                            <a href="{{route('admins.create')}}" class="nav-link">
                              {{-- <i class="fas fa-plus-suquer"></i> --}}
                              <i class="far fa-plus-square nav-icon"></i>
                              <p>Create</p>
                            </a>
                          </li>
                          @endcan
                          @can('Read-Admins')
                        <li class="nav-item">
                            <a href="{{route('admins.index')}}" class="nav-link">
                                <i class="fas fa-list nav-icon"></i>
                              <p>Index</p>
                            </a>
                          </li>
                          @endcan
                    </ul>
                  </li>
                  @endcanany
                  @canany(['Create-User','Read-Users'])
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      <i class="fas fa-user nav-icon"></i>
                      <p>
                        Users
                        <i class="fas fa-angle-left right"></i>
                      </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @can('Create-User')
                        <li class="nav-item">
                            <a href="{{route('users.create')}}" class="nav-link">
                              {{-- <i class="fas fa-plus-suquer"></i> --}}
                              <i class="far fa-plus-square nav-icon"></i>
                              <p>Create</p>
                            </a>
                          </li>
                          @endcan
                          @can('Read-Users')
                        <li class="nav-item">
                            <a href="{{route('users.index')}}" class="nav-link">
                                <i class="fas fa-list nav-icon"></i>
                              <p>Index</p>
                            </a>
                          </li>
                          @endcan
                    </ul>
                  </li>
                  @endcanany
                  @endcanany
                  @canany(['Read-Roles', 'Create-Role', 'Create-Permission	','Read-Permissions'])
                  <li class="nav-header">Roles & Permissions</li>
                  @canany(['Read-Roles', 'Create-Role'])
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      <i class="fas fa-user-tag nav-icon"></i>
                      <p>
                        Roles
                        <i class="fas fa-angle-left right"></i>
                      </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @can('Create-Role')
                        <li class="nav-item">
                            <a href="{{route('roles.create')}}" class="nav-link">
                              <i class="far fa-plus-square nav-icon"></i>
                              <p>Create</p>
                            </a>
                          </li>
                          @endcan
                          @can('Read-Roles')
                        <li class="nav-item">
                            <a href="{{route('roles.index')}}" class="nav-link">
                                <i class="fas fa-list nav-icon"></i>
                              <p>Index</p>
                            </a>
                          </li>
                          @endcan
                    </ul>
                  </li>
                  @endcanany
                  @canany(['Create-Permission', 'Read-Permissions'])
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      <i class="fas fa-key nav-icon"></i>
                      <p>
                        Permissions
                        <i class="fas fa-angle-left right"></i>
                      </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @can('Create-Permission')
                        <li class="nav-item">
                            <a href="{{route('permissions.create')}}" class="nav-link">
                              {{-- <i class="fas fa-plus-suquer"></i> --}}
                              <i class="far fa-plus-square nav-icon"></i>
                              <p>Create</p>
                            </a>
                          </li>
                          @endcan
                          @can('Read-Permissions')
                        <li class="nav-item">
                            <a href="{{route('permissions.index')}}" class="nav-link">
                                <i class="fas fa-list nav-icon"></i>
                              <p>Index</p>
                            </a>
                          </li>
                          @endcan
                    </ul>
                  </li>
                  @endcanany
                  @endcanany
                  @canany(['Create-City', 'Read-Cities', 'Create-Category','Read-Categories','Create-Note','Read-Notes','Create-SubCategory','Read-SubCategories'])
                  <li class="nav-header">{{ __('store.content_management') }}</li>
                  @canany(['Create-City', 'Read-Cities'])
                  <li class="nav-item">
                      <a href="#" class="nav-link">
                          <i class="fas fa-map-marker-alt nav-icon"></i>
                          <p>
                             {{ __('store.cities') }}
                              <i class="fas fa-angle-left right"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                        @can('Create-City')
                          <li class="nav-item">
                              <a href="{{ route('cities.create') }}" class="nav-link">
                                  {{-- <i class="fas fa-plus-suquer"></i> --}}
                                  <i class="far fa-plus-square nav-icon"></i>
                                  <p>{{ __('store.create') }}</p>
                              </a>
                          </li>
                          @endcan
                          @can('Read-Cities')
                          <li class="nav-item">
                              <a href="{{ route('cities.index') }}" class="nav-link">
                                  <i class="fas fa-list nav-icon"></i>
                                  <p>{{ __('store.index') }}</p>
                              </a>
                          </li>
                          @endcan
                      </ul>
                  </li>
                  @endcanany
                  @canany(['Create-Note', 'Read-Notes'])
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fas fa-sticky-note  nav-icon"></i>
                        <p>
                           Note
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                      @can('Create-Note')
                        <li class="nav-item">
                            <a href="{{ route('notes.create') }}" class="nav-link">
                                {{-- <i class="fas fa-plus-suquer"></i> --}}
                                <i class="far fa-plus-square nav-icon"></i>
                                <p>Create</p>
                            </a>
                        </li>
                        @endcan
                        @can('Read-Notes')
                        <li class="nav-item">
                            <a href="{{ route('notes.index') }}" class="nav-link">
                                <i class="fas fa-list nav-icon"></i>
                                <p>index</p>
                            </a>
                        </li>
                        @endcan
                    </ul>
                </li>
                @endcanany
                @canany(['Create-SubCategory', 'Read-SubCategories'])
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fas fa-map-marker-alt nav-icon"></i>
                        <p>
                           Sub Categories
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                      @can('Create-SubCategory')
                        <li class="nav-item">
                            <a href="{{ route('sub-categories.create') }}" class="nav-link">
                                {{-- <i class="fas fa-plus-suquer"></i> --}}
                                <i class="far fa-plus-square nav-icon"></i>
                                <p>Create</p>
                            </a>
                        </li>
                        @endcan
                        @can('Read-SubCategories')
                        <li class="nav-item">
                            <a href="{{ route('sub-categories.index') }}" class="nav-link">
                                <i class="fas fa-list nav-icon"></i>
                                <p>Index</p>
                            </a>
                        </li>
                        @endcan
                    </ul>
                </li>
                @endcanany
                  @canany(['Create-Category','Read-Categories'])
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fas fa-layer-group nav-icon"></i>
                        <p>
                            Categories
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @can('Create-Category')
                        <li class="nav-item">
                            <a href="{{ route('categories.create') }}" class="nav-link">
                                {{-- <i class="fas fa-plus-suquer"></i> --}}
                                <i class="far fa-plus-square nav-icon"></i>
                                <p>Create</p>
                            </a>
                        </li>
                        @endcan
                        @can('Read-Categories')
                        <li class="nav-item">
                            <a href="{{ route('categories.index') }}" class="nav-link">
                                <i class="fas fa-list nav-icon"></i>
                                <p>Index</p>
                            </a>
                        </li>
                        @endcan
                    </ul>
                    @endcanany
                    @endcanany
                    <li class="nav-header">Settings</li>
                    <li class="nav-item">
                        <a href="{{route('change-password')}}" class="nav-link ">
                          <i class="nav-icon fas fa-lock"></i>
                          <p>
                            Change Password
                          </p>
                        </a>
                      </li>
                    <li class="nav-item">
                        <a href="{{route('logout')}}" class="nav-link ">
                          <i class="nav-icon fas fa-sign-out-alt"></i>
                          <p>
                            Logout
                          </p>
                        </a>
                      </li>
                </li>
              </ul>
          </nav>
          <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
  </aside>

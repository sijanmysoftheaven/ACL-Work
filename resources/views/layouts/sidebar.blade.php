<!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/permission/home" class="brand-link">
      <img src="{{asset ('dist/img/acl.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Access Control</span>
    </a>
    
                              

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      
                                
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{ asset('dist/img/user2.png')}}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="{{ route('users.profile') }}" class="d-block">{{ Auth::user()->name }}</a>
        </div>
      </div>



      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item menu-open">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                 @canany([$arrayUser['create'],$arrayUser['index'],$arrayUser['edit'],$arrayUser['delete'],$arrayUser['show']])
                <a href="{{ route('users.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>User Management</p>
                </a>
                @endcanany()
              </li>
              <li class="nav-item">
                @canany([$arrayProduct['create'],$arrayProduct['index'],$arrayProduct['edit'],$arrayProduct['delete'],$arrayProduct['show']])
                <a href="{{ route('products.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Product Management</p>
                </a>
                @endcanany()
              </li>
              <li class="nav-item">
                @canany([$arrayRole['create'],$arrayRole['index'],$arrayRole['edit'],$arrayRole['delete'],$arrayRole['show']])
                <a href="{{ route('roles.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Role Management</p>
                </a>
                @endcanany()
              </li>
              <li class="nav-item">
                @canany([$arrayPermission['create'],$arrayPermission['index'],$arrayPermission['edit'],$arrayPermission['delete'],$arrayPermission['show']])
                <a href="{{ route('permissions.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Permission Management</p>
                </a>
                @endcanany()
              </li>
            </ul>
          </li>
          <li class="nav-item dropdown">
             <a class="dropdown-item" href="{{ route('logout') }}"
                onclick="event.preventDefault();
                document.getElementById('logout-form').submit();">
                {{ __('Logout') }}
              </a>
              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
              </form>                      
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

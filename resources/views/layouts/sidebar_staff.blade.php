<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        {{-- <!-- Sidebar user panel (optional) -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{ URL::to('assets/img/user.png') }} " class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>{{ \Auth::user()->name  }}</p>
                <!-- Status -->
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div> --}}

        {{-- <!-- search form (Optional) -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search...">
                <span class="input-group-btn">
              <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
              </button>
            </span>
            </div>
        </form>
        <!-- /.search form --> --}}

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="{{ Request::is('/') ? 'active' : null }}"><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
            {{-- <li class="header"><i class="fa fa-circle-dot"></i> <span>Data Master</span></li>
            <!-- Optionally, you can add icons to the links -->
            <li class="{{ Request::is('users') ? 'active' : null }}"><a href="{{ url('users') }}"><i class="fa fa-users"></i> <span>Users</span></a></li>
            <li class="{{ Request::is('categories') ? 'active' : null }}"><a href="{{ url('categories') }}"><i class="fa fa-list"></i> <span>Category</span></a></li>
            <li class="{{ Request::is('products') ? 'active' : null }}"><a href="{{ url('products') }}"><i class="fa fa-cubes"></i> <span>Products</span></a></li>
            <li class="{{ Request::is('suppliers') ? 'active' : null }}"><a href="{{ url('suppliers') }}"><i class="fa fa-truck"></i> <span>Suppliers</span></a></li>
            <li class="{{ Request::is('customers') ? 'active' : null }}"><a href="{{ url('customers') }}"><i class="fa fa-users"></i> <span>Customers</span></a></li>
            <li class="{{ Request::is('customers') ? 'active' : null }}"><a href="{{ url('drivers') }}"><i class="fa fa-user"></i> <span>Drivers</span></a></li>
            <li class="{{ Request::is('customers') ? 'active' : null }}"><a href="{{ url('vehicles') }}"><i class="fa fa-car"></i> <span>Cars</span></a></li> --}}

             <li class="header"><i class="fa fa-circle-dot"></i> <span>Data Transaksi</span></li>
             <li class="{{ Request::is('productsIn') ? 'active' : null }}"><a href="{{ url('productsIn') }}"><i class="fa fa-plus"></i> <span>Product In</span></a></li>
             <li class="{{ Request::is('productsOut') ? 'active' : null }}"><a href="{{ url('productsOut') }}"><i class="fa fa-minus"></i> <span>Product Out</span></a></li>
            <li class="{{ Request::is('delivery') ? 'active' : null }}"><a href="{{ url('delivery') }}"><i class="fa fa-truck"></i> <span>Delivery Order</span></a></li>








        </ul>
        <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>

<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
    <div class="menu_section">
      <h3>General</h3>
      <ul class="nav side-menu">
        <li><a href="{{url('dashboard')}}"><i class="fa fa-home"></i> Dashboard</a></li>

        <li><a><i class="fa fa-edit"></i> Base Data <span class="fa fa-chevron-down"></span></a>
          <ul class="nav child_menu">
            @can('users.manage')
            <li><a href="{{url('userlist')}}">Users</a></li>
            @endcan
            <li><a href="{{url('departmentinfo')}}">Departments</a></li>
            <li><a href="{{url('employeeinfo')}}">Employee</a></li>
            <li><a href="{{url('locationinfo')}}">Locations</a></li>
            <li><a href="{{url('location-departments')}}">Location Department</a></li>
          </ul>
        </li>

        <li><a><i class="fa fa-desktop"></i> Inventory <span class="fa fa-chevron-down"></span></a>
          <ul class="nav child_menu">
            <li><a href="{{url('assetTypeInfo')}}">Asset Types</a></li>
            <li><a href="{{url('stocklist')}}">Stock</a></li>
            <li><a href="{{url('issuance')}}">Stock Issuance</a></li>
            <li><a href="{{url('stock-return')}}">Stock Return</a></li>
            <li><a href="{{url('issuance-history')}}">Issuance History</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>

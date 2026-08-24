@extends('common.master')
@section('content')
<div class="right_col bgimg" role="main" >
    <div class="">
      <div class="page-title">
        <div class="title_left">
          <h3>Lahore Waste Management Company</h3>
        </div>
      </div>

      <div class="clearfix"></div>

      <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel">
            <div class="x_title">
              <h2>Users</h2>
              <ul class="nav navbar-right panel_toolbox">
                @can('users.manage')
                <span class="input-group-btn">
                    <a href="{{url('add-user')}}" class="btn btn-primary"><span style="color: white;">Add New</span></a>
                  </span>
                @endcan
              </ul>
              <div class="clearfix"></div>
            </div>
            <div class="x_content">
              <table id="datatable-buttons" class="table table-striped table-bordered">
                <thead>
                  <tr>
                    <th>Sr.</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Created Date</th>
                    <th>Action</th>
                  </tr>
                </thead>
                @php $count = 0; @endphp
                <tbody>
                    @foreach ($userdata as $data)
                  <tr>
                    <td>{{++$count}}</td>
                    <td>{{$data->name}}</td>
                    <td>{{$data->email}}</td>
                    <td>{{ $data->role_label }}</td>
                    <td>
                      @if($data->is_active)
                        <span class="label label-success">Active</span>
                      @else
                        <span class="label label-default">Inactive</span>
                      @endif
                    </td>
                    <td>{{$data->created_at}}</td>
                    <td>
                      @can('users.manage')
                      <a href="{{ route('editUser', $data->id) }}" class="btn btn-app" style="padding: 5px 5px; min-width: 39px; height: 31px;" title="Edit user">
                        <i class="fa fa-edit"></i>
                      </a>
                      @else
                      —
                      @endcan
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

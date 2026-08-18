@extends('common.master')
@section('content')
<div class="right_col bgimg" role="main" >
    <div class="">
      <div class="page-title">
        <div class="title_left">
          <h3>Lahore Waste Management Company</h3>
        </div>

        <div class="title_right">
          <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
            <div class="input-group">


            </div>
          </div>
        </div>
      </div>

      <div class="clearfix"></div>

      <div class="row">


        <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel">
            <div class="x_title">
              <h2>Employee Information</h2>
              <ul class="nav navbar-right panel_toolbox">
                <span class="input-group-btn">
                    <a href="{{url('addEmployee')}}" class="btn btn-primary"><span style="color: white;">Add New</span></a>
                  </span>
              </ul>
              <div class="clearfix"></div>
            </div>
            <div class="x_content">

              <table id="datatable-buttons" class="table table-striped table-bordered">
                <thead>
                  <tr>
                    <th>Sr.</th>
                    <th>Name</th>
                    <th>designation</th>
                    <th>Department</th>
                    <th>Status</th>
                    <th>Type</th>
                    <th>Action</th>

                  </tr>
                </thead>

                @php $count = 0;
                @endphp
                <tbody>
                    @foreach ($empdata as $data)
                  <tr>

                    <td>{{++$count}}</td>
                    <td>{{$data->emp_name}}</td>
                    <td>{{$data->designation}}</td>
                    <td>{{$data->GetDepartment['dep_name']}}</td>
                    <td>{{$data->status}}</td>
                    <td>{{$data->type}}</td>
                    <td><a href="{{route('editEmployee', $data->id)}}" class="btn btn-app" style="padding: 5px 5px; min-width: 39px; height: 31px;">
                        <i class="fa fa-edit"></i>
                      </a></td>

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

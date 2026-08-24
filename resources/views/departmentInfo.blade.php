@extends('common.master')
@section('content')
        <!-- page content -->
        <div class="right_col bgimg" role="main">
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
                    <h2>All Departments</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <span class="input-group-btn">
                            @can('base-data.manage')
                            <a href="{{url('addDep')}}" class="btn btn-primary"><span style="color: white;">Add New</span></a>
                            @endcan
                          </span>
                      </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">

                    <table id="datatable-buttons" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>Sr.</th>
                          <th>Department</th>
                          <th>Created Date</th>

                        </tr>
                      </thead>


                      <tbody>
                        @foreach($depdata as $value)
                        <tr>
                          <td>{{$value->id}}</td>
                          <td>{{$value->dep_name}}</td>
                          <td>{{$value->created_at}}</td>
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
        <!-- /page content -->
@endsection

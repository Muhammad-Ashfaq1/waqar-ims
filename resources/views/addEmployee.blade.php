@extends('common.master')
@section('content')
<div class="right_col bgimg" role="main">
    <div class="">
      <div class="page-title">
        <div class="title_left">
          <h3>Add Employee</h3>
        </div>


      </div>
      <div class="clearfix"></div>
      <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel">
            <div class="x_title">


              <div class="clearfix"></div>
            </div>
            <div class="x_content">
              <br />
              <form id="demo-form2" class="form-horizontal form-label-left" method="POST" action="{{url('addEmployee')}}">
                @csrf
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Employee Name <span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="first-name" class="form-control col-md-7 col-xs-12" name="empname">
                    <span class="form-control-feedback right">@error('empname') {{$message}} @enderror</span>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Designation <span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <select class="form-control" name="designation" id="select1">
                      <option value="">--Select--</option>
                      <option value="Cheif Executive Officer">Cheif Executive Officer</option>
                      <option value="Deputy Cheif Executive Officer">Deputy Cheif Executive Officer</option>
                      <option value="General Manager">General Manager</option>
                      <option value="Deputy General Manager">Deputy General Manager</option>
                      <option value="Chief Financial Officer">Chief Financial Officer</option>
                      <option value="Company Secretary">Company Secretary</option>
                      <option value="Senior Manager">Senior Manager</option>
                      <option value="Manager">Manager</option>
                      <option value="Deputy Manager">Deputy Manager</option>
                      <option value="Executive SecretaryTown Managertary</option>
                      <option value="Executive Secretary">Executive Secretary</option>
                      <option value="Town Manager">Town Manager</option>
                      <option value="Assistant Manager">Assistant Manager</option>
                      <option value="System Administrator">System Administrator</option>
                      <option value="Executive">Executive</option>
                      <option value="Officer">Officer</option>
                      <option value="Research Associate">Research Associate</option>
                      <option value="IT Operator">IT Operator</option>
                      <option value="Computer Operator">Computer Operator</option>
                      <option value="Assistant">Assistant</option>
                      <option value="Supervisor">Supervisor</option>
                  </select>
                    <span class="form-control-feedback right">@error('designation') {{$message}} @enderror</span>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Department <span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <select class="form-control" name="department">
                        <option value="">--Select--</option>
                        @foreach ($depdata as $data)
                        <option value="{{$data->id}}">{{$data->dep_name}}</option>
                        @endforeach
                      </select>
                      <span class="form-control-feedback right">@error('department') {{$message}} @enderror</span>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Employee Type <span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <select class="form-control" name="type">
                        <option value="">--Select--</option>
                        <option value="Corporate">Corporate</option>
                        <option value="Insource">Insource</option>
                        <option value="Regular">Regular</option>
                    </select>
                    <span class="form-control-feedback right">@error('type') {{$message}} @enderror</span>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Status <span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <select class="form-control" name="status">
                        <option value="">--Select--</option>
                        <option value="Active">Active</option>
                        <option value="Suspended">Suspended</option>
                        <option value="Terminated">Terminated</option>
                    </select>
                    <span class="form-control-feedback right">@error('status') {{$message}} @enderror</span>
                  </div>
                </div>
                <div class="ln_solid"></div>
                <div class="form-group">
                  <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <a href="{{url('employeeinfo')}}" class="btn btn-primary">Back</a>
                    <button class="btn btn-primary" type="reset">Reset</button>
                    <button type="submit" class="btn btn-success">Submit</button>
                  </div>
                </div>

              </form>
            </div>
          </div>
        </div>
      </div>



    </div>
  </div>
  <script>
    $(document).ready(function() {
      $('#select1').select2();
  });
  </script>
@endsection

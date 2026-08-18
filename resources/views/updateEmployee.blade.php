@extends('common.master')
@section('content')
<div class="right_col bgimg" role="main">
    <div class="">
      <div class="page-title">
        <div class="title_left">
          <h3>Update Employee</h3>
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
              <form id="demo-form2" class="form-horizontal form-label-left" method="POST" action="/editEmployee/{{$empID->id}}">
                @csrf
                @method('PUT')
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Employee Name <span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="first-name" class="form-control col-md-7 col-xs-12" name="empname" value="{{$empID->emp_name}}">
                    <span class="form-control-feedback right">@error('empname') {{$message}} @enderror</span>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Designation <span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="first-name" class="form-control col-md-7 col-xs-12" name="designation" value="{{$empID->designation}}">
                    <span class="form-control-feedback right">@error('designation') {{$message}} @enderror</span>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Department <span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <select class="form-control" name="department">
                        <option value="{{$empID->department_id}}">{{$empID->GetDepartment['dep_name']}}</option>
                        @foreach ($dep as $data)
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
                        <option value="{{$empID->type}}">{{$empID->type}}</option>
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
                        <option value="{{$empID->status}}">{{$empID->status}}</option>
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
                    <button class="btn btn-danger" type="reset">Reset</button>
                    <button type="submit" class="btn btn-warning">Submit</button>
                  </div>
                </div>

              </form>
            </div>
          </div>
        </div>
      </div>



    </div>
  </div>

@endsection

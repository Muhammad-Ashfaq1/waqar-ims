@extends('common.master')

@section('content')
<div class="right_col bgimg" role="main">
  <div class="page-title"><div class="title_left"><h3>Location Department</h3></div></div>
  <div class="clearfix"></div>
  <div class="row"><div class="col-md-12 col-sm-12 col-xs-12"><div class="x_panel"><div class="x_content"><br>
    <form class="form-horizontal form-label-left" method="POST" action="{{ url('location-departments') }}">
      @csrf
      <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">Location <span class="required">*</span></label>
        <div class="col-md-6 col-sm-6 col-xs-12">
          <select class="form-control" name="location_id" required>
            <option value="">-- Select Location --</option>
            @foreach ($locations as $location)<option value="{{ $location->id }}" @selected(old('location_id') == $location->id)>{{ $location->name }}</option>@endforeach
          </select>
          @error('location_id')<span class="form-control-feedback" style="position:static;display:inline-block;height:auto;width:auto">{{ $message }}</span>@enderror
        </div>
      </div>
      <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">Department <span class="required">*</span></label>
        <div class="col-md-6 col-sm-6 col-xs-12">
          <select class="form-control" name="department_id" required>
            <option value="">-- Select Department --</option>
            @foreach ($departments as $department)<option value="{{ $department->id }}" @selected(old('department_id') == $department->id)>{{ $department->dep_name }}</option>@endforeach
          </select>
          @error('department_id')<span class="form-control-feedback" style="position:static;display:inline-block;height:auto;width:auto">{{ $message }}</span>@enderror
        </div>
      </div>
      <div class="ln_solid"></div><div class="form-group"><div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3"><button class="btn btn-success" type="submit">Save</button></div></div>
    </form>
  </div></div></div></div>
</div>
<script>$(function () { $('select').select2({ width: '100%' }); });</script>
@endsection

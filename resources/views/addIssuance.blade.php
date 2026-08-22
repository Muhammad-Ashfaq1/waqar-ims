@extends('common.master')
@section('content')


<div class="right_col bgimg" role="main">
    <div class="">
      <div class="page-title">
        <div class="title_left">
          <h3>IT Stock Issuance</h3>
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
              <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" method="POST" action="{{url('addIssuance')}}">
                @csrf
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Stock <span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <select class="form-control" name="stock_id" value="{{old('stock_id')}}">
                        <option value="">--Select--</option>
                        @foreach ($assetlist as $data)
                        <option value="{{$data->id}}">{{$data->GetAsset['type']}}&nbsp;|&nbsp;{{$data->serial_no}}</option>
                        @endforeach
                      </select>
                      <span class="form-control-feedback right">@error('stock_id') {{$message}} @enderror</span>
                  </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Employee <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <select class="form-control" name="employee_id" value="{{old('employee_id')}}">
                          <option value="">--Select--</option>
                          @foreach ($emplist as $data)
                          <option value="{{$data->id}}">{{$data->emp_name }}&nbsp;|&nbsp;{{ $data->designation}}&nbsp;|&nbsp;{{ $data->GetDepartment['dep_name']}}</option>
                          @endforeach
                        </select>
                        <span class="form-control-feedback right">@error('employee_id') {{$message}} @enderror</span>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Date of Issuance<span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input type="date" class="form-control col-md-7 col-xs-12" name="issuance_date" value="{{old('issuance_date')}}">
                      <span class="form-control-feedback right">@error('issuance_date') {{$message}} @enderror</span>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Location <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <select class="form-control" name="location_id" id="issuance-location">
                          <option value="">--Select--</option>
                          @foreach ($locations as $location)
                            <option value="{{ $location->id }}" {{ (string) old('location_id') === (string) $location->id ? 'selected' : '' }}>
                              {{ $location->name }} ({{ $location->type_label }})
                            </option>
                          @endforeach
                        </select>
                        <span class="form-control-feedback right">@error('location_id') {{$message}} @enderror</span>
                    </div>
                  </div>
                <div class="ln_solid"></div>
                <div class="form-group">
                  <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <a href="{{url('issuance')}}" class="btn btn-primary">Back</a>
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
    $('select').select2();
});
</script>
@endsection


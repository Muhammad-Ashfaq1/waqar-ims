@extends('common.master')
@section('content')


<div class="right_col bgimg" role="main">
    <div class="">
      <div class="page-title">
        <div class="title_left">
          <h3>Issuance Update</h3>
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
              <form id="demo-form2" class="form-horizontal form-label-left" method="POST" action="/editIssuance/{{$issuanceID->id}}">
                @csrf
                @method('PUT')
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Stock <span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <select class="form-control" name="stock_id">
                        <option value="{{ $issuanceID->GetStock['id']}}">{{$issuanceID->GetStock->GetAsset['type']}}&nbsp;|&nbsp;{{ $issuanceID->GetStock['serial_no']}}</option>
                      </select>
                </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Employee <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <select class="form-control" name="employee_id" id="select1">
                          <option value="{{ $issuanceID->GetEmployee['id']}}">{{$issuanceID->GetEmployee['emp_name'] }}&nbsp;|&nbsp;{{ $issuanceID->GetEmployee['designation']}}&nbsp;|&nbsp;{{ $issuanceID->GetEmployee->GetDepartment['dep_name']}}</option>
                          @foreach ($emp as $data)
                          <option value="{{$data->id}}">{{$data->emp_name }}&nbsp;|&nbsp;{{ $data->designation}}&nbsp;|&nbsp;{{ $data->GetDepartment['dep_name']}}</option>
                          @endforeach
                        </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Date of Issuance<span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input type="date" class="form-control col-md-7 col-xs-12" name="issuance_date" value="{{$issuanceID->issuance_date}}" readonly>

                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Location <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <select class="form-control" name="location" value="{{old('location')}}">
                          <option value="{{$issuanceID->location}}">{{$issuanceID->location}}</option>
                          <option value="Head Office">Head Office</option>
                          <option value="Lakhodair Admin Block">Lakhodair Admin Block</option>
                          <option value="Lakhodair Weighbridge">Lakhodair Weighbridge</option>
                          <option value="Children Hospital Workshop">Children Hospital Workshop</option>
                          <option value="Outfall Road Workshop North">Outfall Road Workshop North</option>
                          <option value="Outfall Road Workshop South">Outfall Road Workshop South</option>
                          <option value="Thokar Workshop">Thokar Workshop</option>

                        </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" >Status <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <select class="form-control" name="status" >
                          <option value="{{$issuanceID->GetStock['status']}}">{{$issuanceID->GetStock['status']}}</option>
                          <option value="In Stock">In Stock</option>
                      </select>
                    </div>
                  </div>
                <div class="ln_solid"></div>
                <div class="form-group">
                  <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <a href="{{url('issuance')}}" class="btn btn-primary">Back</a>
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
<script>
  $(document).ready(function() {
    $('#select1').select2();
});
</script>
@endsection


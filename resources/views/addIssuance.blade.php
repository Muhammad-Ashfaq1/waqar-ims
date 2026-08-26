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
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Stock <span class="required">*</span></label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <select class="form-control" name="stock_id">
                        <option value="">--Select--</option>
                        @foreach ($assetlist as $data)
                        <option value="{{$data->id}}" {{ (string) old('stock_id') === (string) $data->id ? 'selected' : '' }}>{{$data->GetAsset['type']}}&nbsp;|&nbsp;{{$data->serial_no}}</option>
                        @endforeach
                      </select>
                  </div>
                  <div class="col-md-3 col-sm-3 col-xs-12">
                    @error('stock_id')
                      <span class="form-control-feedback" style="position:static; display:inline-block; height:auto; width:auto;">{{ $message }}</span>
                    @enderror
                  </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Assign To <span class="required">*</span></label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <select class="form-control" name="assign_to" id="assign-to">
                        <option value="">--Select--</option>
                        <option value="employee" {{ old('assign_to') === 'employee' ? 'selected' : '' }}>Employee</option>
                        <option value="location" {{ old('assign_to') === 'location' ? 'selected' : '' }}>Location / Workshop</option>
                      </select>
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-12">
                      @error('assign_to')
                        <span class="form-control-feedback" style="position:static; display:inline-block; height:auto; width:auto;">{{ $message }}</span>
                      @enderror
                    </div>
                  </div>
                <div class="form-group" id="employee-assignment-field" style="display: none;">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Employee <span class="required">*</span></label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <select class="form-control" name="employee_id" id="issuance-employee">
                          <option value="">--Select--</option>
                          @foreach ($emplist as $data)
                          <option value="{{$data->id}}" {{ (string) old('employee_id') === (string) $data->id ? 'selected' : '' }}>{{$data->emp_name }}&nbsp;|&nbsp;{{ $data->designation}}&nbsp;|&nbsp;{{ $data->GetDepartment['dep_name']}}</option>
                          @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-12">
                      @error('employee_id')
                        <span class="form-control-feedback" style="position:static; display:inline-block; height:auto; width:auto;">{{ $message }}</span>
                      @enderror
                    </div>
                  </div>
                  <div class="form-group" id="location-assignment-field" style="display: none;">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Location <span class="required">*</span></label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <select class="form-control" name="location_id" id="issuance-location">
                          <option value="">--Select--</option>
                          @foreach ($locations as $location)
                            <option value="{{ $location->id }}" {{ (string) old('location_id') === (string) $location->id ? 'selected' : '' }}>
                              {{ $location->name }}
                            </option>
                          @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-12">
                      @error('location_id')
                        <span class="form-control-feedback" style="position:static; display:inline-block; height:auto; width:auto;">{{ $message }}</span>
                      @enderror
                    </div>
                  </div>
                  @include('common.location-department-field', ['selectedDepartmentId' => null])
                  <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Date of Issuance <span class="required">*</span></label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input type="date" class="form-control" name="issuance_date" value="{{old('issuance_date')}}">
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-12">
                      @error('issuance_date')
                        <span class="form-control-feedback" style="position:static; display:inline-block; height:auto; width:auto;">{{ $message }}</span>
                      @enderror
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
    $('select').select2({ width: '100%' });

    function fixSelectWidth($el) {
      if ($el.data('select2')) {
        $el.select2('destroy');
      }
      $el.select2({ width: '100%' });
      $el.next('.select2-container').css('width', '100%');
    }

    function toggleAssignmentFields() {
      var assignTo = $('#assign-to').val();
      var isEmployee = assignTo === 'employee';
      var isLocation = assignTo === 'location';
      var needsLocation = isEmployee || isLocation;
      var needsDepartment = isLocation;

      $('#employee-assignment-field').toggle(isEmployee);
      $('#location-assignment-field').toggle(needsLocation);

      $('#issuance-employee').prop('disabled', !isEmployee);
      $('#issuance-location').prop('disabled', !needsLocation);

      if (!isEmployee) {
        $('#issuance-employee').val(null);
      }
      if (!needsLocation) {
        $('#issuance-location').val(null);
      }
      refreshIssuanceDepartments(needsDepartment);

      setTimeout(function () {
        if (isEmployee) {
          fixSelectWidth($('#issuance-employee'));
        }
        if (needsLocation) {
          fixSelectWidth($('#issuance-location'));
        }
      }, 0);
    }

    $('#assign-to').on('change', toggleAssignmentFields);
    $('#issuance-location').on('change', function () {
      window.selectedIssuanceDepartment = null;
      refreshIssuanceDepartments($('#assign-to').val() === 'location');
    });
    toggleAssignmentFields();
  });
</script>
@endsection

@extends('common.master')

@section('content')
<div class="right_col bgimg" role="main">
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3>Assign Location Departments</h3>
      </div>
    </div>
    <div class="clearfix"></div>

    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel" style="box-shadow: 0 2px 8px rgba(0,0,0,0.08); border-radius: 6px;">
          <div class="x_title">
            <h2><i class="fa fa-link"></i> Select Location & Check Departments</h2>
            <ul class="nav navbar-right panel_toolbox">
              <span class="input-group-btn">
                <a href="{{ route('locationDepartments') }}" class="btn btn-primary">
                  <span style="color: white;"><i class="fa fa-arrow-left"></i> Back to List</span>
                </a>
              </span>
            </ul>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <br />
            <form id="location-department-form" class="form-horizontal form-label-left" method="POST" action="{{ url('location-departments') }}">
              @csrf

              <!-- Location Dropdown -->
              <div class="form-group">
                <label class="control-label col-md-2 col-sm-3 col-xs-12" for="location-select">
                  Location <span class="required text-danger">*</span>
                </label>
                <div class="col-md-6 col-sm-7 col-xs-12">
                  <select class="form-control select2" id="location-select" name="location_id" required style="width: 100%;">
                    <option value="">-- Select Location --</option>
                    @foreach ($locations as $location)
                      <option value="{{ $location->id }}" {{ (string) $selectedLocationId === (string) $location->id ? 'selected' : '' }}>
                        {{ $location->name }}
                      </option>
                    @endforeach
                  </select>
                  @error('location_id')
                    <span class="text-danger" style="display:block; margin-top:4px;">{{ $message }}</span>
                  @enderror
                </div>
                <div class="col-md-4 col-sm-2 col-xs-12" style="padding-top: 6px;">
                  <span class="label label-info" id="selected-location-badge" style="font-size: 12px; display: none; padding: 5px 8px;">
                    <i class="fa fa-building"></i> <span id="selected-dept-count-text">0 departments linked</span>
                  </span>
                </div>
              </div>

              <!-- Department Checkboxes Header & Search -->
              <div class="form-group" style="margin-top: 20px;">
                <label class="control-label col-md-2 col-sm-3 col-xs-12">
                  Departments <span class="required text-danger">*</span>
                </label>
                <div class="col-md-10 col-sm-9 col-xs-12">
                  <div class="well well-sm" style="background: #f8f9fa; border: 1px solid #e5e5e5; margin-bottom: 10px; padding: 8px 12px;">
                    <div class="row">
                      <div class="col-md-5 col-sm-6 col-xs-12" style="margin-bottom: 5px;">
                        <div class="input-group input-group-sm" style="margin-bottom: 0;">
                          <span class="input-group-addon"><i class="fa fa-search"></i></span>
                          <input type="text" id="dept-search" class="form-control" placeholder="Search departments...">
                        </div>
                      </div>
                      <div class="col-md-7 col-sm-6 col-xs-12 text-right" style="margin-top: 2px;">
                        <button type="button" class="btn btn-default btn-xs" id="btn-select-all">
                          <i class="fa fa-check-square-o"></i> Select All
                        </button>
                        <button type="button" class="btn btn-default btn-xs" id="btn-deselect-all">
                          <i class="fa fa-square-o"></i> Deselect All
                        </button>
                        <span class="badge bg-green" id="dept-counter" style="margin-left: 8px; font-size: 11px;">0 Selected</span>
                      </div>
                    </div>
                  </div>

                  <!-- Checkbox Grid -->
                  <div id="dept-checkbox-container" style="max-height: 340px; overflow-y: auto; padding: 12px; border: 1px solid #e9ecef; border-radius: 4px; background: #fff;">
                    <div class="row">
                      @forelse ($departments as $department)
                        <div class="col-md-4 col-sm-6 col-xs-12 dept-item" data-dept-name="{{ strtolower($department->dep_name) }}" style="margin-bottom: 8px;">
                          <label class="dept-checkbox-label" for="dept_{{ $department->id }}" style="cursor: pointer; font-weight: normal; width: 100%; padding: 7px 10px; background: #fdfdfd; border: 1px solid #eee; border-radius: 4px; display: flex; align-items: center; transition: all 0.2s;">
                            <input type="checkbox" name="department_ids[]" value="{{ $department->id }}" id="dept_{{ $department->id }}" class="dept-checkbox" style="margin-right: 8px; cursor: pointer;">
                            <span class="dept-name-text" style="color: #333;">{{ $department->dep_name }}</span>
                          </label>
                        </div>
                      @empty
                        <div class="col-xs-12 text-muted">No departments found in database.</div>
                      @endforelse
                    </div>
                  </div>
                  @error('department_ids')
                    <span class="text-danger" style="display:block; margin-top:4px;">{{ $message }}</span>
                  @enderror
                </div>
              </div>

              <!-- Submit Buttons -->
              <div class="ln_solid"></div>
              <div class="form-group">
                <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-2">
                  <a href="{{ route('locationDepartments') }}" class="btn btn-primary">Back</a>
                  <button type="button" class="btn btn-default" id="btn-reset-form">
                    <i class="fa fa-refresh"></i> Reset Selection
                  </button>
                  <button type="submit" class="btn btn-success" id="btn-save-mapping">
                    <i class="fa fa-save"></i> Save Departments
                  </button>
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

@push('scripts')
<script>
$(document).ready(function () {
  var locationDeptMap = @json($locationDepartmentMap);

  if ($.fn.select2) {
    $('.select2').select2({ width: '100%' });
  }

  function updateDeptCounter() {
    var totalChecked = $('.dept-checkbox:checked').length;
    $('#dept-counter').text(totalChecked + ' Selected');

    $('.dept-checkbox').each(function () {
      var isChecked = $(this).is(':checked');
      var label = $(this).closest('.dept-checkbox-label');
      if (isChecked) {
        label.css({ 'background-color': '#e8f4fd', 'border-color': '#b6d4fe', 'font-weight': '600' });
      } else {
        label.css({ 'background-color': '#fdfdfd', 'border-color': '#eee', 'font-weight': 'normal' });
      }
    });
  }

  function loadLocationDepartments(locationId) {
    if (!locationId) {
      $('.dept-checkbox').prop('checked', false);
      $('#selected-location-badge').hide();
      updateDeptCounter();
      return;
    }

    var assignedIds = locationDeptMap[locationId] || [];
    $('.dept-checkbox').each(function () {
      var deptId = parseInt($(this).val(), 10);
      var shouldCheck = assignedIds.indexOf(deptId) !== -1;
      $(this).prop('checked', shouldCheck);
    });

    $('#selected-dept-count-text').text(assignedIds.length + ' department(s) currently linked');
    $('#selected-location-badge').show();
    updateDeptCounter();
  }

  $('#location-select').on('change', function () {
    var locId = $(this).val();
    loadLocationDepartments(locId);
  });

  $(document).on('change', '.dept-checkbox', function () {
    updateDeptCounter();
  });

  $('#btn-select-all').on('click', function () {
    $('.dept-item:visible .dept-checkbox').prop('checked', true);
    updateDeptCounter();
  });

  $('#btn-deselect-all').on('click', function () {
    $('.dept-checkbox').prop('checked', false);
    updateDeptCounter();
  });

  $('#btn-reset-form').on('click', function () {
    var locId = $('#location-select').val();
    loadLocationDepartments(locId);
  });

  $('#dept-search').on('keyup', function () {
    var term = $(this).val().toLowerCase().trim();
    $('.dept-item').each(function () {
      var name = $(this).data('dept-name') || '';
      if (term === '' || name.indexOf(term) !== -1) {
        $(this).show();
      } else {
        $(this).hide();
      }
    });
  });

  var initialLocId = $('#location-select').val();
  if (initialLocId) {
    loadLocationDepartments(initialLocId);
  } else {
    updateDeptCounter();
  }
});
</script>
@endpush

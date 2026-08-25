<div class="form-group" id="department-assignment-field" style="display: none;">
  <label class="control-label col-md-3 col-sm-3 col-xs-12">Department <span class="required">*</span></label>
  <div class="col-md-6 col-sm-6 col-xs-12">
    <select class="form-control" name="department_id" id="issuance-department" disabled>
      <option value="">-- Select Department --</option>
    </select>
  </div>
  <div class="col-md-3 col-sm-3 col-xs-12">
    @error('department_id')<span class="form-control-feedback" style="position:static;display:inline-block;height:auto;width:auto">{{ $message }}</span>@enderror
  </div>
</div>
<script>
  window.locationDepartments = @json($locationDepartments);
  window.selectedIssuanceDepartment = @json(old('department_id', $selectedDepartmentId ?? null));
  window.refreshIssuanceDepartments = function (enabled) {
    var $department = $('#issuance-department');
    var locationId = $('#issuance-location').val();
    var departments = window.locationDepartments[locationId] || [];
    var selected = window.selectedIssuanceDepartment;

    $department.empty().append(new Option('-- Select Department --', ''));
    $.each(departments, function (_, department) {
      $department.append(new Option(department.dep_name, department.id, false, String(department.id) === String(selected)));
    });
    $department.prop('disabled', !enabled).trigger('change.select2');
    if (!enabled) {
      $department.val(null);
    }
    $('#department-assignment-field').toggle(enabled);
  };
</script>

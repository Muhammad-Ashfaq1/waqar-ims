@extends('common.master')
@section('content')
<div class="right_col bgimg" role="main">
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3>Update Location</h3>
      </div>
    </div>
    <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title"><div class="clearfix"></div></div>
          <div class="x_content">
            <br />
            @php
              $currentType = old('location_type', $location->location_type?->value ?? $location->location_type);
              $currentActive = old('is_active', $location->is_active ? '1' : '0');
            @endphp
            <form id="demo-form2" class="form-horizontal form-label-left" method="POST" action="{{ url('edit-location/'.$location->id) }}">
              @csrf
              @method('PUT')
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="location-name">Location Name <span class="required">*</span></label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" id="location-name" class="form-control col-md-7 col-xs-12" name="name" value="{{ old('name', $location->name) }}" placeholder="Enter Location / Workshop Name">
                </div>
                <div class="col-md-3 col-sm-3 col-xs-12">
                  @error('name')
                    <span class="form-control-feedback" style="position:static; display:inline-block; height:auto; width:auto;">{{ $message }}</span>
                  @enderror
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="location-slug">Slug <span class="required">*</span></label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" id="location-slug" class="form-control col-md-7 col-xs-12" name="slug" value="{{ old('slug', $location->slug) }}" placeholder="Auto generated from name" readonly style="background-color:#eee; cursor:not-allowed;">
                </div>
                <div class="col-md-3 col-sm-3 col-xs-12">
                  @error('slug')
                    <span class="form-control-feedback" style="position:static; display:inline-block; height:auto; width:auto;">{{ $message }}</span>
                  @enderror
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="location-type">Location Type <span class="required">*</span></label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <select id="location-type" name="location_type" class="form-control">
                    <option value="">Select Location Type</option>
                    @foreach(\App\Enums\LocationType::options() as $value => $label)
                      <option value="{{ $value }}" {{ (string) $currentType === (string) $value ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="col-md-3 col-sm-3 col-xs-12">
                  @error('location_type')
                    <span class="form-control-feedback" style="position:static; display:inline-block; height:auto; width:auto;">{{ $message }}</span>
                  @enderror
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="is-active">Status <span class="required">*</span></label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <select id="is-active" name="is_active" class="form-control">
                    <option value="">Select Status</option>
                    <option value="1" {{ (string) $currentActive === '1' ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ (string) $currentActive === '0' ? 'selected' : '' }}>Inactive</option>
                  </select>
                </div>
                <div class="col-md-3 col-sm-3 col-xs-12">
                  @error('is_active')
                    <span class="form-control-feedback" style="position:static; display:inline-block; height:auto; width:auto;">{{ $message }}</span>
                  @enderror
                </div>
              </div>
              <div class="ln_solid"></div>
              <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                  <a href="{{ url('locationinfo') }}" class="btn btn-primary">Back</a>
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

@push('scripts')
<script>
$(document).ready(function () {
  $('#location-name').on('input', function () {
    var slug = $(this).val().trim()
      .replace(/\s+/g, '-')
      .replace(/[^a-zA-Z0-9\-]/g, '')
      .replace(/-+/g, '-')
      .replace(/^-|-$/g, '');
    $('#location-slug').val(slug);
  });
});
</script>
@endpush

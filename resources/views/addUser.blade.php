@extends('common.master')
@section('content')
<div class="right_col bgimg" role="main">
    <div class="">
      <div class="page-title">
        <div class="title_left">
          <h3>Add User</h3>
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
              <form id="demo-form2" class="form-horizontal form-label-left" method="POST" action="{{url('add-user')}}">
                @csrf
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">First Name <span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="first-name" class="form-control col-md-7 col-xs-12" name="first_name" value="{{old('first_name')}}" placeholder="Enter first name">
                    <span class="form-control-feedback right">@error('first_name') {{$message}} @enderror</span>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Last Name
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="last-name" class="form-control col-md-7 col-xs-12" name="last_name" value="{{old('last_name')}}" placeholder="Enter last name (optional)">
                    <span class="form-control-feedback right">@error('last_name') {{$message}} @enderror</span>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="user-email">Email <span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="email" id="user-email" class="form-control col-md-7 col-xs-12" name="email" value="{{old('email')}}" placeholder="Enter email address">
                    <span class="form-control-feedback right">@error('email') {{$message}} @enderror</span>
                  </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="user-password">Password <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <div style="position: relative;">
                        <input type="password" id="user-password" class="form-control col-md-7 col-xs-12" name="password" style="padding-right: 35px;" placeholder="Enter password">
                        <span class="toggle-password" style="position: absolute; right: 15px; top: 9px; cursor: pointer; color: #73879C; z-index: 10; font-size: 14px;">
                          <i class="fa fa-eye"></i>
                        </span>
                      </div>
                      <span class="form-control-feedback right">@error('password') {{$message}} @enderror</span>
                    </div>
                  </div>
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="user-role">Role <span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <select id="user-role" name="role" class="form-control">
                      <option value="">Select role</option>
                      @foreach(\App\Enums\UserRole::options() as $value => $label)
                        <option value="{{ $value }}" {{ old('role') === $value ? 'selected' : '' }}>{{ $label }}</option>
                      @endforeach
                    </select>
                    <span class="form-control-feedback right">@error('role') {{$message}} @enderror</span>
                  </div>
                </div>
                <div class="ln_solid"></div>
                <div class="form-group">
                  <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <a href="{{url('userlist')}}" class="btn btn-primary">Back</a>
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
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('.toggle-password').on('click', function() {
        var input = $('#user-password');
        var icon = $(this).find('i');
        if (input.attr('type') === 'password') {
            input.attr('type', 'text');
            icon.removeClass('fa-eye').addClass('fa-eye-slash');
        } else {
            input.attr('type', 'password');
            icon.removeClass('fa-eye-slash').addClass('fa-eye');
        }
    });
});
</script>
@endpush

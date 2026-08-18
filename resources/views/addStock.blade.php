@extends('common.master')
@section('content')


<div class="bgimg right_col" role="main">
    <div class="">
      <div class="page-title">
        <div class="title_left">
          <h3>Add Stock</h3>
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
              <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" method="POST" action="{{url('addStock')}}">
                @csrf
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Asset Type <span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <select class="form-control" name="assettype" id="myDropdown">
                        <option value="">--Select--</option>
                        @foreach ($assetlist as $data)
                        <option value="{{$data->id}}">{{$data->type}}</option>
                        @endforeach
                      </select>
                      <span class="form-control-feedback right">@error('assettype') {{$message}} @enderror</span>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Model <span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" class="form-control col-md-7 col-xs-12" name="model">
                    <span class="form-control-feedback right">@error('model') {{$message}} @enderror</span>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Serial No. <span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" class="form-control col-md-7 col-xs-12" name="serial">
                    <span class="form-control-feedback right">@error('serial') {{$message}} @enderror</span>
                  </div>
                </div>
                <div class="form-group" id="input-field-A" style="display: none;">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">RAM <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12" >
                      <input type="text" class="form-control col-md-7 col-xs-12" name="ram" >
                      <span class="form-control-feedback right">@error('ram') {{$message}} @enderror</span>
                    </div>
                  </div>
                  <div class="form-group" id="input-field-B" style="display: none;">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">ROM <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12" >
                      <input type="text" class="form-control col-md-7 col-xs-12" name="rom" >
                      <span class="form-control-feedback right">@error('rom') {{$message}} @enderror</span>
                    </div>
                  </div>
                  <div class="form-group" id="input-field-C" style="display: none;">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Processor <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input type="text" class="form-control col-md-7 col-xs-12" name="processor">
                      <span class="form-control-feedback right">@error('processor') {{$message}} @enderror</span>
                    </div>
                  </div>
                  <div class="form-group" id="input-field-D" style="display: none;">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Generation <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input type="text" class="form-control col-md-7 col-xs-12" name="generation">
                      <span class="form-control-feedback right">@error('generation') {{$message}} @enderror</span>
                    </div>
                  </div>
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Purchase Date <span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="date" class="form-control col-md-7 col-xs-12" name="purchase_date">
                    <span class="form-control-feedback right">@error('purchase_date') {{$message}} @enderror</span>
                  </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Expiry Date <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input type="date" class="form-control col-md-7 col-xs-12" name="expiry_date">
                      <span class="form-control-feedback right">@error('expiry_date') {{$message}} @enderror</span>
                    </div>
                  </div>
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Status <span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <select class="form-control" name="status" >
                        <option value="">--Select--</option>
                        <option value="In Stock">In Stock</option>
                        <option value="Dead">Dead</option>
                        <option value="Repairable">Repairable</option>
                        <option value="Not Receivable">Not Receivable</option>
                    </select>
                    <span class="form-control-feedback right">@error('status') {{$message}} @enderror</span>
                  </div>
                </div>
                <div class="ln_solid"></div>
                <div class="form-group">
                  <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <a href="{{url('stocklist')}}" class="btn btn-primary">Back</a>
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
    $('#myDropdown').on('change', function() {
      var selectedOption = $(this).val();

      // Hide all input fields
      $('[id^="input-field-"]').hide();

      switch (selectedOption) {
        case '2':
          $('#input-field-A, #input-field-B, #input-field-C, #input-field-D').show();
          break;
        case '3':
          $('#input-field-A, #input-field-B, #input-field-C, #input-field-D').show();
          break;
        case '6':
          $('#input-field-A, #input-field-B, #input-field-C, #input-field-D').show();
          break;
      }
    });
    </script>
@endsection


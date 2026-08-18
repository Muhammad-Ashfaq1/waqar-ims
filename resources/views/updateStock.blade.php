@extends('common.master')
@section('content')


<div class="bgimg right_col" role="main">
    <div class="">
      <div class="page-title">
        <div class="title_left">
          <h3>Update Stock</h3>
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
              <form id="demo-form2" class="form-horizontal form-label-left" method="POST" action="/editData/{{$stockID->id}}">
                @csrf
                @method('PUT')
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Asset Type <span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" readonly class="form-control col-md-7 col-xs-12" name="asset" value="{{$stockID->GetAsset['type']}}">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Model <span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" readonly class="form-control col-md-7 col-xs-12" name="model" value="{{$stockID->model}}">
                    <span class="form-control-feedback right">@error('model') {{$message}} @enderror</span>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Serial No. <span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" readonly class="form-control col-md-7 col-xs-12" name="serial" value="{{$stockID->serial_no}}">
                    <span class="form-control-feedback right">@error('serial') {{$message}} @enderror</span>
                  </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">RAM <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12" >
                      <input type="text" readonly class="form-control col-md-7 col-xs-12" name="ram" value="{{$stockID->ram}}">
                      <span class="form-control-feedback right">@error('ram') {{$message}} @enderror</span>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">ROM <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12" >
                      <input type="text" readonly class="form-control col-md-7 col-xs-12" name="rom" value="{{$stockID->rom}}">
                      <span class="form-control-feedback right">@error('rom') {{$message}} @enderror</span>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Processor <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input type="text" readonly class="form-control col-md-7 col-xs-12" name="processor" value="{{$stockID->processor}}">
                      <span class="form-control-feedback right">@error('processor') {{$message}} @enderror</span>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Generation <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input type="text" readonly class="form-control col-md-7 col-xs-12" name="generation" value="{{$stockID->generation}}">
                      <span class="form-control-feedback right">@error('generation') {{$message}} @enderror</span>
                    </div>
                  </div>
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Purchase Date <span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="date" readonly class="form-control col-md-7 col-xs-12" name="purchase_date" value="{{$stockID->purchase_date}}">
                    <span class="form-control-feedback right">@error('purchase_date') {{$message}} @enderror</span>
                  </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Expiry Date <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input type="date" readonly class="form-control col-md-7 col-xs-12" name="expiry_date" value="{{$stockID->expiry_date}}">
                      <span class="form-control-feedback right">@error('expiry_date') {{$message}} @enderror</span>
                    </div>
                  </div>
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Status <span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <select class="form-control" name="status" >
                        <option value="{{$stockID->status}}">{{$stockID->status}}</option>
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
                    <a href="{{url('')}}" class="btn btn-primary">Back</a>
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


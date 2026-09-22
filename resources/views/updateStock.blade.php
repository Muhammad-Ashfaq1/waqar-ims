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
              <form id="demo-form2" class="form-horizontal form-label-left" method="POST" action="{{ url('editData/'.$stockID->id) }}">
                @csrf
                @method('PUT')
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="assettype">Asset Type <span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <select class="form-control" name="assettype" id="assettype" required>
                      <option value="">--Select Asset Type--</option>
                      @foreach ($assetlist as $asset)
                        <option value="{{ $asset->id }}" {{ (string) old('assettype', $stockID->asset_id) === (string) $asset->id ? 'selected' : '' }}>
                          {{ $asset->type }}
                        </option>
                      @endforeach
                    </select>
                    <span class="form-control-feedback right">@error('assettype') {{$message}} @enderror</span>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="model">Model <span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" class="form-control col-md-7 col-xs-12" name="model" id="model" value="{{ old('model', $stockID->model) }}" required>
                    <span class="form-control-feedback right">@error('model') {{$message}} @enderror</span>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="serial">Serial No. <span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" class="form-control col-md-7 col-xs-12" name="serial" id="serial" value="{{ old('serial', $stockID->serial_no) }}" required>
                    <span class="form-control-feedback right">@error('serial') {{$message}} @enderror</span>
                  </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="ram">RAM
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12" >
                      <input type="text" class="form-control col-md-7 col-xs-12" name="ram" id="ram" value="{{ old('ram', $stockID->ram) }}">
                      <span class="form-control-feedback right">@error('ram') {{$message}} @enderror</span>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="rom">ROM
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12" >
                      <input type="text" class="form-control col-md-7 col-xs-12" name="rom" id="rom" value="{{ old('rom', $stockID->rom) }}">
                      <span class="form-control-feedback right">@error('rom') {{$message}} @enderror</span>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="processor">Processor
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input type="text" class="form-control col-md-7 col-xs-12" name="processor" id="processor" value="{{ old('processor', $stockID->processor) }}">
                      <span class="form-control-feedback right">@error('processor') {{$message}} @enderror</span>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="generation">Generation
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input type="text" class="form-control col-md-7 col-xs-12" name="generation" id="generation" value="{{ old('generation', $stockID->generation) }}">
                      <span class="form-control-feedback right">@error('generation') {{$message}} @enderror</span>
                    </div>
                  </div>
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="purchase_date">Purchase Date <span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="date" class="form-control col-md-7 col-xs-12" name="purchase_date" id="purchase_date" value="{{ old('purchase_date', $stockID->purchase_date ? \Carbon\Carbon::parse($stockID->purchase_date)->format('Y-m-d') : '') }}" required>
                    <span class="form-control-feedback right">@error('purchase_date') {{$message}} @enderror</span>
                  </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="expiry_date">Expiry Date <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input type="date" class="form-control col-md-7 col-xs-12" name="expiry_date" id="expiry_date" value="{{ old('expiry_date', $stockID->expiry_date ? \Carbon\Carbon::parse($stockID->expiry_date)->format('Y-m-d') : '') }}" required>
                      <span class="form-control-feedback right">@error('expiry_date') {{$message}} @enderror</span>
                    </div>
                  </div>
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="status">Status <span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    @php
                      $statuses = ['In Stock', 'Issued', 'Dead', 'Repairable', 'Not Receivable'];
                      if (!in_array($stockID->status, $statuses) && !empty($stockID->status)) {
                          $statuses[] = $stockID->status;
                      }
                    @endphp
                    <select class="form-control" name="status" id="status" required>
                      @foreach ($statuses as $statusOption)
                        <option value="{{ $statusOption }}" {{ old('status', $stockID->status) === $statusOption ? 'selected' : '' }}>
                          {{ $statusOption }}
                        </option>
                      @endforeach
                    </select>
                    <span class="form-control-feedback right">@error('status') {{$message}} @enderror</span>
                  </div>
                </div>
                <div class="ln_solid"></div>
                <div class="form-group">
                  <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <a href="{{url('stocklist')}}" class="btn btn-primary">Back</a>
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


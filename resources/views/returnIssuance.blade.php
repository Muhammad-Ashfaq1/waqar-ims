@extends('common.master')
@section('content')
<div class="right_col bgimg" role="main">
    <div class="">
      <div class="page-title">
        <div class="title_left">
          <h3>Return Stock</h3>
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
              <form id="return-issuance-form"
                    class="form-horizontal form-label-left"
                    method="POST"
                    action="{{ url('returnIssuance/'.$issuanceID->id) }}"
                    data-employee="{{ optional($issuanceID->GetEmployee)->emp_name ?? '-' }}"
                    data-asset="{{ optional(optional($issuanceID->GetStock)->GetAsset)->type }} | {{ optional($issuanceID->GetStock)->serial_no }}"
                    data-serial="{{ optional($issuanceID->GetStock)->serial_no ?? '-' }}"
                    data-issue-date="{{ optional($issuanceID->issuance_date)->format('Y-m-d') }}">
                @csrf
                @method('PUT')
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Stock</label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" class="form-control" value="{{ optional(optional($issuanceID->GetStock)->GetAsset)->type }} | {{ optional($issuanceID->GetStock)->serial_no }}" readonly>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Employee</label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" class="form-control" value="{{ optional($issuanceID->GetEmployee)->emp_name }} | {{ optional($issuanceID->GetEmployee)->designation }} | {{ optional(optional($issuanceID->GetEmployee)->GetDepartment)->dep_name }}" readonly>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Date of Issuance</label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" class="form-control" value="{{ optional($issuanceID->issuance_date)->format('d-M-Y') }}" readonly>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Location</label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" class="form-control" value="{{ $issuanceID->location }}" readonly>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Return Date <span class="required">*</span></label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="date" class="form-control" name="return_date" value="{{ old('return_date', date('Y-m-d')) }}">
                    <span class="form-control-feedback right">@error('return_date') {{ $message }} @enderror</span>
                  </div>
                </div>
                <div class="ln_solid"></div>
                <div class="form-group">
                  <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <a href="{{ url('stock-return') }}" class="btn btn-primary">Back</a>
                    <button type="submit" class="btn btn-success">Return to Stock</button>
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('js/stock-return-confirm.js') }}"></script>
<style>
  .return-confirm-popup { font-size: 15px; }
  .return-confirm-details { text-align: left; }
  .return-confirm-details p { margin: 0 0 8px; }
  .return-confirm-details label { display: block; margin-top: 12px; font-weight: 600; }
  .return-confirm-popup .swal2-input { margin: 8px 0 0; width: 100%; height: 38px; }
  .return-confirm-popup .swal2-actions { gap: 8px; }
  .return-confirm-popup .btn { margin: 0 4px; min-width: 120px; }
</style>
@endpush


@extends('common.master')
@section('content')
<div class="right_col bgimg" role="main">
    <div class="">
      <div class="page-title">
        <div class="title_left">
          <h3>Lahore Waste Management Company</h3>
        </div>
      </div>

      <div class="clearfix"></div>

      <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel">
            <div class="x_title">
              <h2>Stock Return</h2>
              <div class="clearfix"></div>
            </div>
            <div class="x_content">
              <table id="datatable-buttons" class="table table-striped table-bordered">
                <thead>
                  <tr>
                    <th>Sr.</th>
                    <th>Assigned To</th>
                    <th>Asset Type</th>
                    <th>Model</th>
                    <th>Serial No.</th>
                    <th>Issue Date</th>
                    <th>Location</th>
                    <th>Action</th>
                  </tr>
                </thead>
                @php $counter = 1; @endphp
                <tbody>
                @foreach ($issuancedata as $data)
                <tr>
                    <td>{{ $counter++ }}</td>
                    <td>{{ $data->assigned_to_display }}</td>
                    <td>{{ optional(optional($data->getStock)->getAsset)->type ?? '-' }}</td>
                    <td>{{ optional($data->getStock)->model ?? '-' }}</td>
                    <td>{{ optional($data->getStock)->serial_no ?? '-' }}</td>
                    <td>{{ optional($data->issuance_date)->format('d-M-Y') }}</td>
                    <td>{{ $data->location_display }}</td>
                    <td>
                      @if(auth()->user()?->canManageInventory())
                      <a href="{{ route('returnIssuance', $data->id) }}"
                         class="btn btn-app js-return-asset"
                         style="padding: 5px 5px; min-width: 39px; height: 31px;"
                         title="Return to stock"
                         data-url="{{ url('returnIssuance/'.$data->id) }}"
                         data-employee="{{ optional($data->getEmployee)->emp_name ?? '-' }}"
                         data-asset="{{ optional(optional($data->getStock)->getAsset)->type ?? '-' }} {{ optional($data->getStock)->model }}"
                         data-serial="{{ optional($data->getStock)->serial_no ?? '-' }}"
                         data-issue-date="{{ optional($data->issuance_date)->format('Y-m-d') }}">
                        <i class="fa fa-undo"></i>
                      </a>
                      @else
                      —
                      @endif
                    </td>
                </tr>
                @endforeach
                </tbody>
              </table>
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

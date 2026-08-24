
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
              <h2>Issuance History</h2>
              <div class="clearfix"></div>
            </div>
            <div class="x_content">
              <style>
                .history-filters .form-group { margin-bottom: 12px; }
                .history-filters label { display: block; }
                .history-filters .select2-container { width: 100% !important; }
                .history-filters .select2-container .select2-selection--single {
                  height: 34px;
                  border: 1px solid #ccc;
                }
                .history-filters .filter-actions .btn { margin-right: 6px; }
              </style>
              <form method="GET" action="{{ url('issuance-history') }}" class="history-filters">
                <div class="row">
                  <div class="col-md-4 col-sm-4 col-xs-12">
                    <div class="form-group">
                      <label>Employee</label>
                      <select class="form-control history-select" name="employee_id">
                        <option value="">All Employees</option>
                        @foreach ($employees as $employee)
                          <option value="{{ $employee->id }}" {{ (string) request('employee_id') === (string) $employee->id ? 'selected' : '' }}>
                            {{ $employee->emp_name }} | {{ $employee->designation }} | {{ optional($employee->GetDepartment)->dep_name }}
                          </option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="col-md-4 col-sm-4 col-xs-12">
                    <div class="form-group">
                      <label>Asset Type</label>
                      <select class="form-control history-select" name="asset_id" id="history-asset-type">
                        <option value="">All Types</option>
                        @foreach ($assets as $asset)
                          <option value="{{ $asset->id }}" {{ (string) request('asset_id') === (string) $asset->id ? 'selected' : '' }}>
                            {{ $asset->type }}
                          </option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="col-md-4 col-sm-4 col-xs-12">
                    <div class="form-group">
                      <label>Specific Asset (Serial)</label>
                      <select class="form-control history-select" name="stock_id" id="history-stock">
                        <option value="">All Serials</option>
                        @foreach ($stocks as $stock)
                          <option value="{{ $stock->id }}"
                                  data-asset-id="{{ $stock->asset_id }}"
                                  {{ (string) request('stock_id') === (string) $stock->id ? 'selected' : '' }}>
                            {{ optional($stock->getAsset)->type ?? 'Asset' }} | {{ $stock->model ?: '-' }} | {{ $stock->serial_no }}
                          </option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="col-md-4 col-sm-4 col-xs-12">
                    <div class="form-group">
                      <label>Status</label>
                      <select class="form-control history-select" name="status">
                        <option value="">All</option>
                        <option value="issued" {{ request('status') === 'issued' ? 'selected' : '' }}>Currently Issued</option>
                        <option value="returned" {{ request('status') === 'returned' ? 'selected' : '' }}>Returned to Stock</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-4 col-sm-4 col-xs-12">
                    <div class="form-group">
                      <label>Issue From</label>
                      <input type="date" class="form-control" name="from_date" value="{{ request('from_date') }}">
                    </div>
                  </div>
                  <div class="col-md-4 col-sm-4 col-xs-12">
                    <div class="form-group">
                      <label>Issue To</label>
                      <input type="date" class="form-control" name="to_date" value="{{ request('to_date') }}">
                    </div>
                  </div>
                  <div class="col-md-4 col-sm-4 col-xs-12">
                    <div class="form-group filter-actions">
                      <label>&nbsp;</label>
                      <div>
                        <button type="submit" class="btn btn-success">Filter</button>
                        <a href="{{ url('issuance-history') }}" class="btn btn-primary">Reset</a>
                      </div>
                    </div>
                  </div>
                </div>
              </form>

              <p style="margin-top: 15px;">
                Total: <strong>{{ $history->count() }}</strong>
                &nbsp;|&nbsp; Currently Issued: <strong>{{ $issuedCount }}</strong>
                &nbsp;|&nbsp; Returned: <strong>{{ $returnedCount }}</strong>
                @if ($selectedStock)
                  <br>
                  Assignment trail for
                  <strong>{{ optional($selectedStock->getAsset)->type ?? 'Asset' }} | {{ $selectedStock->serial_no }}</strong>
                  (oldest to newest)
                @endif
              </p>

              <table id="datatable-buttons" class="table table-striped table-bordered">
                <thead>
                  <tr>
                    <th>Sr.</th>
                    <th>Assigned Type</th>
                    <th>Assign To</th>
                    <th>Designation</th>
                    <th>Department</th>
                    <th>Asset Type</th>
                    <th>Model</th>
                    <th>Serial No.</th>
                    <th>Issue Date</th>
                    <th>Return Date</th>
                    <th>Days Held</th>
                    <th>Location</th>
                    <th>Status</th>
                  </tr>
                </thead>
                @php $counter = 1; @endphp
                <tbody>
                @forelse ($history as $data)
                <tr>
                    <td>{{ $counter++ }}</td>
                    <td>{{ $data->assignment_type_label }}</td>
                    <td>{{ optional($data->getEmployee)->emp_name ?? $data->location_display }}</td>
                    <td>{{ optional($data->getEmployee)->designation ?? '-' }}</td>
                    <td>{{ optional(optional($data->getEmployee)->getDepartment)->dep_name ?? '-' }}</td>
                    <td>{{ optional(optional($data->getStock)->getAsset)->type ?? '-' }}</td>
                    <td>{{ optional($data->getStock)->model ?? '-' }}</td>
                    <td>{{ optional($data->getStock)->serial_no ?? '-' }}</td>
                    <td>{{ optional($data->issuance_date)->format('d-M-Y') }}</td>
                    <td>{{ optional($data->return_date)->format('d-M-Y') ?: '-' }}</td>
                    <td>{{ $data->held_for }}</td>
                    <td>{{ $data->location_display }}</td>
                    <td>{{ $data->history_status }}</td>
                </tr>
                @empty
                @endforelse
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
<script>
  $(document).ready(function() {
    function stockMatchesType(optionEl) {
      var assetId = $('#history-asset-type').val();
      if (!assetId || !optionEl || !optionEl.value) {
        return true;
      }
      return String($(optionEl).data('asset-id')) === String(assetId);
    }

    $('.history-select').not('#history-stock').select2({ width: '100%' });
    $('#history-stock').select2({
      width: '100%',
      matcher: function(params, data) {
        if (!stockMatchesType(data.element)) {
          return null;
        }
        if ($.trim(params.term) === '') {
          return data;
        }
        var term = params.term.toLowerCase();
        var text = (data.text || '').toLowerCase();
        return text.indexOf(term) > -1 ? data : null;
      }
    });

    $('#history-asset-type').on('change', function() {
      var $stock = $('#history-stock');
      var selected = $stock.find('option:selected').get(0);
      if (selected && !stockMatchesType(selected)) {
        $stock.val('').trigger('change');
      } else {
        $stock.trigger('change.select2');
      }
    });
  });
</script>
@endsection

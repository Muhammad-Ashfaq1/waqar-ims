
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
                    <th>Employee</th>
                    <th>Designation</th>
                    <th>Department</th>
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
                    <td>{{ optional($data->getEmployee)->emp_name ?? '-' }}</td>
                    <td>{{ optional($data->getEmployee)->designation ?? '-' }}</td>
                    <td>{{ optional(optional($data->getEmployee)->getDepartment)->dep_name ?? '-' }}</td>
                    <td>{{ optional(optional($data->getStock)->getAsset)->type ?? '-' }}</td>
                    <td>{{ optional($data->getStock)->model ?? '-' }}</td>
                    <td>{{ optional($data->getStock)->serial_no ?? '-' }}</td>
                    <td>{{ optional($data->issuance_date)->format('d-M-Y') }}</td>
                    <td>{{ $data->location ?: '-' }}</td>
                    <td>
                      <a href="{{ route('returnIssuance', $data->id) }}" class="btn btn-app" style="padding: 5px 5px; min-width: 39px; height: 31px;" title="Return to stock">
                        <i class="fa fa-undo"></i>
                      </a>
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

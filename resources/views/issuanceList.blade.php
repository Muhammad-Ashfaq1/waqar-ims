
@extends('common.master')
@section('content')
<div class="right_col bgimg" role="main">
    <div class="">
      <div class="page-title">
        <div class="title_left">
          <h3>Lahore Waste Management Company</h3>
        </div>

        <div class="title_right">
          <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
            <div class="input-group">


            </div>
          </div>
        </div>
      </div>

      <div class="clearfix"></div>

      <div class="row">


        <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel">
            <div class="x_title">
              <h2>Issued Stock</h2>
              <ul class="nav navbar-right panel_toolbox">
                @if(auth()->user()?->canManageInventory())
                <span class="input-group-btn">
                    <a href="{{url('addIssuance')}}" class="btn btn-primary"><span style="color: white;">Add New</span></a>
                  </span>
                @endif
              </ul>
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
                    <th>Status</th>
                    <th>Location</th>
                    <th>Action</th>

                  </tr>
                </thead>

                @php $counter=1;
                @endphp
                <tbody>
                @foreach ($issuancedata as $data)
                <tr>
                    <td>{{$counter++}}</td>
                    <td>{{ $data->assigned_to_display }}</td>
                    <td>{{$data->getStock->getAsset['type']}}</td>
                    <td>{{$data->getStock['model']}}</td>
                    <td>{{$data->getStock['serial_no']}}</td>
                    <td>{{ optional($data->issuance_date)->format('d-M-Y') }}</td>
                    <td>{{$data->getStock['status']}}</td>
                    <td>{{$data->location_display}}</td>
                    <td>
                      @if(auth()->user()?->canManageInventory())
                      <a href="{{route('editIssuance', $data->id)}}" class="btn btn-app" style="padding: 5px 5px; min-width: 39px; height: 31px;">
                        <i class="fa fa-edit"></i>
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

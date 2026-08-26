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
            <h2>Location Departments List</h2>
            <ul class="nav navbar-right panel_toolbox">
              @can('base-data.manage')
              <span class="input-group-btn">
                <a href="{{ route('addLocationDepartment') }}" class="btn btn-primary">
                  <span style="color: white;">Add New</span>
                </a>
              </span>
              @endcan
            </ul>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">

            <!-- Filter Toolbar -->
            <div class="well well-sm" style="background: #fbfbfb; border: 1px solid #e5e5e5; margin-bottom: 20px; padding: 12px 15px;">
              <div class="row">
                <div class="col-md-4 col-sm-6 col-xs-12">
                  <label for="filter-location-select" style="font-weight: 600; margin-bottom: 5px; color: #444;">
                    <i class="fa fa-filter"></i> Filter by Location:
                  </label>
                  <select id="filter-location-select" class="form-control select2" style="width: 100%;">
                    <option value="">-- All Locations (Show All) --</option>
                    @foreach ($locations as $loc)
                      <option value="{{ $loc->id }}" {{ (string) $selectedLocationId === (string) $loc->id ? 'selected' : '' }}>
                        {{ $loc->name }} ({{ $loc->departments->count() }} depts)
                      </option>
                    @endforeach
                  </select>
                </div>
                <div class="col-md-8 col-sm-6 col-xs-12 text-right" style="padding-top: 25px;">
                  <button type="button" id="btn-clear-filter" class="btn btn-sm btn-default">
                    <i class="fa fa-times"></i> Clear Filter
                  </button>
                </div>
              </div>
            </div>

@push('styles')
<style>
  #datatable-location-departments td, #datatable-location-departments th {
    vertical-align: middle !important;
  }
  .dept-badges-wrapper {
    display: flex;
    flex-wrap: wrap;
    gap: 4px;
    align-items: center;
    white-space: normal !important;
  }
  .dept-pill {
    display: inline-block;
    background-color: #26b99a;
    color: #fff;
    font-size: 11px;
    font-weight: normal;
    padding: 3px 8px;
    border-radius: 3px;
    white-space: nowrap;
  }
  .toggle-depts-btn {
    padding: 2px 6px;
    font-size: 10px;
    border-radius: 3px;
    font-weight: 600;
    color: #555;
    background: #eee;
    border: 1px solid #ccc;
    cursor: pointer;
  }
  .toggle-depts-btn:hover {
    background: #ddd;
  }
</style>
@endpush

            <!-- Table -->
            <table id="datatable-buttons" class="table table-striped table-bordered" cellspacing="0" width="100%">
              <thead>
                <tr>
                  <th style="width: 50px;">Sr.</th>
                  <th style="width: 200px;">Location</th>
                  <th style="min-width: 300px;">Assigned Departments</th>
                  <th style="width: 100px;" class="text-center">Total Depts</th>
                  <th style="width: 80px;" class="text-center">Action</th>
                </tr>
              </thead>
              <tbody>
                @php $count = 0; @endphp
                @foreach ($locations as $loc)
                <tr class="location-row" data-location-id="{{ $loc->id }}">
                  <td>{{ ++$count }}</td>
                  <td>
                    <strong>{{ $loc->name }}</strong>
                    @if(!$loc->is_active)
                      <span class="label label-default" style="font-size:10px; margin-left:4px;">Inactive</span>
                    @endif
                  </td>
                  <td style="white-space: normal !important;">
                    @if ($loc->departments->isNotEmpty())
                      <div class="dept-badges-wrapper">
                        @php
                          $departments = $loc->departments;
                          $limit = 10;
                          $hasMore = $departments->count() > $limit;
                        @endphp
                        @foreach ($departments->take($limit) as $dept)
                          <span class="dept-pill">{{ $dept->dep_name }}</span>
                        @endforeach

                        @if ($hasMore)
                          <span id="extra-depts-{{ $loc->id }}" style="display: none;">
                            @foreach ($departments->slice($limit) as $dept)
                              <span class="dept-pill" style="margin-top: 2px;">{{ $dept->dep_name }}</span>
                            @endforeach
                          </span>
                          <button type="button" class="btn btn-default btn-xs toggle-depts-btn" data-target="#extra-depts-{{ $loc->id }}" data-count="{{ $departments->count() - $limit }}">
                            +{{ $departments->count() - $limit }} more
                          </button>
                        @endif
                      </div>
                    @else
                      <span class="text-muted" style="font-style: italic;">No departments linked</span>
                    @endif
                  </td>
                  <td class="text-center">
                    <span class="badge {{ $loc->departments->count() > 0 ? 'bg-green' : 'bg-grey' }}" style="font-size: 12px; padding: 4px 8px;">
                      {{ $loc->departments->count() }}
                    </span>
                  </td>
                  <td class="text-center">
                    @can('base-data.manage')
                    <a href="{{ route('editLocationDepartment', $loc->id) }}" class="btn btn-app" style="padding: 5px 5px; min-width: 39px; height: 31px;" title="Edit / Manage Departments">
                      <i class="fa fa-edit"></i>
                    </a>
                    @else
                    —
                    @endcan
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
<script>
$(document).ready(function () {
  if ($.fn.select2) {
    $('.select2').select2({ width: '100%' });
  }

  // Filter Table by Location
  $('#filter-location-select').on('change', function () {
    var selectedLoc = $(this).val();
    if ($.fn.DataTable && $.fn.DataTable.isDataTable('#datatable-buttons')) {
      var table = $('#datatable-buttons').DataTable();
      if (!selectedLoc) {
        table.column(1).search('').draw();
      } else {
        var locName = $('#filter-location-select option:selected').text().split('(')[0].trim();
        table.column(1).search('^' + locName + '$', true, false).draw();
      }
    } else {
      $('.location-row').each(function () {
        var rowLocId = $(this).data('location-id');
        if (!selectedLoc || String(rowLocId) === String(selectedLoc)) {
          $(this).show();
        } else {
          $(this).hide();
        }
      });
    }
  });

  $('#btn-clear-filter').on('click', function () {
    $('#filter-location-select').val('').trigger('change');
  });

  // Toggle more departments
  $(document).on('click', '.toggle-depts-btn', function () {
    var target = $(this).data('target');
    var count = $(this).data('count');
    var $target = $(target);
    if ($target.is(':visible')) {
      $target.hide();
      $(this).text('+' + count + ' more');
    } else {
      $target.show();
      $(this).text('Show less');
    }
  });

  // Apply initial filter if passed in query string
  var initialFilter = $('#filter-location-select').val();
  if (initialFilter) {
    $('#filter-location-select').trigger('change');
  }
});
</script>
@endpush

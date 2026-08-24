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
            <h2>Locations / Workshops</h2>
            <ul class="nav navbar-right panel_toolbox">
              @can('base-data.manage')
              <span class="input-group-btn">
                <a href="{{ url('add-location') }}" class="btn btn-primary"><span style="color: white;">Add New</span></a>
              </span>
              @endcan
            </ul>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <table id="datatable-buttons" class="table table-striped table-bordered">
              <thead>
                <tr>
                  <th>Sr.</th>
                  <th>Location</th>
                  <th>Slug</th>
                  <th>Type</th>
                  <th>Status</th>
                  <th>Created</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @php $count = 0; @endphp
                @foreach ($locations as $data)
                <tr>
                  <td>{{ ++$count }}</td>
                  <td>{{ $data->name }}</td>
                  <td>{{ $data->slug }}</td>
                  <td>{{ $data->type_label }}</td>
                  <td>
                    @if($data->is_active)
                      <span class="label label-success">Active</span>
                    @else
                      <span class="label label-default">Inactive</span>
                    @endif
                  </td>
                  <td>{{ $data->created_at }}</td>
                  <td>
                    @can('base-data.manage')
                    <a href="{{ route('editLocation', $data->id) }}" class="btn btn-app" style="padding: 5px 5px; min-width: 39px; height: 31px;" title="Edit">
                      <i class="fa fa-edit"></i>
                    </a>
                    <form id="delete-location-form-{{ $data->id }}" action="{{ url('delete-location/'.$data->id) }}" method="POST" style="display:inline;">
                      @csrf
                      @method('DELETE')
                      <button type="button"
                              class="btn btn-app js-delete-location"
                              style="padding: 5px 5px; min-width: 39px; height: 31px;"
                              title="Delete"
                              data-form="#delete-location-form-{{ $data->id }}"
                              data-name="{{ $data->name }}">
                        <i class="fa fa-trash"></i>
                      </button>
                    </form>
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).on('click', '.js-delete-location', function (e) {
  e.preventDefault();
  var formSelector = $(this).data('form');
  var name = $(this).data('name') || 'this location';

  Swal.fire({
    title: 'Delete this location?',
    text: 'You want to delete "' + name + '"?',
    icon: 'warning',
    showCancelButton: true,
    focusCancel: true,
    reverseButtons: true,
    confirmButtonText: 'Yes, delete it',
    cancelButtonText: 'Cancel',
    confirmButtonColor: '#d9534f',
    cancelButtonColor: '#73879C',
    customClass: {
      confirmButton: 'btn btn-danger',
      cancelButton: 'btn btn-default',
    },
    buttonsStyling: false,
  }).then(function (result) {
    if (result.isConfirmed) {
      $(formSelector).submit();
    }
  });
});
</script>
@endpush

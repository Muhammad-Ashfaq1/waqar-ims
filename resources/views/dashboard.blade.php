@extends('common.master')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/ims-glass.css') }}">
<link rel="stylesheet" href="{{ asset('css/ims-dashboard.css') }}">
@endpush

@section('content')

@php
    $kpis = [
        ['label' => 'Total Assets', 'value' => $totalStock, 'icon' => 'fa-cubes', 'tone' => 'primary', 'sub' => 'All stock items', 'href' => url('stocklist')],
        ['label' => 'In Stock', 'value' => $inStockCount, 'icon' => 'fa-archive', 'tone' => 'success', 'sub' => 'Available in store', 'href' => url('stocklist')],
        ['label' => 'Issued', 'value' => $issuedCount, 'icon' => 'fa-share', 'tone' => 'info', 'sub' => 'With employees', 'href' => url('issuance')],
        ['label' => 'Pending Returns', 'value' => $pendingReturns, 'icon' => 'fa-undo', 'tone' => 'warning', 'sub' => 'Still with staff', 'href' => url('stock-return')],
        ['label' => 'Issued This Month', 'value' => $issuedThisMonth, 'icon' => 'fa-calendar', 'tone' => 'primary', 'sub' => now()->format('M Y'), 'href' => url('issuance-history')],
        ['label' => 'Returned This Month', 'value' => $returnedThisMonth, 'icon' => 'fa-check-square-o', 'tone' => 'success', 'sub' => 'Back to stock', 'href' => url('issuance-history').'?status=returned'],
    ];
    $figures = [
        ['label' => 'Active Employees', 'value' => $activeEmployees, 'icon' => 'fa-user', 'tone' => 'success', 'sub' => $employee.' total staff', 'href' => url('employeeinfo')],
        ['label' => 'Departments', 'value' => $departmentCount, 'icon' => 'fa-building', 'tone' => 'secondary', 'sub' => 'Base data', 'href' => url('departmentinfo')],
        ['label' => 'Asset Types', 'value' => $assetTypeCount, 'icon' => 'fa-tags', 'tone' => 'info', 'sub' => 'Registered types', 'href' => url('assetTypeInfo')],
        ['label' => 'Repairable', 'value' => $repairableCount, 'icon' => 'fa-wrench', 'tone' => 'warning', 'sub' => 'Under repair', 'href' => url('stocklist')],
        ['label' => 'Warranty Expired', 'value' => $expiredCount, 'icon' => 'fa-times-circle', 'tone' => 'danger', 'sub' => 'Past expiry date', 'href' => url('stocklist')],
        ['label' => 'Expiring in 90 Days', 'value' => $expiringSoonCount, 'icon' => 'fa-clock-o', 'tone' => 'warning', 'sub' => 'Warranty watch', 'href' => url('stocklist')],
    ];
    $laptopYears = [
        '2010-2013' => $laptop_year1,
        '2015-2018' => $laptop_year2,
        '2019-2021' => $laptop_year3,
        '2022-2023' => $laptop_year4,
        '2024' => $laptop_year5,
    ];
    $laptopYearMax = max(1, max($laptopYears));
    $desktopModels = [
        'HP Elite-Desk-800' => $d1,
        'Accer Veriton M275' => $d2,
        'Dell Optiplex 3080' => $d3,
        'Dell Optiplex 3010' => $d4,
        'Dell Optiplex 3090' => $d5,
        'Dell Optiplex 5050' => $d6,
        'Dell Optiplex 7010' => $d7,
        'Dell Optiplex 7020' => $d8,
        'Dell OptiPlex 7080' => $d9,
        'Dell Optiplex 9010' => $d10,
        'Dell OptiPlex 9020' => $d11,
        'Dell Vostro 230' => $d12,
        'Dell Vostro 270' => $d13,
        'HP Compaq M6200' => $d14,
    ];
@endphp

<div class="right_col ims-dash" role="main">
  <div class="ims-dash-page">
    <h3>Dashboard</h3>
    <p>Inventory overview from stock, issuance, and return.</p>
  </div>

  <div class="row ims-dash-row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="ims-glass-card ims-tone-primary">
        <div class="ims-glass-intro">
          <div class="ims-glass-intro-copy">
            <h4 class="ims-glass-intro-title">Welcome back to MIS Inventory</h4>
            <p class="ims-glass-intro-subtitle">
              {{ number_format($totalStock) }} assets on record ·
              {{ number_format($issuedCount) }} currently issued ·
              {{ number_format($pendingReturns) }} waiting to return
            </p>
          </div>
          <div class="ims-glass-intro-actions">
            <a href="{{ url('addIssuance') }}" class="ims-btn ims-btn-primary">
              <i class="fa fa-plus" aria-hidden="true"></i> New Issuance
            </a>
            <a href="{{ url('stock-return') }}" class="ims-btn ims-btn-ghost">Return Stock</a>
            <a href="{{ url('issuance-history') }}" class="ims-glass-pill ims-tone-success">
              <i class="fa fa-line-chart" aria-hidden="true"></i>
              {{ now()->format('M Y') }}: {{ $issuedThisMonth }} issued / {{ $returnedThisMonth }} returned
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="row ims-dash-row ims-dash-kpis">
    @foreach ($kpis as $card)
      <div class="col-lg-2 col-md-4 col-sm-6 col-xs-12">
        <div class="ims-glass-card ims-tone-{{ $card['tone'] }} ims-dash-card-fill">
          <div class="ims-stat-body">
            <div class="ims-stat-head">
              <span class="ims-stat-icon"><i class="fa {{ $card['icon'] }}" aria-hidden="true"></i></span>
              <h6 class="ims-stat-label">{{ $card['label'] }}</h6>
            </div>
            <p class="ims-stat-value">{{ number_format($card['value']) }}</p>
            <p class="ims-stat-note"><a href="{{ $card['href'] }}">{{ $card['sub'] }}</a></p>
          </div>
        </div>
      </div>
    @endforeach
  </div>

  <div class="row ims-dash-row ims-dash-kpis">
    @foreach ($figures as $card)
      <div class="col-lg-2 col-md-4 col-sm-6 col-xs-12">
        <div class="ims-glass-card ims-tone-{{ $card['tone'] }} ims-dash-card-fill">
          <div class="ims-stat-body">
            <div class="ims-stat-head">
              <span class="ims-stat-icon"><i class="fa {{ $card['icon'] }}" aria-hidden="true"></i></span>
              <h6 class="ims-stat-label">{{ $card['label'] }}</h6>
            </div>
            <p class="ims-stat-value">{{ number_format($card['value']) }}</p>
            <p class="ims-stat-note"><a href="{{ $card['href'] }}">{{ $card['sub'] }}</a></p>
          </div>
        </div>
      </div>
    @endforeach
  </div>

  <div class="row ims-dash-row">
    <div class="col-md-6 col-sm-12 col-xs-12">
      <div class="ims-glass-card ims-tone-primary ims-dash-card-fill">
        <div class="ims-dash-panel-head">
          <div>
            <h5>Stock by Asset Type</h5>
            <small>Live counts from the stock register</small>
          </div>
          <a href="{{ url('stocklist') }}" class="ims-btn ims-btn-ghost">View stock</a>
        </div>
        <div class="ims-dash-panel-body">
          <table class="table ims-dash-table">
            <thead>
              <tr>
                <th>Type</th>
                <th>Total</th>
                <th>In Stock</th>
                <th>Issued</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($stockByType as $row)
              <tr>
                <td>{{ $row->type }}</td>
                <td>{{ $row->total }}</td>
                <td>{{ $row->in_stock }}</td>
                <td>{{ $row->issued }}</td>
              </tr>
              @empty
              <tr><td colspan="4">No stock records yet.</td></tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <div class="col-md-6 col-sm-12 col-xs-12">
      <div class="ims-glass-card ims-tone-info ims-dash-card-fill">
        <div class="ims-dash-panel-head">
          <div>
            <h5>Currently Issued by Department</h5>
            <small>Open issuances still with staff</small>
          </div>
          <a href="{{ url('issuance') }}" class="ims-btn ims-btn-ghost">View issuance</a>
        </div>
        <div class="ims-dash-panel-body">
          <table class="table ims-dash-table">
            <thead>
              <tr>
                <th>Department</th>
                <th>Assets with staff</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($issuedByDepartment as $row)
              <tr>
                <td>{{ $row->dep_name }}</td>
                <td>{{ $row->total }}</td>
              </tr>
              @empty
              <tr><td colspan="2">No assets currently issued.</td></tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <div class="row ims-dash-row">
    <div class="col-md-6 col-sm-12 col-xs-12">
      <div class="ims-glass-card ims-tone-success ims-dash-card-fill">
        <div class="ims-dash-panel-head">
          <div>
            <h5>Recent Issuances</h5>
            <small>Latest handovers</small>
          </div>
          <a href="{{ url('issuance-history') }}" class="ims-btn ims-btn-ghost">Full history</a>
        </div>
        <div class="ims-dash-panel-body">
          <table class="table ims-dash-table">
            <thead>
              <tr>
                <th>Employee</th>
                <th>Asset</th>
                <th>Serial</th>
                <th>Issue Date</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($recentIssuances as $row)
              <tr>
                <td>{{ optional($row->getEmployee)->emp_name ?? '-' }}</td>
                <td>{{ optional(optional($row->getStock)->getAsset)->type ?? '-' }}</td>
                <td>
                  <a href="{{ url('issuance-history') }}?stock_id={{ $row->stock_id }}">
                    {{ optional($row->getStock)->serial_no ?? '-' }}
                  </a>
                </td>
                <td>{{ optional($row->issuance_date)->format('d-M-Y') }}</td>
                <td>{{ $row->history_status }}</td>
              </tr>
              @empty
              <tr><td colspan="5">No issuance records yet.</td></tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <div class="col-md-6 col-sm-12 col-xs-12">
      <div class="ims-glass-card ims-tone-warning ims-dash-card-fill">
        <div class="ims-dash-panel-head">
          <div>
            <h5>Recent Returns</h5>
            <small>Assets back in store</small>
          </div>
          <a href="{{ url('stock-return') }}" class="ims-btn ims-btn-ghost">Return stock</a>
        </div>
        <div class="ims-dash-panel-body">
          <table class="table ims-dash-table">
            <thead>
              <tr>
                <th>Employee</th>
                <th>Asset</th>
                <th>Serial</th>
                <th>Return Date</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($recentReturns as $row)
              <tr>
                <td>{{ optional($row->getEmployee)->emp_name ?? '-' }}</td>
                <td>{{ optional(optional($row->getStock)->getAsset)->type ?? '-' }}</td>
                <td>
                  <a href="{{ url('issuance-history') }}?stock_id={{ $row->stock_id }}">
                    {{ optional($row->getStock)->serial_no ?? '-' }}
                  </a>
                </td>
                <td>{{ optional($row->return_date)->format('d-M-Y') }}</td>
              </tr>
              @empty
              <tr><td colspan="4">No returns recorded yet.</td></tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <div class="row ims-dash-row">
    <div class="col-md-8 col-sm-12 col-xs-12">
      <div class="ims-glass-card ims-tone-danger ims-dash-card-fill">
        <div class="ims-dash-panel-head">
          <div>
            <h5>Longest Currently Issued</h5>
            <small>Items held the longest by staff</small>
          </div>
          <a href="{{ url('stock-return') }}" class="ims-btn ims-btn-ghost">Return to stock</a>
        </div>
        <div class="ims-dash-panel-body">
          <table class="table ims-dash-table">
            <thead>
              <tr>
                <th>Employee</th>
                <th>Department</th>
                <th>Asset</th>
                <th>Serial</th>
                <th>Issue Date</th>
                <th>Days Held</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($longestHeld as $row)
              <tr>
                <td>{{ optional($row->getEmployee)->emp_name ?? '-' }}</td>
                <td>{{ optional(optional($row->getEmployee)->getDepartment)->dep_name ?? '-' }}</td>
                <td>{{ optional(optional($row->getStock)->getAsset)->type ?? '-' }}</td>
                <td>
                  <a href="{{ url('issuance-history') }}?stock_id={{ $row->stock_id }}">
                    {{ optional($row->getStock)->serial_no ?? '-' }}
                  </a>
                </td>
                <td>{{ optional($row->issuance_date)->format('d-M-Y') }}</td>
                  <td>{{ $row->held_for }}</td>
              </tr>
              @empty
              <tr><td colspan="6">No assets currently issued.</td></tr>
              @endforelse
            </tbody>
          </table>
          <p class="ims-dash-hint">Serial links open that asset's assignment trail in Issuance History.</p>
        </div>
      </div>
    </div>
    <div class="col-md-4 col-sm-12 col-xs-12">
      <div class="ims-glass-card ims-tone-warning ims-dash-card-fill">
        <div class="ims-dash-panel-head">
          <div>
            <h5>Warranty Watch</h5>
            <small>Expiry from stock records</small>
          </div>
        </div>
        <div class="ims-dash-panel-body">
          <div class="ims-dash-watch-row">
            <span>Expired</span>
            <strong>{{ $expiredCount }}</strong>
          </div>
          <div class="ims-dash-watch-row">
            <span>Expiring in 90 days</span>
            <strong>{{ $expiringSoonCount }}</strong>
          </div>
          <div class="ims-dash-watch-row">
            <span>Pending returns</span>
            <strong>{{ $pendingReturns }}</strong>
          </div>
          <div class="ims-dash-watch-row">
            <span>Dead / not usable</span>
            <strong>{{ $deadCount }}</strong>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="row ims-dash-row">
    <div class="col-md-4 col-sm-12 col-xs-12">
      <div class="ims-glass-card ims-tone-primary ims-dash-card-fill">
        <div class="ims-dash-panel-head">
          <div>
            <h5>Laptops Year Wise</h5>
            <small>By purchase date</small>
          </div>
        </div>
        <div class="ims-dash-panel-body">
          @foreach ($laptopYears as $label => $count)
            <div class="ims-dash-meter">
              <div class="ims-dash-meter-label">{{ $label }}</div>
              <div class="ims-dash-meter-track">
                <span class="ims-dash-meter-fill" style="width: {{ round(($count / $laptopYearMax) * 100) }}%;"></span>
              </div>
              <div class="ims-dash-meter-value">{{ $count }}</div>
            </div>
          @endforeach
        </div>
      </div>
    </div>
    <div class="col-md-8 col-sm-12 col-xs-12">
      <div class="ims-glass-card ims-tone-info ims-dash-card-fill">
        <div class="ims-dash-panel-head">
          <div>
            <h5>Desktop Computers</h5>
            <small>Count by model</small>
          </div>
        </div>
        <div class="ims-dash-panel-body">
          <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-12">
              <ul class="ims-dash-models">
                @foreach ($desktopModels as $model => $count)
                  @if ($loop->index < 7)
                    <li><span>{{ $model }}</span><strong>{{ $count }}</strong></li>
                  @endif
                @endforeach
              </ul>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <ul class="ims-dash-models">
                @foreach ($desktopModels as $model => $count)
                  @if ($loop->index >= 7)
                    <li><span>{{ $model }}</span><strong>{{ $count }}</strong></li>
                  @endif
                @endforeach
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@extends('common.master')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/ims-glass.css') }}">
<link rel="stylesheet" href="{{ asset('css/ims-dashboard.css') }}">
<style>
  .apexcharts-legend-marker,
  .apexcharts-legend-text,
  .apexcharts-legend-series .apexcharts-legend-marker,
  span.apexcharts-legend-marker,
  svg.apexcharts-legend-marker {
      border-radius: 50% !important;
      rx: 50% !important;
      ry: 50% !important;
  }
  .ims-laptop-year-card { padding: 20px 24px; border-radius: 16px; background: #ffffff; box-shadow: 0 4px 20px rgba(0,0,0,0.03); }
  .ims-laptop-year-card .ims-dash-panel-head { padding-bottom: 14px; border-bottom: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center; }
  .ims-laptop-year-title { display: flex; align-items: center; gap: 14px; }
  .ims-laptop-year-icon { width: 44px; height: 44px; border-radius: 12px; background: #f0eeff; color: #6c5ce7; display: inline-flex; align-items: center; justify-content: center; font-size: 20px; flex-shrink: 0; }
  .ims-laptop-year-title h5 { margin: 0; font-size: 17px; font-weight: 700; color: #1e1e2d; line-height: 1.2; }
  .ims-laptop-year-title small { color: #8a879b; font-size: 12px; }
  .ims-laptop-year-filter-pill { position: relative; display: inline-flex; align-items: center; gap: 6px; background: #ffffff; border: 1px solid #e6e4f5; border-radius: 8px; padding: 6px 12px; color: #4d4a63; font-size: 11px; font-weight: 600; cursor: pointer; box-shadow: 0 1px 2px rgba(0,0,0,0.02); }
  .ims-laptop-year-filter-pill select { position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0; cursor: pointer; z-index: 2; }
  .ims-laptop-year-main { display: flex; align-items: center; gap: 24px; margin-top: 18px; flex-wrap: wrap; }
  .ims-laptop-year-chart-container { flex: 1.2; min-width: 250px; display: flex; justify-content: center; align-items: center; position: relative; min-height: 270px; }
  .ims-laptop-year-right { flex: 1; min-width: 220px; display: flex; flex-direction: column; gap: 14px; }
  .ims-laptop-year-legend-box { background: #fdfdfd; border: 1px solid #e2e8f0; border-radius: 14px; padding: 6px 16px; box-shadow: 0 2px 6px rgba(0,0,0,0.01); }
  .ims-laptop-year-item { display: flex; align-items: center; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid #f1f5f9; font-size: 13px; transition: opacity 0.2s ease; }
  .ims-laptop-year-item:last-child { border-bottom: none; }
  .ims-laptop-year-item-left { display: flex; align-items: center; gap: 10px; }
  .ims-laptop-year-dot { width: 9px; height: 9px; border-radius: 50%; display: inline-block; flex-shrink: 0; }
  .ims-laptop-year-label { font-weight: 600; color: #334155; }
  .ims-laptop-year-item-right { display: flex; align-items: center; gap: 18px; }
  .ims-laptop-year-count { font-weight: 700; color: #1e293b; min-width: 24px; text-align: right; }
  .ims-laptop-year-pct { font-weight: 500; color: #64748b; min-width: 48px; text-align: right; font-size: 12px; }
  .ims-laptop-year-total { background: #f0eeff; color: #6c5ce7; border-radius: 12px; display: flex; justify-content: space-between; align-items: center; padding: 13px 20px; font-size: 14px; font-weight: 700; box-shadow: inset 0 0 0 1px rgba(108,92,231,0.08); }
  .ims-laptop-year-total strong { font-size: 20px; font-weight: 800; }
  @media (max-width: 767px) { .ims-laptop-year-main { flex-direction: column; } .ims-laptop-year-chart-container, .ims-laptop-year-right { width: 100%; } }
</style>
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
    $laptopYearTotal = array_sum($laptopYears);
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
            @if(auth()->user()?->canManageInventory())
            <a href="{{ url('addIssuance') }}" class="ims-btn ims-btn-primary">
              <i class="fa fa-plus" aria-hidden="true"></i> New Issuance
            </a>
            <a href="{{ url('stock-return') }}" class="ims-btn ims-btn-ghost">Return Stock</a>
            @endif
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

  <div class="ims-dash-section-label">Analytics &amp; Charts</div>
  {{-- ── CHARTS ROW 1: Issuance Trend + Stock Status Donut ── --}}
  <div class="row ims-dash-row">
    <div class="col-md-7 col-sm-12 col-xs-12">
      <div class="ims-glass-card ims-tone-primary ims-dash-card-fill">
        <div class="ims-dash-panel-head">
          <div>
            <h5>Issuance Trend</h5>
            <small>Monthly issuances &amp; returns — last 6 months</small>
          </div>
        </div>
        <div class="ims-dash-panel-body" style="padding:4px 0 0;">
          <div id="chartMonthly" style="min-height:260px;"></div>
        </div>
      </div>
    </div>
    <div class="col-md-5 col-sm-12 col-xs-12">
      <div class="ims-glass-card ims-tone-info ims-dash-card-fill">
        <div class="ims-dash-panel-head">
          <div>
            <h5>Stock Status</h5>
            <small>Current breakdown</small>
          </div>
        </div>
        <div class="ims-dash-panel-body" style="padding:4px 0 0;">
          <div id="chartStatus" style="min-height:260px;"></div>
        </div>
      </div>
    </div>
  </div>

  {{-- ── CHARTS ROW 2: Stock Allocation by Asset Category (Light Glass Radial Donut Cards Layout) ── --}}
  <div class="row ims-dash-row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="ims-glass-card ims-tone-primary ims-dash-card-fill" style="padding:16px 20px 20px;">
        
        {{-- Header matching project panel head style --}}
        <div class="ims-dash-panel-head" style="padding:0 0 16px 0;">
          <div>
            <h5 style="display:flex; align-items:center; gap:8px;">
              <i class="fa fa-bar-chart" style="color:rgb(var(--ims-primary-rgb));"></i> Stock Allocation by Asset Category
            </h5>
            <small>Live distribution of total stock, available store items, and employee holdings</small>
          </div>
        </div>

        {{-- 3 Summary Mini-Cards --}}
        @php
          $inStockPct = $totalStock > 0 ? round(($inStockCount / $totalStock) * 100, 2) : 0;
          $issuedPct  = $totalStock > 0 ? round(($issuedCount  / $totalStock) * 100, 2) : 0;
        @endphp
        <div style="display:flex; gap:14px; margin-bottom:20px; flex-wrap:wrap;">
          {{-- Card 1: Total Stock --}}
          <div style="flex:1; min-width:180px; background:#f5f5ff; border:1px solid #e0e0ff; border-radius:10px; padding:14px 16px; display:flex; align-items:center; gap:14px;">
            <div style="width:42px; height:42px; border-radius:10px; background:#ede9fe; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
              <i class="fa fa-cubes" style="color:#7367F0; font-size:18px;"></i>
            </div>
            <div>
              <div style="font-size:10px; font-weight:700; letter-spacing:.06em; text-transform:uppercase; color:var(--ims-muted);">TOTAL STOCK</div>
              <div style="font-size:26px; font-weight:700; color:var(--ims-heading); line-height:1.1; margin:2px 0;">{{ number_format($totalStock) }}</div>
              <div style="font-size:11px; color:var(--ims-muted);">All Assets</div>
            </div>
          </div>

          {{-- Card 2: In Store (Available) --}}
          <div style="flex:1; min-width:180px; background:#f0fdf4; border:1px solid #bbf7d0; border-radius:10px; padding:14px 16px; display:flex; align-items:center; gap:14px;">
            <div style="width:42px; height:42px; border-radius:10px; background:#dcfce7; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
              <i class="fa fa-archive" style="color:#28C76F; font-size:18px;"></i>
            </div>
            <div>
              <div style="font-size:10px; font-weight:700; letter-spacing:.06em; text-transform:uppercase; color:var(--ims-muted);">IN STORE (AVAILABLE)</div>
              <div style="font-size:26px; font-weight:700; color:var(--ims-heading); line-height:1.1; margin:2px 0;">{{ number_format($inStockCount) }}</div>
              <div style="font-size:11px; color:var(--ims-muted);">{{ $inStockPct }}% of total</div>
            </div>
          </div>

          {{-- Card 3: Currently Issued --}}
          <div style="flex:1; min-width:180px; background:#fff7ed; border:1px solid #fed7aa; border-radius:10px; padding:14px 16px; display:flex; align-items:center; gap:14px;">
            <div style="width:42px; height:42px; border-radius:10px; background:#ffedd5; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
              <i class="fa fa-user" style="color:#FF9F43; font-size:18px;"></i>
            </div>
            <div>
              <div style="font-size:10px; font-weight:700; letter-spacing:.06em; text-transform:uppercase; color:var(--ims-muted);">CURRENTLY ISSUED</div>
              <div style="font-size:26px; font-weight:700; color:var(--ims-heading); line-height:1.1; margin:2px 0;">{{ number_format($issuedCount) }}</div>
              <div style="font-size:11px; color:var(--ims-muted);">{{ $issuedPct }}% of total</div>
            </div>
          </div>
        </div>

        {{-- Radial Donut Cards Grid --}}
        <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(130px, 1fr)); gap:12px;">
          @foreach($stockByType as $index => $row)
            <div style="background:#ffffff; border:1px solid rgba(47,43,61,0.12); border-radius:12px; padding:14px 8px 10px; display:flex; flex-direction:column; align-items:center; justify-content:space-between; box-shadow:0 2px 6px rgba(47,43,61,0.04); transition: transform 0.2s, box-shadow 0.2s;">
              <div style="font-size:12px; font-weight:700; color:var(--ims-heading); text-align:center; width:100%; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;" title="{{ $row->type }}">
                {{ $row->type }}
              </div>

              {{-- Donut canvas container --}}
              <div style="position:relative; width:105px; height:105px; display:flex; align-items:center; justify-content:center; margin:6px 0;">
                <div id="catDonut_{{ $index }}" style="width:105px; height:105px;"></div>
              </div>

              {{-- Stats under donut --}}
              <div style="text-align:center; width:100%; font-size:11px; font-weight:700;">
                <div style="color:#28C76F; line-height:1.2;">{{ number_format($row->in_stock) }}</div>
                <div style="color:#FF9F43; line-height:1.2; margin-top:2px;">{{ number_format($row->issued) }}</div>
              </div>
            </div>
          @endforeach
        </div>

        {{-- Bottom Legend Pill --}}
        <div style="display:flex; justify-content:center; margin-top:20px;">
          <div style="background:#ffffff; border:1px solid rgba(47,43,61,0.12); border-radius:30px; padding:8px 24px; display:inline-flex; gap:24px; align-items:center; flex-wrap:wrap; justify-content:center; box-shadow:0 2px 6px rgba(47,43,61,0.03);">
            <div style="display:flex; align-items:center; gap:8px;">
              <span style="width:10px; height:10px; border-radius:50%; background:#7367f0; display:inline-block;"></span>
              <span style="color:var(--ims-muted); font-size:12px; font-weight:600;">Total Stock</span>
            </div>
            <div style="display:flex; align-items:center; gap:8px;">
              <span style="width:10px; height:10px; border-radius:50%; background:#28C76F; display:inline-block;"></span>
              <span style="color:var(--ims-muted); font-size:12px; font-weight:600;">In Store (Available)</span>
            </div>
            <div style="display:flex; align-items:center; gap:8px;">
              <span style="width:10px; height:10px; border-radius:50%; background:#FF9F43; display:inline-block;"></span>
              <span style="color:var(--ims-muted); font-size:12px; font-weight:600;">Currently Issued</span>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>

  <div class="row ims-dash-row ims-dash-row-equal">
    <div class="col-md-6 col-sm-12 col-xs-12">
      <div class="ims-glass-card ims-tone-primary ims-dash-card-fill">
        <div class="ims-dash-panel-head">
          <div>
            <h5>Stock by Asset Type</h5>
            <small>Live counts from the stock register</small>
          </div>
          <a href="{{ url('stocklist') }}" class="ims-btn ims-btn-ghost">View stock</a>
        </div>
        <div class="ims-dash-panel-body ims-dash-panel-body-tight ims-dash-panel-grow">
          <div class="ims-dash-table-scroll">
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
    </div>
    <div class="col-md-6 col-sm-12 col-xs-12">
      <div class="ims-glass-card ims-tone-info ims-dash-card-fill">
        <div class="ims-dash-panel-head">
          <div>
            <h5>Currently Issued by Department</h5>
            <small>Laptops, desktops, printers &amp; scanners with staff</small>
          </div>
          <a href="{{ url('issuance') }}" class="ims-btn ims-btn-ghost">View issuance</a>
        </div>
        <div class="ims-dash-panel-body ims-dash-panel-body-tight ims-dash-panel-grow">
          <div class="ims-dash-table-scroll">
            <table class="table ims-dash-table">
              <thead>
                <tr>
                  <th>Department</th>
                  <th>Laptops</th>
                  <th>Desktops</th>
                  <th>Printers</th>
                  <th>Scanners</th>
                </tr>
              </thead>
              <tbody>
                @forelse ($issuedByDepartment as $row)
                <tr>
                  <td>{{ $row->dep_name }}</td>
                  <td>{{ (int) $row->laptops }}</td>
                  <td>{{ (int) $row->desktops }}</td>
                  <td>{{ (int) $row->printers }}</td>
                  <td>{{ (int) $row->scanners }}</td>
                </tr>
                @empty
                <tr><td colspan="5">No assets currently issued.</td></tr>
                @endforelse
              </tbody>
            </table>
          </div>
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
                <th>Assigned Type</th>
                <th>Assign To</th>
                <th>Asset</th>
                <th>Serial</th>
                <th>Issue Date</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($recentIssuances as $row)
              <tr>
                <td>{{ $row->assignment_type_label }}</td>
                <td>{{ optional($row->getEmployee)->emp_name ?? $row->location_display }}</td>
                <td>{{ optional(optional($row->getStock)->getAsset)->type ?? '-' }}</td>
                <td>
                  <a href="{{ url('issuance-history') }}?stock_id={{ $row->stock_id }}">
                    {{ optional($row->getStock)->serial_no ?? '-' }}
                  </a>
                </td>
                <td>{{ optional($row->issuance_date)->format('d-M-Y') }}</td>
                <td>
                  @if($row->history_status === 'Issued')
                    <span class="ims-badge ims-badge-issued">● Issued</span>
                  @else
                    <span class="ims-badge ims-badge-returned">✓ Returned</span>
                  @endif
                </td>
              </tr>
              @empty
              <tr><td colspan="6">No issuance records yet.</td></tr>
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
                <th>Assigned Type</th>
                <th>Assign To</th>
                <th>Asset</th>
                <th>Serial</th>
                <th>Return Date</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($recentReturns as $row)
              <tr>
                <td>{{ $row->assignment_type_label }}</td>
                <td>{{ optional($row->getEmployee)->emp_name ?? $row->location_display }}</td>
                <td>{{ optional(optional($row->getStock)->getAsset)->type ?? '-' }}</td>
                <td>
                  <a href="{{ url('issuance-history') }}?stock_id={{ $row->stock_id }}">
                    {{ optional($row->getStock)->serial_no ?? '-' }}
                  </a>
                </td>
                <td>{{ optional($row->return_date)->format('d-M-Y') }}</td>
              </tr>
              @empty
              <tr><td colspan="5">No returns recorded yet.</td></tr>
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
                <th>Assigned Type</th>
                <th>Assign To</th>
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
                <td>{{ $row->assignment_type_label }}</td>
                <td>{{ optional($row->getEmployee)->emp_name ?? $row->location_display }}</td>
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
              <tr><td colspan="7">No assets currently issued.</td></tr>
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
    <div class="col-md-6 col-sm-12 col-xs-12">
      <div class="ims-glass-card ims-tone-primary ims-dash-card-fill ims-laptop-year-card">
        <div class="ims-dash-panel-head">
          <div class="ims-laptop-year-title">
            <span class="ims-laptop-year-icon"><i class="fa fa-laptop"></i></span>
            <div>
              <h5>Laptops Year Wise</h5>
              <small>By purchase date</small>
            </div>
          </div>
          <div class="ims-laptop-year-filter-pill">
            <i class="fa fa-calendar"></i>
            <span id="laptop-year-label-text">All Years</span>
            <i class="fa fa-angle-down" style="margin-left: 2px;"></i>
            <select id="laptop-year-select">
              <option value="all">All Years</option>
              @foreach ($laptopYears as $label => $count)
                <option value="{{ $label }}">{{ $label }} ({{ $count }})</option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="ims-dash-panel-body ims-laptop-year-main">
          <div class="ims-laptop-year-chart-container">
            <div id="chartLaptopYear" style="width: 100%; min-height: 290px;"></div>
          </div>
          <div class="ims-laptop-year-right">
            <div class="ims-laptop-year-legend-box">
              @php $laptopYearColors = ['#7B61FF', '#4F80FF', '#31D0AA', '#FFB020', '#9DA4B4']; @endphp
              @foreach ($laptopYears as $label => $count)
                <div class="ims-laptop-year-item" data-year="{{ $label }}">
                  <div class="ims-laptop-year-item-left">
                    <span class="ims-laptop-year-dot" style="background: {{ $laptopYearColors[$loop->index] }};"></span>
                    <span class="ims-laptop-year-label">{{ $label }}</span>
                  </div>
                  <div class="ims-laptop-year-item-right">
                    <span class="ims-laptop-year-count">{{ $count }}</span>
                    <span class="ims-laptop-year-pct">{{ $laptopYearTotal ? number_format(($count / $laptopYearTotal) * 100, 1) : 0 }}%</span>
                  </div>
                </div>
              @endforeach
            </div>
            <div class="ims-laptop-year-total">
              <span>Total Laptops</span>
              <strong id="laptop-year-total-count">{{ $laptopYearTotal }}</strong>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-6 col-sm-12 col-xs-12">
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

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts@3/dist/apexcharts.min.js"></script>
<script>
$(document).ready(function () {
  if (typeof ApexCharts === 'undefined') {
    console.error('ApexCharts library failed to load.');
    return;
  }

  /* ── Count-up animation ── */
  function countUp(el, target, duration) {
    var start = 0, step = target / (duration / 16);
    var timer = setInterval(function () {
      start += step;
      if (start >= target) { start = target; clearInterval(timer); }
      el.textContent = Math.round(start).toLocaleString();
    }, 16);
  }
  document.querySelectorAll('.ims-stat-value').forEach(function (el) {
    var raw = el.textContent.replace(/,/g, '').trim();
    var n = parseInt(raw, 10);
    if (!isNaN(n) && n > 0) {
      el.textContent = '0';
      setTimeout(function () { countUp(el, n, 900); }, 200);
    }
  });

  // ── 1. Line — Issuance Trend ──
  try {
    var elMonthly = document.getElementById('chartMonthly');
    if (elMonthly) {
      var monthly = {!! $monthlyData->toJson() !!};
      new ApexCharts(elMonthly, {
        chart: { type: 'area', height: 280, toolbar: { show: false }, zoom: { enabled: false }, fontFamily: 'inherit' },
        series: [
          { name: 'Issued',   data: monthly.map(function(r){ return r.issued; }) },
          { name: 'Returned', data: monthly.map(function(r){ return r.returned; }) }
        ],
        xaxis: { categories: monthly.map(function(r){ return r.month; }), axisBorder: { show: false }, axisTicks: { show: false } },
        yaxis: { labels: { formatter: function(v){ return Math.round(v); } }, min: 0 },
        colors: ['#7367F0','#28C76F'],
        fill: { type: 'gradient', gradient: { shadeIntensity: 1, opacityFrom: 0.35, opacityTo: 0.05 } },
        stroke: { curve: 'smooth', width: 2 },
        markers: { size: 4 },
        dataLabels: { enabled: false },
        legend: { position: 'top', horizontalAlign: 'right', markers: { width: 10, height: 10, radius: 12 } },
        grid: { borderColor: '#f1f1f1', strokeDashArray: 4 },
        tooltip: { shared: true, intersect: false }
      }).render();
    }
  } catch(e) { console.error('chartMonthly error:', e); }

  // ── 2. Donut — Stock Status ──
  try {
    var elStatus = document.getElementById('chartStatus');
    if (elStatus) {
      new ApexCharts(elStatus, {
        chart: { type: 'donut', height: 280, fontFamily: 'inherit' },
        series: [{{ (int)$inStockCount }}, {{ (int)$issuedCount }}, {{ (int)$repairableCount }}, {{ (int)$deadCount }}, {{ (int)$notReceivableCount }}],
        labels: ['In Stock','Issued','Repairable','Dead','Not Receivable'],
        colors: ['#10B981','#7367F0','#FF9F43','#EA5455','#A8AAAE'],
        plotOptions: { pie: { donut: { size: '65%', labels: {
          show: true,
          total: { show: true, label: 'Total', formatter: function(w){ return w.globals.seriesTotals.reduce(function(a,b){ return a+b; },0); } }
        } } } },
        dataLabels: { enabled: false },
        legend: { position: 'bottom', fontSize: '12px', markers: { width: 10, height: 10, radius: 12 } },
        tooltip: { y: { formatter: function(v){ return v + ' items'; } } }
      }).render();
    }
  } catch(e) { console.error('chartStatus error:', e); }

  try {
    var elLaptopYear = document.getElementById('chartLaptopYear');
    if (elLaptopYear) {
      var allLaptopSeries = {!! json_encode(array_values($laptopYears)) !!};
      var yearLabels = {!! json_encode(array_keys($laptopYears)) !!};
      var laptopYearTotal = {{ (int) $laptopYearTotal }};
      var chartColors = ['#7B61FF', '#4F80FF', '#31D0AA', '#FFB020', '#9DA4B4'];

      var laptopChart = new ApexCharts(elLaptopYear, {
        chart: { type: 'donut', height: 260, fontFamily: 'inherit' },
        series: laptopYearTotal ? allLaptopSeries : [1],
        labels: yearLabels,
        colors: laptopYearTotal ? chartColors : ['#e8e7ef'],
        stroke: { width: 2, colors: ['#ffffff'] },
        dataLabels: {
          enabled: true,
          style: { fontSize: '11px', fontFamily: 'inherit', fontWeight: '600', colors: ['#ffffff'] },
          dropShadow: { enabled: true, top: 1, left: 1, blur: 1, color: '#000000', opacity: 0.35 },
          formatter: function(val, opts) {
            if (!laptopYearTotal) return '';
            var count = opts.w.config.series[opts.seriesIndex];
            return count > 0 ? count + ' (' + val.toFixed(1) + '%)' : '';
          }
        },
        legend: { show: false },
        tooltip: {
          y: {
            formatter: function(value, opts) {
              if (!laptopYearTotal) return '0 laptops';
              var pct = opts.w.globals.seriesPercent[opts.seriesIndex][0].toFixed(1);
              return value + ' laptops (' + pct + '%)';
            }
          }
        },
        plotOptions: {
          pie: {
            donut: {
              size: '62%',
              labels: {
                show: true,
                name: {
                  show: true,
                  fontSize: '11px',
                  fontWeight: 600,
                  color: '#8a879b',
                  offsetY: 18,
                  formatter: function() { return 'Total Laptops'; }
                },
                value: {
                  show: true,
                  fontSize: '24px',
                  fontWeight: 700,
                  color: '#1e1e2d',
                  offsetY: -10,
                  formatter: function() { return laptopYearTotal; }
                },
                total: {
                  show: true,
                  label: 'Total Laptops',
                  color: '#8a879b',
                  fontSize: '11px',
                  formatter: function() { return laptopYearTotal; }
                }
              }
            }
          }
        }
      });
      laptopChart.render();

      // Dynamic Dropdown Filter Handler
      $('#laptop-year-select').on('change', function() {
        var val = $(this).val();
        $('#laptop-year-label-text').text(val === 'all' ? 'All Years' : val);

        if (val === 'all') {
          laptopChart.updateOptions({
            series: laptopYearTotal ? allLaptopSeries : [1],
            labels: yearLabels
          });
          $('.ims-laptop-year-item').css('opacity', '1').show();
          $('#laptop-year-total-count').text(laptopYearTotal);
        } else {
          var idx = yearLabels.indexOf(val);
          if (idx !== -1) {
            var selectedCount = allLaptopSeries[idx];
            var filteredSeries = allLaptopSeries.map(function(c, i) {
              return i === idx ? c : 0;
            });
            laptopChart.updateOptions({
              series: filteredSeries
            });
            $('.ims-laptop-year-item').each(function() {
              if ($(this).attr('data-year') === val) {
                $(this).css('opacity', '1');
              } else {
                $(this).css('opacity', '0.35');
              }
            });
            $('#laptop-year-total-count').text(selectedCount);
          }
        }
      });
    }
  } catch(e) { console.error('chartLaptopYear error:', e); }

  // ── 3. Category Radial Donut Charts ──
  try {
    var catItems = [
      @foreach($stockByType as $index => $row)
        {
          id: 'catDonut_{{ $index }}',
          total: {{ (int)$row->total }},
          inStock: {{ (int)$row->in_stock }},
          issued: {{ (int)$row->issued }}
        }@if(!$loop->last),@endif
      @endforeach
    ];

    catItems.forEach(function(item) {
      var el = document.getElementById(item.id);
      if (!el) return;

      var series = (item.inStock === 0 && item.issued === 0) ? [1] : [item.inStock, item.issued];
      var colors = (item.inStock === 0 && item.issued === 0) ? ['#e2e8f0'] : ['#28C76F', '#FF9F43'];

      new ApexCharts(el, {
        chart: {
          type: 'donut',
          height: 110,
          width: 110,
          sparkline: { enabled: true },
          animations: { enabled: true, easing: 'easeinout', speed: 500 }
        },
        series: series,
        colors: colors,
        stroke: { width: 3, colors: ['#ffffff'] },
        plotOptions: {
          pie: {
            donut: {
              size: '72%',
              background: 'transparent',
              labels: {
                show: true,
                name: { show: false },
                value: {
                  show: true,
                  fontSize: '17px',
                  fontWeight: '700',
                  color: '#1f1c2c',
                  offsetY: 5,
                  formatter: function() { return item.total; }
                },
                total: {
                  show: true,
                  label: '',
                  color: '#1f1c2c',
                  formatter: function() { return item.total; }
                }
              }
            }
          }
        },
        tooltip: { enabled: false }
      }).render();
    });
  } catch(e) { console.error('catDonut error:', e); }
});
</script>
@endpush

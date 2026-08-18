@extends('common.master')
@section('content')
<div class="right_col" role="main">
    <!-- top tiles -->
    <div class="row tile_count">
      <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
        <span class="count_top"><i class="fa fa-user"></i> Total Employees</span>
        <div class="count green">{{$employee}}</div>
        <span class="count_bottom"><i class="green">4% </i> Active Employee</span>
      </div>
      <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
        <span class="count_top"><i class="fa fa-laptop"></i> Laptops</span>
        <div class="count">{{$laptop}}</div>
        <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>3% </i> From last Week</span>
      </div>
      <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
        <span class="count_top"><i class="fa fa-desktop"></i> Desktops</span>
        <div class="count green">{{$desktop}}</div>
        <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>34% </i> From last Week</span>
      </div>
      <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
        <span class="count_top"><i class="fa fa-print"></i> Printers</span>
        <div class="count">{{$printer}}</div>
        <span class="count_bottom"><i class="red"><i class="fa fa-sort-desc"></i>12% </i> From last Week</span>
      </div>
      <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
        <span class="count_top"><i class="fa fa-print"></i> Scanners</span>
        <div class="count green">{{$scanner}}</div>
        <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>34% </i> From last Week</span>
      </div>
      <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
        <span class="count_top"><i class="fa fa-desktop"></i> All in One PCs</span>
        <div class="count">{{$allinone}}</div>
        <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>34% </i> From last Week</span>
      </div>
    </div>
    <div class="row tile_count">
      <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
        <span class="count_top"><i class="fa fa-user"></i> Servers</span>
        <div class="count">{{$server}}</div>
        <span class="count_bottom"><i class="green">4% </i> From last Week</span>
      </div>
      <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
        <span class="count_top"><i class="fa fa-clock-o"></i> Tablets</span>
        <div class="count green">{{$tablet}}</div>
        <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>3% </i> From last Week</span>
      </div>
      <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
        <span class="count_top"><i class="fa fa-user"></i> Access Points</span>
        <div class="count">{{$ap}}</div>
        <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>34% </i> From last Week</span>
      </div>
      <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
        <span class="count_top"><i class="fa fa-user"></i> Switches</span>
        <div class="count green">{{$ns}}</div>
        <span class="count_bottom"><i class="red"><i class="fa fa-sort-desc"></i>12% </i> From last Week</span>
      </div>
      <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
        <span class="count_top"><i class="fa fa-user"></i> NVR / DVR </span>
        <div class="count">{{$nvr}}</div>
        <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>34% </i> From last Week</span>
      </div>
      <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
        <span class="count_top"><i class="fa fa-user"></i> Smart LEDs</span>
        <div class="count green">{{$led}}</div>
        <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>34% </i> From last Week</span>
      </div>
    </div>
    <!-- /top tiles -->

    <br />

    <div class="row">


      <div class="col-md-4 col-sm-4 col-xs-12">
        <div class="x_panel tile fixed_height_320">
          <div class="x_title">
            <h2>Laptops Year Wise</h2>
            <ul class="nav navbar-right panel_toolbox">

            </ul>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <h4>Year</h4>
            <div class="widget_summary">
              <div class="w_left w_25">
                <span>2010-2013</span>
              </div>
              <div class="w_center w_55">
                <div class="progress">
                  <div class="progress-bar bg-green" role="progressbar" aria-valuenow="10" aria-valuemin="0" aria-valuemax="50" style="width: {{$laptop_year1.'%'}};">
                    <span class="sr-only">10% Complete</span>
                  </div>
                </div>
              </div>
              <div class="w_right w_20">
                <span>{{$laptop_year1}}</span>
              </div>
              <div class="clearfix"></div>
            </div>

            <div class="widget_summary">
              <div class="w_left w_25">
                <span>2015-2018</span>
              </div>
              <div class="w_center w_55">
                <div class="progress">
                  <div class="progress-bar bg-green" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: {{$laptop_year2.'%'}};">
                    <span class="sr-only">60% Complete</span>
                  </div>
                </div>
              </div>
              <div class="w_right w_20">
                <span>{{$laptop_year2}}</span>
              </div>
              <div class="clearfix"></div>
            </div>
            <div class="widget_summary">
              <div class="w_left w_25">
                <span>2019-2021</span>
              </div>
              <div class="w_center w_55">
                <div class="progress">
                  <div class="progress-bar bg-green" role="progressbar" aria-valuenow="" aria-valuemin="0" aria-valuemax="50" style="width: {{$laptop_year3.'%'}};">
                    <span class="sr-only">60% Complete</span>
                  </div>
                </div>
              </div>
              <div class="w_right w_20">
                <span>{{$laptop_year3}}</span>
              </div>
              <div class="clearfix"></div>
            </div>
            <div class="widget_summary">
              <div class="w_left w_25">
                <span>2022-2023</span>
              </div>
              <div class="w_center w_55">
                <div class="progress">
                  <div class="progress-bar bg-green" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: {{$laptop_year4.'%'}};">
                    <span class="sr-only">60% Complete</span>
                  </div>
                </div>
              </div>
              <div class="w_right w_20">
                <span>{{$laptop_year4}}</span>
              </div>
              <div class="clearfix"></div>
            </div>
            <div class="widget_summary">
              <div class="w_left w_25">
                <span>2024</span>
              </div>
              <div class="w_center w_55">
                <div class="progress">
                  <div class="progress-bar bg-green" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: {{$laptop_year5.'%'}};">
                    <span class="sr-only">60% Complete</span>
                  </div>
                </div>
              </div>
              <div class="w_right w_20">
                <span>{{$laptop_year5}}</span>
              </div>
              <div class="clearfix"></div>
            </div>

          </div>
        </div>
      </div>

      <div class="col-md-8 col-sm-4 col-xs-12">
        <div class="x_panel tile fixed_height_320 overflow_hidden">
          <div class="x_title">
            <h2>Desktop Computers</h2>
            <ul class="nav navbar-right panel_toolbox">

            </ul>
            <div class="clearfix"></div>
          </div>

          <div class="x_content">
            <table class="" style="width:100%">
              <tr>
                <th style="width:37%;">
                  <p>Top 5</p>
                </th>
                <th>
                  <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                    <p class="">Model</p>
                  </div>
                  <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                    <p class="">Count</p>
                  </div>
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                      <p class="">Model</p>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                      <p class="">Count</p>
                    </div>
                  </th>
              </tr>
              <tr>
                <td>
                  <canvas class="canvasDoughnut" height="140" width="140" style="margin: 15px 10px 10px 0"></canvas>
                </td>
                <td>
                  <table class="tile_info col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <tr>
                      <td>
                        <p><i class="fa fa-square blue"></i>HP E-D-800 </p>
                      </td>
                      <td>{{$d1}}</td>
                      <td>
                        <p><i class="fa fa-square blue"></i>Accer M275 </p>
                      </td>
                      <td>{{$d2}}</td>
                    </tr>
                    <tr>
                      <td>
                        <p><i class="fa fa-square green"></i>Dell 3080 </p>
                      </td>
                      <td>{{$d3}}</td>
                      <td>
                        <p><i class="fa fa-square green"></i>Dell 3010 </p>
                      </td>
                      <td>{{$d4}}</td>
                    </tr>
                    <tr>
                      <td>
                        <p><i class="fa fa-square purple"></i>Dell 3090 </p>
                      </td>
                      <td>{{$d5}}</td>
                      <td>
                        <p><i class="fa fa-square purple"></i>Dell 5050 </p>
                      </td>
                      <td>{{$d6}}</td>
                    </tr>
                    <tr>
                      <td>
                        <p><i class="fa fa-square aero"></i>Dell 7010 </p>
                      </td>
                      <td>{{$d7}}</td>
                      <td>
                        <p><i class="fa fa-square aero"></i>Dell 7020 </p>
                      </td>
                      <td>{{$d8}}</td>
                    </tr>
                    <tr>
                      <td>
                        <p><i class="fa fa-square darkblue"></i>Dell 7080 </p>
                      </td>
                      <td>{{$d9}}</td>
                      <td>
                        <p><i class="fa fa-square darkblue"></i>Dell 9010 </p>
                      </td>
                      <td>{{$d10}}</td>
                    </tr>
                    <tr>
                        <td>
                          <p><i class="fa fa-square yellow"></i>Dell 9020 </p>
                        </td>
                        <td>{{$d11}}</td>
                        <td>
                          <p><i class="fa fa-square yellow"></i>Dell Vostro 230 </p>
                        </td>
                        <td>{{$d12}}</td>
                      </tr>
                      <tr>
                        <td>
                          <p><i class="fa fa-square green2"></i>Dell Vostro 270 </p>
                        </td>
                        <td>{{$d13}}</td>
                        <td>
                          <p><i class="fa fa-square green2"></i>HP M6200 </p>
                        </td>
                        <td>{{$d14}}</td>
                      </tr>
                  </table>
                </td>
              </tr>
            </table>
          </div>
        </div>
      </div>



    </div>


  </div>
  @endsection

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>MIS Inventory</title>

    <!-- Bootstrap -->
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="/css/font-awesome.min.css" rel="stylesheet">
    <link href="/css/select2.min.css" rel="stylesheet">


    <!-- Datatables -->
    <link href="/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="/css/buttons.bootstrap.min.css" rel="stylesheet">


    <!-- Custom Theme Style -->
    <link href="/css/custom.min.css" rel="stylesheet">
    <script src="/js/jquery.js"></script>
  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
               <a href="" class="site_title"><i class="fa fa-desktop"></i> <span>MIS Inventory</span></a>
            </div>

            <div class="clearfix"></div>

            <!-- menu profile quick info -->
            <!-- menu profile quick info -->
            <div class="profile clearfix">
              <div class="profile_pic">
                <img src="{{asset('img/img.jpg')}}" alt="..." class="img-circle profile_img">
              </div>
              <div class="profile_info">
                <span>Welcome,</span>
                <h2>System Admin</h2>
              </div>
            </div>
            <!-- /menu profile quick info -->

            <br />

            <!-- sidebar menu -->

            @include('common.menu')

            <!-- /sidebar menu -->
          </div>
        </div>

        <!-- top navigation -->
         @include('common.header')
        <!-- /top navigation -->

        <!-- page content -->
        @yield('content')
        <!-- /page content -->

        <!-- footer content -->
        @include('common.footer')
        <!-- /footer content -->
      </div>
    </div>

    <!-- jQuery -->
    <script src="/js/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="/js/bootstrap.min.js"></script>

    <!-- Datatables -->
    <script src="/js/jquery.dataTables.min.js"></script>
    <script src="/js/dataTables.bootstrap.min.js"></script>
    <script src="/js/dataTables.buttons.min.js"></script>
    <script src="/js/buttons.bootstrap.min.js"></script>
    <script src="/js/buttons.flash.min.js"></script>
    <script src="/js/buttons.html5.min.js"></script>
    <script src="/js/buttons.print.min.js"></script>
    <script src="/js/select2.min.js"></script>
    <script src="/js/chart.min.js"></script>
    <script src="/js/progress.min.js"></script>

    <!-- Custom Theme Scripts -->
    <script src="/js/custom.min.js"></script>

  </body>
</html>

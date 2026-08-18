<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>MIS Inventory </title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="css/font-awesome.min.css" rel="stylesheet">


    <!-- Custom Theme Style -->
    <link href="css/custom.min.css" rel="stylesheet">
  </head>

  <body class="bgimg">
    <div>
      <a class="hiddenanchor" id="signup"></a>
      <a class="hiddenanchor" id="signin"></a>

      <div class="login_wrapper">
        <div class="animate form login_form x_panel">
          <section class="login_content">
            <form method="POST" action="{{url('authenticate')}}">
                @csrf
                <p>Inventory Management System
                </p>
              <h1>Login Form</h1>
              <div>
                <input type="text" class="form-control" placeholder="Email" name="email" />
              </div>
              <div>
                <input type="password" class="form-control" placeholder="Password" name="password" />
              </div>
              <div>
                <button type="submit" class="btn btn-success">Login</button>
              </div>

              <div class="clearfix"></div>

              <div class="separator">
                <p class="change_link">Developed by MIS Department <br>
                  <a href="" class="to_register"> Lahore Waste Management Company </a>
                </p>

                <div class="clearfix"></div>
                <br />


              </div>
            </form>
          </section>
        </div>
      </div>
    </div>
  </body>
</html>

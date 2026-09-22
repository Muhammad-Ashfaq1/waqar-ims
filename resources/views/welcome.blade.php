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
                <input type="text" class="form-control" placeholder="Email" name="email" value="{{ old('email') }}" />
              </div>
              <div style="position: relative; margin: 0 0 20px;">
                <input type="password" id="password" class="form-control" placeholder="Password" name="password" style="margin-bottom: 0; padding-right: 40px;" />
                <button type="button" id="togglePassword" aria-label="Toggle password visibility" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); background: none; border: none; padding: 0; cursor: pointer; color: #73879C; font-size: 15px; outline: none; z-index: 10;">
                  <i class="fa fa-eye" id="togglePasswordIcon"></i>
                </button>
              </div>
              <div class="checkbox" style="text-align:left;margin:10px 0 15px;">
                <label>
                  <input type="checkbox" name="remember" value="1" {{ old('remember') ? 'checked' : '' }}> Remember me
                </label>
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
    <script>
      document.addEventListener('DOMContentLoaded', function () {
        var toggleBtn = document.getElementById('togglePassword');
        var passwordInput = document.getElementById('password');
        var toggleIcon = document.getElementById('togglePasswordIcon');

        if (toggleBtn && passwordInput && toggleIcon) {
          toggleBtn.addEventListener('click', function (e) {
            e.preventDefault();
            var isPassword = passwordInput.getAttribute('type') === 'password';
            passwordInput.setAttribute('type', isPassword ? 'text' : 'password');
            toggleIcon.classList.toggle('fa-eye', !isPassword);
            toggleIcon.classList.toggle('fa-eye-slash', isPassword);
          });
        }
      });
    </script>
  </body>
</html>

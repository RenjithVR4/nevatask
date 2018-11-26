<?php

require_once("helpers/helpers.php");

if($userid = sessionValidate(USER_SESSION_ID))
{
    error_log('User Session Validation Success');
    header( 'Location: ./messages.php');
}


?>


<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="Renjith">
  <title>Login | Friends</title>
  <!-- Favicon -->
  <link href="assets/img/logo.png" rel="icon" type="image/png">
  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
  <!-- Icons -->
  <link href="assets/vendor/nucleo/css/nucleo.css" rel="stylesheet">
  <link href="assets/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  <!-- Argon CSS -->
  <link type="text/css" href="assets/css/argon.css?v=1.0.1" rel="stylesheet">
  <link type="text/css" href="assets/css/custom.css?v=1.0.1" rel="stylesheet">
  <!-- Docs CSS -->
  <link type="text/css" href="assets/css/docs.min.css" rel="stylesheet">
  <link type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
</head>

<script type="text/javascript">
  document.onreadystatechange = function() {
      var state = document.readyState
      if (state == 'interactive') {
          document.getElementById('contents').style.visibility = "hidden";
      } else if (state == 'complete') {
          setTimeout(function() {
              document.getElementById('interactive');
              document.getElementById('loading').style.visibility = "hidden";
              document.getElementById('contents').style.visibility = "visible";
          }, 1500);
      }
  }
</script>

<body>
  <div id="loading"></div>
  <header class="header-global">
    <nav id="navbar-main" class="navbar navbar-main navbar-expand-lg navbar-transparent navbar-light headroom">
      <div class="container">
        <a class="navbar-brand mr-lg-5" href="./">
          <img src="assets/img/logo.png">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar_global" aria-controls="navbar_global"
          aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="navbar-collapse collapse" id="navbar_global">
          <div class="navbar-collapse-header">
            <div class="row">
              <div class="col-6 collapse-brand">
                <a href="./">
                  <img src="assets/img/logo.png">
                </a>
              </div>
              <div class="col-6 collapse-close">
                <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbar_global"
                  aria-controls="navbar_global" aria-expanded="false" aria-label="Toggle navigation">
                  <span></span>
                  <span></span>
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </nav>
  </header>
  <main>
    <section class="section section-shaped section-lg">
      <div class="shape shape-style-1 bg-gradient-default">
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
      </div>
      <div class="container pt-lg-md" id="userloginDiv">
        <div class="row justify-content-center">
          <div class="col-lg-6">
            <div class="card bg-secondary shadow border-0">
              <div class="card-body px-lg-6 py-lg-6">
                <p class="text-center">Please use your credentails to log in</p>
                <div class="text-center text-muted mb-4">
                  <small>Login User</small>
                </div>
                <form role="form" id="loginuserForm">
                  <div class="form-group mb-3">
                    <div class="input-group input-group-alternative">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                      </div>
                      <input class="form-control" placeholder="Email" type="text" id="loginEmail">
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="input-group input-group-alternative">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                      </div>
                      <input class="form-control" placeholder="Password" type="password" id="loginPassword">
                    </div>
                  </div>
                  <div class="custom-control custom-control-alternative custom-checkbox">
                    <input class="custom-control-input" id="customCheckLogin" type="checkbox">
                    <label class="custom-control-label" for="customCheckLogin">
                      <span>Remember me</span>
                    </label>
                  </div>
                  <div class="text-center">
                    <input type="submit" id="loginbutton" class="btn btn-primary my-4" value="Login">
                  </div>
                  <div class="text-center">
                    <a href="#" id="registerForm" class="text-darker">
                      <small>Create new account</small>
                    </a>
                  </div>
                </form>
              </div>
            </div>

          </div>
        </div>
      </div>

      <div class="container pt-lg-md">
        <div class="row justify-content-center">
          <div class="col-lg-6">
            <div class="card bg-secondary shadow border-0">
              <div class="card-body px-lg-6 py-lg-6" id="usercreateDiv">
                <!-- <p id="message"></p> -->
                <div class="text-center text-muted mb-4">
                  <small>Register User</small>
                </div>
                <form id="createuserForm">
                  <div class="form-group">
                    <div class="input-group input-group-alternative">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="ni ni-hat-3"></i></span>
                      </div>
                      <input class="form-control" placeholder="Enter Name" type="text" id="userName">
                    </div>
                  </div>
                  <div class="form-group mb-3">
                    <div class="input-group input-group-alternative">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                      </div>
                      <input class="form-control" placeholder="Enter Email" type="text" id="userEmail">
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="input-group input-group-alternative">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                      </div>
                      <input class="form-control" placeholder="Enter Password" type="password" id="userPassword">
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="input-group input-group-alternative">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                      </div>
                      <input class="form-control" placeholder="Confirm Password" type="password" id="confirmPassword">
                    </div>
                  </div>

                  <div class="text-center">
                    <input type="submit" id="createUser" class="btn btn-primary my-4" value="Register">
                  </div>
                  <div class="text-center">
                    <a href="#" id="loginForm" class="text-darker">
                      <small>Login User</small>
                    </a>
                  </div>

                </form>
              </div>
            </div>

          </div>
        </div>
      </div>


    </section>
  </main>
  <!-- <footer class="footer">
    <div class="container">
      <hr>
      <div class="row align-items-center justify-content-md-between">
        <div class="col-md-12">
          <div class="copyright text-center">
            &copy;
            <?php echo date('Y'); ?>
            <a href="https://renjithvr.in" target="_blank">Renjith V R - A task from NEVA</a>.
          </div>
        </div>
      </div>
    </div>
  </footer> -->
  <!-- Core -->
  <script src="assets/vendor/jquery/jquery.min.js"></script>
  <script src="assets/vendor/popper/popper.min.js"></script>
  <script src="assets/vendor/bootstrap/bootstrap.min.js"></script>
  <script src="assets/vendor/headroom/headroom.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
  <!-- Argon JS -->
  <script src="assets/js/argon.js?v=1.0.1"></script>
  <script src="assets/js/helper.js?v=1.0.1"></script>
  <script src="assets/js/index.js?v=1.0.1"></script>
  <script>
    toastr.options = {
      "closeButton": true,
      "debug": false,
      "newestOnTop": false,
      "progressBar": false,
      "positionClass": "toast-top-right",
      "preventDuplicates": false,
      "onclick": null,
      "showDuration": "300",
      "hideDuration": "1000",
      "timeOut": "5000",
      "extendedTimeOut": "1000",
      "showEasing": "swing",
      "hideEasing": "linear",
      "showMethod": "fadeIn",
      "hideMethod": "fadeOut"
    }
  </script>
</body>

</html>
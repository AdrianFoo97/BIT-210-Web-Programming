<?php
session_start();
if (empty($_SESSION['tSignUp'])) {
  $_SESSION['tSignUp'] = "empty";
}
if (empty($_SESSION['userName'])) {
  $_SESSION['userName'] = "empty";
}
if (empty($_SESSION['mSignUp'])) {
  $_SESSION['mSignUp'] = "empty";
}
?>
<!DOCTYPE html>
<html lang = "en">
<head>
  <meta charset = "utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Sign In</title>
  <link rel="icon" href="../img/Gym-logo.png">
  <link href="../css/bootstrap.min.css" rel="stylesheet">
  <link href="../css/signIn.css" rel="stylesheet">
</head>
<body>
  <script src="../js/jquery-3.2.1.min.js"></script>
  <script src="../js/bootstrap.min.js"></script>
  <script src="../js/script.js"></script>
  <!--
  This is the sign in form of the web page with
  a background and some css to style it on the center
  of the web page.
-->
<form action="../php/validate.php" method="post">
  <div class="container">
    <div class="vertical-align">
      <h1 class="display-1">HELP FIT</h1><br /><br />
      <div class="row">
        <div class="form-group">
          <div class="col-xs-12 col-sm-offset-4 col-sm-4">
            <label class="label hidden">UserName:</label><br/>
            <div class="input-group">
              <div class="input-group-addon">
                <span class="glyphicon glyphicon-user"></span>
              </div>
              <input class="form-control input-lg" type="text"
              placeholder="user name" name="userName"
              onfocus="this.placeholder=''" onblur="this.placeholder='user name'"
              required/><br /><br />
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group">
          <div class="col-xs-12 col-sm-offset-4 col-sm-4">
            <label class="label hidden">Password:</label><br />
            <div class="input-group">
              <div class="input-group-addon">
                <span class="glyphicon glyphicon-lock"></span>
              </div>
              <input class="form-control input-lg" type="password" placeholder="password"
              name="password"  onfocus="this.placeholder=''"
              onblur="this.placeholder='password'" required/>
            </div>
            <?php
            /*
            show user some alert when they failed to log in
            */
            if($_SESSION['userName'] == "failed") {
              echo
              "<br />
              <div class='alert alert-danger'>
              Invalid username or password. Please try again!
              </div>";
              unset($_SESSION['userName']);
            }
            ?>
          </div>
        </div>
      </div><br /><br />
      <div class = "row">
        <div style = "text-align: center; padding-left:15px; padding-right:15px;">
          <input class = "btn btn-lg btn-primary btn-block visible-xs-block"
          style = "border-radius: 20px;" type = "submit" value = "Log In"/>
          <input class = "btn btn-lg btn-primary hidden-xs" type = "submit"
          value = "Log In" style = "width: 125px";/>
          <br /><span class = "hidden-xs"><br /></span>
          <p style = "color: white;">
            Don't have an account? <br />
          </p>
          <a data-toggle="modal" data-target="#myModal">Sign Up Now</a>
        </div>
      </div>

    </div>
  </div>
</form>
<!--
This is the modal which contains a user sign up form for
usr to sign up.
-->
<!-- Modal -->
<div class="modal fade" id="myModal" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h3 style="text-align: center;" class="modal-title">Register</h3>
      </div>
      <div class="modal-body">
        <div class="container">
          <div class = "row">
            <div class = "col-xs-12 col-sm-6">
              <br />
              <ul class="nav nav-tabs nav-justified">
                <li class="active"><a data-toggle="tab" href="#member">Member</a></li>
                <li><a data-toggle="tab" href="#trainer">Trainer</a></li>
              </ul>
              <div class="tab-content">
                <div id="member" class="tab-pane fade in active">
                  <form name="MsignUpForm" onsubmit="return validateMemberForm()"
                  action="../php/MemberSignUp.php" method="post">
                  <div class="row" style="margin-top: 50px;">
                    <div class="col-sm-offset-2 col-sm-8">
                      <div class="form-group">
                        <label>Full Name: </label>
                        <input type="text" name="mFullName" placeholder="Full Name"
                        class="form-control" required>
                      </div>

                      <div class="form-group">
                        <label>User Name: </label>
                        <input type="text" name="mUserName" placeholder="Username"
                        class="form-control" required>
                      </div>

                      <div class="form-group">
                        <label>Password: </label>
                        <input type="password" name="mPassword" placeholder="Password"
                        class="form-control" required>
                      </div>

                      <div class="form-group">
                        <label>Eamil: </label>
                        <input type="email" name="mEmail" placeholder="Email"
                        class="form-control"
                        required>
                      </div>

                      <div class = "form-group">
                        <label>Level:</label>
                        <br>
                        <select name ="mLevel" class="form-control">
                          <option value = "beginner">Beginner</option>
                          <option value = "advanced">Advanced</option>
                          <option value = "expert">Expert</option>
                        </select>
                      </div><br />
                    </div>
                  </div>

                  <div class="modal-footer">
                    <div style="text-align: center;">
                      <br />
                      <input type="submit" value="Get Started" name="register"
                      id="membersubmit" class="btn btn-default" required>
                    </div>
                  </div>
                </form>
              </div>
              <div id="trainer" class="tab-pane fade">
                <form name="TsignUpForm" onsubmit="return validateTrainerForm()"
                action="../php/TrainerSignUp.php" method="post">
                <div class="row" style="margin-top:50px;">
                  <div class="col-sm-offset-2 col-sm-8">
                    <div class="form-group">
                      <label>Full Name: </label>
                      <input type="text" name="tFullName" placeholder="Full Name"
                      class="form-control" required>
                    </div>

                    <div class="form-group">
                      <label>User Name: </label>
                      <input type="text" name="tUserName" placeholder="Username"
                      class="form-control" required>
                    </div>

                    <div class="form-group">
                      <label>Password</label>
                      <input type="password" name="tPassword" placeholder="Password"
                      class="form-control" required>
                    </div>

                    <div class="form-group">
                      <label>Email: </label>
                      <input type="email" name="tEmail" placeholder="Email"
                      class="form-control"
                      required>
                    </div>

                    <div class = "form-group">
                      <label>Specialty:</label>
                      <select name ="tSpecialty" class="form-control">
                        <option value = "mma">MMA</option>
                        <option value = "dance">Dance</option>
                        <option value = "sports">Sports</option>
                      </select>
                    </div><br />
                  </div>
                </div>
                <div class="modal-footer">
                  <div style="text-align: center;">
                    <br />
                    <input type="submit" value="Get Started" name="register"
                    id="trainersubmit" class="btn btn-default" required>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

</div>
</div>
<?php
/*
prompt the user if they failed to sign up
*/
if($_SESSION['tSignUp'] == "failed") {
  echo
  "<script>alert('This username has been taken!')</script>";
  unset($_SESSION['tSignUp']);
}
if($_SESSION['mSignUp'] == "failed") {
  echo
  "<script>alert('This username has been taken!')</script>";
  unset($_SESSION['mSignUp']);
}
?>
</body>
</html>

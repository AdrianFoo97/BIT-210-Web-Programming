<?php
session_start();

if(empty($_SESSION['personalRegister'])){
  $_SESSION['personalRegister'] = 'unsuccessfull';
}

if(empty($_SESSION['groupRegister'])){
  $_SESSION['groupRegister'] = 'unsuccessfull';
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>New Session</title>
<link rel="icon" href="../img/Gym-logo.png">
<!--Bootstrap-->
<link href="../css/bootstrap.min.css" rel="stylesheet">
<link href="../css/font-awesome.min.css" rel="stylesheet">
<link rel = "stylesheet" href = "../css/style.css" />
<link href="../css/sessions.css" rel="stylesheet">
<style>
  body {
    padding-top: 50px;
    height: 100%;
  }
  html {
    height: 100%;
  }
  .height {
    height: 100%;
  }

.profile-img{
margin-top: -5px;
margin-right: 5px;
float: left;
<?php
/*
This code will replace the default profile picture if the user has
a profile picture uploaded
*/
if ($_SESSION['profilePic'] != "") {
  echo "background: url(../uploads/" . $_SESSION['profilePic'] .  ") 50% 50% no-repeat;";
}
else if ($_SESSION['profilePic'] == "") {
  echo "background: url(../img/person-flat.png) 50% 50% no-repeat;";
}
?>
background-size: auto 100%; /* Interchange this value depending on prefering width vs. height */
width: 30px;
height: 30px;
border-radius: 50%;
}

</style>

</head>

<body class="bodyBG">
  <!--Include JQuery: necessary for Bootstrap plugins-->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <!--Include bootstrap library as needed-->
  <script src="../js/bootstrap.min.js"></script>
  <script src="../js/time.js"></script>
  <script src="../js/validateSessionForm.js"></script>

  <?php
  if($_SESSION['personalRegister'] == 'successfull' ){
    echo "<div class='alert alert-success alert-dismissable' style='margin:0px;'>";
    echo "<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>";
    echo "Personal session has been successfully added.";
    echo "<span class='glyphicon glyphicon-ok'></span>";
    echo "</div>";
    unset($_SESSION['personalRegister']);
  }

  if($_SESSION['groupRegister'] == 'successfull' ){
    echo "<div class='alert alert-success alert-dismissable' style='margin:0px;'>";
    echo "Group session has been successfully added.";
    echo "<span class='glyphicon glyphicon-ok'></span>";
    echo "</div>";
    unset($_SESSION['groupRegister']);
  }
   ?>

  <nav class="navbar navbar-inverse navbar-fixed-top" >
    <div class="container">

      <div class = "navbar-header">
        <a class="navbar-brand" href="#">
          <span style = "background-image: url(Gym-logo.png);"></span>
          HELP Fit
        </a>
        <button class = "navbar-toggle pull-left" style = "margin-left: 10px;" data-toggle = "collapse" data-target = ".navHeaderCollapse">
          <span class = "icon-bar"></span>
          <span class = "icon-bar"></span>
          <span class = "icon-bar"></span>
        </button>
      </div>
      <div class = "collapse navbar-collapse navHeaderCollapse">
        <ul class = "nav navbar-nav">
          <li class="active">
            <a  href="newSession.php">
              <span class = "glyphicon glyphicon-blackboard"></span>
              Training Session
            </a>
          </li>
          <li>
            <a href="TrainingHistory.php">
              <span class = "glyphicon glyphicon-time"></span>
              Training History
            </a>
          </li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
          <li id="welcome" class = "collapse navbar-collapse navbar-text"><script>checkTime()</script></li>
          <li class="dropdown">
              <a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                  <!-- The Profile picture inserted via div class below, with shaping provided by Bootstrap -->
                  <div class="img-rounded profile-img"></div>
                  <?php echo $_SESSION['fullName']; ?>
                  <span class="caret"></span>
              </a>
              <ul class="dropdown-menu">
                  <li>
                      <a href="editProfile.php">
                        <span class = "glyphicon glyphicon-edit"></span>
                        &nbsp;&nbsp;Edit Profile
                      </a>
                  </li>
                  <li role="separator" class="divider"></li>
                  <li>
                      <a href="SignIn.php">
                        <span class = "glyphicon glyphicon-log-out"></span>
                        &nbsp;&nbsp;Log out
                      </a>
                  </li>
              </ul>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <div class = "container-fluid height">
    <div class="row height">
    <div class="col-xs-6 col-md-6 height" style="padding: 0px 0px 0px 0px;">
      <a data-toggle="modal" data-target="#personalModal" style="text-decoration:none; cursor: pointer;">
        <div class ="overlay height">
        <div class='personalSession height'>
          <div class='bannerText'>Personal Session
          </div>
          </div>
        </div>
      </a>
    </div>
    <div class="col-xs-6 col-md-6 height" style="padding: 0px 0px 0px 0px;">
      <a data-toggle="modal" data-target="#groupModal" style="text-decoration:none; cursor: pointer;">
        <div class="overlay height">
        <div class='groupSession height'>
          <div class='bannerText height'>Group Session
          </div>
          </div>
        </div>
      </a>
    </div>
    </div>
    <div>
    </div>
  </div>
  </div>

<div class="container">
  <!-- Modal -->
  <div class="modal fade" id="personalModal" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h3 class="modal-title" style="text-align:center;">Personal Session</h3>
      </div>
      <div class="modal-body">
        <div class = "container">
          <div class = "row">
          <div class = "col-xs-12 col-sm-6">
            <!--
            This is a table containing the form to create a personal session.
            -->
            <table class = "table table-striped table-responsive"
            style="margin-top:30px; margin-bottom:30px;">
            <form name="personalForm" onsubmit="return validatePersonalForm()" action="../php/personalSession.php" method="post">

            <div class = "col-xs-12">

                <div class = "form-group">
                  <label for="title">Title:</label>
                  <input type="text" class ="form-control" id='title' name="title" placeholder="Enter Title Here." required>
                  <div id="invalidPTitle" class="error"></div>
                </div>

                <div class ="form-group">
                  <label for="date">Date:</label>
                  <input type ="date" class="form-control" name="date" required>
                  <div id="invalidPDate" class="error"></div>
                </div>
              </div>

              <div class="col-xs-12">
              <div class ="form-group">
                <label for="startingtime">Starting Time:</label>
                <input type ="time" class="form-control" name="time" required>
                <div id="invalidPTime" class="error"></div>
              </div>
            </div>

              <div class = "col-xs-5">
              <div class = "form-group">
                <label for="fee">Fee (MYR/Pax):</label>
                <input type="number" class ="form-control" name="fee" placeholder="Enter Session Fee" required>
                <div id="invalidPFee" class="error"></div>
              </div>
              </div>

              <div class = "col-xs-12">
              <div style="text-align:center;">
              <input type = "submit" value = "Submit">
              </div>
            </div>

              </form>

            </table>
          </div>
        </div>

      </div>
    </div>
    </div>

  </div>
  </div>

</div>

<div class="container">
  <!-- Modal -->
  <div class="modal fade" id="groupModal" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h3 class="modal-title" style="text-align:center;">Group Session</h3>
      </div>
      <div class="modal-body">
        <div class = "container">
          <div class = "row">
          <div class = "col-xs-12 col-sm-6">
            <!--
            This is a table containing the form to create a group session.
            -->
            <table class = "table table-striped table-responsive"
            style="margin-top:30px; margin-bottom:30px;">
            <form name="groupForm" action="../php/groupSession.php" onsubmit ="return validateGroupForm()" method="post">

            <div class = "col-xs-12">

                <div class = "form-group">
                  <label for="title">Title:</label>
                  <input type="text" class ="form-control" name="title" placeholder="Enter Title Here." required>
                  <div id="invalidGrpTitle" class="error"></div>
                </div>

                <div class ="form-group">
                  <label for="date">Date:</label>
                  <input type ="date" class="form-control" name="date" required>
                  <div id="invalidGrpDate" class="error"></div>
                </div>
              </div>

              <div class="col-xs-12">
              <div class ="form-group">
                <label for="startingtime">Starting Time:</label>
                <input type ="time" class="form-control" name="time" required>
                <div id="invalidGrpTime" class="error"></div>
              </div>
            </div>

            <div class = "col-xs-8">
            <div class = "form-group">
              <label>No. of participants: </label>
              <input type="number" class ="form-control" name="pax" required>
              <div id="invalidGrpParticipants" class="error"></div>
            </div>
            </div>

            <div class = "col-xs-8">
              <div class="form-group">
              <label for="classtype">Class Type:</label>
              <select class="form-control" name="groupType">
                <option>MMA</option>
                <option>Dance</option>
                <option>Sports</option>

              </select>
            </div>
            </div>

              <div class = "col-xs-5">
              <div class = "form-group">
                <label for="fee">Fee (MYR/Pax):</label>
                <input type="number" class ="form-control" name="fee" placeholder="Enter Session Fee" required>
                <div id="invalidGrpFee" class="error"></div>
              </div>
              </div>

              <div class = "col-xs-12">
              <div style="text-align: center;">
              <input type = "submit" value = "Submit">
              </div>
            </div>

              </form>

            </table>
          </div>
        </div>

      </div>
    </div>
    </div>

  </div>
  </div>

</div>


</body>
</html>

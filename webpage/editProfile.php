<?php
session_start();
include '../php/dbConnection.php';
$userName = $_SESSION['userName'];
$userType = $_SESSION['userType'];
if ($userType == "trainer") {
  $query = "SELECT * from user, trainer
  WHERE user.userName = trainer.userName
  AND user.userName = '$userName'";

  $result = mysqli_query($connection, $query);
  while ($row = mysqli_fetch_assoc($result)) {
    $fullName = $row['fullName'];
    $password = $row['password'];
    $email = $row['email'];
    $specialty = $row['specialty'];
    $profilePic = $row['profilePic'];
  }
}
else if ($userType == "member") {
  $query = "SELECT * from user, member
  WHERE user.userName = member.userName
  AND user.userName = '$userName'";

  $result = mysqli_query($connection, $query);
  while ($row = mysqli_fetch_assoc($result)) {
    $fullName = $row['fullName'];
    $password = $row['password'];
    $email = $row['email'];
    $level = $row['level'];
    $profilePic = $row['profilePic'];
  }
}

?>
<!DOCTYPE html>
<html lang = "en">
<head>
  <meta charset = "utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Edit Member Profile</title>
  <link rel="icon" href="../img/Gym-logo.png">
  <link rel="stylesheet" href="../css/bootstrap.min.css" />
  <link rel="stylesheet" href="../css/style.css" />
  <link rel="stylesheet" href="../css/font-awesome.min.css">
  <link rel="stylesheet" href="../css/editProfile.css" />
  <style>
  .profile-img{
    margin-top: -5px;
    margin-right: 5px;
    float: left;
    <?php
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

<body>
  <script src = "../js/jquery-3.2.1.min.js"></script>
  <script src = "../js/bootstrap.min.js"></script>
  <script src = "../js/time.js"></script>
  <script src = "../js/fileUpload.js"></script>

  <nav class="navbar navbar-inverse navbar-fixed-top" >
    <div class="container">

      <div class = "navbar-header">
        <a class="navbar-brand" href="#">
          <span style = "background-image: url(Gym-logo.png);"></span>
          HELP Fit
        </a>
        <button class="navbar-toggle pull-left" style = "margin-left: 10px;" data-toggle = "collapse" data-target = ".navHeaderCollapse">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
      </div>
      <div class="collapse navbar-collapse navHeaderCollapse">
        <ul class="nav navbar-nav">
          <li>
            <?php
            /*
            This will redirect the user to the correct pages depends
            on their user type
            */
            if ($_SESSION['userType'] == "member"){
              echo "<a href='newRegisterSession.php'>";
            }
            else if ($_SESSION['userType'] == "trainer"){
              echo "<a href='newSession.php'>";
            }
            ?>
              <span class="glyphicon glyphicon-blackboard"></span>
              Training Session
            </a>
          </li>
          <li>
            <a href="TrainingHistory.php">
              <span class="glyphicon glyphicon-time"></span>
              Training History
            </a>
          </li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
          <li id="welcome" class="collapse navbar-collapse navbar-text"><script>checkTime()</script></li>
          <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
              <!-- The Profile picture inserted via div class below, with shaping provided by Bootstrap -->
              <?php
              echo "<div class='img-rounded profile-img'></div>";
              echo $_SESSION['fullName'];
              ?>
              <span class="caret"></span>
            </a>
            <ul class="dropdown-menu">
              <li>
                <a href="#">
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
  <form action='../php/updateProfile.php' method='post' enctype="multipart/form-data">
    <div style = "margin: 0; padding: 0;">
      <div class = "container-fluid">
        <div class = "row">
          <div class = "col-sm-12 col-xs-12" style = "padding:0;">
            <div id = "background">
              <div class = "row" style = "margin: 0;">
                <div class="middle">
                  <h2 style="margin:0; color:white;">Edit Profile</h2><br />
                  <div id="dvPreview">
                    <?php
                    if ($profilePic != "") {
                      echo "<img src='../uploads/". $profilePic . "'height=200
                      width=200 alt='profile-img' style='border-radius: 50%;'/>";
                    }
                    else {
                      echo "<img src='../img/person-flat.png' height=200
                      width=200 alt='profile-img' style='border-radius: 50%;'/>";
                    }

                    ?>
                  </div><br />
                  <label class="btn btn-default btn-file">
                    Browse <input id="fileupload" type="file" style="display: none;"
                    name="profilePic">
                  </label>
                </div>
              </div>
            </div>
          </div>
        </div><br /><br />

      </div>
    </div>

    <div class = "container">
      <div class="container" style="max-width:500px;">
        <div class="row">
          <div class="col-xs-12">
            <div class ="card">
              <br>
              <div class = "form-group">
                <label for = "full-name">Full Name:</label>
                <?php echo "<input type='text' class='form-control' id='full-name'
                placeholder='Full Name' name='fullName' value='" . $fullName .
                "'required>" ?>
              </div>
              <br>
              <div class = "form-group">
                <label for = "password">Password:</label>
                <?php echo "<input type='password' class='form-control' id='password'
                placeholder='Password' name='password' value='" . $password .
                "'required>" ?>
              </div>
              <br>
              <div class = "form-group">
                <label for = "email">Email:</label>
                <?php echo "<input type='email' class='form-control' id='email'
                placeholder='Email' name='email' value='" . $email .
                "'required>" ?>
              </div>
              <br>
              <div class = "form-group">
                <?php
                if ($userType == "member") {
                  echo "<label>Level:</label>";
                  echo "<br>";
                  echo "<select name ='level' class='form-control'>";
                  if ($level == "beginner") {
                    echo "<option value='beginner' selected='selected'>Beginner</option>";
                    echo "<option value='advance'>Advance</option>";
                    echo "<option value='expert'>Expert</option>";
                  }
                  else if ($level == "advanced") {
                    echo "<option value='beginner''>Beginner</option>";
                    echo "<option value='advance' selected='selected'>Advance</option>";
                    echo "<option value='expert'>Expert</option>";
                  }
                  else if ($level == "expert") {
                    echo "<option value='beginner''>Beginner</option>";
                    echo "<option value='advance'>Advance</option>";
                    echo "<option value='expert' selected='selected'>Expert</option>";
                  }
                  echo "</select>";
                }
                else if ($userType == "trainer") {
                  echo "<label>Specialty:</label>";
                  echo "<br>";
                  echo "<select name='specialty' class='form-control'>";
                  if ($specialty == "mma") {
                    echo "<option value='mma' selected='selected'>MMA</option>";
                    echo "<option value='dance'>Dance</option>";
                    echo "<option value='sports'>Sport</option>";
                  }
                  else if ($specialty == "dance") {
                    echo "<option value='mma'>MMA</option>";
                    echo "<option value='dance' selected='selected'>Dance</option>";
                    echo "<option value='sports'>Sports</option>";
                  }
                  else if ($specialty == "sports") {
                    echo "<option value='mma'>MMA</option>";
                    echo "<option value='dance'>Dance</option>";
                    echo "<option value='sports' selected='selected'>Sports</option>";
                  }
                  echo "</select>";
                }
                ?>
              </div><br />
              <div style="text-align:center;">
                <button type="submit" class="btn btn-default">Update</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </form>
  <br>
</body>
</html>

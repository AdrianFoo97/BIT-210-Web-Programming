<?php
session_start();
if(empty($_SESSION['repeat'])){
  $_SESSION['repeat'] = "false";
}

if(empty($_SESSION['successP'])){
  $_SESSION['successP'] = "no";
}

if(empty($_SESSION['successG'])){
  $_SESSION['successG'] = "no";
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Register Session</title>
<link rel="icon" href="../img/Gym-logo.png">
<!--Bootstrap-->
<link href="../css/bootstrap.min.css" rel="stylesheet">
<link href="../css/font-awesome.min.css" rel="stylesheet">

<link rel = "stylesheet" href = "../css/style.css" />

<style type="text/css">
a {
  text-decoration:none;
}

td{
  align:center;
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
<script>
  /**
    This function will search the title of the
    session in the table based on the user
    input (reference from Internet)
  */
  function myFunction(column) {
  // Declare variables
  var input, filter, table, tr, td, i, column;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("myTable");
  tr = table.getElementsByTagName("tr");

  // Loop through all table rows, and hide those who don't match the search query
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[column];
    if (td) {
      if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }
  }
  }
</script>

</head>

<body>
  <!--Include JQuery: necessary for Bootstrap plugins-->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <!--Include bootstrap library as needed-->
  <script src="../js/bootstrap.min.js"></script>

  <script src="../js/newSession.js"></script>
  <script src="../js/time.js"></script>

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
            <a href="newRegisterSession.php">
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
                  <?php
                  echo  $_SESSION['fullName'] . "<span class='caret'></span>";
                  ?>
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

<div class ="container">
  <!-- Input from user to search for session -->
  <input type="text" class = "form-control" id="myInput" onkeyup="myFunction(2)" placeholder="Search for title..">
  <br />

  <?php
  if($_SESSION['successP'] == 'yes' ){
    echo "<div class='alert alert-success'>";
    echo "Personal session has been successfully registered.";
    echo "<span class='glyphicon glyphicon-ok'></span>";
    echo "</div>";
    unset($_SESSION['successP']);
  }

  if($_SESSION['successG'] == 'yes' ){
    echo "<div class='alert alert-success'>";
    echo "Group session has been successfully registered.";
    echo "<span class='glyphicon glyphicon-ok'></span>";
    echo "</div>";
    unset($_SESSION['successG']);
  }
   ?>

  <div class ="row">
    <div class = "col-xs-12">
      <h3>Available Sessions:</h3>
      <div id="myTable" class="table-responsive">
        <table class="table table-bordered table-hover table-condensed">
          <thead>
            <tr style="background-color: #162b4c; color: #fff;">
              <th style="text-align:center">ID</th>
              <th style="text-align:center">Title</th>
              <th style="text-align:center">Date</th>
              <th style="text-align:center">Time</th>
              <th style="text-align:center">Fee(RM)</th>
              <th style="text-align:center">Type</th>
              <th style="text-align:center">Trainer</th>
              <th style="text-align:center">Specialty</th>
              <th style="text-align:center">Rating</th>
              <th style="text-align:center">Status</th>
              <th style="text-align:center">Add</th>
            </tr>
          </thead>
          <tbody>

          <?php

          $serverName = "localhost";
          $dbUserName = "root";
          $dbPassword = "";
          $dbName = "assignment2";
          $connection = new mysqli($serverName, $dbUserName, $dbPassword, $dbName);

          $query = "SELECT * FROM `training session`, trainer, user
                    WHERE `training session`.status = 'AVAILABLE'
                    AND user.userName = trainer.userName
                    AND `training session`.trainer = trainer.userName";
          $result = mysqli_query($connection, $query);

          if(mysqli_num_rows($result) > 0){

            while($row = mysqli_fetch_assoc($result)){
              echo "<form action='../php/registerSession.php' method='post'>";
              echo "<tr>";
              echo "<td style='text-align:center'>" .$row["sessionID"] . "</td>";
              echo "<td style='text-align:center'>" . $row['title'] . "</td>";
              echo "<td style='text-align:center'>" . $row['date'] . "</td>";
              echo "<td style='text-align:center'>" . $row['time'] . "</td>";
              echo "<td style='text-align:center'>" . $row['fee'] . "</td>";
              echo "<td style='text-align:center'>" . $row['classType'] . "</td>";
              echo "<td style='text-align:center'>" . $row['fullName'] . "</td>";
              echo "<td style='text-align:center'>" . $row['specialty'] . "</td>";
              echo "<td style='text-align:center'>" . $row['rating'] . "/5 </td>";
              echo "<td style='text-align:center'>" . $row['status'] . "</td>";
              echo "<td><input type=submit value='Register' style='width:100%'></td>";
              echo "<input type=hidden name=hidden1 value=" . $row['sessionID'] . ">";
              echo "<input type=hidden name=hidden2 value=" . $row['classType'] . ">";
              echo "</tr>";
              echo "</form>";
            }
          }
          if($_SESSION['repeat'] == "true"){
          echo "<script>alert('You have already registered for this session.')</script>";
          unset($_SESSION['repeat']);
        }
          ?>
          </tbody>
        </table><br/>
      </div>
    </div>
  </div>
</div>

</body>
</html>

<?php
session_start();
include '../php/dbConnection.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset = "utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Training History</title>
  <link rel="icon" href="../img/Gym-logo.png">
  <link rel="stylesheet" href="../css/bootstrap.min.css" />
  <link rel="stylesheet" href="../css/style.css" />
  <link rel="stylesheet" href="../css/font-awesome.min.css" />
  <link rel="stylesheet" href="../css/trainingHistory.css" />
  <style>
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

<body>
  <script src="../js/jquery-3.2.1.min.js"></script>
  <script src="../js/bootstrap.min.js"></script>
  <script src="../js/time.js"></script>
  <script src="../js/findSession.js"></script>
  <script src="../js/sortTable.js"></script>
  <script>
  /**
  This JQuery will submit the form when the user click
  on the row
  **/
  $(document).ready(function(){
    $('table tbody tr').click(function(){
      var tableID = "t" + this.id;
      document.getElementById(tableID).submit();
    });
  });
  </script>

  <!-- Navigation bar -->
  <nav class="navbar navbar-inverse navbar-fixed-top" >
    <div class="container">
      <div class="navbar-header">
        <a class="navbar-brand" href="TrainingHistory.php">
          <span style="background-image: url(img/Gym-logo.png);"></span>
          HELP Fit
        </a>
        <button class="navbar-toggle pull-left" style="margin-left: 10px;"
        data-toggle="collapse" data-target = ".navHeaderCollapse">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
      </div>
      <div class = "collapse navbar-collapse navHeaderCollapse">
        <ul class = "nav navbar-nav">
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
        <li class="active">
          <a href="TrainingHistory.php">
            <span class="glyphicon glyphicon-time"></span>
            Training History
          </a>
        </li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li id="welcome" class="collapse navbar-collapse navbar-text">
          <script>checkTime()</script></li>
        <li class="dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown" role="button"
          aria-haspopup="true" aria-expanded="false">
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

<div class = "container">
  <!-- Input from user to search for session -->
  <input type="text" class = "form-control" id="myInput" onkeyup="myFunction(1)"
  placeholder="Search for title... " onfocus="this.placeholder=''"
  onblur="this.placeholder='Search for title...'">
  <br />
  <!-- A panel contains the table of training history -->
  <div class="panel panel-primary"  style='border-radius: 20px;'>
    <div class="panel-heading" style = "text-align: center; font-size: 20px;
    border-radius: 20px 20px 0 0;">Training History</div>
    <div class="panel-body" style="padding: 0;">
      <!-- The table which contains a list of session -->
      <div id="myTable" class="table-responsive">
        <table class="table table-hover">
          <thead>
            <tr>
              <th>ID</th>
              <th>Title</th>
              <th onclick="sortTable(2)">Date <i class="fa fa-sort"
                aria-hidden="true"></i></th>
              <th>Time</th>
              <th>Type of Training</th>
            </tr>
          </thead>
          <tbody>
            <?php
            /*
            Check whether the $page variable has been set

            If this web page is first viewed by the user, the default value of
            $page will be set to 1 (first page)
            */
            if (isset($_GET["page"])) {
              $page = $_GET["page"];
            }
            else {
              $page = 1;
            }
            /*
            If the current $page is empty or 1, set the $startingElement to 0
            (first element in SQL database start from 0)
            Else set the startingElement with ($page * 10) - 10
            (eg. starting page2 element = (2 * 10) - 10 = 10)
            */
            if ($page == "" || $page == "1") {
              $startingElement = 0;
              $_SESSION['pagePrevious'] = $page;
              $_SESSION['pageAfter'] = $page + 1;
            }
            else {
              $startingElement = ($page * 10) - 10;
              $_SESSION['page'] = $startingElement;
              $_SESSION['pagePrevious'] = $page - 1;
              $_SESSION['pageAfter'] = $page + 1;
            }
            /*
            This section will find all the training session registered or
            created by the user and display it in a form of table
            */
            $userName = $_SESSION['userName'];
            $query = "SELECT * FROM user_session, `training session` WHERE
            user_session.sessionID = `training session`.sessionID AND
            userName = '$userName' LIMIT $startingElement, 10";
            $result = mysqli_query($connection, $query);
            if (mysqli_num_rows($result) > 0) {
              while ($row = mysqli_fetch_assoc($result)) {
                /*
                If the user is a trainer, submitting the form will redirect
                the trainer to update record page
                */
                if ($_SESSION['userType'] == "trainer") {
                  echo "<form action='updateTrainingRecord.php' method='post'
                  id='t" . $row['sessionID'] . "'>";
                }
                /*
                If the user is a member, submitting the form will redirect
                the member to review the trainer
                */
                else if ($_SESSION['userType'] == "member") {
                  echo "<form action='reviewTrainer.php' method='post' id='t" .
                  $row['sessionID'] . "'>";
                }
                // Displaying the table
                echo "<tr id='" . $row['sessionID'] . "'>";
                echo "<td><a href = '#'>" . $row['sessionID'] . "</a></td>";
                echo "<td>" . $row['title'] . "</td>";
                echo "<td>" . $row['date'] . "</td>";
                echo "<td>" . $row['time'] . "</td>";
                echo "<td>" . $row['classType'] . "</td>";
                echo "<input type=hidden name=sessionID value=" .
                $row["sessionID"]." />";
                echo "</tr>";
                echo "</form>";
              }
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <!-- Pagination -->
  <div class="row">
    <div class="col-xs-12" style="text-align: center;">
      <ul class="pagination">
        <?php
        /*
        This section of code will generate the pagination according to the
        number or session that the user has registered or created.
        */
        $query = "SELECT * FROM user_session, `training session` WHERE
        user_session.sessionID = `training session`.sessionID AND
        userName = '$userName'";
        $result = mysqli_query($connection, $query);
        // getting the rows of result (1 session per row)
        $rows = mysqli_num_rows($result);
        // divide the total session by 10 for 1 page
        $totalPage = $rows / 10;
        $totalPage = ceil($totalPage);
        /*
        If the current page has reach the last page, set the $pageAfter
        to current page
        */
        if ($_SESSION['pageAfter'] > $totalPage) {
          $_SESSION['pageAfter'] = $page;
        }
        // Displaying the pagination
        for ($i = 1; $i <= $totalPage; $i++) {
          $num1 = 1;
          // Print the '<' button at the beginning
          if ($i == 1) {
            echo "<li><a href = 'TrainingHistory.php?page=" . $_SESSION['pagePrevious'] .
            "'>&laquo;</a></li>";
          }
          // If the pagination equals to current page, set it to active
          if ($i == $page) {
            echo "<li class='active'><a href = 'TrainingHistory.php?page=" . $i .
             "'>" . $i . "</a></li>";
          }
          else {
            echo "<li><a href = 'TrainingHistory.php?page=" . $i . "'>" . $i . "</a></li>";
          }
          // Pring the '>' button at the end
          if ($i == $totalPage) {
            echo "<li><a href = 'TrainingHistory.php?page=" . $_SESSION['pageAfter'] .
            "'>&raquo;</a></li>";
          }
        }
        ?>
      </ul>
    </div>
  </div>
</div>
</body>
</html>

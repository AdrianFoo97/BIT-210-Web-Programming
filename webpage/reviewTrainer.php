<?php
	session_start();
  if (!isset($_POST['sessionID'])) {
    $sessionID = $_SESSION['sessionID'];
  }
  else {
    $_SESSION['sessionID'] = $_POST['sessionID'];
    $sessionID = $_SESSION['sessionID'];
  }
  if (!isset($_SESSION['reviewFailed'])) {
    $_SESSION['reviewFailed'] = "null";
  }
	include '../php/dbConnection.php';
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset = "utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Review Trainer</title>
    <link rel="icon" href="../img/Gym-logo.png">
    <link rel="stylesheet" href="../css/bootstrap.min.css" />
    <link rel="stylesheet" href="../css/styles.css" />
    <link rel="stylesheet" href="../css/font-awesome.min.css" />
    <link rel="stylesheet" href="../css/updateReviewSession.css" />
  </head>
  <body>
    <script src="../js/jquery-3.2.1.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/validateReviewForm.js"></script>
    <script src="../js/countdown.js"></script>
    <?php
      if ($_SESSION['reviewFailed'] == "true") {
        echo "<script>alert('You have reviewed this session!');</script>";
        unset($_SESSION['reviewFailed']);
      }
      else if ($_SESSION['reviewFailed'] == "false") {
        echo "<script>alert('Thanks for your review!');</script>";
        unset($_SESSION['reviewFailed']);
      }
    ?>

    <!--
    This is a modal of session details that will shown
    when the "details" button is clicked.
    -->
    <div class="container">
      <!-- Modal -->
      <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">

          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h3 class="modal-title" style="text-align:center;">Training Session Details</h3>
            </div>
            <div class="modal-body">
              <div class="container">
                  <div class="row">
                    <div class="col-xs-12 col-sm-6">
                      <table class="table table-striped table-responsive"
                      style="margin-top:30px; margin-bottom:30px;">
                      <?php
      									$query = "SELECT * FROM `training session` WHERE sessionID =
      									'$sessionID'";
      									$result = mysqli_query($connection, $query);
      									if (mysqli_num_rows($result) > 0) {
      										while ($row = mysqli_fetch_assoc($result)) {
      											$_SESSION['title'] = $row['title'];
      											$_SESSION['fee'] = $row['fee'];
      											$_SESSION['status'] = $row['status'];
      											$_SESSION['classType'] = $row['classType'];
                            $day = substr($row['date'], 8);
      											$month = substr($row['date'], 5, 2);
      											$year = substr($row['date'], 0, 4);
      											$hour = substr($row['time'], 0, 2);
      											$minute = substr($row['time'], 3, 2);
      											echo "<tr>";
      												echo "<th>Date: </th>";
      												echo "<td>" . $row['date'] . "</td>";
      											echo "</tr>";
      											echo "<tr>";
      												echo "<th>Time: </th>";
      												echo "<td>" . $row['time'] . "</td>";
      											echo "</tr>";
      											echo "<tr>";
      												echo "<th>Fee: </th>";
      												echo "<td>" . $row['fee'] . "</td>";
      											echo "</tr>";
      											echo "<tr>";
      												echo "<th>Status: </th>";
      												echo "<td>" . $row['status'] . "</td>";
      											echo "</tr>";
      											if ($row['classType'] == "personal") {
                              $query2 = "SELECT * FROM `training session`, `personal training` WHERE
      												`training session`.sessionID = `personal training`.sessionID AND
      												`training session`.sessionID = '$sessionID'";
      												$result2 = mysqli_query($connection, $query2);
                              if (mysqli_num_rows($result2) > 0) {
                                while ($row2 = mysqli_fetch_assoc($result2)) {
                                  $_SESSION['trainer'] = $row2['trainer'];
                                  echo "<tr>";
          													echo "<th>Class Type: </th>";
          													echo "<td>" . $row['classType'] . "</td>";
          												echo "</tr>";
                                  echo "<tr>";
            												echo "<th>Trainer: </th>";
            												echo "<td>" . $row2['trainer'] . "</td>";
            											echo "</tr>";
                                }
                              }
      											}
      											else if ($row['classType'] == "group") {
      												$query2 = "SELECT * FROM `training session`, `group training` WHERE
      												`training session`.sessionID = `group training`.sessionID AND
      												`training session`.sessionID = '$sessionID'";
      												$result2 = mysqli_query($connection, $query2);
      												if (mysqli_num_rows($result2) > 0) {
      													while ($row2 = mysqli_fetch_assoc($result2)) {
      														$_SESSION['maxNum'] = $row2['maxNum'];
      														$_SESSION['groupType'] = $row2['groupType'];
                                  $_SESSION['trainer'] = $row2['trainer'];
      														echo "<tr>";
      															echo "<th>Class Type: </th>";
      															echo "<td>" . $row['classType'] . " (" . $row2['groupType'] . ")</td>";
      														echo "</tr>";
      														echo "<tr>";
      															echo "<th>Max Participant: </th>";
      															echo "<td>" . $row2['maxNum'] . "</td>";
      														echo "</tr>";
                                  echo "<tr>";
            												echo "<th>Trainer: </th>";
            												echo "<td>" . $row2['trainer'] . "</td>";
            											echo "</tr>";
      													}
      												}
      											}
      										}
      									}
      								 ?>
                      </table>
                    </div>
                  </div>

              </div>
            </div>
            <div class="modal-footer" style="text-align: center;">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
          </div>

        </div>
      </div>

    </div>
    <div class="container">
    <!--
    This is the modal of a form when the member wants to
    review a trainer.
    -->
    <!-- Modal -->
    <div class="modal fade" id="myModal2" role="dialog">
      <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h3 class="modal-title" style="text-align:center;">Review Trainer</h3>
          </div>
          <div class="modal-body">
            <!--
              This is the review form for the member with a radio form
              and comments.
            -->
            <form name="reviewForm" onsubmit="return validateForm2()"
            action="../php/reviewForm.php" method="post">
              <div class = "row">
                <br /><br />
                <div class = "form-group">
                  <label class = "form-check-label col-sm-2 col-xs-12">Rating:</label>
                  <label class = "form-check-label col-sm-2">
                    <input class = "form-check-input" type = "radio" name = "rating" value = "1" />1
                  </label>
                  <label class = "form-check-label col-sm-2">
                    <input class = "form-check-input" type = "radio" name = "rating" value = "2" />2
                  </label>
                  <label class = "form-check-label col-sm-2">
                    <input class = "form-check-input" type = "radio" name = "rating" value = "3" />3
                  </label>
                  <label class = "form-check-label col-sm-2">
                      <input class = "form-check-input" type = "radio" name = "rating" value = "4" />4
                  </label>
                  <label class = "form-check-label col-sm-2">
                    <input class = "form-check-input" type = "radio" name = "rating" value = "5" />5
                  </label>
                </div>
                <p style="text-align: center;" id="text"></p>
              </div>
              <br />
              <div class="row">
                <div class="form-group">
                  <div class="col-xs-12">
                    <label>Comments: </label>
                    <p>
                      <textarea id="txtArea" class = "form-control" name = "comments" rows = "4" cols = "40"></textarea>
                    </p>
                  </div>

                </div>
              </div><br />
              <?php
                echo "<input type=hidden name=sessionID value=" . $sessionID . " />";
                echo "<input type=hidden name=userName value=" . $_SESSION["trainer"] . " />";
              ?>
              <div class="row">
                <div class="modal-footer">
                  <div style="text-align: center;">
                    <input class="btn btn-secondary" type = "submit" value = "Submit"/>
                  </div>
                </div>
              </div>
            </form>
          </div>

        </div>

      </div>
    </div>

  </div>
  <!--
  This is the main interface of the web page which consists of
  the background image, buttons and some header.
  -->
  <div class="bgimg">
    <div class="middle">
      <h1 style="font-size:50px;"><?php echo $_SESSION['title']; ?></h1>
      <hr>
      <p id="demo" style="font-size:30px"></p>
      <button data-toggle="modal" data-target="#myModal" type="button" class="btn btn-default btn-lg">Details</button>
      <?php
      $date = mktime($hour, $minute, 0, $month, $day, $year);
      $date = date("Y-m-d h:i:sa", $date);
      date_default_timezone_set("Asia/Kuala_Lumpur");
      $currentDate = date("Y-m-d h:i:sa");
      // if the currentDate has past the session date
      if ($currentDate > $date) {
        echo "<button data-toggle='modal' data-target='#myModal2' type='button'
         class='btn btn-default btn-lg'>Review</button>";
      }
      ?>

    </div>
    <div class="bottomleft">
      <a href="TrainingHistory.php" style="color:white;">
        <span style="display:inline-block;" class = "glyphicon glyphicon-time"></span>
      </a>
    </div>
  </div>
  <script>
    /*
      This is a java script that convert the duration between the
      session date and the current date into day, time and minutes.
      If the session date has passed the current date, a string
      "session has ended will be display", else the duration
      will be shown.
    */
    var year = <?php echo $year ?>;
    var month = <?php echo $month ?>;
    var month = month - 1;
    var day = <?php echo $day ?>;
    var hour = <?php echo $hour ?>;
    var minute = <?php echo $minute ?>;
    // Set the date we're counting down to
    var countDownDate = new Date(year, month, day, hour, minute, 0, 0).getTime();

    // Update the count down every 1 second
    var countdownfunction = setInterval(function() {

        // Get todays date and time
        var now = new Date().getTime();

        // Find the distance between now an the count down date
        var distance = countDownDate - now;

        // Time calculations for days, hours, minutes and seconds
        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);

        // Output the result in an element with id="demo"
        document.getElementById("demo").innerHTML =
        "<h3>Starts In</h3>" + days + "d " + hours + "h "
        + minutes + "m " + seconds + "s ";

        // If the count down is over, write some text
        if (distance < 0) {
            clearInterval(countdownfunction);
            document.getElementById("demo").innerHTML = "Class Ended";
        }
    }, 1000);
  </script>
  </body>
</html>

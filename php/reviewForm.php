  <?php
    session_start();
    include 'dbConnection.php';

    $rating = $_POST["rating"];
    $comments = $_POST["comments"];
    $sessionID= $_POST["sessionID"];
    $userName = $_SESSION["userName"];

    $query = "SELECT * FROM review WHERE member = '$userName'
    AND sessionID = '$sessionID'";
    $result = mysqli_query($connection, $query);

    if (mysqli_num_rows($result) > 0) {
      $_SESSION['reviewFailed'] = "true";
    }
    else {
      $query = "INSERT INTO  review (sessionID, rating, comments, member)
      VALUES ('$sessionID','$rating','$comments', '$userName')";
      mysqli_query($connection, $query);
      $_SESSION['reviewFailed'] = "false";

      $query2 = "SELECT trainer FROM `training session` WHERE
      sessionID = '$sessionID'";
      $result = mysqli_query($connection, $query2);
      if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
          $trainer = $row['trainer'];
        }
      }
      echo "$trainer". "<br />";
      $query3 = "SELECT * FROM trainer WHERE userName = '$trainer'";
      $result = mysqli_query($connection, $query3);
      if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
          $reviewNum = $row['reviewNum'] + 1;
          $ratingRetrieved = $row['rating'];
          $ratingNew = ($rating + $ratingRetrieved) / $reviewNum;
		  $ratingNew = round($ratingNew, 1);
        }
      }
      mysqli_query($connection, $query3);

      $query4 = "UPDATE trainer SET rating = '$ratingNew', reviewNum = '$reviewNum'
      WHERE userName = '$trainer'";
      mysqli_query($connection, $query4);
    }

    $_SESSION['sessionID'] = $sessionID;
    header("Location: ../webpage/reviewTrainer.php");

    mysqli_close($connection);
  ?>

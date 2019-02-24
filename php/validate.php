<?php
  session_start();
  include 'dbConnection.php';

  $userName = stripcslashes($_POST['userName']);
  $password = stripcslashes($_POST['password']);
  $userName = mysqli_real_escape_string($connection, $userName);
  $password = mysqli_real_escape_string($connection, $password);

  $query = "SELECT * FROM user WHERE userName = '$userName' and
          password = '$password'";
  $result = mysqli_query($connection, $query);
  $row = mysqli_fetch_assoc($result);

  if ($row['userName'] == $userName && $row['password'] == $password) {
    header('Location: ../webpage/TrainingHistory.php');
    $_SESSION['fullName'] = $row['fullName'];
    $_SESSION['userName'] = $row['userName'];
    $_SESSION['userType'] = $row['userType'];
    if ($row['userType'] != "") {
      $_SESSION['profilePic'] = $row['profilePic'];
    }
  }
  else {
    header('Location: ../webpage/SignIn.php');
    $_SESSION['userName'] = "failed";
  }

   mysqli_close($connection);
 ?>

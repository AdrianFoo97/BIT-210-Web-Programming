<?php
  session_start();
  $serverName = "localhost";
  $dbUserName = "root";
  $dbPassword = "";
  $dbName = "assignment2";
  $connection = new mysqli($serverName, $dbUserName, $dbPassword, $dbName);

  $userName = stripcslashes($_POST['tUserName']);
  $password = stripcslashes($_POST['tPassword']);
  $fullName = stripcslashes($_POST['tFullName']);
  $email = stripcslashes($_POST['tEmail']);
  $specialty = stripcslashes($_POST['tSpecialty']);
  $userName = mysqli_real_escape_string($connection, $userName);
  $password = mysqli_real_escape_string($connection, $password);
  $fullName = mysqli_real_escape_string($connection, $fullName);
  $email = mysqli_real_escape_string($connection, $email);
  $specialty = mysqli_real_escape_string($connection, $specialty);

  $query = "SELECT * FROM user WHERE userName = '$userName'";
  $result = mysqli_query($connection, $query);

  if (mysqli_num_rows($result) > 0) {
    echo "<script>alert('sign up failed');</script>";
    $_SESSION['tSignUp'] = "failed";
    header("Location: ../webpage/SignIn.php");
  }
  else {
    $query = "INSERT INTO  user (userName, password, fullName, email, userType) VALUES
    ('$userName','$password','$fullName','$email', 'trainer')";
    $query2 = "INSERT INTO  trainer (userName, specialty) VALUES
    ('$userName', '$specialty')";
    mysqli_query($connection, $query);
    mysqli_query($connection, $query2);
    header("Location: ../webpage/SignIn.php");
  }

  mysqli_close($connection);
?>

<?php
  session_start();
  include 'dbConnection.php';

  $userName = stripcslashes($_POST['mUserName']);
  $password = stripcslashes($_POST['mPassword']);
  $fullName = stripcslashes($_POST['mFullName']);
  $email = stripcslashes($_POST['mEmail']);
  $level = stripcslashes($_POST['mLevel']);
  $userName = mysqli_real_escape_string($connection, $userName);
  $password = mysqli_real_escape_string($connection, $password);
  $fullName = mysqli_real_escape_string($connection, $fullName);
  $email = mysqli_real_escape_string($connection, $email);
  $level = mysqli_real_escape_string($connection, $level);

  $query = "SELECT * FROM user WHERE userName = '$userName'";
  $result = mysqli_query($connection, $query);

  if (mysqli_num_rows($result) > 0) {
    echo "<script>alert('sign up failed');</script>";
    $_SESSION['mSignUp'] = "failed";
    header("Location: ../webpage/SignIn.php");
  }
  else {
    $query = "INSERT INTO  user (userName, password, fullName, email, userType)
    VALUES ('$userName','$password','$fullName', '$email', 'member')";
    $query2 = "INSERT INTO  member (userName, level)
    VALUES ('$userName', '$level')";
    mysqli_query($connection, $query);
    mysqli_query($connection, $query2);
    header("Location: ../webpage/SignIn.php");
  }

  mysqli_close($connection);
?>

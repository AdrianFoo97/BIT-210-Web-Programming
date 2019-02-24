<?php
session_start();
include 'dbConnection.php';

$target = "../uploads/" . basename($_FILES['profilePic']['name']);

$fullName = $_POST['fullName'];
$password = $_POST['password'];
$email = $_POST['email'];
$userName = $_SESSION['userName'];
$userType = $_SESSION['userType'];
$image = $_FILES['profilePic']['name'];

if ($userType == "trainer") {
  $specialty = $_POST['specialty'];

  $query = "UPDATE user
  SET fullName = '$fullName', password = '$password', email = '$email', profilePic = '$image'
  WHERE userName = '$userName'";
  $query2 = "UPDATE trainer
  SET fullName = '$fullName', password = '$password', email = '$email' , specialty = '$specialty'
  WHERE userName = '$userName'";
  mysqli_query($connection, $query);
  mysqli_query($connection, $query2);
  $_SESSION['fullName'] = $fullName;
}
else if ($userType == "member") {
  $level = $_POST['level'];

  $query = "UPDATE user
  SET fullName = '$fullName', password = '$password', email = '$email', profilePic = '$image'
  WHERE userName = '$userName'";
  $query2 = "UPDATE member
  SET fullName = '$fullName', password = '$password', email = '$email' , level = '$level'
  WHERE userName = '$userName'";
  mysqli_query($connection, $query);
  mysqli_query($connection, $query2);
  $_SESSION['fullName'] = $fullName;
}
if (move_uploaded_file($_FILES['profilePic']['tmp_name'], $target)) {
  $msg = "Image uploaded sucessfully";
  $_SESSION['profilePic'] = $image;
}
else {
  $msg = "There was a problem uploading image";
}
header("Location: ../webpage/TrainingHistory.php");

?>

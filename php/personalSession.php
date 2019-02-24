<?php
session_start();

$serverName = "localhost";
$dbUserName = "root";
$dbPassword = "";
$dbName = "assignment2";
$connection = new mysqli($serverName, $dbUserName, $dbPassword, $dbName);

$title=$_POST['title'];
$date=$_POST['date'];
$time=$_POST['time'];
$fee=$_POST['fee'];
$trainerName=$_SESSION['userName'];

//insert into training session table.
$sql1="INSERT INTO `training session` (title, date, time, fee, status, classType, trainer)
      VALUES ('$title', '$date', '$time', '$fee', 'AVAILABLE', 'personal', '$trainerName')";
mysqli_query($connection, $sql1);

//get the latest personal session added which is also the newest.
$query="SELECT sessionID from `training session`";
$result = mysqli_query($connection, $query);
if (mysqli_num_rows($result) > 0) {
    // output data of each row
   while($row = mysqli_fetch_assoc($result)) {
     $sessionID=$row['sessionID'];
   }
 }

$sql2="INSERT INTO `personal training` (sessionID)
        VALUES ('$sessionID')";

       mysqli_query($connection, $sql2);

$query2 = "INSERT INTO user_session(userName, sessionID)
            VALUES ('$trainerName', '$sessionID')";
      mysqli_query($connection, $query2);
       mysqli_close($connection);

$_SESSION['personalRegister'] = "successfull";

header ('Location: ../webpage/newSession.php');
 ?>

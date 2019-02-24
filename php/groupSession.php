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
$maxNum=$_POST['pax'];
$fee=$_POST['fee'];
$groupType=$_POST['groupType'];
$trainerName=$_SESSION['userName'];

//retrieving all the data from the form and entering it into the training session table.
$sql="INSERT INTO `training session` (title, date, time, fee, status, classType, trainer)
      VALUES ('$title', '$date', '$time', '$fee', 'AVAILABLE', 'group', '$trainerName')";

       mysqli_query($connection, $sql);

$query="SELECT sessionID from `training session`";
$result = mysqli_query($connection, $query);
if (mysqli_num_rows($result) > 0) {
    // output data of each row
   while($row = mysqli_fetch_assoc($result)) {
     $sessionID=$row['sessionID'];
   }
 }

//insert into the group training session the data which only group session has.
 $sql2="INSERT INTO `group training` (sessionID, groupType, maxNum)
         VALUES ('$sessionID', '$groupType', '$maxNum')";

         mysqli_query($connection, $sql2);

//insert reference for the trainer who created this session.
$query2 = "INSERT INTO user_session(userName, sessionID)
            VALUES ('$trainerName', '$sessionID')";
mysqli_query($connection, $query2);

mysqli_close($connection);

$_SESSION['groupRegister'] = "successfull";

header ('Location: ../webpage/newSession.php');
 ?>

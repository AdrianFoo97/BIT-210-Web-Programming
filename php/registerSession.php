<?php
session_start();


$serverName = "localhost";
$dbUserName = "root";
$dbPassword = "";
$dbName = "assignment2";
$connection = new mysqli($serverName, $dbUserName, $dbPassword, $dbName);

$sessionID=$_POST['hidden1'];
$classType=$_POST['hidden2'];
$userName= $_SESSION['userName'];

if ($classType == "personal"){

//set reference for the member who registered for this session.
  $query1 = "INSERT INTO user_session(userName, sessionID)
            VALUES ('$userName', '$sessionID')";
  mysqli_query($connection, $query1);

//sest session as full after the first registration since it is personal.
  $query2 = "UPDATE `training session`
             SET status = 'FULL'
             WHERE sessionID = '$sessionID'";
  mysqli_query($connection, $query2);

  mysqli_close($connection);

  $_SESSION['successP'] = 'yes';

  header('Location: ../webpage/newRegisterSession.php');
}

if($classType=="group"){

    $query3 ="SELECT * FROM `group training`
              WHERE `group training`.sessionID = '$sessionID'";
    $result=mysqli_query($connection, $query3);

    $row=mysqli_fetch_assoc($result);

    //check the group session whether it is full.
    if($row['maxNum'] > $row['currentNum']){

      //check whether the member already has registered for this session previously.
        $querya ="SELECT * FROM user_session
                  WHERE user_session.userName = '$userName'
                  AND user_session.sessionID = '$sessionID'";


      $resultCheck=mysqli_query($connection, $querya);

      //had registered
      if(mysqli_num_rows($resultCheck) > 0){
              $_SESSION['repeat'] = "true";
              header('Location: ../webpage/newRegisterSession.php');
            }

      //add member for future check and reference.
      else{
      $query4 = "INSERT INTO user_session(userName, sessionID)
                VALUES ('$userName', '$sessionID')";
      mysqli_query($connection, $query4);

      //increments the counter from the training session table
      $currentNum = $row['currentNum'] + 1;

      $query5 = "UPDATE `group training`
                 SET currentNum = '$currentNum'
                 WHERE sessionID = '$sessionID'";
      mysqli_query($connection, $query5);

      //get the updated table for checking again.
      $query6 ="SELECT * FROM `group training`
                WHERE `group training`.sessionID = '$sessionID'";
      $result2=mysqli_query($connection, $query6);

      $row2=mysqli_fetch_assoc($result2);

      $_SESSION['successG'] = 'yes';

      //check whether the member is the last eligible meber for ref=gis
      if($row2['maxNum'] == $row2['currentNum']){
        $query7 = "UPDATE `training session`
                   SET status = 'FULL'
                   WHERE sessionID = '$sessionID'";
        mysqli_query($connection, $query7);
        header('Location: ../webpage/newRegisterSession.php');
      }
    mysqli_close($connection);
    header('Location: ../webpage/newRegisterSession.php');
}
}
}




 ?>

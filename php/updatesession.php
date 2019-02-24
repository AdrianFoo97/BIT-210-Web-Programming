<?php
    include 'dbConnection.php';

    $date = $_POST["date"];
    $time = $_POST["time"];
    $fee = $_POST["fee"];
    $status = strtoupper($_POST["status"]);
    $groupType = $_POST["groupType"];
    $classType = $_POST["classType"];
    $sessionID = $_POST["sessionID"];
    $notes = $_POST["notes"];

    if ($classType == "group") {
        $query = "UPDATE `training session`
        SET date = '$date', time = '$time', fee = '$fee' , status = '$status'
        WHERE sessionID = '$sessionID'";
        $query2 = "UPDATE `group training`
        SET groupType = '$groupType'
        WHERE `group training`.sessionID = '$sessionID'";
        header('Location: ../webpage/TrainingHistory.php');
    }
    else if ($classType == "personal") {
        $query = "UPDATE `training session`
        SET date = '$date', time = '$time', fee = '$fee' , status = '$status'
        WHERE sessionID = '$sessionID'";
        $query2 = "UPDATE `personal training`
        SET notes = '$notes'
        WHERE `personal training`.sessionID = '$sessionID'";
        header('Location: ../webpage/TrainingHistory.php');
    }
    else {
        echo "<script>alert('update unsuccessfully! Please try again!');</script>";
        header('Location: ../webpage/TrainingHistory.php');
    }
    $result = mysqli_query($connection, $query);
    $result2 = mysqli_query($connection, $query2);

    mysqli_close($connection);
?>

<?php
	session_start();
	$sessionID = $_POST['sessionID'];
	include '../php/dbConnection.php';
?>
<!DOCTYPE html>
<html lang = "en">
  <head>
    <meta charset = "utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Update Record</title>
		<link rel="icon" href="../img/Gym-logo.png">
    <link rel="stylesheet" href="../css/bootstrap.min.css" />
    <link rel ="stylesheet" href="../css/font-awesome.min.css" />
    <link rel="stylesheet" href="../css/updateReviewSession.css" />
  </head>
	<body>
		<script src="../js/jquery-3.2.1.min.js"></script>
		<script src="../js/bootstrap.min.js"></script>
		<script src="../js/script.js"></script>
    <script src="../js/validateUpdateForm.js"></script>
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
					  <div class = "container">
						  <div class = "row">
							<div class = "col-xs-12 col-sm-6">
	              <!--
	              This is a table containing the details of the
	              session.
	              -->
							  <table class = "table table-striped table-responsive"
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
											$_SESSION['date'] = $row['date'];
											$_SESSION['time'] = $row['time'];
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
												echo "<tr>";
													echo "<th>Class Type: </th>";
													echo "<td>" . $row['classType'] . "</td>";
												echo "</tr>";
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
														echo "<tr>";
															echo "<th>Class Type: </th>";
															echo "<td>" . $row['classType'] . " (" . $row2['groupType'] . ")</td>";
														echo "</tr>";
														echo "<tr>";
															echo "<th>Max Participant: </th>";
															echo "<td>" . $row2['maxNum'] . "</td>";
														echo "</tr>";
														echo "<tr>";
															echo "<th>Current participants: </th>";
															echo "<td>" . $row2['currentNum'] . "</td>";
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
				<div class="modal-footer" style="text-align:center;">
				  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				</div>
			  </div>

			</div>
		  </div>

		</div>

    <!--
    This is the modal of a form when the trainer wants to
    update the training session
    -->
		<!-- Modal -->
		<div class="modal fade" id="myModal2" role="dialog">
			<div class="modal-dialog">

			  <!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
					  <button type="button" class="close" data-dismiss="modal">&times;</button>
					  <h3 class="modal-title" style="text-align:center;">Update Record</h3>
					</div>
					<div class="modal-body">
						<div class="container">
							<div class = "row">
								<div class = "col-xs-12 col-sm-6">
								  <br />
									<form name="updateForm" onsubmit="return validateForm()"
                  action="../php/updateSession.php" method="post">
										<table class = "table table-striped table-responsive">
										  <tr>
											<th>Date:</th>
											<td>
                        <div id="dateGroup" class="form-group" style="margin: 0;">
													<?php
													echo "<input type='date' name='date' class='form-control'
													value='" . $_SESSION['date'] . "'>";
													?>
                          <span id="invalidDateIcon" class="glyphicon glyphicon-remove form-control-feedback"></span>
                          <span id="successDateIcon" class="glyphicon glyphicon-ok form-control-feedback"></span>
                          <div id="invalidDate" class="error"></div>
                        </div>
											</td>
										  </tr>
										  <tr>
											<th>Time:</th>
											<td>
                        <div class="form-group" id="timeGroup" style="margin: 0;">
													<?php
													echo "<input type='time' name='time' class='form-control'
													value='" . $_SESSION['time'] . "'>";
													?>
                          <span id="invalidTimeIcon" class="glyphicon glyphicon-remove form-control-feedback"></span>
                          <span id="successTimeIcon" class="glyphicon glyphicon-ok form-control-feedback"></span>
                          <div id="invalidTime" class="error"></div>
                        </div>
											</td>
										  </tr>
										  <tr>
											<th>Fee:</th>
											<td>
                        <div class="form-group" id="feeGroup" style="margin: 0;">
                          <div class="input-group">
    												<span class="input-group-addon" id="basic-addon1">RM</span>
														<?php echo '<input type="number" name="fee" class="form-control" value="' . $_SESSION['fee'] . '";>' ?>
                            <span id="invalidFeeIcon" class="glyphicon glyphicon-remove form-control-feedback"></span>
                            <span id="successFeeIcon" class="glyphicon glyphicon-ok form-control-feedback"></span>
    											 </div>
  											  <div id="invalidFee" class="error"></div>
                        </div>
											</td>
										  </tr>
										  <tr>
											<th>Status</th>
											<td>
											  <select  class = "form-control" name="status">
													<?php
													if ($_SESSION['status'] == "AVAILABLE") {
														echo "<option value='available' selected='selected'>AVAILABLE</option>";
														echo "<option value='completed'>COMPLETED</option>";
														echo "<option value='cancelled'>CANCELLED</option>";
													}
													else if ($_SESSION['status'] == "COMPLETED") {
														echo "<option value='available'>AVAILABLE</option>";
														echo "<option value='completed' selected='selected'>COMPLETED</option>";
														echo "<option value='cancelled'>CANCELLED</option>";
													}
													else {
														echo "<option value='available'>AVAILABLE</option>";
														echo "<option value='completed'>COMPLETED</option>";
														echo "<option value='cancelled' selected='selected'>CANCELLED</option>";
													}
													?>
											  </select>
											</td>
										  </tr>
											<?php
											if ($_SESSION['classType'] == "group") {
												echo "<tr>";
													echo "<th>MAX participants:</th>";
													echo "<td>" . $_SESSION['maxNum'] . "</td>";
											  echo "</tr>";
												echo "<tr>";
												echo "<th>Class type:</th>";
												echo "<td>";
												  echo "<select  class = 'form-control' name='groupType'>";
														if ($_SESSION['groupType'] == "MMA") {
															echo "<option value='MMA' selected='selected'>MMA</option>";
															echo "<option value='Dance'>Dance</option>";
															echo "<option value='Sports'>Sports</option>";
														}
														else if ($_SESSION['groupType'] == "Dance") {
															echo "<option value='MMA'>MMA</option>";
															echo "<option value='Dance' selected='selected'>Dance</option>";
															echo "<option value='Sports'>Sports</option>";
														}
														else if ($_SESSION['groupType'] == "Sports"){
															echo "<option value='MMA'>MMA</option>";
															echo "<option value='Dance'>Dance</option>";
															echo "<option value='Sports' selected='selected'>Sports</option>";
														}
												  echo "</select>";
												echo "</td>";
											  echo "</tr>";
											}
											else if ($_SESSION['classType'] == "personal") {
												echo "<tr>";
													echo "<th>Class type:</th>";
													echo "<td>Personal Training</td>";
												echo "</tr>";
												echo "<tr>";
													echo "<th>Notes:</th>";
													echo "<td><textarea id='txtArea' class = 'form-control'
													name = 'notes' rows = '4' cols = '40'></textarea></td>";
												echo "</tr>";
											}
											echo "<input type=hidden name=sessionID value=" . $sessionID ." />";
											echo "<input type=hidden name=classType value=" . $_SESSION['classType'] ." />";
											?>
										</table>
										<div class="modal-footer">
										  <div class = "col-xs-12" style = "text-align: center;">
											<input type="submit" class = "btn btn-secondary"
                      value="Update" >
										  </div>
										</div>
									</form>
								</div>
							</div>
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
			<h1 style="font-size:70px;"><?php echo $_SESSION['title']; ?></h1>
			<hr>
			<p id="demo" style="font-size:30px"></p>
			<button data-toggle="modal" data-target="#myModal" type="button" class="btn btn-default btn-lg">Details</button>
			<button data-toggle="modal" data-target="#myModal2" type="button" class="btn btn-default btn-lg">Update</button>
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

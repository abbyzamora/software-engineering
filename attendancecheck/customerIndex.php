<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Attendance Tracker</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/datepicker3.css" rel="stylesheet">
    <link href="css/bootstrap-table.css" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet">
    <link href="css/myStyle.css" rel="stylesheet">
    <link href="//cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" rel="stylesheet">

    <!--Icons-->
    <script src="js/lumino.glyphs.js"></script>

    <!--[if lt IE 9]>
<script src="js/html5shiv.js"></script>
<script src="js/respond.min.js"></script>
<![endif]-->

</head>
<?php 
session_start();
$_SESSION['adminemail'] = $_SESSION['user'];
$accountNo = 2;

require_once('../mysql_connect.php');
$printname = "select accountNo, concat(a.firstName, ' ', a.lastName) as 'completename', ra.accounttypedescription, a.accountno as account from accounts a join ref_accounttype ra on a.accounttypeno = ra.accounttypeno where email = '{$_SESSION['adminemail']}'";
$printresult = mysqli_query($dbc,$printname);
$row=mysqli_fetch_array($printresult,MYSQLI_ASSOC);
$accountNo = $row['accountNo'];
?>

    <body>
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#sidebar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="admindashboard.php"><img src="dlsu2.png" height="23px"><span> <b>De La Salle University | Attendance Tracker</b></span></a>
                    <ul class="user-menu">
                        <li class="dropdown pull-right">


                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <svg class="glyph stroked male-user">
                                    <use xlink:href="#stroked-male-user"></use>
                                </svg> User <span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li>
                                    <a href="login.php">
                                        <svg class="glyph stroked cancel">
                                            <use xlink:href="#stroked-cancel"></use>
                                        </svg> Log out</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                    <ul class="user-menu">
                        <li class="dropdown pull-right">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown-m"><span style="font-size:1.2em; vertical-align:bottom;" class="glyphicon glyphicon-bell" id="notif"></span></a> &nbsp;
                        </li>
                    </ul>
                </div>
            </div>
            <!-- /.container-fluid -->
        </nav>
        <div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar">
            <ul class="nav menu">
                <li class="userID">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="row col-md-offset-1">
                                <p class="pull-left">
                                    <?php echo $row['completename']?>
                                </p>
                                <br>
                                <p class="pull-left">
                                    <h4 id="accounttype"><b><?php echo $row['accounttypedescription']?></b></h4></p>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="active">
                    <a href="customerindex.php">
                        <svg class="glyph stroked dashboard-dial">
                            <use xlink:href="#stroked-app-window-with-content"></use>
                        </svg> Dashboard</a>
                </li>
                <li><a data-toggle="modal" href="#myModalCheckedRooms"><span class="glyphicon glyphicon-upload"></span>Upload Checked Rooms</a></li>
                <li>
                    <a href="buildingAssignments.php">
                        <svg class="glyph stroked eye">
                            <use xlink:href="#stroked-eye" />
                        </svg> Building Assignments</a>
                </li>
                <li role="presentation" class="divider"></li>

                <li class="parent">
                    <a href="customerhelpdesk.php"><span><svg class="glyph stroked paperclip"><use xlink:href="#stroked-paperclip"/></svg>Help Desk | FAQs</span></a>
                </li>
            </ul>

        </div>
        <!--/.sidebar-->

        <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
            <div class="row">
                <ol class="breadcrumb">
                    <li>
                        <a href="customerindex.php">
                            <svg class="glyph stroked home">
                                <use xlink:href="#stroked-home"></use>
                            </svg>
                        </a>
                    </li>
                    <li class="active">Dashboard</li>
                </ol>
            </div>
            <!--/.row-->

            <div class="row">
                <div class="col-lg-12">
                    <h2 class="page-header">Dashboard</h2>
                </div>
            </div>
            <!--/.row-->

            <div class="row">

                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-body tabs">
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#tab1" data-toggle="tab">Make-up</a></li>
                                <li><a href="#tab2" data-toggle="tab">Room Transfer</a></li>
                                <li><a href="#tab3" data-toggle="tab">Alternative Class</a></li>
                                <li><a href="#tab4" data-toggle="tab">Change in Time</a></li>
                                <li><a href="#tab5" data-toggle="tab">Substitutions</a></li>
                            </ul>

                            <div class="tab-content">
                                <div class="tab-pane fade in active" id="tab1">
                                    <h4>Make-up List</h4>
                                    <table data-toggle="table" class="data-table">
                                        <thead>
                                            <tr>
                                                <th data-field="room">Room</th>
                                                <th data-field="fname">Faculty</th>
                                                <th data-field="department">Class Time</th>
                                                <th data-field="remarks">Class Date</th>
                                                <th data-field="actions">Class Details</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
									$query = "SELECT 
												fmu.roomCode,
												fmu.courseCode as course,
											    fmu.section,
											    DATE_FORMAT(fmu.absentDate, '%M %e %Y %a') as absentDate,
												CONCAT(DATE_FORMAT(p.startTime, '%H:%i'), ' - ', DATE_FORMAT(p.endTime, '%H:%i')) as absentTime,
												CONCAT(TRIM(f.firstName), ', ', TRIM(f.lastName)) as faculty,
												DATE_FORMAT(fmu.makeUpDate, '%M %e %Y %a') as makeUpDate,
											    CONCAT(DATE_FORMAT(fmu.makeUpStartTime, '%H:%i'), ' - ', DATE_FORMAT(fmu.makeUpEndTime, '%H:%i')) as makeUpTime
											  FROM MV_FacultyMakeUp fmu JOIN Plantilla p
																		  ON fmu.courseCode = p.courseCode
																		 AND fmu.facultyID = p.facultyID
											                             AND fmu.dayID = p.dayID
											                             AND fmu.schoolYear = p.schoolYear
											                             AND fmu.term = p.term
											                             AND fmu.section = p.section
																		JOIN faculty f
											                              ON fmu.facultyID = f.facultyID
											                            JOIN Room r
											                              ON p.roomCode = r.roomCode
											                            JOIN (SELECT *
											                                   FROM Assigned_Building
											                                  WHERE accountNo = $accountNo) ab
											                              ON r.buildingCode = ab.buildingCode
											                            JOIN REF_Shift s
											                              ON ab.shiftCode = s.shiftCode
											WHERE fmu.makeUpDate >= CURDATE()
											  AND fmu.makeUpStartTime BETWEEN s.shiftStart AND s.shiftEnd;";

									$result = $dbc->query($query);
									$count = 0;
									if($result){

										while($row = mysqli_fetch_array($result, MYSQLI_ASSOC) ){
											echo '<tr>';
											echo "<td>{$row['roomCode']}</td>";
											echo "<td>{$row['faculty']}</td>";
											echo "<td>{$row['makeUpTime']}</td>";
											echo "<td>{$row['makeUpDate']}</td>";
											echo "<td>
													<button class=\"btn btn-primary btn-xs\" data-toggle=\"modal\" data-target=\"#myModal$count\">
														Details
													</button>
													<!-- Modal -->
													<div class=\"modal fade\" id=\"myModal$count\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"myModalLabel\" aria-hidden=\"true\">
														<div class=\"modal-dialog\">
															<div class=\"modal-content\">
																<div class=\"modal-header\">
																	<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-hidden=\"true\">&times;</button>
																	<h4 class=\"modal-title\" id=\"myModalLabel\">Make-up class</h4>
																</div>
																<div class=\"modal-body\">
																	<ul class=\"list-group\" style=\"text-align:left;\">
																	  <li class=\"list-group-item\"><b>Subject:</b> {$row['course']}</li>
																	  <li class=\"list-group-item\"><b>Section:</b> {$row['section']}</li>
																	  <li class=\"list-group-item\"><b>Missed Class Date:</b>&nbsp;{$row['absentDate']}</li>
																	  <li class=\"list-group-item\"><b>Missed Class Time:</b>&nbsp;{$row['absentTime']}</li>
																	  <li class=\"list-group-item\"><b>Alternative Class Date:</b>&nbsp;{$row['makeUpDate']}</li>
																	  <li class=\"list-group-item\"><b>Alternative Class Time:</b>&nbsp;{$row['makeUpTime']}</li>
																	  <li class=\"list-group-item\"><b>Scheduled Room:</b> {$row['roomCode']}</li>
																	</ul>
																<div class=\"modal-footer\">
																	<button type=\"button\" class=\"btn btn-default\" data-dismiss=\"modal\">Close</button>
																</div>
															</div>
															<!-- /.modal-content -->
														</div>
														<!-- /.modal-dialog -->
													</div>
													<!-- /.modal -->
												</td>";
											$count++;
											echo '</tr>';
										}
									}
								?>
                                        </tbody>
                                    </table>

                                </div>
                                <div class="tab-pane fade" id="tab2">
                                    <h4>Room Transfer List</h4>
                                    <table data-toggle="table" class="data-table">
                                        <thead>
                                            <tr>
                                                <th data-field="room">Original Room</th>
                                                <th data-field="room">Transfer Room</th>
                                                <th data-field="fname">Faculty</th>
                                                <th data-field="classTime">Class Time</th>
                                                <th data-field="transferDate">Transfer Date</th>
                                                <th data-field="actions">Class Details</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
								$query = "SELECT
											   p.roomCode as originalRoom,
										       rt.venue as newRoom,
											   CONCAT(f.lastname, ', ', f.firstName) as faculty,
										       CONCAT(DATE_FORMAT(p.startTime, '%H:%i'), ' - ', DATE_FORMAT(p.endTime, '%H:%i')) AS time,
										       DATE_FORMAT(rt.transferDate, '%M %e %Y %a') as transferDate,
										       rt.courseCode,
										       rt.section,
										       rtr.transferDescription
										  FROM MV_RoomTransfer rt JOIN Faculty f
																	ON rt.facultyID = f.facultyID
																  JOIN Plantilla p
																	ON rt.courseCode = p.courseCode
																   AND rt.facultyID = p.facultyID
										                           AND rt.dayID = p.dayID
																   AND rt.schoolYear = p.schoolYear
										                           AND rt.term = p.term
										                           AND rt.section = p.section
																  JOIN Ref_RoomTransferReason rtr
																	ON rt.transferCode = rtr.transferCode
																  JOIN Room r
                                                                    ON p.roomCode = r.roomCode
																  JOIN Ref_Building b
                                                                    ON r.buildingCode = b.buildingCode
																  JOIN (SELECT *
																	      From Assigned_Building
																	    WHERE accountNo = $accountNo) ab
																    ON b.buildingCode = ab.buildingCode
																 JOIN REf_Shift sh
                                                                   ON ab.shiftCode = sh.shiftCode
										WHERE rt.schoolYear = YEAR(CURRENT_TIMESTAMP)
										  AND rt.term = (SELECT MAX(term)
														FROM MV_RoomTransfer
													   WHERE schoolYear = YEAR(CURRENT_TIMESTAMP))
										  AND (rt.transferCode = 'RT'
											   OR rt.transferCode = 'PR')
										  AND transferDate >= CURDATE()
                                          AND rt.startTime BETWEEN sh.shiftStart AND sh.shiftEnd;";

									$result = $dbc->query($query);

									foreach($result as $row){
										echo '<tr>';
											echo "<td>{$row['originalRoom']}</td>";
											echo "<td>{$row['newRoom']}</td>";
											echo "<td>{$row['faculty']}</td>";
											echo "<td>{$row['time']}</td>";
											echo "<td>{$row['transferDate']}</td>";
											echo "<td>
															<button class=\"btn btn-primary btn-xs\" data-toggle=\"modal\" data-target=\"#myModal$count\">
																Details
															</button>

															<!-- Modal -->
															<div class=\"modal fade\" id=\"myModal$count\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"myModalLabel\" aria-hidden=\"true\">
																<div class=\"modal-dialog\">
																	<div class=\"modal-content\">
																		<div class=\"modal-header\">
																			<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-hidden=\"true\">&times;</button>
																			<h4 class=\"modal-title\" id=\"myModalLabel\">Room-transfer</h4>
																		</div>
																		<div class=\"modal-body\">
																			<ul class=\"list-group\" style=\"text-align:left;\">
																				<li class=\"list-group-item\"><b>Subject:</b> {$row['courseCode']}</li>
																				<li class=\"list-group-item\"><b>Section:</b>&nbsp;{$row['section']}</li>
																				<li class=\"list-group-item\"><b>Effective Schedule:</b>&nbsp;{$row['transferDate']} </li>
																				<li class=\"list-group-item\"><b>Original Room:</b> {$row['originalRoom']}</li>
																				<li class=\"list-group-item\"><b>Transfer Room:</b> {$row['newRoom']}</li>
																				<li class=\"list-group-item\"><b>Class Time:</b> {$row['time']}</li>
																				<li class=\"list-group-item\"><b>Reason:</b> {$row['transferDescription']}</li>
																			</ul>
																		<div class=\"modal-footer\">
																			<button type=\"button\" class=\"btn btn-default\" data-dismiss=\"modal\">Close</button>
																		</div>
																	</div>
																	<!-- /.modal-content -->
																</div>
																<!-- /.modal-dialog -->
															</div>
															<!-- /.modal -->
														</td>";
										echo '</tr>';
										$count++;
									}
							?>
                                        </tbody>
                                    </table>

                                </div>
                                <div class="tab-pane fade" id="tab3">
                                    <h4>Alternative Class List</h4>
                                    <table data-toggle="table" class="data-table">
                                        <thead>
                                            <tr>
                                                <th data-field="room">Original Room</th>
                                                <th data-field="fname">Faculty</th>
                                                <th data-field="cllassTime">Class Time</th>
                                                <th data-field="transferDate">Transfer Date</th>
                                                <th data-field="classDate">Original Date</th>
                                                <th data-field="actions">Class Details</th>
                                            </tr>
                                        </thead>
                                        <?php
								$query = "SELECT 
								               p.roomCode,
											   CONCAT(f.lastname, ', ', f.firstName) as faculty,
										       CONCAT(DATE_FORMAT(p.startTime, '%H:%i'), ' - ', DATE_FORMAT(p.endTime, '%H:%i')) AS time,
											   DATE_FORMAT(rt.transferDate, '%M %e %Y %a') as transferDate,
											   DATE_FORMAT(rt.originalDate, '%M %e %Y %a') as originalDate,
										       rt.courseCode,
											   rt.section,
										       CONCAT(DATE_FORMAT(rt.startTime, '%H:%i'), ' - ', DATE_FORMAT(rt.endTime, '%H:%i')) AS altTime,
										       rt.venue,
											   rtr.transferDescription
										  FROM MV_RoomTransfer rt JOIN Faculty f
																	ON rt.facultyID = f.facultyID
																  JOIN Plantilla p
																	ON rt.courseCode = p.courseCode
																   AND rt.facultyID = p.facultyID
										                           AND rt.dayID = p.dayID
																   AND rt.schoolYear = p.schoolYear
										                           AND rt.term = p.term
										                           AND rt.section = p.section
																  JOIN Ref_RoomTransferReason rtr
                													ON rt.transferCode = rtr.transferCode
                												  JOIN Room r
																    ON p.roomCode = r.roomCode
																  JOIN Ref_Building b
                                                                    ON r.buildingCode = b.buildingCode
																  JOIN (SELECT *
                                                                          FROM Assigned_Building
																		 WHERE accountNo = $accountNo) ab
																    ON b.buildingCode = ab.buildingCode
																  JOIN Ref_Shift s
                                                                    ON ab.shiftCode = s.shiftCode
										WHERE rt.schoolYear = YEAR(CURRENT_TIMESTAMP)
										  AND rt.term = (SELECT MAX(term)
														FROM MV_RoomTransfer
													   WHERE schoolYear = YEAR(CURRENT_TIMESTAMP))
										  AND (rt.transferCode = 'FT'
											   OR rt.transferCode = 'AC')
										  AND transferDate >= CURDATE()
										  AND rt.startTime BETWEEN s.shiftStart AND s.shiftEnd;";

								$result = $dbc->query($query);
							?>
                                            <tbody>
                                                <?php
									foreach($result as $row){
										echo '<tr>';
											echo "<td>{$row['roomCode']}</td>";
											echo "<td>{$row['faculty']}</td>";
											echo "<td>{$row['time']}</td>";
											echo "<td>{$row['transferDate']}</td>";
											echo "<td>{$row['originalDate']}</td>";
											echo "<td>
													<button class=\"btn btn-primary btn-xs\" data-toggle=\"modal\" data-target=\"#myModal$count\">
														Details
													</button>

													<!-- Modal -->
													<div class=\"modal fade\" id=\"myModal$count\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"myModalLabel\" aria-hidden=\"true\">
														<div class=\"modal-dialog\">
															<div class=\"modal-content\">
																<div class=\"modal-header\">
																	<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-hidden=\"true\">&times;</button>
																	<h4 class=\"modal-title\" id=\"myModalLabel\">Alternative Class</h4>
																</div>
																<div class=\"modal-body\">
																	<ul class=\"list-group\" style=\"text-align:left;\">
																		<li class=\"list-group-item\"><b>Subject:</b> {$row['courseCode']}</li>
																		<li class=\"list-group-item\"><b>Section:</b> {$row['section']}</li>
																		<li class=\"list-group-item\"><b>Original Class Date:</b>&nbsp;{$row['originalDate']}</li>
																		<li class=\"list-group-item\"><b>Original Class Time:</b>&nbsp;{$row['time']}</li>
																		<li class=\"list-group-item\"><b>Alternative Class Date:</b>&nbsp;{$row['transferDate']} </li>
																		<li class=\"list-group-item\"><b>Alternative Class Time:</b>&nbsp;{$row['altTime']} </li>
																		<li class=\"list-group-item\"><b>Venue:</b> {$row['venue']}</li>
																		<li class=\"list-group-item\"><b>Reason:</b> {$row['transferDescription']}</li>
																	</ul>
																<div class=\"modal-footer\">
																	<button type=\"button\" class=\"btn btn-default\" data-dismiss=\"modal\">Close</button>
																</div>
															</div>
															<!-- /.modal-content -->
														</div>
														<!-- /.modal-dialog -->
													</div>
													<!-- /.modal -->
												</td>";
										echo '</tr>';

										$count++;
									}
								?>
                                            </tbody>

                                    </table>
                                </div>
                                <div class="tab-pane fade" id="tab4">
                                    <h4>Change in time List</h4>
                                    <table data-toggle="table" class="data-table">
                                        <thead>
                                            <tr>
                                                <th data-field="room">Original Room</th>
                                                <th data-field="fname">Faculty</th>
                                                <th data-field="cllassTime">Original Class Time</th>
                                                <th data-field="cllassTime">New Class Time</th>
                                                <th data-field="transferDate">Effective Date</th>
                                                <th data-field="actions">Class Details</th>
                                            </tr>
                                        </thead>

                                        <?php
									$query = "SELECT
												   p.roomCode as originalRoom,
												   rt.venue as newRoom,
												   CONCAT(f.lastname, ', ', f.firstName) as faculty,
												   CONCAT(DATE_FORMAT(p.startTime, '%H:%i'), ' - ', DATE_FORMAT(p.endTime, '%H:%i')) AS originalTime,
												   CONCAT(DATE_FORMAT(rt.startTime, '%H:%i'), ' - ', DATE_FORMAT(rt.endTime, '%H:%i')) AS newTime,
												   DATE_FORMAT(rt.transferDate, '%M %e %Y %a') as effectiveDate,
												   rt.courseCode,
												   rt.section,
												   rtr.transferDescription
											  FROM MV_RoomTransfer rt JOIN Faculty f
																		ON rt.facultyID = f.facultyID
																	  JOIN Plantilla p
																		ON rt.courseCode = p.courseCode
																	   AND rt.facultyID = p.facultyID
											                           AND rt.dayID = p.dayID
																	   AND rt.schoolYear = p.schoolYear
											                           AND rt.term = p.term
											                           AND rt.section = p.section
																	  JOIN Ref_RoomTransferReason rtr
																		ON rt.transferCode = rtr.transferCode
																	  JOIN Room r
																        ON p.roomCode = r.roomCode
																      JOIN Ref_Building b
                                                                        ON r.buildingCode = b.buildingCode
																      JOIN (SELECT *
                                                                              FROM Assigned_Building
																	   	     WHERE accountNo = $accountNo) ab
																	   	ON b.buildingCode = ab.buildingCode
																      JOIN Ref_Shift s
                                                                        ON ab.shiftCode = s.shiftCode
											WHERE rt.schoolYear = YEAR(CURRENT_TIMESTAMP)
											  AND rt.term = (SELECT MAX(term)
															FROM MV_RoomTransfer
														   WHERE schoolYear = YEAR(CURRENT_TIMESTAMP))
											  AND rt.transferCode = 'CT'
												AND transferDate >= CURDATE()
												AND ((rt.startTime BETWEEN s.shiftStart AND s.shiftEnd) OR (p.startTime BETWEEN s.shiftStart AND s.shiftEnd));";
									$result = $dbc->query($query);
								?>
                                            <tbody>
                                                <?php
										foreach($result as $row){
											echo '<tr>';
												echo "<td>{$row['originalRoom']}</td>";
												echo "<td>{$row['faculty']}</td>";

												echo "<td>{$row['originalTime']}</td>";
												echo "<td>{$row['newTime']}</td>";
												echo "<td>{$row['effectiveDate']}</td>";
												echo "<td>
																<button class=\"btn btn-primary btn-xs\" data-toggle=\"modal\" data-target=\"#myModal$count\">
																	Details
																</button>

																<!-- Modal -->
																<div class=\"modal fade\" id=\"myModal$count\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"myModalLabel\" aria-hidden=\"true\">
																	<div class=\"modal-dialog\">
																		<div class=\"modal-content\">
																			<div class=\"modal-header\">
																				<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-hidden=\"true\">&times;</button>
																				<h4 class=\"modal-title\" id=\"myModalLabel\">Change in time</h4>
																			</div>
																			<div class=\"modal-body\">
																				<ul class=\"list-group\" style=\"text-align:left;\">
																					<li class=\"list-group-item\"><b>Subject:</b> {$row['courseCode']}</li>
																					<li class=\"list-group-item\"><b>Section:</b> {$row['section']}</li>
																					<li class=\"list-group-item\"><b>Effective Date:</b> {$row['effectiveDate']}</li>
																					<li class=\"list-group-item\"><b>Original Class Time:</b>&nbsp;{$row['originalTime']}</li>
																					<li class=\"list-group-item\"><b>New Class Time:</b>&nbsp;{$row['newTime']} </li>
																					<li class=\"list-group-item\"><b>Original Room:</b> {$row['originalRoom']}</li>
																					<li class=\"list-group-item\"><b>Transfer Room:</b> {$row['newRoom']}</li>
																				</ul>
																			<div class=\"modal-footer\">
																				<button type=\"button\" class=\"btn btn-default\" data-dismiss=\"modal\">Close</button>
																			</div>
																		</div>
																		<!-- /.modal-content -->
																	</div>
																	<!-- /.modal-dialog -->
																</div>
																<!-- /.modal -->
															</td>";
											echo '</tr>';

											$count++;
										}
									?>
                                            </tbody>

                                    </table>
                                </div>
                                <div class="tab-pane fade" id="tab5">
                                    <h4>Substitutions List</h4>
                                    <table data-toggle="table" class="data-table">
                                        <thead>
                                            <tr>
                                                <th data-field="room">Room</th>
                                                <th data-field="fname">Original Faculty</th>
                                                <th data-field="fname">Substitute Faculty</th>
                                                <th data-field="cllassTime">Class Time</th>
                                                <th data-field="transferDate">Anticipated Date</th>
                                                <th data-field="actions">Class Details</th>
                                            </tr>
                                        </thead>

                                        <?php
									$query = "SELECT p.roomCode as room,
												   CONCAT(of.lastName, ', ', of.firstName) as originalFaculty,
												   CONCAT(nf.lastName, ', ', nf.firstName) as substituteFaculty,
												   CONCAT(DATE_FORMAT(p.startTime, '%H:%i'), ' - ', DATE_FORMAT(p.endTime, '%H:%i')) as classTime,
												   DATE_FORMAT(s.anticipatedDate, '%M %e %Y %a') as classDate,
												   s.courseCode,
												   s.section
												FROM MV_Substitution s JOIN Faculty of
																		 ON s.facultyID = of.facultyID
																	   JOIN Faculty nf
																		 ON s.substituteFacultyID = nf.facultyID
																	   JOIN Plantilla p
																		 ON s.courseCode = p.courseCode
																		AND s.facultyID = p.facultyID
																		AND s.dayID = p.dayID
																		AND s.schoolYear = p.schoolYear
																		AND s.term = p.term
																		AND s.section = p.section
																	   JOIN Room r
																         ON p.roomCode = r.roomCode
																       JOIN Ref_Building b
                                                                         ON r.buildingCode = b.buildingCode
																       JOIN (SELECT *
                                                                               FROM Assigned_Building
																	   	      WHERE accountNo = $accountNo) ab
																	   	 ON b.buildingCode = ab.buildingCode
																       JOIN Ref_Shift sh
                                                                         ON ab.shiftCode = sh.shiftCode
											WHERE s.schoolYear = YEAR(CURRENT_TIMESTAMP)
											  AND s.term = (SELECT MAX(term)
															FROM MV_Substitution
														   WHERE schoolYear = YEAR(CURRENT_TIMESTAMP))
															AND anticipatedDate >= CURDATE()
															AND p.startTime BETWEEN sh.shiftStart AND sh.shiftEnd;";
									$result = $dbc->query($query);
								?>

                                            <tbody>
                                                <?php
										foreach($result as $row){
											echo '<tr>';
												echo "<td>{$row['room']}</td>";
												echo "<td>{$row['originalFaculty']}</td>";

												echo "<td>{$row['substituteFaculty']}</td>";
												echo "<td>{$row['classTime']}</td>";
												echo "<td>{$row['classDate']}</td>";
												echo "<td>
																<button class=\"btn btn-primary btn-xs\" data-toggle=\"modal\" data-target=\"#myModal$count\">
																	Details
																</button>

																<!-- Modal -->
																<div class=\"modal fade\" id=\"myModal$count\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"myModalLabel\" aria-hidden=\"true\">
																	<div class=\"modal-dialog\">
																		<div class=\"modal-content\">
																			<div class=\"modal-header\">
																				<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-hidden=\"true\">&times;</button>
																				<h4 class=\"modal-title\" id=\"myModalLabel\">Alternative Class</h4>
																			</div>
																			<div class=\"modal-body\">
																				<ul class=\"list-group\" style=\"text-align:left;\">
																					<li class=\"list-group-item\"><b>Subject:</b> {$row['courseCode']}</li>
																					<li class=\"list-group-item\"><b>Section:</b> {$row['section']}</li>
																					<li class=\"list-group-item\"><b>Original Faculty:</b> {$row['originalFaculty']}</li>
																					<li class=\"list-group-item\"><b>Substitute Faculty:</b>&nbsp;{$row['substituteFaculty']}</li>
																					<li class=\"list-group-item\"><b>Class Room:</b>&nbsp;{$row['room']} </li>
																					<li class=\"list-group-item\"><b>Class Time:</b> {$row['classTime']}</li>
																					<li class=\"list-group-item\"><b>Class Date:</b> {$row['classDate']}</li>
																				</ul>
																			<div class=\"modal-footer\">
																				<button type=\"button\" class=\"btn btn-default\" data-dismiss=\"modal\">Close</button>
																			</div>
																		</div>
																		<!-- /.modal-content -->
																	</div>
																	<!-- /.modal-dialog -->
																</div>
																<!-- /.modal -->
															</td>";
											echo '</tr>';
										}
									?>
                                            </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="myModalCheckedRooms">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title" id="myModalLabel1">Upload Checked Rooms</h4>
                    </div>
                    <div class="modal-body">
                        <input type="file" id="my_file_input2" />
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" id='checked-button' class="btn btn-success">Upload Checked Rooms</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    </body>


    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script src="js/shim.js"></script>
    <script src="js/jszip.js"></script>
    <script src="js/xlsx.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/lumino.glyphs.js"></script>

    <script src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <script>
        // notification

        var interval = 100; // 1000 = 1 second, 3000 = 3 seconds
        function number() {
            $.ajax({
                type: 'POST',
                url: 'post.php',
                data: {
                    check: 'number'
                },
                success: function (data) {

                    $('#notif').html(data); // first set the value  

                },
                complete: function (data) {
                    // Schedule the next
                    setTimeout(number, interval);
                }
            });
        }

        function open() {
            $.ajax({
                type: 'POST',
                url: 'post.php',
                data: {
                    check: 'open'
                },
                success: function (data) {

                    $('#notif').html(data); // first set the value  

                },
                complete: function (data) {
                    // Schedule the next
                    setTimeout(number, interval);
                }
            });
        }

        setTimeout(number, interval);
        //redirect
        $('#notif').click(function () {

            if (!$('#notif').text().length) {

            } else if ($('#notif').text().length != 0) {
                open();
                //window.location.replace("http://stackoverflow.com");
            }


        });
    </script>
    <script>
        ! function ($) {
            $(document).on("click", "ul.nav li.parent > a > span.icon", function () {
                $(this).find('em:first').toggleClass("glyphicon-minus");
            });
            $(".sidebar span.icon").find('em:first').addClass("glyphicon-plus");
        }(window.jQuery);

        $(window).on('resize', function () {
            if ($(window).width() > 768) $('#sidebar-collapse').collapse('show')
        })
        $(window).on('resize', function () {
            if ($(window).width() <= 767) $('#sidebar-collapse').collapse('hide')
        })

        //target = 4 means the 5th column. Column is counted from 0-nth
        //orderable means if it is sortable
        $(document).ready(function () {
            $('table.data-table').DataTable({
                "columnDefs": [
                    {
                        "orderable": false,
                        "targets": -1
                    }
			  ]
            });
        });
    </script>

    <script>
        var output;
        $('input[type=file]').change(function () {
            readFile($(this).attr('id'));
        });



        function readFile(thiss) {
            var files = document.getElementById(thiss).files;

            var i, f;
            for (i = 0, f = files[i]; i != files.length; ++i) {
                var reader = new FileReader();
                var name = files[0].name;
                reader.onload = function (e) {
                    var data = e.target.result;
                    //var wb = XLSX.read(data, {type: 'binary'});
                    var arr = String.fromCharCode.apply(null, new Uint8Array(data));
                    var wb = XLSX.read(btoa(arr), {
                        type: 'base64'
                    });
                    process_wb(wb);
                };
                //reader.readAsBinaryString(f);
                reader.readAsArrayBuffer(f);
            }
        }

        function process_wb(wb) {



            /*output = JSON.stringify(to_json(wb), 2, 2);
             */
            output = to_json(wb);





            console.log(output);
        }

        function to_json(workbook) {
            var result = {};
            workbook.SheetNames.forEach(function (sheetName) {
                var roa = XLSX.utils.sheet_to_row_object_array(workbook.Sheets[sheetName]);
                if (roa.length > 0) {
                    result[sheetName] = roa;
                }
            });
            return result;
        }
        $('#plantilla-button').click(function () {
            if (output) {
                $.post({

                    url: 'insert.php',
                    data: output,
                    success: function (data) {
                        alert(data);
                    },
                    error: function (jqXHR, textStatus, errorThrown) {

                        alert(textStatus);
                        alert(errorThrown);
                    }
                });
            } else {
                alert('Failed!');
            }
            $('input[type=file]').val('');
            $('#myModalPlantilla').modal('hide');
        });
        $('#checked-button').click(function () {
            if (output) {
                $.post({

                    url: 'insertCheckedRooms.php',
                    data: {
                        'data': output
                    },
                    success: function (data) {
                        alert(data);
                    },
                    error: function (jqXHR, textStatus, errorThrown) {

                        alert(textStatus);
                        alert(errorThrown);
                    }
                });
            } else {
                alert('Failed!');
            }
            $('input[type=file]').val('');
            $('#myModalCheckedRooms').modal('hide');
        });
    </script>

</html>
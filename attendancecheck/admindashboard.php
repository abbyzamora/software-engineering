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

<!--[if lt IE 9]>
<script src="js/html5shiv.js"></script>
<script src="js/respond.min.js"></script>
<![endif]-->

</head>
<?php
	session_start();
	$_SESSION['adminemail'] = $_SESSION['user'];

	require_once('../mysql_connect.php');
	$printname = "select concat(a.firstName,' ', a.lastName) as 'completename', ra.accounttypedescription from accounts a join ref_accounttype ra on a.accounttypeno = ra.accounttypeno where email = '{$_SESSION['adminemail']}'";
	$printresult = mysqli_query($dbc,$printname);

	$row=mysqli_fetch_array($printresult,MYSQLI_ASSOC);
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


						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><svg class="glyph stroked male-user"><use xlink:href="#stroked-male-user"></use></svg> User <span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">
							<li><a href="login.php"><svg class="glyph stroked cancel"><use xlink:href="#stroked-cancel"></use></svg> Log out</a></li>
						</ul>
					</li>
				</ul>
				<ul class="user-menu">
					<li class="dropdown pull-right">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span style="font-size:1.4em; vertical-align:bottom;" class="glyphicon glyphicon-upload" aria-hidden="true"></span>&nbsp; &nbsp;Import <span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">
							<li><a data-toggle="modal" href="#myModalPlantilla">Import Faculty Plantilla</a></li>
							<li><a data-toggle="modal" href="#myModalCheckedRooms">Import Checked Rooms</a></li>
						</ul>
						&nbsp;
					</li>
					</ul>
			</div>
		</div><!-- /.container-fluid -->
	</nav>


	<div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar helvetica">

		<ul class="nav menu">
			<li class="userID">
				<div class="panel panel-default">
					<div class="panel-body">
						<div class="row col-md-offset-1">
                            <p class="pull-left"><?php echo $row['completename']?></p><br>
                            <p class="pull-left"><h4 id="accounttype"><b><?php echo $row['accounttypedescription']?></b></h4></p>
						</div>
					</div>
				</div>
			</li>
			<li class="active"><a href="admindashboard.php"><svg class="glyph stroked dashboard-dial"><use xlink:href="#stroked-app-window-with-content"></use></svg> Dashboard</a></li>
			<li class="parent">
				<a href="#" data-toggle="collapse" data-target="#sub-item-1">
					<span><svg class="glyph stroked chevron-down"><use xlink:href="#stroked-chevron-down"> </use></svg></span> Attendance Monitor
				</a>
				<ul class="children collapse" id="sub-item-1">
					<li>
						<a class="" href="scheduleclass.php">
							<svg class="glyph stroked chevron-right"><use xlink:href="#stroked-chevron-right"></use></svg> Schedule a Class
						</a>
					</li>
					<li>
                        <a href="viewCheckedRooms.php">
                            <svg class="glyph stroked chevron-right">
                                <use xlink:href="#stroked-chevron-right"></use>
                            </svg> View Checked Rooms
                        </a>
                    </li>
				</ul>
			</li>
			<li class="parent">
				<a href="#" data-toggle="collapse" data-target="#sub-item-2">
					<span><svg class="glyph stroked chevron-down"><use xlink:href="#stroked-chevron-down"></use></svg></span> Manage Users
				</a>
				<ul class="children collapse" id="sub-item-2">
					<li>
						<a class="" href="newAccount.php">
							<svg class="glyph stroked chevron-right"><use xlink:href="#stroked-chevron-right"></use></svg> Create new user account
						</a>
					</li>
					<li>
						<a class="" href="assign-checker.php">
							<svg class="glyph stroked chevron-right"><use xlink:href="#stroked-chevron-right"></use></svg> Assign Checker
						</a>
					</li>
				</ul>
			</li>

			<li role="presentation" class="divider"></li>

			<li class="parent">
			    <a href="adminhelpdesk.php"><span><svg class="glyph stroked paperclip"><use xlink:href="#stroked-paperclip"/></svg>Help Desk | FAQs</span></a>
			</li>

		</ul>

	</div><!--/.sidebar-->

	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
		<div class="row">
			<ol class="breadcrumb">
				<li><a href="admindashboard.php"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
				<li class="active">Dashboard</li>
			</ol>
		</div><!--/.row-->

		<div class="row">
			<div class="col-lg-12">
				<h2 class="page-header">Dashboard</h2>
			</div>
		</div><!--/.row-->

		<div class="row">

			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-heading"><u>Make-up Classes List</u></div>
					<div class="panel-body">

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
									date_default_timezone_set('UTC');
									$query = "SELECT
															fmu.coursecode as course,
															fmu.section as section,
															MONTH(fmu.absentdate) as abmonth,
															DAY(fmu.absentdate) as abday,
													 		YEAR(fmu.absentdate) as abyear,
															CONCAT(p.starttime,' - ',p.endtime) as abtime,
													 		CONCAT(trim(f.firstname), ' ', trim(f.lastname)) as facultyname,
															fmu.makeupdate as altdate,
															MONTH(fmu.makeupdate) as altmonth,
                              DAY(fmu.makeupdate) as altday,
															YEAR(fmu.makeupdate) as altyear,
															fmu.makeuproom as altroom,
                              CONCAT(fmu.makeupstarttime,' - ',fmu.makeupendtime) as alttime
														FROM mv_facultymakeup fmu join faculty f
																												on fmu.facultyid = f.facultyid
																		  								join plantilla p
																		    								on fmu.coursecode = p.coursecode
											    WHERE fmu.makeupdate >= CURDATE()
                       group by 1,2";

									$result = mysqli_query($dbc, $query);
									$count = 0;
									if($result){

										while($row = mysqli_fetch_array($result, MYSQLI_ASSOC) ){
											echo '<tr>';
											echo "<td>{$row['altroom']}</td>";
											echo "<td>{$row['facultyname']}</td>";
											echo "<td>{$row['alttime']}</td>";
											echo "<td>";
											echo date('F j Y D', mktime(0, 0, 0, $row['altmonth'], $row['altday'], $row['altyear'] ));
											echo "</td>";

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
																	  <li class=\"list-group-item\"><b>Missed Class Schedule:</b>"; echo date('F j Y D', mktime(0, 0, 0, $row['abmonth'], $row['abday'], $row['abyear'] )).' '; echo "{$row['abtime']}</li>
																	  <li class=\"list-group-item\"><b>Alternative Class Schedule:</b>"; echo date('F j Y D', mktime(0, 0, 0, $row['altmonth'], $row['altday'], $row['altyear'] )).' '; echo "{$row['alttime']}</li>
																	  <li class=\"list-group-item\"><b>Scheduled Room:</b> {$row['altroom']}</li>
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

						<div class="panel-heading"><u>Room Transfer List</u></div>

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
											WHERE rt.schoolYear = YEAR(CURRENT_TIMESTAMP)
											  AND rt.term = (SELECT MAX(term)
															FROM MV_RoomTransfer
														   WHERE schoolYear = YEAR(CURRENT_TIMESTAMP))
											  AND (rt.transferCode = 'RT'
												   OR rt.transferCode = 'PR')
												AND transferDate >= CURDATE();";
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
							<tbody>

							</tbody>
						</table>

						<div class="panel-heading"><u>Alternative Class List</u></div>

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
								$query = "SELECT p.roomCode,
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
													WHERE rt.schoolYear = YEAR(CURRENT_TIMESTAMP)
													  AND rt.term = (SELECT MAX(term)
																	FROM MV_RoomTransfer
																   WHERE schoolYear = YEAR(CURRENT_TIMESTAMP))
													  AND (rt.transferCode = 'FT'
														   OR rt.transferCode = 'AC')
														AND transferDate >= CURDATE();";
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
																				<li class=\"list-group-item\"><b>Original Class Schedule:</b>&nbsp;{$row['originalDate']}</li>
																				<li class=\"list-group-item\"><b>Alternative Class Schedule:</b>&nbsp;{$row['transferDate']} </li>
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

							<div class="panel-heading"><u>Change in time List</u></div>

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
														WHERE rt.schoolYear = YEAR(CURRENT_TIMESTAMP)
														  AND rt.term = (SELECT MAX(term)
																		FROM MV_RoomTransfer
																	   WHERE schoolYear = YEAR(CURRENT_TIMESTAMP))
														  AND rt.transferCode = 'CT'
															AND transferDate >= CURDATE();";
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
																				<h4 class=\"modal-title\" id=\"myModalLabel\">Alternative Class</h4>
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

							<div class="panel-heading"><u>Substitutions List</u></div>

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
														                            AND s.dayID = p.facultyID
														                            AND s.schoolYear = p.schoolYear
														                            AND s.term = p.term
														                            AND s.section = p.section
														WHERE s.schoolYear = YEAR(CURRENT_TIMESTAMP)
														  AND s.term = (SELECT MAX(term)
																		FROM MV_Substitution
																	   WHERE schoolYear = YEAR(CURRENT_TIMESTAMP))
															AND anticipatedDate >= CURDATE();";
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
				</div><!-- panel-body -->
			</div><!-- panel -->
		</div><!--/.col-md-12-->
	</div><!--/.row-->

	<div class="modal fade" id="myModalPlantilla" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title" id="myModalLabel">Upload Plantilla</h4>
				</div>
				<div class="modal-body">
					<input type="file" id="my_file_input" />
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="button" id='plantilla-button' class="btn btn-success">Upload Plantilla</button>
				</div>
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>
	<div class="modal fade" id="myModalCheckedRooms">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" >&times;</button>
					<h4 class="modal-title" id="myModalLabel1">Upload Checked Rooms</h4>
				</div>
				<div class="modal-body">
					<input type="file" id="my_file_input2"/>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="button"  id='checked-button' class="btn btn-success">Upload Checked Rooms</button>
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


		!function ($) {
		    $(document).on("click","ul.nav li.parent > a > span.icon", function(){
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
		//a target with a negative number means the counting starts from the leftmost column
		$(document).ready(function(){
			$('table.data-table').DataTable({
			  "columnDefs": [
			    { "orderable": false,
			      "targets": -1 }
			  ]
			});
		});

	</script>

	<script>
    var output;
    $('input[type=file]').change(function(){
        readFile($(this).attr('id'));
    });



    function readFile(thiss) {
        var files=document.getElementById(thiss).files;

        var i,f;
        for (i = 0, f = files[i]; i != files.length; ++i) {
            var reader = new FileReader();
            var name = files[0].name;
            reader.onload = function(e) {
                var data = e.target.result;
                //var wb = XLSX.read(data, {type: 'binary'});
                var arr = String.fromCharCode.apply(null, new Uint8Array(data));
                var wb = XLSX.read(btoa(arr), {type: 'base64'});
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
	    workbook.SheetNames.forEach(function(sheetName) {
	        var roa = XLSX.utils.sheet_to_row_object_array(workbook.Sheets[sheetName]);
	        if(roa.length > 0){
	            result[sheetName] = roa;
	        }
	    });
	    return result;
	}
	$('#plantilla-button').click(function(){
		if(output){
			$.post({

		      url: 'insert.php',
		      data:output,
		      success:function(data){
		        alert(data);
		      },
		       error : function(jqXHR, textStatus, errorThrown) {

		        alert(textStatus);
		        alert(errorThrown);
		    }
		    });
		 }
		  else{
		 	alert('Failed!');
		 }
		 $('input[type=file]').val('');
		 $('#myModalPlantilla').modal('hide');
	});
	$('#checked-button').click(function(){
		if(output){
			$.post({

		      url: 'insertCheckedRooms.php',
		      data:{'data':output},
		      success:function(data){
		        alert(data);
		      },
		       error : function(jqXHR, textStatus, errorThrown) {

		        alert(textStatus);
		        alert(errorThrown);
		    }
		    });
		 }
		  else{
		 	alert('Failed!');
		 }
		 $('input[type=file]').val('');
		 $('#myModalCheckedRooms').modal('hide');
	});

	</script>



</html>

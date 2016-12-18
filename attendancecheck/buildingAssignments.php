<?php
require_once '../mysql_connect.php';

session_start();

$accountNo = 2;

if(isset($_SESSION['adminemail'])){
	$_SESSION['adminemail'] = $_SESSION['user'];

	$printname = "select accountNo, concat(a.firstName,' ', a.lastName) as 'completename', ra.accounttypedescription from accounts a join ref_accounttype ra on a.accounttypeno = ra.accounttypeno where email = '{$_SESSION['adminemail']}'";
	$printresult = mysqli_query($dbc,$printname);
	$row=mysqli_fetch_array($printresult,MYSQLI_ASSOC);

	$accountNo = $row['accountNo'];
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Attendance Tracker</title>

	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/datepicker3.css" rel="stylesheet">
	<link href="css/tableexport.css" rel="stylesheet">
	<link href="css/styles.css" rel="stylesheet">
	<link href="css/myStyle.css" rel="stylesheet">
	<link href="css/bootstrap-table.css" rel="stylesheet">

	<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
	<script src="js/xlsx.core.min.js"></script>
	<script src="js/Blob.js"></script>
	<script src="js/FileSaver.min.js"></script>
	<script src="js/tableexport.min.js"></script>

	<!--Icons-->


	<!--[if lt IE 9]>
	<script src="js/html5shiv.js"></script>
	<script src="js/respond.min.js"></script>
	<![endif]-->

</head>

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
						<a href="#" class="dropdown-toggle"  data-toggle="dropdown-m"><span style="font-size:1.2em; vertical-align:bottom;" class="glyphicon glyphicon-bell" id="notif"></span></a>
						&nbsp;
					</li>
					</ul>
			</div>
		</div><!-- /.container-fluid -->
	</nav>
	<div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar">
		<ul class="nav menu">
			<li class="userID">
				<div class="panel panel-default">
					<div class="panel-body">
						<div class="row col-md-offset-1">
						    <p class="pull-left"><?php echo $row['completename']?></p> <br>
                            <p class="pull-left"><h4 id="accounttype"><b><?php echo $row['accounttypedescription']?></b></h4></p>
						</div>
					</div>
				</div>
			</li>
			<li><a href="customerindex.php"><svg class="glyph stroked dashboard-dial"><use xlink:href="#stroked-app-window-with-content"></use></svg> Dashboard</a></li>
			<li><a data-toggle="modal" href="#myModalCheckedRooms"><span class="glyphicon glyphicon-upload"></span>Upload Checked Rooms</a></li>
			<li class="active"><a href="buildingAssignments.php"><svg class="glyph stroked eye"><use xlink:href="#stroked-eye"/></svg> Building Assignments</a></li>
			<li role="presentation" class="divider"></li>

			<li class="parent">
			    <a href="customerhelpdesk.php"><span><svg class="glyph stroked paperclip"><use xlink:href="#stroked-paperclip"/></svg>Help Desk | FAQs</span></a>
			</li>
		</ul>

	</div><!--/.sidebar-->

	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
		<div class="row">
			<ol class="breadcrumb">
				<li><a href="#"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
                <li class="active"><a href="buildingAssignments.php">Building Assignments</a></li>
			</ol>
		</div><!--/.row-->

		<div class="row">
			<div class="col-lg-12">
				<h2 class="page-header">Building Assignments</h2>
			</div>
		</div><!--/.row-->

		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-body">
						<?php
							//retrieve assigned rooms
							$query = "SELECT B.buildingName, P.roomCode,  P.courseCode, P.section, S.shiftCode as shift ,CONCAT(DATE_FORMAT(startTime, '%H:%i'), ' - ', DATE_FORMAT(endTime, '%H:%i')) AS time, startTime, endTime, P.dayID, CONCAT(f.firstName, ' ', f.lastName) as faculty,P.term as term
													FROM Accounts A JOIN Assigned_Building AB
																						ON A.ACCOUNTNO = AB.ACCOUNTNO
																				  JOIN REF_Shift S
																				  	ON AB.shiftCode = S.shiftCode
																					JOIN Room R
																						ON R.BUILDINGCODE = AB.BUILDINGCODE
																					JOIN Plantilla P
																						ON P.ROOMCODE = R.ROOMCODE
																					JOIN Faculty F
																						ON P.facultyID = F.facultyID
																					JOIN Ref_Building B
																					  ON R.buildingCode = B.buildingCode
												 WHERE A.ACCOUNTNO = $accountNo
													 AND AB.TERM = (SELECT MAX(TERM)
																 						FROM Assigned_Building
																 					  WHERE SCHOOLYEAR = YEAR(NOW()))
													 AND P.TERM = (SELECT MAX(TERM)
																					 FROM Assigned_Building
																					 WHERE SCHOOLYEAR = YEAR(NOW()))
													 AND AB.SCHOOLYEAR = YEAR(NOW())
													 AND P.DAYID = SUBSTRING(DATE_FORMAT(CURRENT_TIMESTAMP,'%a') FROM 1 FOR 1)
													 AND P.startTime BETWEEN S.shiftStart AND S.shiftEnd;";

							$result = $dbc->query($query);

							$buildings = [];

							//sort the rooms into buildings and shifts
							foreach ($result as $row) {
								$buildings[$row['buildingName']][$row['shift']][] = ['startTime' => $row['startTime'], 'endTime' => $row['endTime'], $row['roomCode'], $row['courseCode'], $row['section'], $row['time'], $row['dayID'], $row['faculty'],$row['term']];
							}

							//we now have a list of buildings
							// with shifts
							// with rooms with classes @_@
							// without room transfers considered
							/// We must remove the rooms with transfers, make-up, etc.

/* SUBTRATION/REMOVAL SECTION */
							//remove from plantilla rooms that are transfered

							//get classes that are transfered
							$query = "SELECT *
												  FROM MV_RoomTransfer
												 WHERE (originalDate = CURDATE()
											 					OR transferDate = CURDATE())
												   AND dayID = SUBSTRING(DATE_FORMAT(CURRENT_TIMESTAMP,'%a') FROM 1 FOR 1)
												   AND term = (SELECT MAX(term)
																	       FROM Assigned_Building
																        WHERE schoolYear = YEAR(CURRENT_TIMESTAMP));";
							$result = $dbc->query($query);

							//now to remove the classes that are transfered
							foreach($result as $row){
								foreach ($buildings as $building => $shifts) {
									foreach ($shifts as $shift => $classes) {
										foreach($classes as $index => $class){
												if($class[2] == $row['section'] AND $class[1] == $row['courseCode'] AND $class['startTime'] == $row['startTime'] AND $class['endTime'] == $row['endTime']){
													unset($buildings[$building][$shift][$index]);
													goto end1;
												}
										}
									}
								}
								end1:
							}

							// remove make up classes
							$result = $dbc->query("SELECT
																				  fmu.courseCode,
																			    fmu.section,
																			    p.startTime,
																			    p.endTime,
																			    b.buildingName
																			FROM MV_FacultyMakeUp fmu JOIN Plantilla p
																										ON fmu.courseCode = p.courseCode
																									   AND fmu.facultyID = p.facultyID
																			                           AND fmu.dayID = p.dayID
																			                           AND fmu.schoolYear = p.schoolYear
																			                           AND fmu.term = p.term
																			                           AND fmu.section = p.section
																			                           JOIN Room r
																			                           ON p.roomCode = r.roomCode
																			                           JOIN Ref_Building b
																			                            ON r.buildingCode = b.buildingCode
																			WHERE fmu.schoolYear = YEAR(CURRENT_TIMESTAMP)
																			AND fmu.term = (SELECT MAX(term)
																						FROM MV_FacultyMakeUp
																					  WHERE schoolYear = YEAR(CURRENT_TIMESTAMP))
																			AND fmu.dayID = SUBSTRING(DATE_FORMAT(CURRENT_TIMESTAMP,'%a') FROM 1 FOR 1);
																			AND fmu.makeUpDate = CURDATE()");

							foreach($result as $row){
								foreach($buildings[$row['buildingName']] as $building => $shifts){
									foreach($shifts as $shift => $classes){
										foreach($classes as $index => $class){
											if($class[2] == $row['section'] AND $class[1] == $row['courseCode'] AND $class['startTime'] == $row['startTime'] AND $class['endTime'] == $row['endTime']){
												unset($buildings[$building][$shift][$index]);
											}
										}
									}
								}

							}

/* ADDITION SECTION */
							//add the transfered classes for today
							$query = "SELECT ab.shiftCode as shift , b.buildingName as building, rt.courseCode, rt.venue, rt.section,  rt.dayID, rt.startTime, rt.endTime, CONCAT(DATE_FORMAT(rt.startTime, '%H:%i'), ' - ', DATE_FORMAT(rt.endTime, '%H:%i')) AS time, SUBSTRING(DATE_FORMAT(CURRENT_TIMESTAMP,'%a') FROM 1 FOR 1) as day, CONCAT(f.firstName, ' ', f.lastName) as faculty,P.term as term
												  FROM MV_RoomTransfer rt JOIN Plantilla p
																			ON rt.courseCode = p.courseCode
																		   AND rt.facultyID = p.facultyID
												                           AND rt.dayID = p.dayID
												                           AND rt.schoolYear = p.schoolYear
												                           AND rt.term = p.term
												                           AND rt.section = p.section
																		  JOIN Faculty f
																			ON rt.facultyID = f.facultyID
																		  JOIN Room r
																			ON p.roomCode = r.roomCode
																		  JOIN Ref_Building b
												                            ON r.buildingCode = b.buildingCode
																		  JOIN Assigned_Building ab
																			ON ab.buildingCode = b.buildingCode
																		  JOIN REF_Shift s
																			ON s.shiftCode = ab.shiftCode
												 WHERE rt.transferDate = CURDATE()
												   AND rt.dayID = SUBSTRING(DATE_FORMAT(CURRENT_TIMESTAMP,'%a') FROM 1 FOR 1)
												   AND ab.accountNo = $accountNo
												   AND ab.schoolYear = YEAR(CURRENT_TIMESTAMP)
												   AND ab.term = (SELECT MAX(term)
																	FROM Assigned_Building
																   WHERE schoolYear = YEAR(CURRENT_TIMESTAMP))
												   AND rt.startTime BETWEEN s.shiftStart AND s.shiftEnd;";
							$result = $dbc->query($query);


							foreach ($result as $row) {
								//$buildings[$row['buildingName']][$row['shift']][] = ['startTime' => $row['startTime'], 'endTime' => $row['endTime'], $row['roomCode'], $row['courseCode'], $row['section'], $row['time'], $row['dayID'], $row['faculty']];

								foreach($buildings[$row['building']][$row['shift']] as $index => $class){
									if($class[2] == $row['section'] AND $class[1] == $row['courseCode'] AND $class['startTime'] == $row['startTime'] AND $class['endTime'] == $row['endTime']){
										unset($buildings[$building][$shift][$index]);
										break;
									}
								}
								$buildings[$row['building']][$row['shift']][] =['startTime' => $row['startTime'], 'endTime' => $row['endTime'], $row['venue'], $row['courseCode'], $row['section'], $row['time'], $row['dayID'], $row['faculty'], $row['term']];

							}

							//add make-up classes for today
							$query = "SELECT ab.shiftCode as shift, mu.term as term, b.buildingName as building, mu.courseCode, mu.roomCode, mu.section,  mu.dayID, mu.makeUpStartTime, mu.makeUpEndTime, CONCAT(DATE_FORMAT(mu.makeUpStartTime, '%H:%i'), ' - ', DATE_FORMAT(mu.makeUpEndTime, '%H:%i')) AS time, SUBSTRING(DATE_FORMAT(CURRENT_TIMESTAMP,'%a') FROM 1 FOR 1) as day, CONCAT(f.firstName, ' ', f.lastName) as faculty,P.term as term
											   FROM MV_FacultyMakeUp mu JOIN Plantilla p
																		  ON mu.courseCode = p.courseCode
																		 AND mu.facultyID = p.facultyID
											                             AND mu.dayID = p.dayID
											                             AND mu.schoolYear = p.schoolYear
											                             AND mu.term = p.term
											                             AND mu.section = p.section
																		JOIN Faculty f
																		  ON mu.facultyID = f.facultyID
																		JOIN Room r
																		  ON mu.roomCode = r.roomCode
																	    JOIN Ref_Building b
											                              ON r.buildingCode = b.buildingCode
																	    JOIN Assigned_Building ab
																		  ON ab.buildingCode = b.buildingCode
																	    JOIN REF_Shift s
																		  ON s.shiftCode = ab.shiftCode
											WHERE mu.schoolYear = YEAR(CURRENT_TIMESTAMP)
											  AND mu.term = (SELECT MAX(term)
															FROM MV_FacultyMakeUp
														  WHERE schoolYear = YEAR(CURRENT_TIMESTAMP))
											  AND mu.dayID = SUBSTRING(DATE_FORMAT(CURRENT_TIMESTAMP,'%a') FROM 1 FOR 1)
											  AND mu.makeUpDate = CURDATE()
											  AND mu.makeUpStartTime BETWEEN s.shiftStart AND s.shiftEnd
											  AND ab.accountNo = $accountNo;";
							$result = $dbc->query($query);

							foreach ($result as $row) {
								//$buildings[$row['buildingName']][$row['shift']][] = ['startTime' => $row['startTime'], 'endTime' => $row['endTime'], $row['roomCode'], $row['courseCode'], $row['section'], $row['time'], $row['dayID'], $row['faculty']];

								$buildings[$row['building']][$row['shift']][] =['startTime' => $row['makeUpStartTime'], 'endTime' => $row['makeUpEndTime'], $row['roomCode'], $row['courseCode'], $row['section'], $row['time'], $row['dayID'], $row['faculty'],$row['term']];
							}

							$currentDate = date('F d, Y');
						?>
						<table data-toggle="table">
							<thead>
								<tr>
									<th>Time</th>
									<th data-field="building" data-align="center">Building</th>
									<th data-field="actions"> Actions</th>
								</tr>
							</thead>
							<tbody>
								<?php
									$count = 0;
									$modals = '';

				          foreach ($buildings as $building => $shifts) {
				            foreach ($shifts as $shift => $classes) {
				              echo '<tr>';
				                echo "<td>$shift</td>";
				                echo "<td>$building</td>";

				                echo '<td>';
													echo "<button class=\"btn btn-primary details-button btn-xs\" data-toggle=\"modal\" data-target=\"#myModal$count\">
																	Details
																</button>";

													$modals .= "<div class=\"modal fade\" id=\"myModal$count\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"myModalLabel\" aria-hidden=\"true\">
																	<div class=\"modal-dialog\">
																		<div class=\"modal-content\">

																			<div class=\"modal-header\">
																				<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-hidden=\"true\">&times;</button>
																				<div calign=\"center\" lass=\"row\">
																					<h4 align=\"center\" class=\"modal-title\" id=\"myModalLabel\">Classes in <u>$building</u></h4>
																				</div><!-- /.row -->
																				<h6 align=\"center\">for this day: <u>$currentDate</u></h6>
																			</div><!-- /.modal-header-->

																			<div class=\"modal-body\">";

																			$modals .= "<caption  background=\"gray\"><h3 style='text-align:center;margin-top:0px;margin-bottom:10px'>$shift</h3></caption>";
																			$modals .= '<table class="export_table" data-toggle="table">';
																				$modals .=  '<thead>';
																					$modals .=  '<tr>';
																						$modals .=  '<th>Course Code</th>';
																						$modals .=  '<th>Section</th>';
																						$modals .=  '<th>Time</th>';
																						$modals .=  '<th>Room</th>';
																						$modals .=  '<th>Day</th>';
																						$modals .=  '<th>Faculty</th>';

																						$modals .= '<th class="hidden" >Term</th>';
																						$modals .= '<th class="hidden">Code</th>';
																						$modals .= '<th class="hidden">Remarks</th>';
																					$modals .=  '</tr>';
																				$modals .=  '</thead>';
																				$modals .= '<tbody>';
																					foreach($classes as $index => $class){
																						$modals .= '<tr>';
																							$modals .= "<td>{$class[1]}</td>";
																							$modals .= "<td>{$class[2]}</td>";
																							$modals .= "<td>{$class[3]}</td>";
																							$modals .= "<td>{$class[0]}</td>";
																							$modals .= "<td>{$class[4]}</td>";
																							$modals .= "<td>{$class[5]}</td>";

																							$modals .= "<td>{$class[6]}</td>";
																							$modals .= "<td></td>";
																							$modals .= "<td></td>";


																						$modals .= '</tr>';
																					}
																				$modals .= '</tbody>';
																			$modals .= '</table>';


													$modals .= "			</div><!-- /.modal-body -->

																			<div class=\"modal-footer\">
																				<button type=\"button\" class=\"btn btn-default\" data-dismiss=\"modal\">Close</button>
																			</div><!-- /.modal-footer -->

																		</div><!--/.modal-content -->
																	</div><!--/.modal-dialog -->
																</div><!-- /.modal -->";
												echo '</td>';
				              echo '</tr>';

											$count++;
				            }
				          }

				        ?>
							</tbody>
					</table>


				</div>
			</div>
		</div>
	</div>
</div><!--/.col-->
<?php echo $modals; ?>
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

<script src="js/jquery.tabletoCSV.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/shim.js"></script>
<script src="js/jszip.js"></script>
<script src="js/xlsx.js"></script>
<script src="js/bootstrap-table.js"></script>
<script src="js/lumino.glyphs.js"></script>


<script>
var time, building,date,d;

var table = $(".export_table").tableExport({
	formats: ["xlsx"],
	fileName: date,
	position:"top",
	bootstrap:false
});


$('table').on('click','button.details-button',function(){
	console.log('asd');
	time = $(this).closest('tr').find('td:first-child').html();
	console.log(time);
	building = $(this).closest('tr').find('td:nth-child(2)').html();
	console.log(building);
	d = new Date();
    date = d.toDateString();
    date = time + ' - '+building + ' - '+ date;
    console.log(date);




	table.update({
		headings:true,
		footer:true,
		fileName: date,
		position:"bottom",

	});

  	$('button').addClass("btn btn-primary btn-xs").css({'color':'white','font-size':'12px','position':"right"});
});

$('button').addClass("btn btn-primary btn-xs").css({'color':'white','font-size':'12px','position':"right"});






</script>
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

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

									if($result){
										$count = 0;
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
									<th data-field="fname">Faculty</th>
									<th data-field="cllassTime">Class Time</th>
									<th data-field="transferDate">Transfer Date</th>
									<th data-field="classDate">Original Date</th>
									<th data-field="actions">Class Details</th>
								</tr>
							</thead>
							<?php
								$query ="SELECT
													  p.roomCode AS originalRoom,
													  CONCAT(f.firstName, ' ', f.lastName) AS faculty,
													  CONCAT(mrt.starttime, ' - ', mrt.endtime) AS classTime,
													  DATE_FORMAT(originalDate, '%M, %d %Y - %a') AS originalDate,
													  DATE_FORMAT(transferDate, '%M, %d %Y - %a') AS transferDate,

													  mrt.courseCode,
													  p.section,
													  mrt.venue,
													  rrt.transferDescription

													FROM mv_roomtransfer mrt JOIN plantilla p
													              						 ON mrt.courseCode = p.courseCode
													                          AND mrt.facultyID = p.facultyID
													                          AND mrt.dayID = p.dayID
													                          AND mrt.schoolYear = p.schoolYear
													                          AND mrt.term = p.term
													                          AND mrt.section = p.section
													              					 JOIN ref_roomtransferreason rrt
																			               ON mrt.transferCode = rrt.transferCode
																		               JOIN faculty f
																			               ON mrt.facultyID = f.facultyID;";
								$result = $dbc->query($query);
							?>
							<tbody>
								<?php
									foreach($result as $row){
										echo '<tr>';
											echo "<td>{$row['originalRoom']}</td>";
											echo "<td>{$row['faculty']}</td>";
											echo "<td>{$row['classTime']}</td>";
											echo "<td>{$row['transferDate']}</td>";
											echo "<td>{$row['originalDate']}</td>";
											echo "<td>";
											echo "<button class=\"btn btn-primary btn-xs\" data-toggle=\"modal\" data-target=\"#myModal$count\">
																Details
														</button>";

											echo "<!-- Modal -->
														<div class=\"modal fade\" id=\"myModal$count\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"myModalLabel\" aria-hidden=\"true\">
															<div class=\"modal-dialog\">
																<div class=\"modal-content\">
																	<div class=\"modal-header\">
																		<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-hidden=\"true\">&times;</button>
																		<h4 class=\"modal-title\" id=\"myModalLabel\">Alternative class</h4>
																	</div>
																	<div class=\"modal-body\">
																		<ul class=\"list-group\" style=\"text-align:left;\">
																			<li class=\"list-group-item\"><b>Subject:</b> {$row['courseCode']}</li>
																			<li class=\"list-group-item\"><b>Section:</b> {$row['section']}</li>
																			<li class=\"list-group-item\"><b>Venue:</b> {$row['venue']}</li>
																			<li class=\"list-group-item\"><b>Transfer Reason: </b>{$row['transferDescription']}</li>
																		</ul>
																	<div class=\"modal-footer\">
																		<button type=\"button\" class=\"btn btn-default\" data-dismiss=\"modal\">Close</button>
																	</div>
																</div>
																<!-- /.modal-content -->
															</div>
															<!-- /.modal-dialog -->
														</div>
														<!-- /.modal -->";

											echo "</td>";
										echo '</tr>';

										$count++;
									}
								?>
							</tbody>
						<table>
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

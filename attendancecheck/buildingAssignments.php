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
										//get the assigned buildings from the database
								$query = "SELECT b.buildingName, b.buildingCode, ab.shiftCode
								FROM (SELECT *
										FROM Assigned_Building
										WHERE accountNo = $accountNo
										AND schoolYear = YEAR(CURRENT_TIMESTAMP)
										AND term = (SELECT MAX(term)
										FROM Assigned_Building
										WHERE schoolYear = YEAR(CURRENT_TIMESTAMP))) ab JOIN Ref_Building b
								ON ab.buildingCode = b.buildingCode
								Order by 3 asc;";
										// buildings assigned to
								$buildingResult = $dbc->query($query);
								$count = 0;
								$currentDate = date('F d, Y');
								$modals = "";
								foreach($buildingResult as $buildingRow){
									$buildingCode = $buildingRow['buildingCode'];
									echo '<tr>';
									echo "<td>{$buildingRow['shiftCode']}</td>";
									echo "<td>{$buildingRow['buildingName']}</td>";
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
												<h4 align=\"center\" class=\"modal-title\" id=\"myModalLabel\">Classes in <u>{$buildingRow['buildingName']}</u></h4>
											</div><!-- /.row -->
											<h6 align=\"center\">for this day: <u>$currentDate</u></h6>
										</div><!-- /.modal-header-->

										<div class=\"modal-body\">";

											$query = "SELECT b.shiftCode, s.shiftDescription, s.shiftStart, s.shiftEnd
											FROM (SELECT shiftCode
											FROM Assigned_Building
											WHERE accountNo = $accountNo
											AND schoolYear = YEAR(CURRENT_TIMESTAMP)
											AND term = (SELECT MAX(term)
											FROM Assigned_Building
											WHERE schoolYear = YEAR(CURRENT_TIMESTAMP))
											AND buildingCode = '$buildingCode') b JOIN Ref_Shift s
											ON b.shiftCode = s.shiftCode;";

											$shiftResult = $dbc->query($query);
											 
											foreach($shiftResult as $shiftRow){

																			//get the rooms with classes on the assigned building from the database
												$query1 = "SELECT roomCode, courseCode, section, trim(term) as term, CONCAT(DATE_FORMAT(startTime, '%H:%i'), ' - ', DATE_FORMAT(endTime, '%H:%i')) AS time,  dayID, CONCAT(firstName, ' ', lastName) AS faculty
												FROM (SELECT * 
												FROM Plantilla
												WHERE roomCode IN (SELECT roomCode
												FROM Room
												WHERE buildingCode = '$buildingCode'
												AND startTime BETWEEN TIME('{$shiftRow['shiftStart']}') AND TIME('{$shiftRow['shiftEnd']}')
												AND dayID = SUBSTRING(DATE_FORMAT(CURRENT_TIMESTAMP,'%a') FROM 1 FOR 1))
												AND schoolYear = YEAR(CURRENT_TIMESTAMP)
												AND term  = (SELECT MAX(term)
												FROM Plantilla
												WHERE YEAR(CURRENT_TIMESTAMP))) c JOIN Faculty f
												ON c.facultyID = f.facultyID;";
												$roomResult = $dbc->query($query1);										

												$modals .= "<caption  background=\"gray\"><h3 style='text-align:center;margin-top:0px;margin-bottom:10px'>{$shiftRow['shiftDescription']}</h3></caption>";	
												$modals .= '<table class="export_table" data-toggle="table">';
												
												$modals .= '<thead>';
												$modals .= '<tr>';
												$modals .= '<th>Room</th>';
												$modals .= '<th>Course Code</th>';
												$modals .= '<th>Section</th>';
												$modals .= '<th>Time</th>';
												$modals .= '<th>Day</th>';																						
												$modals .= '<th>Faculty</th>';
												$modals .= '<th class="hidden" >Term</th>';
												$modals .= '<th class="hidden">Code</th>';
												$modals .= '<th class="hidden">Remarks</th>';
												$modals .= '</tr>';
												$modals .= '</thead>';

												$modals .= '<tbody>';
												foreach($roomResult as $roomRow){
													$modals .= '<tr>';
													$modals .= "<td>{$roomRow['roomCode']}</td>";
													$modals .= "<td>{$roomRow['courseCode']}</td>";
													$modals .= "<td>{$roomRow['section']}</td>";
													$modals .= "<td>{$roomRow['time']}</td>";
													$modals .= "<td>{$roomRow['dayID']}</td>";
																								
													$modals .= "<td>{$roomRow['faculty']}</td>";
													$modals .= "<td class='hidden'>{$roomRow['term']}</td>";
													$modals .= "<td class='hidden'></td>";
													$modals .= "<td class='hidden'></td>";
													$modals .= '</tr>';
												}
												$modals .= '</tbody>';
												$modals .= '</table>';
											}

											$modals .= "			</div><!-- /.modal-body -->

											<div class=\"modal-footer\">
												<button type=\"button\" class=\"btn btn-default\" data-dismiss=\"modal\">Close</button>
											</div><!-- /.modal-footer -->

										</div><!--/.modal-content -->
									</div><!--/.modal-dialog -->
								</div><!-- /.modal -->
								";
								echo '</td>';

								echo '</tr>';


								$count++;
							}	
							?>
						</tbody>
					</table>	

					<?php  echo $modals; ?>					
				</div>
			</div>
		</div>
	</div>	
</div><!--/.col-->

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

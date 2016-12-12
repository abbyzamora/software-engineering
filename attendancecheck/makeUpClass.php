<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Attendance Tracker</title>

<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/datepicker3.css" rel="stylesheet">
<link href="css/styles.css" rel="stylesheet">
<link href="css/bootstrap-table.css" rel="stylesheet">
<link href="css/myStyle.css" rel="stylesheet">

<!--Icons-->


</head>
<?php
	session_start();
	$_SESSION['adminemail'] = $_SESSION['user'];
	require_once('../mysql_connect.php');
	$printname = "select concat(a.firstName, ' ', a.lastName) as 'completename', ra.accounttypedescription from accounts a join ref_accounttype ra on a.accounttypeno = ra.accounttypeno where email = '{$_SESSION['adminemail']}'";
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
                            <p class="pull-left"><?php echo $row['completename']?></p>
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
						<a class="" href="makeupClass.php">
							<svg class="glyph stroked chevron-right"><use xlink:href="#stroked-chevron-right"></use></svg> Add Alternative Class
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
				</ul>
			</li>

			<li role="presentation" class="divider"></li>
			
			<li class="parent">
			    <a href="#"><span><svg class="glyph stroked paperclip"><use xlink:href="#stroked-paperclip"/></svg>Help Desk | FAQs</span></a>
			</li>

		</ul>

	</div><!--/.sidebar-->

    <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			
		<div class="row">
			<ol class="breadcrumb">
				<li><a href="admindashboard.php"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
				<li>Attendance Monitor</li>
				<li class="active"><a href="makeUpClass.php">Add Alternative Class</a></li>
			</ol>
		</div><!--/.row-->
		
		<div class="row">
			<div class="col-lg-12">
				<h2 class="page-header">Add Alternative Class</h2>
			</div>
		</div>
		
		<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-body">
					<form role="form" method="post">
						<fieldset>
							<div class="form-group col-md-4 col-md-offset-4">
								<select name = "courseCode" class="form-control" required>
									<?php
										$query = "SELECT C.COURSECODE AS 'COURSECODE'
													FROM COURSE C";
										$printresult = mysqli_query($dbc,$query);
										echo "<option value=''>--Select Course Code--</option>";
											while($row=mysqli_fetch_array($printresult,MYSQLI_ASSOC)){
												$courseCode = $row['COURSECODE'];
												echo "<option value='$courseCode'> $courseCode </option>";
											}
										
										
									?>
								
								</select>
							</div>
							<div class="form-group col-md-4 col-md-offset-4">
								<input class="form-control" placeholder="Section" name="section" type="text" maxlength="3" required>
							</div>
							<div class="form-group col-md-4 col-md-offset-4">
								<input class="form-control" placeholder="Scheduled Room" name="room" type="text" value="" required>
							</div>
							
							<div class="form-group col-md-4 col-md-offset-4">
								<label>Reason for the Missed Class</label>
								<select name = "reason" class="form-control" required>
								<?php
								
										$absent = "SELECT absentdescription as 'desc', absentcode as 'code'
													FROM ref_absentreason";
										$printabsent = mysqli_query($dbc,$absent);
										echo "<option value=''></option>";
											while($row=mysqli_fetch_array($printabsent,MYSQLI_ASSOC)){
												$name = $row['code'];
												$desc = $row['desc'];
												echo "<option value='$name'> $desc </option>";
											}
										
										
								?>
								</select>
							</div>
							<div class="form-group col-md-4 col-md-offset-4">
								<label>Missed Class Date</label>
								<input class="form-control" class="date" name="misseddate" type="date" required>
							</div>
							
							<div class="form-group col-md-4 col-md-offset-4">
								<label>Alternative Class Date & Time</label>
								<input class="form-control" class="date" name="altdate" type="date" required>
							</div>
							<div class="form-group col-md-4 col-md-offset-4">
								
								<label class="control-label col-md-12">Start Time:</label><br>
								<div class="col-md-4">
									<select name="altstarthour" class="form-control" required>
										<option value="">HH</option>
										<option value="07">07</option>
										<option value="08">08</option>
										<option value="09">09</option>
										<option value="10">10</option>
										<option value="11">11</option>
										<option value="12">12</option>
										<option value="13">13</option>
										<option value="14">14</option>
										<option value="15">15</option>
										<option value="16">16</option>
										<option value="17">17</option>
										<option value="18">18</option>
										<option value="19">19</option>
										<option value="20">20</option>
									</select>
								</div>
								<div class="col-md-4">
									<select name="altstartminute" class="form-control" required>
										<option value="">MM</option>
										<option value="00">00</option>
										<option value="15">15</option>
										<option value="30">30</option>
										<option value="45">45</option>
									</select>
								</div>
								
							</div>

							<div class="form-group col-md-4 col-md-offset-4">
								
								<label class="control-label col-md-12">End Time:</label>
								<div class="col-md-4">
									<select name="altendhour" class="form-control" required>
										<option value="">HH</option>
										<option value="07">07</option>
										<option value="08">08</option>
										<option value="09">09</option>
										<option value="10">10</option>
										<option value="11">11</option>
										<option value="12">12</option>
										<option value="13">13</option>
										<option value="14">14</option>
										<option value="15">15</option>
										<option value="16">16</option>
										<option value="17">17</option>
										<option value="18">18</option>
										<option value="19">19</option>
										<option value="20">20</option>
										<option value="21">21</option>
									</select>
								</div>
								<div class="col-md-4">
									<select name="altendminute" class="form-control" required>
										<option value="">MM</option>
										<option value="00">00</option>
										<option value="15">15</option>
										<option value="30">30</option>
										<option value="45">45</option>
									</select>
								</div>
								
							</div>
							
						</fieldset>
						<br>
						<div class="col-md-4 col-md-offset-7">
							<button class="btn btn-primary btn-success" name="create">Create Class</button>
						</div>	
					</form>
				</div>
			</div>
        </div>
					
			
		</div><!--/.row-->
		<?php
			if(isset($_POST['create'])){
				$message=NULL;
				
				//Course code empty field checking
				if(empty($_POST['courseCode'])){
					$_SESSION['courseCode'] = NULL;
					$message.="<p> You forgot to select a coursecode";
				}
				else{
					$_SESSION['courseCode'] = $_POST['courseCode'];
				}

				// Section empty field checking
				if (empty($_POST['section'])){
					$message.="<p> You forgot to enter a section!";
					$_SESSION['section'] = NULL;
				} else {
					$_SESSION['section'] = $_POST['section'];
				}
				

				//Validity of room is checked here already and also empty field checking
				if(empty($_POST['room'])){
					$_SESSION['room'] = NULL;
					$message.="<p> You forgot to enter the scheduled room";
				}
				else{
					$query = "SELECT R.ROOMCODE as ROOM
							   FROM ROOM R
							  WHERE '{$_POST['room']}' = R.ROOMCODE";
					$printresult = mysqli_query($dbc,$query);
					$row3 = mysqli_fetch_array($printresult, MYSQLI_ASSOC);
					if($row3['ROOM'] != NULL){
						$_SESSION['room'] = $_POST['room'];
					}
					else{
						$message.="<p>Invalid room code";
					}
					
				}



				// Absent Reason empty field checking
				if (empty($_POST['reason'])){
					$_SESSION['reason'] = NULL;
					$message.="<p> You forgot to select the Reason for absence!";
				} else {
					$_SESSION['reason'] = $_POST['reason'];
				}


				// Missed Class Date empty field checking
				// Also checks the Sunday Error
				$date = new DateTime($_POST['misseddate']);
				$day = date_format($date, 'd');
				$month = date_format($date, 'm');
				$year = date_format($date, 'Y');
				if(empty($_POST['misseddate'])){
					$_SESSION['misseddate'] = NULL;
					$message.="<p> You forgot to enter the missed class date";
				} else if (date('D',mktime(0, 0, 0, $month, $day, $year )) == 'Sun') {
					$_SESSION['misseddate'] = NULL;
					$message.="<p> Missed Date cannot be sunday!";
				}
				else{
					$_SESSION['misseddate'] = $_POST['misseddate'];
				}



				// Alternative date empty field checking
				// Also missed date and alternative date error checking
				// Also sunday error
				$altdate = new DateTime($_POST['altdate']);
				$altday = date_format($altdate, 'd');
				$altmonth = date_format($altdate, 'm');
				$altyear = date_format($altdate, 'Y');
				if(empty($_POST['altdate'])){
					$_SESSION['altdate'] = NULL;
					$message.="<p> You forgot to enter the alternative class date";
				}
				else if (date('D',mktime(0, 0, 0, $altmonth, $altday, $altyear )) == 'Sun') {
					$_SESSION['altdate'] = NULL;
					$message.="<p> Alternative Class Date cannot be sunday!";
				}
				else{
					if($_SESSION['misseddate'] != null){
						if($_SESSION['misseddate'] > $_POST['altdate']){
							$message.="<p> Alternative Date is Invalid!
										   You must select a date that exceeds the
										   Missed Class Date";
						}
						else{
							$_SESSION['altdate'] = $_POST['altdate'];
						}
					} 
					
				}

				// Alternative Class START HOUR empty field checking
				if(empty($_POST['altstarthour'])){
					$_SESSION['altstarthour'] = NULL;
					$message.="<p> You forgot to enter the alternative class starting hour time";
				}
				else{
					$_SESSION['altstarthour'] = $_POST['altstarthour'];
				}

				// Alternative Class START MINUTE empty field checking
				// Also concats alternative starting time
				if(empty($_POST['altstartminute'])){
					$_SESSION['altstartminute'] = NULL;
					$message.="<p> You forgot to enter the alternative class starting minute time";
				}
				else{
					$_SESSION['altstartminute'] = $_POST['altstartminute'];
					$altstarttime = $_SESSION['altstarthour'].':'.$_SESSION['altstartminute']. ':00';

				}

				// Alternative Class END HOUR empty field checking
				if(empty($_POST['altendhour'])){
					$_SESSION['altendhour'] = NULL;
					$message.="<p> You forgot to enter the alternative class end hour time";
				}
				else{
					$_SESSION['altendhour'] = $_POST['altendhour'];
				}

				// Alternative Class END MINUTE empty field checking
				// Also concats alternative end time
				if(empty($_POST['altendminute'])){
					$_SESSION['altendminute'] = NULL;
					$message.="<p> You forgot to enter the alternative class end minute time";
				}
				else{
					$_SESSION['altendminute'] = $_POST['altendminute'];
					$altendtime = $_SESSION['altendhour'].':'.$_SESSION['altendminute']. ':00';

				}


				// Compare Alternative Class Start and End Time			
				if ($altstarttime > $altendtime){
					$message.='<p> Alternative Class Time is Invalid';
				}

				
				$course = "select coursecode, section, facultyid, dayid, YEAR(NOW()) as schoolyear, roomcode,
							concat(starttime,'-',endtime) as originaltime, starttime, endtime, term
							 from plantilla
							where term = (select max(term)
											from plantilla)";
				
				// Check if course and section are equal to plantilla
				$check = mysqli_query($dbc,$course);
				$valid = 0;

				while ($row=mysqli_fetch_array($check,MYSQLI_ASSOC)){
					if ($_SESSION['courseCode'] == "{$row['coursecode']}" && $_SESSION['section'] == "{$row['section']}") {

							$valid = 1;
							$syear = $row['schoolyear'];
							$curterm = $row['term'];
							$roomc = $row['roomcode'];
							$faculty = $row['facultyid'];
							$day = $row['dayid'];
							$course = $row['coursecode'];
							$sec = $row['section'];
					}
				}
				if ($valid == 0) {
					$message.='<p> Course and Section Selected do not Match!';
				}

				
				// Check if missed date is equal to the day ID of the course and section of plantilla
				$course2 = "select coursecode, section, facultyid, dayid, YEAR(NOW()) as schoolyear, roomcode,
						concat(starttime,'-',endtime) as originaltime, starttime, endtime, term
						 from plantilla
						where term = (select max(term)
										from plantilla)";
				$check2 = mysqli_query($dbc,$course2);
				$mdate = new DateTime($_SESSION['misseddate']);
				$mday = date_format($mdate, 'd');
				$mmonth = date_format($mdate, 'm');
				$myear = date_format($mdate, 'Y');

				$valid2 = 0;
				while ($row2=mysqli_fetch_array($check2,MYSQLI_ASSOC)){
					if (substr(date('D', mktime(0,0,0, $mmonth, $mday, $myear)),0,1) == 'T') {
						if (strtoupper(substr(date('D', mktime(0,0,0, $mmonth, $mday, $myear)),1,1)) == 'U') {

							if (substr(date('D', mktime(0,0,0, $mmonth, $mday, $myear)),0,1) == "{$row2['dayid']}" &&
								$_SESSION['courseCode'] == "{$row2['coursecode']}" && 
								$_SESSION['section'] == "{$row2['section']}"){

								$valid2 = 1;

								$gday = $row2['dayid'];

							}

						} else if (strtoupper(substr(date('D', mktime(0,0,0, $mmonth, $mday, $myear)),1,1)) == 'H') {

							if (strtoupper(substr(date('D', mktime(0,0,0, $mmonth, $mday, $myear)),1,1)) == "{$row2['dayid']}" &&
								$_SESSION['courseCode'] == "{$row2['coursecode']}" && 
								$_SESSION['section'] == "{$row2['section']}"){

								$valid2 = 1;

								$gday = $row2['dayid'];

							}

						}
					} else {
						if (substr(date('D', mktime(0,0,0, $mmonth, $mday, $myear)),0,1) == "{$row2['dayid']}" &&
							$_SESSION['courseCode'] == "{$row2['coursecode']}" && 
							$_SESSION['section'] == "{$row2['section']}"){

							$valid2 = 1;

							$gday = $row2['dayid'];

						}
					}
					
				}
				if ($valid2 == 0){
					$_SESSION['misseddate'] = NULL;
					$message.='<p> Missed Class Date Does Not Match with the Course Class Schedule!';
				}

				// Check for class schedule conflicts on Plantilla
				$validity = 0;
				$course3 = "select coursecode, section, facultyid, dayid, YEAR(NOW()) as schoolyear, roomcode,
						concat(starttime,'-',endtime) as originaltime, starttime, endtime, term
						 from plantilla
						where term = (select max(term)
										from plantilla)";
				$check3 = mysqli_query($dbc,$course3);
				$adate = new DateTime($_SESSION['altdate']);
				$aday = date_format($adate, 'd');
				$amonth = date_format($adate, 'm');
				$ayear = date_format($adate, 'Y');

				while ($row4 = mysqli_fetch_array($check3, MYSQLI_ASSOC)){
					if (substr(date('D', mktime(0,0,0, $amonth, $aday, $ayear)),0,1) == 'T') {
						if (strtoupper(substr(date('D', mktime(0,0,0, $amonth, $aday, $ayear)),1,1)) == 'U') {

							if (substr(date('D', mktime(0,0,0, $amonth, $aday, $ayear)),0,1) == "{$row4['dayid']}" &&
								$altstarttime >= "{$row4['starttime']}" && $altendtime <= "{$row4['endtime']}" &&
								"{$row4['roomcode']}" == $_SESSION['room']) {

								$validity = 1;

							}

						} else if (strtoupper(substr(date('D', mktime(0,0,0, $amonth, $aday, $ayear)),1,1)) == 'H') {

							if (strtoupper(substr(date('D', mktime(0,0,0, $amonth, $aday, $ayear)),1,1)) == "{$row4['dayid']}" &&
								$altstarttime >= "{$row4['starttime']}" && $altendtime <= "{$row4['endtime']}" &&
								"{$row4['roomcode']}" == $_SESSION['room'] ){

								$validity = 1;

							}

						}
					} else {
						if (substr(date('D', mktime(0,0,0, $amonth, $aday, $ayear)),0,1) == "{$row4['dayid']}" &&
							$altstarttime >= "{$row4['starttime']}" && $altendtime <= "{$row4['endtime']}" &&
							"{$row4['roomcode']}" == $_SESSION['room'] ){

							$validity = 1;

						}
					}

				}
				



				// Check for class schedule conflicts on Alternative Class 
				$valid3 = 0;
				$makeup = "SELECT makeupdate, makeupstarttime, makeupendtime, makeuproom from mv_facultymakeup";
				$getmakeup = mysqli_query($dbc, $makeup);

				while ($row5=mysqli_fetch_array($getmakeup, MYSQLI_ASSOC)){
					if ($_SESSION['altdate'] == "{$row5['makeupdate']}" && $altstarttime >= "{$row5['makeupstarttime']}"
						&& $altendtime <= "{$row5['makeupendtime']}" && $_SESSION['room'] == "{$row5['makeuproom']}"){
						$valid3 = 1;
					}

				}
				if ($validity == 1){
					$message.='<p> Alternative class has conflict with another class! </p>';
				}

				if($valid3 == 1){
					$message.='<p> Alternative class has conflict with another class!</p>';
				}

				


				// Get Faculty Attendance Form with last insert id
				// Gawin ko muna max nalang.
				$fform = "select MAX(facultyattendanceformcode) as 'formid' from form_facultyattendanceform";
				$fget = mysqli_query($dbc, $fform);
				$get = mysqli_fetch_array($fget,MYSQLI_ASSOC);


				//Insert to Database
				// NOTE: Day ID will be changed!!
				if (!isset($message)){
					$insert = "insert into mv_facultymakeup(courseCode, facultyid, dayid, schoolyear, term,
							   section, facultyattendanceformcode, absentcode, absentdate, roomcode, makeupdate,
							   makeuproom, makeupstarttime, makeupendtime) 
							   VALUES ('{$_SESSION['courseCode']}', '$faculty', '$gday',
							   	'$syear', '$curterm', '{$_SESSION['section']}', '{$get['formid']}',
							   	'{$_SESSION['reason']}', '{$_SESSION['misseddate']}', '$roomc', '{$_SESSION['altdate']}',
							   	'{$_SESSION['room']}', '$altstarttime', '$altendtime')";
					$insertres = mysqli_query($dbc,$insert);
					if ($insertres){
						$message.='<p> Alternative Class has been added!';
					} 
					
				}

				
			}
			
			if (isset($message)){
				echo "<font color='green'>.$message.</font>";
			}
		?>
			</div><!--/.col-->
		</div><!--/.row-->
	</div>	<!--/.main-->

	<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>

	<script src="js/shim.js"></script>
<script src="js/jszip.js"></script>
<script src="js/xlsx.js"></script>
<script src="js/lumino.glyphs.js"></script>
	<script>
    var output;
    $('#my_file_input, #input-2').change(function(){
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
	
	      url: '/Swengg/attendancecheck/insert.php',
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
		$.ajax({
			type:'POST',
	      url: '/swengg/attendancecheck/insertCheckedRooms.php',
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
	<script src="js/bootstrap.min.js"></script>
	<!-- <script src="js/chart.min.js"></script>
	<script src="js/chart-data.js"></script>
	<script src="js/easypiechart.js"></script>
	<script src="js/easypiechart-data.js"></script> -->
	<script src="js/bootstrap-datepicker.js"></script>
	<script src="js/bootstrap-table.js"></script>
	<script>
		$('.calendar').datepicker();

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

</body>

</html>

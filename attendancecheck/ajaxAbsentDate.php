<?php
	$courseCode = $_GET['courseCode'];
	$section = $_GET['section'];
	
	require_once ('../mysql_connect.php');
	$query = "select date from form_attendance fa join mv_attendance ma on fa.formID = ma.formID
where ma.attendanceCode = 'AB' 
and ma.facultyID = (select facultyID from plantilla where courseCode = 'SW-ENGG' and section = 'S15' and schoolYear = year(curdate()) and term = (SELECT TERM from term where MONTH(CURDATE()) between start and end) order by 1 limit 1 )";
	
	$result = $dbc->query($query);
	
	$return = [];
	$dates = [];
	foreach($result as $row){
		$dates[] = $row['date'];
	}
	
	header('Content-type: application/json');
	
	$return = ['dates' => $dates];
	echo json_encode($dates);
?>
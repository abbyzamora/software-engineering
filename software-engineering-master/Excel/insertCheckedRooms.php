<!DOCTYPE html>
<html>
<?php
	require'mysql_connect.php';
	foreach($_POST['data'] as $key=>$sheet){
		 
			$errorLine = array();
			$er = 1;

			$date =	date('Y-m-d');

			$formQuery = "INSERT INTO FORM_ATTENDANCE VALUES (NULL, '{$date}', '1', '{$key}')";
			$enter = mysqli_query($dbc, $formQuery);
			$formID =  mysqli_insert_id($dbc);
			foreach ($sheet as $subject) {
				//Insert Form Attendance 
				
				 
				//Check if Attendace is inserted(means valid, not yet uploaded the file)
				if($enter){
					//set values
					
					 
					$coursecode = $subject['Course Code'];
					$section = $subject['Section'];
					$roomCode = $subject['Room'];
					$term = $subject['Term'];
					//get Faculty ID
					$facultyQueryStatement = 'Select FacultyID From Faculty Where Concat(firstName, lastName) = "'.$subject['Faculty'].'"';		
					$facultyQuery = mysqli_query($dbc,$facultyQueryStatement);
					$facultyIdArray = mysqli_fetch_array($facultyQuery);
				
					$facultyId = $facultyIdArray['FacultyID'];
					$attendaceCode = $subject['Code'];
					$remarks = $subject['Remarks'];
					 
					if ($facultyIdArray['FacultyID'] == null) {
						echo 'Shift:'.$key." Error Faculty ID line";
					}

					//day
					$day = $subject['Day'] ;
				 
					$year = date('Y');
						
						 
					$insertQuery = 
						'Insert into MV_ATTENDANCE VALUES("'.$coursecode.'","'.$facultyId.'","'.$day.'" ,"'.$year.'", "'.$term.'","'.$section.'","'.$formID.'","'.$attendaceCode.'","'.$remarks.'")';
					 
					$success = mysqli_query($dbc,$insertQuery);

					if($success){
						
					}else{
						 
						Echo 'Shift:'.$key.' Line '.$er.' Failed!';
					}



					 
					$er++; 
				}else{
					echo 'Error in Form';

				}



				
				
				 
				 
				
			 
				
				 
				

				
				 
				 
				
				/*try{


				}catch(){

				}*/
			}
		 
		 
	}
	

?>
</html>
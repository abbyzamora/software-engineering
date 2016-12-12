<!DOCTYPE html>
<html>
<?php
	require'mysql_connect.php';
	if(isset($_POST['Sheet1'])){
		$sheet = $_POST['Sheet1'];
		$errorLine = array();
		$er = 1;
		foreach ($sheet as $subject) {
			
			$coursecode = $subject['Course Code'];
			$section = $subject['Section'];
			$year = $subject['Year'];
			$term = $subject['Term'];
			$startTime = $subject['Start'];
			$endTime = $subject['End'];
			$roomCode = $subject['Room'];
			 
			//get Faculty ID
			$facultyQueryStatement = 'Select FacultyID From Faculty Where Concat(firstName, lastName) = "'.$subject['Faculty'].'"';
			$facultyQuery = 'Select FacultyID From Faculty Where Concat(firstName, lastName) = "asd"';
			$facultyQuery = mysqli_query($dbc,$facultyQueryStatement);
			$facultyIdArray = mysqli_fetch_array($facultyQuery);
		
			$facultyId = $facultyIdArray['FacultyID'];
			print_r($facultyIdArray['FacultyID']);
			
			if ($facultyIdArray['FacultyID'] == null) {
				echo "Error Faculty ID line";
			}

			//day
			$temp = true;
			for($ctr = 0; $ctr <= strlen($subject['Day']); $ctr++){
				
				$day = substr($subject['Day'],$ctr+1,1);
				$insertQuery = 
				'Insert into Plantilla VALUES("'.$coursecode.'","'.$facultyId.'","'.$day.'" ,"'.$year.'", "'.$term.'","'.$section.'","'.$roomCode.'", "'.$startTime.'","'.$endTime.'" )';	
				/*echo $insertQuery;*/
				$success = mysqli_query($dbc,$insertQuery);

				if($success){

				}else{
					$ctr++;
					if($temp){
						array_push($errorLine,$er);	
						$temp = false;
					}
					
				}



			}
			$er++;
			 
			 
			
			/*try{


			}catch(){

			}*/
		}
		print_r($errorLine);
	}

?>
</html>
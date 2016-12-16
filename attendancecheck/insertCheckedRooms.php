 
<?php
	require'../mysql_connect.php';
	 try{
	 	 $dbc->begin_transaction();
	 	$good =1;
	foreach($_POST['data'] as $key=>$sheet){
		 	$key = substr($key, 0,2);
			$errorLine = array();
			$er = 1;

			$date =	date('Y-m-d');

			// account id to be change
			$formQuery = "INSERT INTO FORM_ATTENDANCE VALUES (NULL, '{$date}', '1', '{$key}')";
			$enter = mysqli_query($dbc, $formQuery);
			$formID =  mysqli_insert_id($dbc);
			foreach ($sheet as $subject) {
				//Insert Form Attendance 
				
				 
				//Check if Attendace is inserted(means valid, not yet uploaded the file)
				if($enter){
					//set values
				/*	echo 'enter';*/
					 
					$coursecode =trim( $subject['Course Code']);
					$section = trim($subject['Section']);
					$roomCode = trim($subject['Room']);
					$term = trim($subject['Term']);
					//get Faculty ID
					// OLD FACULTY
					/*$facultyQueryStatement = 'Select FacultyID From Faculty Where Concat(trim(firstName)," ", trim(lastName)) = "'.trim($subject['Faculty']).'"';	*/
					$facultyQueryStatement = 'Select FacultyID From Faculty Where lower(Concat(replace(firstName," ",""), replace(lastName," ","") ) ) = "'.strtolower(str_replace(' ','',$subject['Faculty'])).'"';

					$facultyQuery = mysqli_query($dbc,$facultyQueryStatement);
					$facultyIdArray = mysqli_fetch_array($facultyQuery);
				
					$facultyId = $facultyIdArray['FacultyID'];
					$attendaceCode = trim($subject['Code']);
					$remarks = trim($subject['Remarks']);
					 
					if ($facultyIdArray['FacultyID'] == null) {
						/*echo 'Shift:'.$key." Error Faculty ID line";*/
							$good =0;
					}

					//day
					$day = $subject['Day'] ;
				 
					$year = date('Y');

					//Time checker
					$selectQuery = "Select startTime from plantilla where coursecode = '{$coursecode}' and facultyId = {$facultyId} and 
					dayID = '{$day}' and schoolYear = {$year} and term = {$term} and section = '{$section}' ";
					$start = mysqli_query($dbc, $selectQuery);
					$startTime =  mysqli_fetch_array($start);
					 
					if(time() <= strtotime($startTime[0])){
						throw new Exception();
					}


					
						 
					$insertQuery = 
						'Insert into MV_ATTENDANCE VALUES("'.$coursecode.'","'.$facultyId.'","'.$day.'" ,"'.$year.'", "'.$term.'","'.$section.'","'.$formID.'","'.$attendaceCode.'","'.$remarks.'")';
					 
					$success =$dbc->query($insertQuery);
					 

					if($success){
						
					}else{
						 	$good =0;
						/*Echo 'Shift:'.$key.' Line '.$er.' Failed!';*/
					}



					 
					$er++; 
				}else{
					/*echo 'Error in Form';*/
					$good =0;
				}
				
				/*try{


				}catch(){

				}*/
			}
		
	}
		if($good){
				echo 'Success!';
				$dbc->commit();
		}
		
		else 
		 echo 'Failed!';
	}catch(Exception $e){
		echo "Failed!";
		 $dbc->rollback();
	}
	

?>
 
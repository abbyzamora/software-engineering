 
<?php
	require'../mysql_connect.php';
	 try{
	 	 $dbc->begin_transaction();
	 	$good =0;
	 	$dup=0;
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
					// $selectQuery = "Select startTime from plantilla where coursecode = '{$coursecode}' and facultyId = {$facultyId} and 
					// dayID = '{$day}' and schoolYear = {$year} and term = {$term} and section = '{$section}' ";
					// $start = mysqli_query($dbc, $selectQuery);
					// $startTime =  mysqli_fetch_array($start);
					// date_default_timezone_set("Asia/Manila");
					
					// if( date("H:i:s") <= ($startTime[0])){
					// 	throw new Exception("Invalid Submission: Due to class time after system time. ");
					// }
					$ssdate =  date('Y:m:d');
					// duplicate check
					$dQuery = "Select * from Form_attendance fa join MV_ATTENDANCE ma on fa.formID = ma.formID where fa.date = date(now()) and  ma.coursecode = '{$coursecode}' and ma.facultyId = {$facultyId} and 
					ma.dayID = '{$day}' and ma.schoolYear = {$year} and ma.term = {$term} and ma.section = '{$section}' ";
					
					$d = mysqli_query($dbc, $dQuery);

					 
					$num_row =  mysqli_num_rows($d);

					if($num_row == 0){
						
						$insertQuery = 
							'Insert into MV_ATTENDANCE VALUES("'.$coursecode.'","'.$facultyId.'","'.$day.'" ,"'.$year.'", "'.$term.'","'.$section.'","'.$formID.'","'.$attendaceCode.'","'.$remarks.'")';
						
						$success =$dbc->query($insertQuery);
						 

						if($success){
								$good =1;
						}else{
							 
							/*Echo 'Shift:'.$key.' Line '.$er.' Failed!';*/
						} 

						
						
					}
					else{
						$dup = 1;
						 
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
		if($dup){
			echo 'Duplicate values are not added.';
		}
		if($good){
				echo 'Success!';
				$dbc->commit();
		}

		
		else 
		 echo 'Failed!';
	}catch(Exception $e){
		if($e->getMessage()  == "Invalid Submission: Due to class time after system time. "){
			echo $e->getMessage();
		}
		echo "Failed!";
		 $dbc->rollback();
	}
	

?>
 
 
<?php
	require'/../mysql_connect.php';
	try{
		$good =false;

		if(isset($_POST['Sheet1'])){
			$sheet = $_POST['Sheet1'];
			$errorLine = array();
			$er = 1;
			$good = true;
			if(count($sheet) <> 0)
				foreach ($sheet as $subject) {

					$validSection = 1;

					if(isset($subject['Course Code']) && isset( $subject['Section']) && isset( $subject['Year']) && isset($subject['Term']) && isset($subject['Start']) && isset($subject['End']) && isset($subject['Room']) && isset($subject['Faculty'])){
						/*$subject['subject'] = trim($subject['Course Code']);
						echo "sa lbas";
							
						if( preg_match("/[CK][31-50]/", $subject['Section']) ){
							echo 'pumasok sa regex';
							$validSection = 1;								
						}elseif(preg_match("/[S][1-3][1-9]/", $subject['Section'])){

						}elseif(preg_match("/[L][8-1][1-9]/", $subject['Section'])){

						}elseif(preg_match("/[E][A-Z]/", $subject['Section'])){

						}elseif(preg_match("/[A][5-8][1-9]/", $subject['Section'])){

						}elseif(preg_match("/[N][0-1][1-9]/", $subject['Section'])){
							
						}elseif(preg_match("/[E][A-Z]/", $subject['Section'])){
							
						}elseif(preg_match("/[E][A-Z]/", $subject['Section'])){
							
						}elseif(preg_match("/[E][A-Z]/", $subject['Section'])){
							
						}*/



						if(  !empty(trim( $subject['Year'])) && !empty(trim($subject['Year'])) && !empty(trim($subject['Section'])) && trim($subject['Year'] )== date('Y') && (trim( $subject['Term']) == 1 ||trim( $subject['Term']) == 2|| trim($subject['Term']) == 3) && $validSection){
							$coursecode = trim($subject['Course Code']);
							$section = trim($subject['Section']);
							$year = trim($subject['Year']);
							$term = trim($subject['Term']);
							$startTime = trim($subject['Start']);
							$endTime = trim($subject['End']);
							$roomCode = trim($subject['Room']);
							 
							//get Faculty ID
							/*echo $subject['Faculty'];*/

							# old FACULTY QUERY
							// $facultyQueryStatement = 'Select FacultyID From Faculty Where Concat(trim(firstName)," ",trim(lastName)) = "'.trim($subject['Faculty']).'"';

							$facultyQueryStatement = 'Select FacultyID From Faculty Where lower(Concat(replace(firstName," ",""), replace(lastName," ","") ) ) = "'.strtolower(str_replace(' ','',$subject['Faculty'])).'"';
							$facultyQuery = 'Select FacultyID From Faculty Where Concat(firstName, lastName) = "asd"';
							$facultyQuery = mysqli_query($dbc,$facultyQueryStatement);
							$facultyIdArray = mysqli_fetch_array($facultyQuery);
							/*print_r($facultyIdArray);*/
							$facultyId = $facultyIdArray['FacultyID'];
							 
							
							if ($facultyIdArray['FacultyID'] == null) {
								/*echo "Error Faculty ID line ".$er.' .';*/
							}

							//day
							$temp = true;
							for($ctr = 0; $ctr < strlen($subject['Day']); $ctr++){
								
								$day = substr($subject['Day'],$ctr,1);
								
								$insertQuery = 
								'Insert into Plantilla VALUES("'.$coursecode.'","'.$facultyId.'","'.$day.'" ,"'.$year.'", "'.$term.'","'.$section.'","'.$roomCode.'", "'.$startTime.'","'.$endTime.'" )';	
								/*echo $insertQuery;*/
									
								 
								if( mysqli_query($dbc,$insertQuery)){
									
								}else{
									$ctr++;
									if($temp){
									 
										array_push($errorLine,$er);	
										$temp = false;
										$good=false;
									}
									
								}



							}
							$er++;
						 
						 
						}
						else{
								/*echo 'Invalid Format!';*/
								$good=false;
						}
					}else{
								/*echo 'Invalid Format!';*/
								$good=false;
						}
					/*try{


					}catch(){

					}*/
				}
			else{

			/* echo ' Empty. ';*/
			 $good=false;
			}
			if( count($errorLine) >0){
				for($ctr = 0; $ctr < count($errorLine); $ctr++  ) {
				 	$good=false;
					echo ' Line '.$errorLine[$ctr].', ';
				 
				}	
				/*echo "error in insert!";*/
				$good=false;
			}
			 	
		}
		else{
			/*echo 'Invalid Format!';*/
			$good=false;
		}
		if($good){
			echo "Success!";
		}
		elseif(!$good){
			echo "Failed!";
		}
	}catch(Exception $e){
		echo 'Invalid Format!';
	}

?>
 
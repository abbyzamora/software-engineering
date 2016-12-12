<?php  
//Set the default timezone to UTC.  

date_default_timezone_set('UTC');  
echo "<strong>Display current date dd/mm/yyyy format </strong>"."<br />";  
echo date("d/m/Y")."<br />";  
echo "<strong>Display current date mm/dd/yyyy format</strong> "."<br />";  
echo date("m/d/Y")."<br />";  
echo "<strong>Display current date mm-dd-yyyy format </strong>"."<br />";  
echo date("m-d-Y")."<br />";  
echo "<strong>Display like Monday 6th of March 1996 </strong>"."<br />";  
echo date("l jS \of F Y")."<br />";  
echo "<strong>Display the above format with time </strong>"."<br />";  
echo date('l jS \of F Y h:i:s A')."<br />";  

echo " " . date('l F j Y', mktime(0, 0, 0, 10, 25, 2016));
//hour minute second month day year
//
//echo date('F j Y');
?>  



SELECT fmu.roomCode as room, f.completeName as faculty, CONCAT(fmu.makeUpStartTime, ' - ', fmu.makeUpEndTime) as classTime, fmu.makeUpDate as classDate, fmu.courseCode as subject, CONCAT(fmu.absentDate, ' ', p.startTime, ' - ', p.endTime) as missedSchedule, CONCAT(fmu.makeUpDate, '(', d.dayCode, ')',' ', fmu.makeUpStartTime, ' - ', fmu.makeUpEndTime) as altClass, fmu.makeUpRoom as makeUpRoom
											   FROM MV_FacultyMakeUp fmu JOIN Plantilla p
																		   ON fmu.courseCode = p.courseCode	
																		  AND fmu.section = p.section
																		 JOIN Faculty f
																		   ON fmu.facultyID = f.facultyID
																		 AND P.FACULTYID = F.FACULTYID
																		 JOIN MV_ATTENDANCE MA
																		   ON P.COURSECODE = MA.COURSECODE AND F.FACULTYID = MA.FACULTYID AND P.DAYID = MA.DAYID AND P.SCHOOLYEAR = MA.SCHOOLYEAR AND P.TERM = MA.TERM AND P.SECTION = MA.SECTION
																		 JOIN FORM_ATTENDANCE FA
																		   ON MA.FORMID = FA.FORMID
																		 JOIN MV_FACULTYMAKEUP MP
																		   ON P.COURSECODE = MP.COURSECODE AND F.FACULTYID = MP.FACULTYID AND P.DAYID = MP.DAYID AND P.SCHOOLYEAR = MP.SCHOOLYEAR AND P.TERM = MP.TERM AND P.SECTION = MP.SECTION
																		 JOIN Ref_Days d
																		   ON d.dayID = p.dayID
												WHERE fmu.makeUpDate >= CURDATE()
												  AND MA.ATTENDANCECODE = 'AB';"



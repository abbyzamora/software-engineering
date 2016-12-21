-- LAHT NG NAKASSSIGN SA KANYA. CHANGE YUNG DAY ID SA NOW(PHP).
-- room courseCode, Section, time, day, faculty
SELECT B.buildingName, P.roomCode,  P.courseCode, P.section, S.shiftCode as shift,CONCAT(DATE_FORMAT(startTime, '%H:%i'), ' - ', DATE_FORMAT(endTime, '%H:%i')) AS time, P.dayID, CONCAT(F.lastname, ', ', F.firstName) as faculty
  FROM Accounts A JOIN Assigned_Building AB
					ON A.ACCOUNTNO = AB.ACCOUNTNO
				JOIN REF_Shift S
					ON AB.shiftCode = S.shiftCode
				  JOIN Room R
					ON R.BUILDINGCODE = AB.BUILDINGCODE
				  JOIN Plantilla P
					ON P.ROOMCODE = R.ROOMCODE				  
				  JOIN Faculty F
                    ON P.facultyID = F.facultyID
		  JOIN Ref_Building B
			ON R.buildingCode = B.buildingCode
 WHERE A.ACCOUNTNO = 2
   AND AB.TERM = (SELECT MAX(TERM)
				 FROM Assigned_Building
				 WHERE SCHOOLYEAR = YEAR(NOW()))
   AND P.TERM = (SELECT MAX(TERM)
				 FROM Assigned_Building
				 WHERE SCHOOLYEAR = YEAR(NOW()))
   AND AB.SCHOOLYEAR = YEAR(NOW())
   AND P.DAYID = 'M'
   AND P.startTime BETWEEN S.shiftStart AND S.shiftEnd;

-- Room Transfer add to plantilla today
-- room courseCode, Section, time, day, faculty
SELECT ab.shiftCode as shift, b.buildingName as building, rt.courseCode, rt.venue, rt.section,  rt.dayID, rt.startTime, rt.endTime, CONCAT(DATE_FORMAT(rt.startTime, '%H:%i'), ' - ', DATE_FORMAT(rt.endTime, '%H:%i')) AS time, SUBSTRING(DATE_FORMAT(CURRENT_TIMESTAMP,'%a') FROM 1 FOR 1) as day, CONCAT(f.lastname, ', ', f.firstName) as faculty
  FROM MV_RoomTransfer rt JOIN Plantilla p
							ON rt.courseCode = p.courseCode
						   AND rt.facultyID = p.facultyID
                           AND rt.dayID = p.dayID
                           AND rt.schoolYear = p.schoolYear
                           AND rt.term = p.term
                           AND rt.section = p.section
						  JOIN Faculty f
							ON rt.facultyID = f.facultyID 
						  JOIN Room r
							ON p.roomCode = r.roomCode
						  JOIN Ref_Building b
                            ON r.buildingCode = b.buildingCode
						  JOIN Assigned_Building ab
							ON ab.buildingCode = b.buildingCode
						  JOIN REF_Shift s
							ON s.shiftCode = ab.shiftCode
 WHERE rt.originalDate = CURDATE()
   AND rt.dayID = SUBSTRING(DATE_FORMAT(CURRENT_TIMESTAMP,'%a') FROM 1 FOR 1)
   AND ab.accountNo = 2
   AND ab.schoolYear = YEAR(CURRENT_TIMESTAMP)
   AND ab.term = (SELECT MAX(term)
					FROM Assigned_Building
				   WHERE schoolYear = YEAR(CURRENT_TIMESTAMP))
   AND rt.startTime BETWEEN s.shiftStart AND s.shiftEnd;
   
-- remove plantilal
SELECT *
  FROM MV_RoomTransfer
 WHERE originalDate = CURDATE()
   AND dayID = SUBSTRING(DATE_FORMAT(CURRENT_TIMESTAMP,'%a') FROM 1 FOR 1)
   AND term = (SELECT MAX(term)
					FROM MV_RoomTransfer
				   WHERE schoolYear = YEAR(CURRENT_TIMESTAMP))
   AND YEAR(originalDate) = YEAR(CURRENT_TIMESTAMP);
   
-- make up removal
SELECT * FROM SWENGG.MV_FacultyMakeUp;

SELECT ab.shiftCode as shift, b.buildingName as building, mu.courseCode, mu.roomCode, mu.section,  mu.dayID, mu.makeUpStartTime, mu.makeUpEndTime, CONCAT(DATE_FORMAT(mu.makeUpStartTime, '%H:%i'), ' - ', DATE_FORMAT(mu.makeUpEndTime, '%H:%i')) AS time, SUBSTRING(DATE_FORMAT(CURRENT_TIMESTAMP,'%a') FROM 1 FOR 1) as day, CONCAT(f.lastname, ', ', f.firstName) as faculty
   FROM MV_FacultyMakeUp mu JOIN Plantilla p
							  ON mu.courseCode = p.courseCode
							 AND mu.facultyID = p.facultyID
                             AND mu.dayID = p.dayID
                             AND mu.schoolYear = p.schoolYear
                             AND mu.term = p.term
                             AND mu.section = p.section
							JOIN Faculty f
							  ON mu.facultyID = f.facultyID 
							JOIN Room r
							  ON mu.roomCode = r.roomCode
						    JOIN Ref_Building b
                              ON r.buildingCode = b.buildingCode
						    JOIN Assigned_Building ab
							  ON ab.buildingCode = b.buildingCode
						    JOIN REF_Shift s
							  ON s.shiftCode = ab.shiftCode
WHERE mu.schoolYear = YEAR(CURRENT_TIMESTAMP)
  AND mu.term = (SELECT MAX(term)
				FROM MV_FacultyMakeUp
			  WHERE schoolYear = YEAR(CURRENT_TIMESTAMP))
  AND mu.dayID = SUBSTRING(DATE_FORMAT(CURRENT_TIMESTAMP,'%a') FROM 1 FOR 1)
  AND mu.makeUpDate = CURDATE()
  AND mu.makeUpStartTime BETWEEN s.shiftStart AND s.shiftEnd
  AND ab.accountNo = 2;
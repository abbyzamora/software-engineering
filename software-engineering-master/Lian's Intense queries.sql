SELECT * FROM Assigned_Building;

SELECT * FROM Ref_Building;

SELECT * FROM Plantilla;

-- Assigned Buildings query
SELECT b.buildingName, b.buildingCode
  FROM (SELECT *
		  FROM Assigned_Building
	     WHERE accountNo = 2
           AND schoolYear = YEAR(CURRENT_TIMESTAMP)
		   AND term = (SELECT MAX(term)
					     FROM Assigned_Building
						WHERE schoolYear = YEAR(CURRENT_TIMESTAMP))) ab JOIN Ref_Building b
																		  ON ab.buildingCode = b.buildingCode;


-- assigned building with rooms that have class
SELECT * 
  FROM Plantilla
 WHERE roomCode IN (SELECT roomCode
					  FROM Room
					 WHERE buildingCode IN (SELECT buildingCode
											  FROM Assigned_Building
											 WHERE accountNo = 2
											   AND schoolYear = (SELECT MAX(schoolYear)
																   FROM Assigned_Building)
											   AND term = (SELECT MAX(term)
															 FROM Assigned_Building)));

-- (above) + with name of faculty
SELECT roomCode, courseCode, section, CONCAT(startTime, '-', endTime) AS time,  dayID, CONCAT(firstName, lastName) AS faculty
FROM (SELECT * 
	    FROM Plantilla
	   WHERE roomCode IN (SELECT roomCode
						    FROM Room
						   WHERE buildingCode = 'G')) c JOIN Faculty f
													      ON c.facultyID = f.facultyID;

-- shift in assigned building
SELECT b.shiftCode, s.shiftDescription, s.shiftStart, s.shiftEnd
	FROM (SELECT shiftCode
		    FROM Assigned_Building
		   WHERE accountNo = 2
		     AND schoolYear = (SELECT MAX(schoolYear)
							   FROM Assigned_Building)
		     AND term = (SELECT MAX(term)
						 FROM Assigned_Building)
		     AND buildingCode = 'G') b JOIN Ref_Shift s
										 ON b.shiftCode = s.shiftCode;
   
-- with faculty and of current day and shift
SELECT roomCode, courseCode, section, CONCAT(DATE_FORMAT(startTime, '%H:%i'), ' - ', DATE_FORMAT(endTime, '%H:%i')) AS time,  dayID, CONCAT(firstName, lastName) AS faculty
FROM (SELECT * 
	    FROM Plantilla
	   WHERE roomCode IN (SELECT roomCode
						    FROM Room
						   WHERE buildingCode = 'G'
                             AND startTime BETWEEN TIME('07:30:00') AND TIME('15:59:00')
                             AND dayID = SUBSTRING(DATE_FORMAT(CURRENT_TIMESTAMP,'%a') FROM 1 FOR 1))) c JOIN Faculty f
																								   ON c.facultyID = f.facultyID;

select accountNo, concat(a.firstName,' ', a.lastName) as 'completename', ra.accounttypedescription from accounts a join ref_accounttype ra on a.accounttypeno = ra.accounttypeno where email = 'karmela_libed@dlsu.edu.ph';

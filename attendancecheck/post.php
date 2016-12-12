<html>

<?php
	SESSION_START();
	$_SESSION['checker'] = $_SESSION['user'];

	require_once('../mysql_connect.php');
	$email = $_SESSION['checker'];
	//query toget number of make up class
	if($_POST['check'] == 'number'){
		
		$query = "SELECT COUNT(*) as 'count'
				    FROM ACCOUNTS A JOIN MV_NOTIFICATION N
				                      ON A.ACCOUNTNO = N.ACCOUNTNO
				   WHERE N.NOTIFICATIONSTATUS = '1'
					 AND '{$email}' = A.EMAIL";
		$printresult = $dbc->query($query);
		$row = $printresult->fetch_assoc();
		echo $row['count'];
	}
	
	//query to deactivate notif
	elseif($_POST['check'] == 'open'){
		$deact = "update mv_notification set notificationstatus = '2' where accountno = (select accountno from accounts where '{$email}' = EMAIL)";
		if ($dbc->query($deact) == TRUE) {
			echo '';
		} else 'failed to update!';
	}
?>
</html>
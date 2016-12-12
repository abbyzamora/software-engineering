<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>User Reset Password</title>

<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/datepicker3.css" rel="stylesheet">
<link href="css/styles.css" rel="stylesheet">

<!--[if lt IE 9]>
<script src="js/html5shiv.js"></script>
<script src="js/respond.min.js"></script>
<![endif]-->

</head>
<?php
session_start();
require_once('../mysql_connect.php');
$_SESSION['useremail'] = $_SESSION['user'];


?>
<body>


	
	<div class="row">
		<div class="col-md-4 col-md-offset-4">
			<div class="login-panel panel panel-default">
				<div class="panel-heading">Reset Password </div>
				<div class="panel-body">
					<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
						<p><font size='1'> 
							Your new password must contain at least 8 characters,
							1 Uppercase, 1 Lowercase, 1 Number and 1 Special Character
						</font></p>
						<fieldset>
							<div class="form-group">
								<input class="form-control" placeholder="Password" name="newpass" type="password" value="">
							</div>
							<div class="form-group">
								<input class="form-control" placeholder="Re-type Password" name="repeat" type="password" value="">
							</div>
							<div class="col-md-6 col-md-offset-3">
							<button type="submit" name="change" class="btn btn-primary">Reset Password</button>
							</div>
						</fieldset>
					</form>
					<?php
					if (isset($_POST['change'])){
					$message=NULL;

					if (empty($_POST['newpass'])){
						$_SESSION['newpass']=NULL;
						$message.="<p> You did not enter a new password!";
					} 

					if (empty($_POST['repeat'])){
						$_SESSION['repeat']=FALSE;
						$message.='<p>You did not re-type your password!';
					} elseif ($_POST['repeat'] != $_POST['newpass']){
						$message.='<p> Passwords do not match!';
					} else {
						if (strlen($_POST["repeat"]) < 8){
							$message.='<p>Your password must contain at least 8 Characters!</p>';
						} 
						if(!preg_match("#[0-9]+#",$_POST["repeat"])) {
							$message.= "<p>Your password must contain at least 1 Number!</p>";
						} 
						if(!preg_match("#[A-Z]+#",$_POST["repeat"])) {
							$message.= "<p>Your password must contain at least 1 Uppercase Character!</p>";
						} 
						if(!preg_match("#[a-z]+#",$_POST["repeat"])) {
							$message.= "<p>Your password must contain at least 1 Lowercase Character!</p>";
						} 
						if (!preg_match("#[\#$%^&*()+=\-\[\]\';,.\/{}|\":<>?!@_~\\\\]+#",$_POST["repeat"])) {
							// # / [ ] ' " 
							$message.= "<p>Your password must contain at least 1 Special Character!</p>";
						} 
						
						if (!isset($message)){
							$_SESSION['repeat'] = $_POST['repeat'];
							$newpass = $_POST['repeat'];
							$useremail = $_SESSION['useremail'];
							$change = "update accounts set password='{$newpass}' where email ='{$useremail}'";
							$status = "update accounts set accountstatus='2' where email ='{$useremail}'";

							if ($dbc->query($change) == TRUE && $dbc->query($status) == TRUE){
								$message.="<p> Password is updated!";
								header("Location: http://".$_SERVER['HTTP_HOST'].  dirname($_SERVER['PHP_SELF'])."/customerindex.php");
							}
						} 

					}

				}

				if (isset($message)){
					echo '<div><font color="green">'.$message.'</font></div>';
				}
				?>
				</div>
			</div>
		</div><!-- /.col-->
	</div><!-- /.row -->	
	
	<script src="js/jquery-1.11.1.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/chart.min.js"></script>
	<script src="js/chart-data.js"></script>
	<script src="js/easypiechart.js"></script>
	<script src="js/easypiechart-data.js"></script>
	<script src="js/bootstrap-datepicker.js"></script>
	<script>
		!function ($) {
			$(document).on("click","ul.nav li.parent > a > span.icon", function(){		  
				$(this).find('em:first').toggleClass("glyphicon-minus");	  
			}); 
			$(".sidebar span.icon").find('em:first').addClass("glyphicon-plus");
		}(window.jQuery);

		$(window).on('resize', function () {
		  if ($(window).width() > 768) $('#sidebar-collapse').collapse('show')
		})
		$(window).on('resize', function () {
		  if ($(window).width() <= 767) $('#sidebar-collapse').collapse('hide')
		})
	</script>	
</body>

</html>

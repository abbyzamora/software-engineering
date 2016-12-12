<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Login</title>

<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/datepicker3.css" rel="stylesheet">
<link href="css/styles.css" rel="stylesheet">
<style>
    body {
    background-image: url(dlsubg.jpg);
    margin: 0;
    padding: 72px;
    background-size: 1366px 768px;
    background-repeat: no-repeat;
    display: compact;
    }    
    
    .whitetext {
        color: white;
    }
</style>
<!--[if lt IE 9]>
<script src="js/html5shiv.js"></script>
<script src="js/respond.min.js"></script>
<![endif]-->

</head>

<body>
	<div class="row">
		<div class="col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2 col-md-4 col-md-offset-4">
			<div style="text-align:center"><img src="DLSU.png" style="width:125px" /></div>
            <h2 class="text-center galliard whitetext"><b>De La Salle University</b></h2>
			<h4 class="text-center whitetext">FACULTY ATTENDANCE TRACKER</h4>
			<div class="login-panel panel panel-default">
                <div class="panel-heading" style="text-align:center"><b>Log in</b></div>
				
				<div class="panel-body">
					
					<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
						<fieldset>
							<div class="form-group col-md-10 col-md-offset-1">
								<input class="form-control" placeholder="E-mail" name="user" required type="text" autofocus="">
							</div>
							<div class="form-group col-md-10 col-md-offset-1">
								<input class="form-control" placeholder="Password" name="password" type="password" value="">
							</div>
							<div class="col-md-10 col-md-offset-1">
							<button type="submit" name="login" class="btn btn-primary btn-block">Log in</button>
						</fieldset>

						<?php
							session_start();


							if (isset($_POST['login'])){
								$message=NULL;

								if (empty($_POST['user'])){
									$_SESSION['user']=NULL;
									$message.='<p>You forgot to enter your email! </p>';
								} elseif (!filter_var($_POST['user'], FILTER_VALIDATE_EMAIL) === false) {
									$_SESSION['user']=$_POST['user']; 
								} else {
									$message.='<p> Email is invalid! </p>';
									$_SESSION['user']=FALSE;
								}

								if (empty($_POST['password'])){
									$_SESSION['password']=NULL;
									$message.='<p>You forgot to enter your password! </p>';
								} else {
									$_SESSION['password']=$_POST['password'];
								}

								// query for calling accounts table to check if email 
								// and password matches
								require_once('../mysql_connect.php');
								$loginquery="select email, password, accounttypeNo, accountstatus from accounts";
								$result=mysqli_query($dbc,$loginquery);
								$num_rows=$result->num_rows;

								if (!empty($num_rows)){

									while ($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){

										if ($_SESSION['user'] == "{$row['email']}" && $_SESSION['password'] == "{$row['password']}" && "{$row['accounttypeNo']}" == 1) {
											header("Location: http://".$_SERVER['HTTP_HOST'].  dirname($_SERVER['PHP_SELF'])."/admindashboard.php");
										} else if ($_SESSION['user'] == "{$row['email']}" && $_SESSION['password'] == "{$row['password']}" && "{$row['accounttypeNo']}" == 2) 
											if ("{$row['accountstatus']}" == 1){
												header("Location: http://".$_SERVER['HTTP_HOST'].  dirname($_SERVER['PHP_SELF'])."/resetpassword.php");
											} else header("Location: http://".$_SERVER['HTTP_HOST'].  dirname($_SERVER['PHP_SELF'])."/customerIndex.php");
											
										
									}
									if (!isset($message)){
										$message.='Email and password do not match, please try again';
									}
									
								}

							}
							if (isset($message)){
								echo '<font color="green">'.$message. '</font>';
							}
							?>
					</form>
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

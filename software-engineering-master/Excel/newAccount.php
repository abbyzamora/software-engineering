<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Attendance Tracker</title>

		<link href="css/bootstrap.min.css" rel="stylesheet">

		<link href="css/styles.css" rel="stylesheet">
		<link href="css/bootstrap-table.css" rel="stylesheet">
		<link href="css/myStyle.css" rel="stylesheet">

		<!--Icons-->
		<script src="js/lumino.glyphs.js"></script>

		<!--[if lt IE 9]>
		<script src="js/html5shiv.js"></script>
		<script src="js/respond.min.js"></script>
		<![endif]-->

	</head>
	<?php
		session_start();
		require_once('../mysql_connect.php');
		
		$_SESSION['adminemail'] = $_SESSION['user'];
		$printname = "select concat(a.firstName, ' ', a.lastName) as 'completename', ra.accounttypedescription from accounts a join ref_accounttype ra on a.accounttypeno = ra.accounttypeno where email = '{$_SESSION['adminemail']}'";
		$printresult = mysqli_query($dbc,$printname);
		$row=mysqli_fetch_array($printresult,MYSQL_ASSOC)
	?>

	<body>
		<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
			<div class="container-fluid">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#sidebar-collapse">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="admindashboard.php"><span>Attendance Tracker</span></a>
					<ul class="user-menu">
						<li class="dropdown pull-right">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown"><svg class="glyph stroked male-user"><use xlink:href="#stroked-male-user"></use></svg> User <span class="caret"></span></a>
							<ul class="dropdown-menu" role="menu">
								<li><a href="#"><svg class="glyph stroked male-user"><use xlink:href="#stroked-male-user"></use></svg> Profile</a></li>
								<li><a href="#"><svg class="glyph stroked gear"><use xlink:href="#stroked-gear"></use></svg> Settings</a></li>
								<li><a href="login.php"><svg class="glyph stroked cancel"><use xlink:href="#stroked-cancel"></use></svg> Log out</a></li>
							</ul>
						</li>
					</ul>
					<ul class="user-menu">
					<li class="dropdown pull-right">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"> Import <span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">
							<li><a href="#">Import Faculty Plantilla</a></li>
							<li><a href="#">Import Checked Rooms</a></li>
						</ul>
						&nbsp;
					</li>
				</ul>
				</div><!-- navbar-headers -->
			</div><!-- /.container-fluid -->
		</nav>
			
		<div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar">
			
			<ul class="nav menu">
				<li class="userID">			
					<div class="panel panel-default">
						<div class="panel-body">
							<div class="row col-md-offset-1">
						<p id="username" class="pull-left"><b><?php echo $row['completename']?></b></p>
						</div>
						<div class="row col-md-offset-1">
						<p class="pull-left"><?php echo $row['accounttypedescription']?></p>
						</div>
						</div>
					</div>					
				</li>
				<li><a href="admindashboard.php"><svg class="glyph stroked dashboard-dial"><use xlink:href="#stroked-dashboard-dial"></use></svg> Dashboard</a></li>
				<li class="parent">
					<a href="#" data-toggle="collapse" data-target="#sub-item-1">
						<span data-toggle="collapse" href="#sub-item-1"><svg class="glyph stroked chevron-down"><use xlink:href="#stroked-chevron-down"></use></svg></span> Attendance Monitor 
					</a>
					<ul class="children collapse" id="sub-item-1">
						<li>
							<a class="" href="makeUpClass.php">
								<svg class="glyph stroked chevron-right"><use xlink:href="#stroked-chevron-right"></use></svg> Add Alternative Class
							</a>
						</li>
						
					</ul>
				</li>
				<li class="parent active">
					<a href="#" data-toggle="collapse" data-target="#sub-item-2">
						<span data-toggle="collapse" href="#sub-item-2"><svg class="glyph stroked chevron-down"><use xlink:href="#stroked-chevron-down"></use></svg></span> Manage Users 
					</a>
					<ul class="children collapse" id="sub-item-2">
						<li>
							<a class="" href="newAccount.php">
								<svg class="glyph stroked chevron-right"><use xlink:href="#stroked-chevron-right"></use></svg> Create new user account
							</a>
						</li>
					</ul>
				</li>
				
				<li role="presentation" class="divider"></li>
				
			</ul>

		</div><!--/.sidebar-->
			
		<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			
			<div class="row">
				<ol class="breadcrumb">
					<li><a href="admindashboard.php"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
					<li class="active">Dashboard</li>
				</ol>
			</div><!--/.row-->
			
			<div class="row">
				<div class="col-lg-12">
					<h1 class="page-header">Create User Accounts</h1>
				</div>
			</div>
		<div class="panel panel-default">
			<div class="panel-body">
				<div class="row">
					
						
					<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
						<fieldset>
							<div class="col-md-12">
								
								<div class="form-group col-md-4 col-md-offset-4">
									<input class="form-control" placeholder="First Name" name="first" required type="text"   value="<?php if (isset($_POST['first'])) echo $_POST['first']; ?>">
								</div>
								<div class="form-group col-md-4 col-md-offset-4">
									<input class="form-control" placeholder="Last Name" name="last" required type="text"   value="<?php if (isset($_POST['last'])) echo $_POST['last']; ?>">
								</div>
								<div class="form-group col-md-4 col-md-offset-4">
									<input class="form-control" placeholder="Email" name="email" required type="email"  value="<?php if (isset($_POST['email'])) echo $_POST['email']; ?>">
								</div>
								<div class="form-group col-md-4 col-md-offset-4">
									<div class="col-md-3">
										<input class="form-control" value="+63" readonly="readonly" /> 
									</div>
									<div class="col-md-9">
										<input class="form-control" data-inputmask="'mask': '(999) 999-9999'"  name="contact" required type="text" value="<?php if (isset($_POST['contact'])) echo $_POST['contact']; ?>">
									</div>
								</div>
							<div class="col-md-2 col-lg-offset-5">
								<button type="submit" name="creation" class="btn btn-primary btn-success">Create Account</button>
							</div>	
						</fieldset>
					</form>

					<?php
					
					//echo $_SESSION['adminemail'];

					if (isset($_POST['creation'])){
						$message=NULL;

						if (empty($_POST['first'])){
							$_SESSION['first']=NULL;
							$message.='<p>You forgot to enter the first name!';
						} else {
							$_SESSION['first']=$_POST['first']; 
						}
						if (empty($_POST['last'])){
							$_SESSION['last']=NULL;
							$message.='<p>You forgot to enter the Last Name!';
						} else {
							$_SESSION['last']=$_POST['last']; 
						}
						if (empty($_POST['email'])){
							$_SESSION['email']=NULL;
							$message.='<p>You forgot to enter the Email!';
						} elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) === false) {
							$_SESSION['email']=$_POST['email']; 
						} else {
							$message.='<p> Email is invalid! </p>';
							$_SESSION['email']=NULL;
						}
						
						echo $_POST['contact'];
						if (empty($_POST['contact'])){
							$_SESSION['contact']=NULL;
							$message.='<p>You forgot to enter the contact number!';
						} else {
							$_SESSION['contact']= $_POST['contact'];
						}

						$_SESSION['password']= generatePassword();
						//echo $_SESSION['password'];

						if (!isset($message)){
							$adminquery = "select email from accounts";
							$adminresult = mysqli_query($dbc,$adminquery);
							$num_rows=$adminresult->num_rows;

							if (!empty($num_rows)){
								while ($row=mysqli_fetch_array($adminresult,MYSQL_ASSOC)){
									if ($_SESSION['email'] == "{$row['email']}"){
										$message.="<p>Account is already existing!</p>";
									} 
								}
								if (!isset($message)){
									$show_modal="1";
								}
							}
						} 

					}
					if (isset($message)){
						echo '<font color="green">'.$message. '</font>';
					}

				?>

					<?php
						if (isset($_POST['verification'])){
								$message = NULL;

								if (empty($_POST['adminpassword'])){
									$_SESSION['adminpassword']=FALSE;
									$message.='<p>You forgot to enter your password!';
								} else {
									$_SESSION['adminpassword']=$_POST['adminpassword']; 
								}
								

								$admincheck = "select email, password from accounts";
								$checkresult = mysqli_query($dbc,$admincheck);
								$num_rows=$checkresult->num_rows;

								if (!empty($num_rows)){
									while ($row=mysqli_fetch_array($checkresult,MYSQL_ASSOC)){
										//type the password in an account you have logged in
										if ($_SESSION['adminemail'] == "{$row['email']}" && $_SESSION['adminpassword'] == "{$row['password']}"){
											$success = 1;
											$registerquery = "insert into accounts(firstName, lastName, password,accountTypeNo,email,accountstatus,contactnumber) VALUES
											('{$_SESSION['first']}', '{$_SESSION['last']}','{$_SESSION['password']}','2','{$_SESSION['email']}','1',CONCAT('+63','{$_SESSION['contact']}'))";

											require_once ('..\PHPMailer\PHPMailerAutoload.php');

											$mailer = new PHPMailer();
											//$mailer->SMTPDebug = 9001;   

											$mailer->SMTPOptions = array('ssl' => array('verify_peer' => false,
																						'verify_peer_name' => false,
																						'allow_self_signed' => true)
																		);
											$mailer->isSMTP();
											$mailer->Timeout = 900;
											$mailer->Username = 'dlsum.facultyattendance@gmail.com'; 
											$mailer->Password = '01234567891011'; //Secure password
											$mailer->SMTPSecure = 'tls';
											$mailer->Port = 587; 
											$mailer->Host = 'tls://smtp.gmail.com';
											$mailer->SMTPAuth = true;

											$mailer->setFrom('dlsum.facultyattendance@gmail.com', 'Faculty Checker Automated Mailing System');
											$mailer->addAddress($_SESSION['email'], $_SESSION['first'], $_SESSION['last']);


											$mailer->Subject = '[Faculty Attendance] New Account';
											//$mailer->Body = 'You have just created a brand new account for the online attendance checker system.';

											// WE COULD SEND HTML TO THE USER
											 
											$mailer->isHTML(true); 
											$mailer->Body = "Hello {$_SESSION['first']} ' ' {$_SESSION['last']}! <br />
															 To be able to login please use the following credentals: email: <u>{$_SESSION['email']}</u> with the password: <u>{$_SESSION['password']}</u><br />
															 <br />
															 <font size=\"2%\">Note: Please do not attempt to reply to this email as it was sent through an automated system.</font>";
											try{
												if($mailer->send()){
													$registerresult=mysqli_query($dbc,$registerquery);
													$message.="<p>Account has been successfully created!</p>";
												}else{
													$message.="<p>An internal error ocurred! (mail) </p>";
												}
											}catch(phpmailerException $e){
												$message .= "<p>Error: Can't proceed account creation due to slow internet connection.</p>";
											}
											
										}
									}
									if (!isset($message)){
										$success = 2;
										$message.="<p>Password is incorrect!";
									}		
								}
								if (isset($message)){
									echo '<div> <font color="green">'.$message. '</font></div>';
								}
								else{
									$registerquery = "insert into accounts(firstname,lastname,password,accountTypeNo,email,accountstatus,contactnumber) VALUES
											('{$_SESSION['first']}','{$_SESSION['last']}','{$_SESSION['password']}','2','{$_SESSION['email']}','1', CONCAT('+63','{$_SESSION['contact']}'))";
								}
						}
						?>	
				</div><!--/.row-->

				<!-- Modal -->
				<div class="modal fade" id="verifymodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
								<h4 class="modal-title" id="myModalLabel">Admin Verification</h4>
							</div>
							<div class="modal-body">
								<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
									<fieldset>
										<div class="col-md-12">
											<div class="form-group col-md-6 col-md-offset-3">
												<label><font size="2">Confirm your password to continue </font></label>
												<input class="form-control" placeholder="Admin Password" name="adminpassword" required type="password"   value="<?php if (isset($_POST['adminpassword'])) echo $_POST['adminpassword']; ?>">
											</div>
											
											<div class="col-md-4 col-md-offset-4">
											<button type="submit" name="verification" class="btn btn-primary btn-success">Verify Account</button>
											</div>
										</div>
											
									</fieldset>
								</form>
							
						</div>
						<!-- /.modal-content -->
					</div>
					<!-- /.modal-dialog -->
				</div>
				<!-- /.modal -->
			</div>
		</div>
				</div><!--/.col-->
			</div><!--/.row-->
		</div>	<!--/.main-->
		<?php
		function generatePassword() {
			$combination = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
			$pass = array(); 
			$alphaLength = strlen($combination) - 1; 
			for ($i = 0; $i < 8; $i++) {
				$j = rand(0, $alphaLength);
				$pass[] = $combination[$j];
			}
			return implode($pass); //password generated
		}
		?>
		<script src="js/jquery-1.11.1.min.js"></script>
		<script>
			alert('asd');
			$(document).ready(function(){
				$(":input").inputmask();
			});
		</script>
		<script src="js/bootstrap.min.js"></script>
		<script src="js/chart.min.js"></script>

		<script src="js/jquery.inputmask.bundle.js"></script>

		<script src="js/bootstrap-table.js"></script>
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
			$(document).ready(function(){
				var showModal = '<?php echo $show_modal; ?>';
				if(showModal=="1"){$("#verifymodal").modal("show");}
			});

			
		</script>	
	</body>
</html>

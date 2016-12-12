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
							<li><a data-toggle="modal" href="#myModalPlantilla">Import Faculty Plantilla</a></li>
                            <li><a data-toggle="modal" href="#myModalCheckedRooms">Import Checked Rooms</a></li>
						</ul>
						&nbsp;
					</li>
				</ul>
				</div><!-- navbar-headers -->
			</div><!-- /.container-fluid -->
		</nav>
		
		<div class="modal fade" id="myModalPlantilla" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="myModalLabel">Upload Plantilla</h4>
                    </div>
                    <div class="modal-body">
                        <input type="file" id="my_file_input" />
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" id='plantilla-button' class="btn btn-success">Upload Plantilla</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->

        <div class="modal fade" id="myModalCheckedRooms" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="myModalLabel1">Upload Checked Rooms</h4>
                    </div>
                    <div class="modal-body">
                        <input type="file" id="input-2">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" id='checked-button' class="btn btn-success">Upload Checked Rooms</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>

		<div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar">
			
			<ul class="nav menu">
				<li class="userID">			
					<div class="panel panel-default">
						<div class="panel-body">
							<div class="row col-md-offset-1">
						<p id="username" class="pull-left"><b><?php echo $row['completename']?></b></p>
						</div>
						<div class="row col-md-offset-1">
						<p class="pull-left"><h4 id="accounttype"><?php echo $row['accounttypedescription']?></h4></p>
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
							<a class="" href="scheduleclass.php">
								<svg class="glyph stroked chevron-right"><use xlink:href="#stroked-chevron-right"></use></svg> Schedule a Class
							</a>
						</li>
						<li>
                            <a href="viewCheckedRooms.php">
                                <svg class="glyph stroked chevron-right">
                                    <use xlink:href="#stroked-chevron-right"></use>
                                </svg> View Checked Rooms
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
						<li>
							<a class="" href="assign-checker.php">
								<svg class="glyph stroked chevron-right"><use xlink:href="#stroked-chevron-right"></use></svg> Assign Checker
							</a>
						</li>
					</ul>
				</li>
				
				<li role="presentation" class="divider"></li>
			
				<li class="parent">
				    <a href="adminhelpdesk.php"><span><svg class="glyph stroked paperclip"><use xlink:href="#stroked-paperclip"/></svg>Help Desk | FAQs</span></a>
				</li>
				
			</ul>

		</div><!--/.sidebar-->
			
		<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			
			<div class="row">
				<ol class="breadcrumb">
					<li>
                        <a href="admindashboard.php">
                            <svg class="glyph stroked home">
                                <use xlink:href="#stroked-home"></use>
                            </svg>
                        </a>
                    </li>
                    <li>Manage Users</li>
                    <li class="active"><a href="assign-checker.php">Assign Checker</a></li>
				</ol>
			</div><!--/.row-->
			
			<div class="row">
				<div class="col-lg-12">
					<h1 class="page-header">Assign Checker to Buildings and Shifts</h1>
				</div>
			</div>
		<div class="panel panel-default">
			<div class="panel-body">
				<div class="row">
					
						
					<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
						<fieldset>
							<div class="col-md-12">
								
								<div class="form-group col-md-4 col-md-offset-4">
									<label>Checker Name</label>
									<select name = "checker" class="form-control" required>
									<?php
											$checkername = "SELECT ACCOUNTNO, CONCAT(FIRSTNAME, ' ', LASTNAME) AS 'NAME' 
															  FROM ACCOUNTS 
															 WHERE ACCOUNTTYPENO = '2'
															   AND ACCOUNTNO NOT IN (SELECT ACCOUNTNO
																					   FROM ASSIGNED_BUILDING)";
											$printname2 = mysqli_query($dbc,$checkername);
											echo "<option value=''></option>";
												while($row=mysqli_fetch_array($printname2,MYSQL_ASSOC)){
													$id = $row['ACCOUNTNO'];
													$checker = $row['NAME'];
													if($id == $_POST['checker']){
														echo "<option value='$id' selected='selected'> $checker </option>";
													}
													else{
														echo "<option value='$id'> $checker </option>";
													}
													
												}
											
											
									?>
									</select>
								</div>
								
								<div class="form-group col-md-4 col-md-offset-4">
									<div class="radio">
										<?php
											if(empty($_POST['shift'])){
												echo '<label class="col-md-offset-1">
														<input type="radio" name="shift" id="optionsRadios1" value="AM">Morning Shift
													</label>
													<label class="col-md-offset-2">
														<input type="radio" name="shift" id="optionsRadios2" value="PM">Afternoon Shift
													</label>';
											}
											else{
												if($_POST['shift'] == 'AM'){
													echo '<label class="col-md-offset-1">
															<input checked type="radio" name="shift" id="optionsRadios1" value="AM">Morning Shift
														</label>
														<label class="col-md-offset-2">
															<input type="radio" name="shift" id="optionsRadios2" value="PM">Afternoon Shift
														</label>';
												}
												else{
													echo '<label class="col-md-offset-1">
															<input type="radio" name="shift" id="optionsRadios1" value="AM">Morning Shift
														</label>
														<label class="col-md-offset-2">
															<input checked type="radio" name="shift" id="optionsRadios2" value="PM">Afternoon Shift
														</label>';
												}
											}
										
										?>
										
										
									</div>
								</div>
								<div class="col-md-2 col-md-offset-5">
									<button type="submit" name="creation" class="btn btn-primary btn-success" style="margin-bottom: 20px">Show Building Sets</button>
								</div>
								
								<?php
									$message = "";
									
									if(isset($_POST['creation'])){
										$_SESSION['checker'] = $_POST['checker'];
										$checkernamequery = "SELECT CONCAT(FIRSTNAME, ' ', LASTNAME) as fullName FROM ACCOUNTS WHERE ACCOUNTNO = '{$_POST['checker']}'";
										$checkernameresult = mysqli_query($dbc,$checkernamequery);
										$row=mysqli_fetch_array($checkernameresult,MYSQL_ASSOC);
										$_SESSION['checkername'] = $row['fullName'];
										if(empty($_POST['shift'])){
											$message.="No shift selected";
										}
										else if($_POST['shift'] == 'AM'){
											echo "
											<div class=\"table-responsive col-md-10 col-md-offset-1\"> 
													<table class=\"table table-bordered table-striped\">
														<thead>
															<tr>
																<th>Building Sets</th>
																<th></th>
															</tr>
														</thead>
															
														<tbody>";
														$checkSet1 = "SELECT * 
																		  FROM ASSIGNED_BUILDING
																		 WHERE BUILDINGCODE = 'LS'
																		   AND SHIFTCODE = 'AM'";
														$set1Result = mysqli_query($dbc,$checkSet1);
														if(mysqli_num_rows($set1Result)==0){
															echo"<tr>
																	<td>LS, SJ, Mutien Marie</td>
																	<td><button type=\"submit\" name=\"assign1\" class=\"btn btn-primary btn-success btn-xs\">Assign</button></td>
																</tr>";
														}
														$checkSet2 = "SELECT * 
																		  FROM ASSIGNED_BUILDING
																		 WHERE BUILDINGCODE = 'A'
																		   AND SHIFTCODE = 'AM'";
														$set2Result = mysqli_query($dbc,$checkSet2);
														if(mysqli_num_rows($set2Result)==0){
															echo"<tr>
																	<td>Andrew</td>
																	<td><button type=\"submit\" name=\"assign2\" class=\"btn btn-primary btn-success btn-xs\">Assign</button></td>
																</tr>";
														}
														$checkSet3 = "SELECT * 
																		  FROM ASSIGNED_BUILDING
																		 WHERE BUILDINGCODE = 'M'
																		   AND SHIFTCODE = 'AM'";
														$set3Result = mysqli_query($dbc,$checkSet3);
														if(mysqli_num_rows($set3Result)==0){
															echo"<tr>
																	<td>Miguel, Velasco, Yuchengco</td>
																	<td><button type=\"submit\" name=\"assign3\" class=\"btn btn-primary btn-success btn-xs\">Assign</button></td>
																</tr>";
														}
														$checkSet4 = "SELECT * 
																		  FROM ASSIGNED_BUILDING
																		 WHERE BUILDINGCODE = 'G'
																		   AND SHIFTCODE = 'AM'";
														$set4Result = mysqli_query($dbc,$checkSet4);
														if(mysqli_num_rows($set4Result)==0){
														echo"<tr>
																<td>Gokongwei, STRC, Razon</td>
																<td><button type=\"submit\" name=\"assign4\" class=\"btn btn-primary btn-success btn-xs\">Assign</button></td>
															</tr>";
														}
											echo		"</tbody>
													</table>
												</div>";
										}
										else{
											echo "
											<div class=\"table-responsive col-md-10 col-md-offset-1\"> 
													<table class=\"table table-bordered table-striped\">
														<thead>
															<tr>
																<th>Building Sets</th>
																<th></th>
															</tr>
														</thead>
															
														<tbody>";
														$checkSet5 = "SELECT * 
																		  FROM ASSIGNED_BUILDING
																		 WHERE BUILDINGCODE = 'LS'
																		   AND SHIFTCODE = 'PM'";
														$set5Result = mysqli_query($dbc,$checkSet5);
														if(mysqli_num_rows($set5Result)==0){
															echo"<tr>
																	<td>LS, SJ, Mutien Marie, Miguel, Velasco, Yuchengco</td>
																	<td><button type=\"submit\" name=\"assign5\" class=\"btn btn-primary btn-success btn-xs\">Assign</button></td>
																</tr>";
														}
														$checkSet6 = "SELECT * 
																		  FROM ASSIGNED_BUILDING
																		 WHERE BUILDINGCODE = 'A'
																		   AND SHIFTCODE = 'PM'";
														$set6Result = mysqli_query($dbc,$checkSet6);
														if(mysqli_num_rows($set6Result)==0){
														echo"<tr>
																<td>Andrew, Gokongwei, STRC, Razon</td>
																<td><button type=\"submit\" name=\"assign6\" class=\"btn btn-primary btn-success btn-xs\">Assign</button></td>
															</tr>";
														}
													echo"</tbody>
													</table>
												</div>";
										}
									}
								?>
							</div>
						</fieldset>
					</form>
					<?php
						if(isset($_POST['assign1'])){
							$_SESSION['buttonclicked'] = "assign1";
							$show_modal = "1";
						}
						else if(isset($_POST['assign2'])){
							$_SESSION['buttonclicked'] = "assign2";
							$show_modal = "1";
						}
						else if(isset($_POST['assign3'])){
							$_SESSION['buttonclicked'] = "assign3";
							$show_modal = "1";
						}
						else if(isset($_POST['assign4'])){
							$_SESSION['buttonclicked'] = "assign4";
							$show_modal = "1";
						}
						else if(isset($_POST['assign5'])){
							$_SESSION['buttonclicked'] = "assign5";
							$show_modal = "1";
						}
						else if(isset($_POST['assign6'])){
							$_SESSION['buttonclicked'] = "assign6";
							$show_modal = "1";
						}
						if(isset($_POST['verification'])){
							$message = NULL;

								if (empty($_POST['adminpassword'])){
									$_SESSION['adminpassword']=FALSE;
									$message.='<p>You forgot to enter your password!';
								} else {
									$_SESSION['adminpassword']=$_POST['adminpassword']; 
								}
								

								$admincheck = "select password from accounts where email = '{$_SESSION['adminemail']}'";
								$checkresult = mysqli_query($dbc,$admincheck);
								$row = mysqli_fetch_array($checkresult, MYSQL_ASSOC);
								
								if ($row!=null){
									if ($row['password'] == $_SESSION['adminpassword']){
										$term = "select max(term) as 'term' from plantilla
												where schoolYear = YEAR(NOW())";
										$termResult = mysqli_query($dbc, $term);
										$row = mysqli_fetch_array($termResult, MYSQL_ASSOC);
										if($_SESSION['buttonclicked'] == "assign1"){
											
											$assign = "insert into assigned_building
																   (buildingCode, accountNo, schoolYear, term, shiftCode)
															values ('LS', '{$_SESSION['checker']}', YEAR(NOW()), '{$row['term']}', 'AM')";
											$assignResult = mysqli_query($dbc, $assign);
											$assign = "insert into assigned_building
																   (buildingCode, accountNo, schoolYear, term, shiftCode)
															values ('SJ', '{$_SESSION['checker']}', YEAR(NOW()), '{$row['term']}', 'AM')";
											$assignResult = mysqli_query($dbc, $assign);
											$assign = "insert into assigned_building
																   (buildingCode, accountNo, schoolYear, term, shiftCode)
															values ('MM', '{$_SESSION['checker']}', YEAR(NOW()), '{$row['term']}', 'AM')";
											$assignResult = mysqli_query($dbc, $assign);
											echo '<div align = "center"><font color="green">Successfully assigned '.$_SESSION["checkername"].' to AM classes in LS, SJ, and Mutien Marie</font></div>';
											echo '<meta http-equiv="refresh" content="3">';
										}
										else if($_SESSION['buttonclicked'] == "assign2"){
											$assign = "insert into assigned_building
																   (buildingCode, accountNo, schoolYear, term, shiftCode)
															values ('A', '{$_SESSION['checker']}', YEAR(NOW()), '{$row['term']}', 'AM')";
											$assignResult = mysqli_query($dbc, $assign);
											echo '<div align = "center"><font color="green">Successfully assigned '.$_SESSION["checkername"].' to AM classes in Andrew</font></div>';
											echo '<meta http-equiv="refresh" content="3">';
										}
										else if($_SESSION['buttonclicked'] == "assign3"){
											$assign = "insert into assigned_building
																   (buildingCode, accountNo, schoolYear, term, shiftCode)
															values ('M', '{$_SESSION['checker']}', YEAR(NOW()), '{$row['term']}', 'AM')";
											$assignResult = mysqli_query($dbc, $assign);
											$assign = "insert into assigned_building
																   (buildingCode, accountNo, schoolYear, term, shiftCode)
															values ('VL', '{$_SESSION['checker']}', YEAR(NOW()), '{$row['term']}', 'AM')";
											$assignResult = mysqli_query($dbc, $assign);
											$assign = "insert into assigned_building
																   (buildingCode, accountNo, schoolYear, term, shiftCode)
															values ('Y', '{$_SESSION['checker']}', YEAR(NOW()), '{$row['term']}', 'AM')";
											$assignResult = mysqli_query($dbc, $assign);
											echo '<div align = "center"><font color="green">Successfully assigned '.$_SESSION["checkername"].' to AM classes in Miguel, Velasco, and Yuchengco</font></div>';
											echo '<meta http-equiv="refresh" content="3">';
										}
										else if($_SESSION['buttonclicked'] == "assign4"){
											$assign = "insert into assigned_building
																   (buildingCode, accountNo, schoolYear, term, shiftCode)
															values ('G', '{$_SESSION['checker']}', YEAR(NOW()), '{$row['term']}', 'AM')";
											$assignResult = mysqli_query($dbc, $assign);
											$assign = "insert into assigned_building
																   (buildingCode, accountNo, schoolYear, term, shiftCode)
															values ('C', '{$_SESSION['checker']}', YEAR(NOW()), '{$row['term']}', 'AM')";
											$assignResult = mysqli_query($dbc, $assign);
											$assign = "insert into assigned_building
																   (buildingCode, accountNo, schoolYear, term, shiftCode)
															values ('ER', '{$_SESSION['checker']}', YEAR(NOW()), '{$row['term']}', 'AM')";
											$assignResult = mysqli_query($dbc, $assign);
											echo '<div align = "center"><font color="green">Successfully assigned '.$_SESSION["checkername"].' to AM classes in Gokongwei, STRC, and Razon</font></div>';
											echo '<meta http-equiv="refresh" content="3">';
										}
										else if($_SESSION['buttonclicked'] == "assign5"){
											$assign = "insert into assigned_building
																   (buildingCode, accountNo, schoolYear, term, shiftCode)
															values ('LS', '{$_SESSION['checker']}', YEAR(NOW()), '{$row['term']}', 'PM')";
											$assignResult = mysqli_query($dbc, $assign);
											$assign = "insert into assigned_building
																   (buildingCode, accountNo, schoolYear, term, shiftCode)
															values ('SJ', '{$_SESSION['checker']}', YEAR(NOW()), '{$row['term']}', 'PM')";
											$assignResult = mysqli_query($dbc, $assign);
											$assign = "insert into assigned_building
																   (buildingCode, accountNo, schoolYear, term, shiftCode)
															values ('MM', '{$_SESSION['checker']}', YEAR(NOW()), '{$row['term']}', 'PM')";
											$assignResult = mysqli_query($dbc, $assign);
											$assign = "insert into assigned_building
																   (buildingCode, accountNo, schoolYear, term, shiftCode)
															values ('M', '{$_SESSION['checker']}', YEAR(NOW()), '{$row['term']}', 'PM')";
											$assignResult = mysqli_query($dbc, $assign);
											$assign = "insert into assigned_building
																   (buildingCode, accountNo, schoolYear, term, shiftCode)
															values ('VL', '{$_SESSION['checker']}', YEAR(NOW()), '{$row['term']}', 'PM')";
											$assignResult = mysqli_query($dbc, $assign);
											$assign = "insert into assigned_building
																   (buildingCode, accountNo, schoolYear, term, shiftCode)
															values ('Y', '{$_SESSION['checker']}', YEAR(NOW()), '{$row['term']}', 'PM')";
											$assignResult = mysqli_query($dbc, $assign);
											echo '<div align = "center"><font color="green">Successfully assigned '.$_SESSION["checkername"].' to PM classes in LS, SJ, Mutien Marie, Miguel, Velasco, Yuchengco</font></div>';
											echo '<meta http-equiv="refresh" content="3">';
										}
										else if($_SESSION['buttonclicked'] == "assign6"){
											$assign = "insert into assigned_building
																   (buildingCode, accountNo, schoolYear, term, shiftCode)
															values ('A', '{$_SESSION['checker']}', YEAR(NOW()), '{$row['term']}', 'PM')";
											$assignResult = mysqli_query($dbc, $assign);
											$assign = "insert into assigned_building
																   (buildingCode, accountNo, schoolYear, term, shiftCode)
															values ('G', '{$_SESSION['checker']}', YEAR(NOW()), '{$row['term']}', 'PM')";
											$assignResult = mysqli_query($dbc, $assign);
											$assign = "insert into assigned_building
																   (buildingCode, accountNo, schoolYear, term, shiftCode)
															values ('C', '{$_SESSION['checker']}', YEAR(NOW()), '{$row['term']}', 'PM')";
											$assignResult = mysqli_query($dbc, $assign);
											$assign = "insert into assigned_building
																   (buildingCode, accountNo, schoolYear, term, shiftCode)
															values ('ER', '{$_SESSION['checker']}', YEAR(NOW()), '{$row['term']}', 'PM')";
											$assignResult = mysqli_query($dbc, $assign);
											echo '<div align = "center"><font color="green">Successfully assigned '.$_SESSION["checkername"].' to PM classes in Andrew, Gokongwei, STRC, and Razon</font></div>';
											echo '<meta http-equiv="refresh" content="3">';
										}
									}
								}

						}
					?>
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
				</div><!--/.row-->


			</div>
				</div><!--/.col-->
			</div><!--/.row-->
		</div>	<!--/.main-->
		
		<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
		
		<script src="js/bootstrap.min.js"></script>
		<script src="js/chart.min.js"></script>

		<script src="js/jquery.inputmask.bundle.js"></script>
		<script src="js/shim.js"></script>
        <script src="js/jszip.js"></script>
        <script src="js/xlsx.js"></script>
        <script src="js/lumino.glyphs.js"></script>
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

		 <script>
            var output;
            $('#my_file_input, #input-2').change(function () {
                readFile($(this).attr('id'));
            });



            function readFile(thiss) {
                var files = document.getElementById(thiss).files;

                var i, f;
                for (i = 0, f = files[i]; i != files.length; ++i) {
                    var reader = new FileReader();
                    var name = files[0].name;
                    reader.onload = function (e) {
                        var data = e.target.result;
                        //var wb = XLSX.read(data, {type: 'binary'});
                        var arr = String.fromCharCode.apply(null, new Uint8Array(data));
                        var wb = XLSX.read(btoa(arr), {
                            type: 'base64'
                        });
                        process_wb(wb);
                    };
                    //reader.readAsBinaryString(f);
                    reader.readAsArrayBuffer(f);
                }
            }

            function process_wb(wb) {



                /*output = JSON.stringify(to_json(wb), 2, 2);
                 */
                output = to_json(wb);





                console.log(output);
            }

            function to_json(workbook) {
                var result = {};
                workbook.SheetNames.forEach(function (sheetName) {
                    var roa = XLSX.utils.sheet_to_row_object_array(workbook.Sheets[sheetName]);
                    if (roa.length > 0) {
                        result[sheetName] = roa;
                    }
                });
                return result;
            }
            $('#plantilla-button').click(function () {
                if (output) {
                    $.post({

                        url: 'insert.php',
                        data: output,
                        success: function (data) {
                            alert(data);
                        },
                        error: function (jqXHR, textStatus, errorThrown) {

                            alert(textStatus);
                            alert(errorThrown);
                        }
                    });
                } else {
                    alert('Failed!');
                }
                $('input[type=file]').val('');
                $('#myModalPlantilla').modal('hide');
            });
            $('#checked-button').click(function () {
                if (output) {
                    $.ajax({
                        type: 'POST',
                        url: 'insertCheckedRooms.php',
                        data: {
                            'data': output
                        },
                        success: function (data) {
                            alert(data);
                        },
                        error: function (jqXHR, textStatus, errorThrown) {

                            alert(textStatus);
                            alert(errorThrown);
                        }

                    });
                } else {
                    alert('Failed!');
                }
                $('input[type=file]').val('');
                $('#myModalCheckedRooms').modal('hide');
            });
        </script>
       
	</body>
</html>

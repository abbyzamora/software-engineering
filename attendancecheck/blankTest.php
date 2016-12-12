
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Attendance Tracker</title>

<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/datepicker3.css" rel="stylesheet">
<link href="css/styles.css" rel="stylesheet">
<link href="css/myStyle.css" rel="stylesheet">
<link href="css/bootstrap-table.css" rel="stylesheet">

<!--Icons-->
<script src="js/lumino.glyphs.js"></script>

<!--[if lt IE 9]>
<script src="js/html5shiv.js"></script>
<script src="js/respond.min.js"></script>
<![endif]-->

</head>

<body>
	<nav class="navbar navbar-custom navbar-fixed-top" id="customer" role="navigation">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#sidebar-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" id="custom" href="customerIndex.php"><img src="dlsu1.png" alt="logo"/><span><b>&nbsp Attendance Tracker</b></span></a>
				<ul class="user-menu">
					<li class="dropdown pull-right">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><svg class="glyph stroked male-user"><use xlink:href="#stroked-male-user"></use></svg> User <span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">
							<li><a href="#"><svg class="glyph stroked male-user"><use xlink:href="#stroked-male-user"></use></svg> Profile</a></li>
							<li><a href="#"><svg class="glyph stroked gear"><use xlink:href="#stroked-gear"></use></svg> Settings</a></li>
							<li><a href="#"><svg class="glyph stroked cancel"><use xlink:href="#stroked-cancel"></use></svg> Logout</a></li>
						</ul>
					</li>
				</ul>
			</div>
		</div><!-- /.container-fluid -->
	</nav>		
	<div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar">
		<ul class="nav menu">
			<li class="userID">			
				<div class="panel panel-default">
					<div class="panel-heading">
						<b>Hello, User!</b><!--Insert username here-->
					</div>
					<div class="panel-body">
						<p><b>User Full Name</b></p>
						<p>Position</p>
					</div>
				</div>					
			</li>
			<li><a href="index.html"><svg class="glyph stroked dashboard-dial"><use xlink:href="#stroked-dashboard-dial"></use></svg> Dashboard</a></li>
			<li><a href="#"><svg class="glyph stroked star"><use xlink:href="#stroked-star"></use></svg> View Class List</a></li>
			<li><a href="#"><svg class="glyph stroked star"><use xlink:href="#stroked-star"></use></svg> Upload Excel File</a></li>
			<li class="active"><a href="#"><svg class="glyph stroked eye"><use xlink:href="#stroked-eye"/></svg> Building Assignments</a></li>
			<li role="presentation" class="divider"></li>
			<li><a href="login.html"><svg class="glyph stroked male-user"><use xlink:href="#stroked-male-user"></use></svg> Contact Support</a></li>
		</ul>
	</div><!--/.sidebar-->
	
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			
		<div class="row">
			<ol class="breadcrumb">
				<li><a href="#"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
				<li class="active">Building Assignments</li>
			</ol>
		</div><!--/.row-->
		
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">Building Assignments</h1>
			</div>
		</div><!--/.row-->		
		
		<div class="row">
			<div class="col-md-3">
				<div class="panel panel-default">
					<div class="panel-body">
						<table data-toggle="table">
							<thead>
								<tr>
									<th data-field="building" data-align="center">Building</th>
									<th data-field="actions"></th>
								</tr>
							</thead>
							<tbody>							
								<tr><td>Gokongwei</td><td>
													<button class="btn btn-primary btn-xs" data-toggle="modal" data-target="#myModal0">
														Details
													</button>
													<!-- Modal -->
													<div class="modal fade" id="myModal0" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
														<div class="modal-dialog">
															<div class="modal-content">
																<div class="modal-header">
																	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
																	<div class="row">
																		<h4 class="modal-title" id="myModalLabel">Classes in <u>Gokongwei</u></h4>
																	</div>
																		<h6>for this day: <u>November 08, 2016</u></h6>
																</div>
																<div class="modal-body"><table data-toggle="table"><caption>Morning</caption><thead><tr><th>Room</th><th>Course</th><th>Section</th><th>Time</th><th>Day</th><th>Faculty</th></tr></thead><tbody><tr><td>G202</td><td>SYSTIMP</td><td>S15</td><td>09:15 - 10:45</td><td>T</td><td>DannyCheng</td></tr></tbody></table><div class="modal-footer">
																	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
																</div>
															</div>
															<!-- /.modal-content -->
														</div>
														<!-- /.modal-dialog -->
													</div>
													<!-- /.modal -->
												</td></tr>							</tbody>
						</table>						
					</div>
				</div>
			</div>
		</div>	
	</div><!--/.col-->

	<script src="js/jquery-1.11.1.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/chart.min.js"></script>
	<script src="js/chart-data.js"></script>
	<script src="js/easypiechart.js"></script>
	<script src="js/easypiechart-data.js"></script>
	<script src="js/bootstrap-datepicker.js"></script>
	<script src="js/bootstrap-table.js"></script>
	<script>
		$('#calendar').datepicker({
		});

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

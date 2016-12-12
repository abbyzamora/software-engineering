<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Attendance Tracker</title>

<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/datepicker3.css" rel="stylesheet">
<link href="css/bootstrap-table.css" rel="stylesheet">
<link href="css/styles.css" rel="stylesheet">
<link href="css/myStyle.css" rel="stylesheet">
<link href="//cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" rel="stylesheet">
<!--Icons-->

<!--[if lt IE 9]>
<script src="js/html5shiv.js"></script>
<script src="js/respond.min.js"></script>
<![endif]-->

</head>
<?php
	session_start();
	$_SESSION['adminemail'] = $_SESSION['user'];

	require_once('../mysql_connect.php');
	$printname = "select concat(a.firstName,' ', a.lastName) as 'completename', ra.accounttypedescription from accounts a join ref_accounttype ra on a.accounttypeno = ra.accounttypeno where email = '{$_SESSION['adminemail']}'";
	$printresult = mysqli_query($dbc,$printname);
	$row=mysqli_fetch_array($printresult,MYSQLI_ASSOC);
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
                <a class="navbar-brand" href="admindashboard.php"><img src="dlsu2.png" height="23px"><span> <b>De La Salle University | Attendance Tracker</b></span></a>
				<ul class="user-menu">
					<li class="dropdown pull-right">


						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><svg class="glyph stroked male-user"><use xlink:href="#stroked-male-user"></use></svg> User <span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">
							<li><a href="login.php"><svg class="glyph stroked cancel"><use xlink:href="#stroked-cancel"></use></svg> Log out</a></li>
						</ul>
					</li>
				</ul>
				<ul class="user-menu">
					<li class="dropdown pull-right">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span style="font-size:1.4em; vertical-align:bottom;" class="glyphicon glyphicon-upload" aria-hidden="true"></span>&nbsp; &nbsp;Import <span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">
							<li><a data-toggle="modal" href="#myModalPlantilla">Import Faculty Plantilla</a></li>
							<li><a data-toggle="modal" href="#myModalCheckedRooms">Import Checked Rooms</a></li>
						</ul>
						&nbsp;
					</li>
					</ul>
			</div>
		</div><!-- /.container-fluid -->
	</nav>


	<div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar helvetica">

		<ul class="nav menu">
			<li class="userID">
				<div class="panel panel-default">
					<div class="panel-body">
						<div class="row col-md-offset-1">
                            <p class="pull-left"><?php echo $row['completename']?></p><br>
                            <p class="pull-left"><h4 id="accounttype"><b><?php echo $row['accounttypedescription']?></b></h4></p>
						</div>
					</div>
				</div>
			</li>
			<li><a href="admindashboard.php"><svg class="glyph stroked dashboard-dial"><use xlink:href="#stroked-app-window-with-content"></use></svg> Dashboard</a></li>
			<li class="parent">
				<a href="#" data-toggle="collapse" data-target="#sub-item-1">
					<span><svg class="glyph stroked chevron-down"><use xlink:href="#stroked-chevron-down"> </use></svg></span> Attendance Monitor
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
			<li class="parent">
				<a href="#" data-toggle="collapse" data-target="#sub-item-2">
					<span><svg class="glyph stroked chevron-down"><use xlink:href="#stroked-chevron-down"></use></svg></span> Manage Users
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
			
			<li class="parent active">
			    <a href="adminhelpdesk.php"><span><svg class="glyph stroked paperclip"><use xlink:href="#stroked-paperclip"/></svg>Help Desk | FAQs</span></a>
			</li>

		</ul>

	</div><!--/.sidebar-->

	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
		<div class="row">
			<ol class="breadcrumb">
				<li><a href="admindashboard.php"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
				<li class="active">Help Desk | FAQs</li>
			</ol>
		</div><!--/.row-->

		<div class="row">
			<div class="col-lg-12">
				<h2 class="page-header">Help Desk | FAQs</h2>
			</div>
		</div><!--/.row-->

		<div class="row">

			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-body">
						<p> <font color="black">
							<h4>A. Logging in</h4>
							<ul style="list-style-type:disc">	
								<li> When the system is opened, the login page should appear
							 	<li> Enter email and password to the corresponding fields
								<li> Click "Log in" button
								<li> User should be directed to the admin dashboard
							</ul>
							<h4><font color="black">B. Logging out</font></h4>
							<ul style="list-style-type:disc">	
								<li> Click "User" located at the upper right corner
								<li> Click Log Out
							</ul>
							<h4><font color="black">C. Importing a faculty plantilla</font></h4>
							<ul style="list-style-type:disc">	
								<li> Click "Import" located at the upper right corner
								<li> A list of options will be shown, click "Import Faculty Plantilla"
								<li> Click "Choose file" to choose the plantilla to be imported
								<li> After choosing the plantilla to be imported, click "Upload Plantilla" or click "Close" to stop choosing a plantilla to be imported
								<li> After the plantilla has been imported, a window which contains the alert message, whether or not the plantilla has been imported, will pop out
							</ul>
							<h4><font color="black">D. Importing a checked rooms file</font></h4>
							<ul style="list-style-type:disc">	
								<li> Click "Import" located at the upper right corner
								<li> A list of options will be shown, click "Import Checked Rooms"
								<li> Click "Choose file" to choose the checked rooms file to be imported
								<li> After choosing the the file to be imported, click "Upload Checked Rooms" or click "Close" 	to stop choosing a plantilla to be imported
								<li>After the checked rooms has been imported, a window which contains the alert message,whether or not the checked rooms file has been imported, will pop out
							</ul>
							<h4><font color="black">E. Creating a new user</font></h4>
							<ul style="list-style-type:disc">	
								<li> Click "Manage Users" located at the left side
								<li> Click "Create User Accounts"
								<li> After clicking "Create User Accounts", a form will be shown. Fill up the necessary/required fields
								<li> After filling up the form, click "Create Account"
								<li> Admin will be asked to verify password to continue, enter password then click "Verify Account"
								<li> A notification that the user has been created will appear at the bottom of the form
							</ul>
							<h4><font color="black">F. Scheduling a make-up Class</font></h4>
							<ul style="list-style-type:disc">	
								<li> Click "Attendance Monitor" located at the left side
								<li> Click "Schedule a Class"
							 	<li> Select Course Code of the Class then click "Make-up Class"
								<li> A form will be shown, fill up the necessary/required fields
								<li> After filling up the form, click "Create Class"
								<li> A notification that the make-up class has been created will appear at the bottom of the form
							</ul>
							<h4><font color="black">G. Scheduling an alternative Class</font></h4>
							<ul style="list-style-type:disc">	
								<li> Click "Attendance Monitor" located at the left side
								<li> Click "Schedule a Class"
							 	<li> Select Course Code of the Class then click "Alternative Class"
								<li> A form will be shown, fill up the necessary/required fields
								<li> After filling up the form, click "Create Class"
								<li> A notification that the alternative class has been created will appear at the bottom of the form
							</ul>
							<h4><font color="black">H. Scheduling a Change in Time</font></h4>
							<ul style="list-style-type:disc">	
								<li> Click "Attendance Monitor" located at the left side
								<li> Click "Schedule a Class"
							 	<li> Select Course Code of the Class then click "Change in time"
								<li> A form will be shown, fill up the necessary/required fields
								<li> After filling up the form, click "Create Class"
							</ul>
							<h4><font color="black">I. Checking the details of Make-up Classes</font></h4>
							<ul style="list-style-type:disc">	
								<li> Go to the dashboard
							 	<li> On the list of make-up classes, click "Details" of a class
								<li> A window will pop out containing the details of the chosen makeup class
							 	<li> To exit the window, Click the "Close" button on the bottom right side corner of the window or the "X" icon on the upper right side corner of the window
								<li> After clicking, the window should be closed and the dashboard will be displayed again
							</ul>
							<h4><font color="black">J. Checking the details of a Room Transfer</font></h4>
							<ul style="list-style-type:disc">	
								<li> Go to the dashboard
							 	<li> On the list of Room Transfers, click "Details" of a class
								<li> A window will pop out containing the details of the chosen class
							 	<li> To exit the window, Click the "Close" button on the bottom right side corner of the window or the "X" icon on the upper right side corner of the window
								<li> After clicking, the window should be closed and the dashboard will be displayed again
							</ul>
						</font> </p>
				</div><!-- panel-body -->
			</div><!-- panel -->
		</div><!--/.col-md-12-->
	</div><!--/.row-->

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
	<div class="modal fade" id="myModalCheckedRooms">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" >&times;</button>
					<h4 class="modal-title" id="myModalLabel1">Upload Checked Rooms</h4>
				</div>
				<div class="modal-body">
					<input type="file" id="my_file_input2"/>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="button"  id='checked-button' class="btn btn-success">Upload Checked Rooms</button>
				</div>
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>
	</body>

	<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
	<script src="js/shim.js"></script>
	<script src="js/jszip.js"></script>
	<script src="js/xlsx.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/lumino.glyphs.js"></script>


	 <script src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
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

		//target = 4 means the 5th column. Column is counted from 0-nth
		//orderable means if it is sortable
		//a target with a negative number means the counting starts from the leftmost column
		$(document).ready(function(){
			$('table.data-table').DataTable({
			  "columnDefs": [
			    { "orderable": false,
			      "targets": -1 }
			  ]
			});
		});

	</script>

	<script>
    var output;
    $('input[type=file]').change(function(){
        readFile($(this).attr('id'));
    });



    function readFile(thiss) {
        var files=document.getElementById(thiss).files;

        var i,f;
        for (i = 0, f = files[i]; i != files.length; ++i) {
            var reader = new FileReader();
            var name = files[0].name;
            reader.onload = function(e) {
                var data = e.target.result;
                //var wb = XLSX.read(data, {type: 'binary'});
                var arr = String.fromCharCode.apply(null, new Uint8Array(data));
                var wb = XLSX.read(btoa(arr), {type: 'base64'});
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
	    workbook.SheetNames.forEach(function(sheetName) {
	        var roa = XLSX.utils.sheet_to_row_object_array(workbook.Sheets[sheetName]);
	        if(roa.length > 0){
	            result[sheetName] = roa;
	        }
	    });
	    return result;
	}
	$('#plantilla-button').click(function(){
		if(output){
			$.post({

		      url: 'insert.php',
		      data:output,
		      success:function(data){
		        alert(data);
		      },
		       error : function(jqXHR, textStatus, errorThrown) {

		        alert(textStatus);
		        alert(errorThrown);
		    }
		    });
		 }
		  else{
		 	alert('Failed!');
		 }
		 $('input[type=file]').val('');
		 $('#myModalPlantilla').modal('hide');
	});
	$('#checked-button').click(function(){
		if(output){
			$.post({

		      url: 'insertCheckedRooms.php',
		      data:{'data':output},
		      success:function(data){
		        alert(data);
		      },
		       error : function(jqXHR, textStatus, errorThrown) {

		        alert(textStatus);
		        alert(errorThrown);
		    }
		    });
		 }
		  else{
		 	alert('Failed!');
		 }
		 $('input[type=file]').val('');
		 $('#myModalCheckedRooms').modal('hide');
	});

	</script>



</html>

<?php
require_once '../mysql_connect.php';

session_start();

$accountNo = 2;
if(isset($_SESSION['adminemail'])){
	$_SESSION['adminemail'] = $_SESSION['user'];

	$printname = "select accountNo, concat(a.firstName,' ', a.lastName) as 'completename', ra.accounttypedescription from accounts a join ref_accounttype ra on a.accounttypeno = ra.accounttypeno where email = '{$_SESSION['adminemail']}'";
	$printresult = mysqli_query($dbc,$printname);
	$row=mysqli_fetch_array($printresult,MYSQLI_ASSOC);	

	$accountNo = $row['accountNo'];
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Attendance Tracker</title>

	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/datepicker3.css" rel="stylesheet">
	<link href="css/tableexport.css" rel="stylesheet">
	<link href="css/styles.css" rel="stylesheet">
	<link href="css/myStyle.css" rel="stylesheet">
	<link href="css/bootstrap-table.css" rel="stylesheet">
	
	<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
	<script src="js/xlsx.core.min.js"></script> 
	<script src="js/Blob.js"></script> 
	<script src="js/FileSaver.min.js"></script> 
	<script src="js/tableexport.min.js"></script> 

	<!--Icons-->
	

	<!--[if lt IE 9]>
	<script src="js/html5shiv.js"></script>
	<script src="js/respond.min.js"></script>
	<![endif]-->

</head>

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
						<a href="#" class="dropdown-toggle"  data-toggle="dropdown-m"><span style="font-size:1.2em; vertical-align:bottom;" class="glyphicon glyphicon-bell" id="notif"></span></a>
						&nbsp;
					</li>
					</ul>
			</div>
		</div><!-- /.container-fluid -->
	</nav>		
	<div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar">
		<ul class="nav menu">
			<li class="userID">			
				<div class="panel panel-default">
					<div class="panel-body">
						<div class="row col-md-offset-1">
						    <p class="pull-left"><?php echo $row['completename']?></p> <br>
                            <p class="pull-left"><h4 id="accounttype"><b><?php echo $row['accounttypedescription']?></b></h4></p>
						</div>
					</div>
				</div>					
			</li>
			<li><a href="customerindex.php"><svg class="glyph stroked dashboard-dial"><use xlink:href="#stroked-app-window-with-content"></use></svg> Dashboard</a></li>
			<li><a data-toggle="modal" href="#myModalCheckedRooms"><span class="glyphicon glyphicon-upload"></span>Upload Checked Rooms</a></li>	
			<li><a href="buildingAssignments.php"><svg class="glyph stroked eye"><use xlink:href="#stroked-eye"/></svg> Building Assignments</a></li>
			<li role="presentation" class="divider"></li>

			<li class="parent active">
			    <a href="customerhelpdesk.php"><span><svg class="glyph stroked paperclip"><use xlink:href="#stroked-paperclip"/></svg>Help Desk | FAQs</span></a>
			</li>
		</ul>

	</div><!--/.sidebar-->

	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			
		<div class="row">
			<ol class="breadcrumb">
				<li><a href="#"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
                <li class="active"><a href="customerhelpdesk.php">Help Desk | FAQs </a></li>
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
						<p><font color="black"> 
						<h4>A. Logging in</h4>
						<ul style="list-style-type:disc">	
							<li> When the system is opened, the login page should appear </li>
						 	<li> Enter email and password to the corresponding fields </li>
							<li> Click "Log in" button </li>
							<li> User should be directed to the checker dashboard </li>
						</ul>
						<h4><font color="black">B. Logging out </font></h4>
						<ul style="list-style-type:disc">
							<li> Click "User" located at the upper right corner </li> 
							<li> Click Log Out </li> 
						</ul>
						<h4><font color="black">C. Checking the details of Alternative Classes</font></h4>
						<ul style="list-style-type:disc">
							<li> Go to the dashboard
						 	<li> On the list of alternative classes, click "Details" of a class
							<li> A window will pop out containing the details of the chosen alternative class
							<li> To exit the window, Click the "Close" on the bottom right side corner of the window or the "X" icon on the upper right side corner of the window
						 	<li> After clicking, the window should be closed and the dashboard will be displayed again
						 </ul> 
						<h4><font color="black">D. Viewing of Building Assignments</font></h4> 
						<ul style="list-style-type:disc">
							<li> Click "Building Assignments" located at the left side
							<li> The list of assigned buildings for a checker will be displayed for that day
						</ul>
						<h4><font color="black">E. Viewing of Assigned Classes</font></h4>
						<ul style="list-style-type:disc">
							<li> Click "Building Assignments" located at the left side
							<li> The list of assigned buildings for a checker will be displayed for that day
							<li> On the list of building assignments, Click the "Details" of a building
							<li> A window will pop out that contains all of the classes a checker should monitor that day
						 	<li> To exit the list of assigned classes for that day, Click the "Close" button on the bottom right corner of the window
							<li> After clicking, the window should be closed and the Building assignments will be displayed again
						</ul>
						<h4><font color="black">F. Exporting the list of assigned classes for today in excel format</font></h4>
						<ul style="list-style-type:disc">
							<li> Click "Building Assignments" located at the left side/sidebar
							<li> The list of assigned buildings for a checker will be displayed for that day
							<li> On the list of building assignments, Click the "Details" of a building
							<li> A window will pop out that contains all of the classes a checker should monitor that day
							<li> Click the "Export to xlsx" to download/export the excel file containing the assigned classes for the day
							<li> To exit the window, click "Close" on the bottom right side corner of the window
						</ul>
						<h4><font color="black">G. Upload checked rooms</font></h4>
						<ul style="list-style-type:disc">
							<li> Click "Upload Checked Rooms" located at the left side/sidebar
							<li> Click "Choose file" to choose the file to be imported/uploaded
							<li> After choosing the file to be imported, click "Upload Checked Rooms" or click "Close" to stop choosing a plantilla to be imported
							<li> After the file has been imported, a window which contains the alert message, whether or not the file has been imported, will pop out
						</ul>
						</font></p>	
				</div>
			</div>
		</div>
	</div>	
</div><!--/.col-->

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

<script src="js/jquery.tabletoCSV.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/shim.js"></script>
<script src="js/jszip.js"></script>
<script src="js/xlsx.js"></script>
<script src="js/bootstrap-table.js"></script>
<script src="js/lumino.glyphs.js"></script>


<script>
var time, building,date,d;

var table = $(".export_table").tableExport({
	formats: ["xlsx"],
	fileName: date,
	position:"top",
	bootstrap:false
});


$('table').on('click','button.details-button',function(){
	console.log('asd');
	time = $(this).closest('tr').find('td:first-child').html();
	console.log(time);
	building = $(this).closest('tr').find('td:nth-child(2)').html();
	console.log(building);
	d = new Date();
    date = d.toDateString();
    date = time + ' - '+building + ' - '+ date;
    console.log(date);

    
	

	table.update({
		headings:true,
		footer:true,
		fileName: date,
		position:"bottom",

	});

  	$('button').addClass("btn btn-primary btn-xs").css({'color':'white','font-size':'12px','position':"right"});
});

$('button').addClass("btn btn-primary btn-xs").css({'color':'white','font-size':'12px','position':"right"});





   
</script>
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

		      url: '/swengg/attendancecheck/insert.php',
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

		      url: '/swengg/attendancecheck/insertCheckedRooms.php',
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

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
<script src="js/lumino.glyphs.js"></script>

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
			</div>
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
	
	<div class="modal fade" id="myModalCheckedRooms" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title" id="myModalLabel">Upload Plantilla</h4>
				</div>
				<div class="modal-body">
					<input type="file">
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-success">Upload Plantilla</button>
				</div>
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>
	<!-- /.modal -->
		
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
			<li class="active"><a href="admindashboard.php"><svg class="glyph stroked dashboard-dial"><use xlink:href="#stroked-dashboard-dial"></use></svg> Dashboard</a></li>
			<li class="parent">
				<a href="#" data-toggle="collapse" data-target="#sub-item-1">
					<span><svg class="glyph stroked chevron-down"><use xlink:href="#stroked-chevron-down"> </use></svg></span> Attendance Monitor 
				</a>
				<ul class="children collapse" id="sub-item-1"> 
					<li>
						<a class="" href="makeupClass.php">
							<svg class="glyph stroked chevron-right"><use xlink:href="#stroked-chevron-right"></use></svg> Add Alternative Class
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
				<h1 class="page-header">Dashboard</h1>
			</div>
		</div><!--/.row-->		
		
		<div class="row">

			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-heading">Alternative Classes List</div>
					<div class="panel-body">
						<table data-toggle="table" id="data-table" >
						    <thead>
						    <tr>
								<th data-field="room">Room</th>
						        <th data-field="fname">Faculty</th>
						        <th data-field="department">Class Time</th>
						        <th data-field="remarks">Class Date</th>
								<th data-field="actions">Class Details</th>
						    </tr>
						    </thead>
							<tbody>
								<?php
									date_default_timezone_set('UTC');  
									$query = "SELECT fmu.coursecode as course, fmu.section as section, MONTH(fmu.absentdate) as abmonth, DAY(fmu.absentdate) as abday,
													 YEAR(fmu.absentdate) as abyear, concat(p.starttime,' - ',p.endtime) as abtime,
													 concat(f.firstname, ' ', f.lastname) as facultyname, fmu.makeupdate as altdate, MONTH(fmu.makeupdate) as altmonth, 
                                                     DAY(fmu.makeupdate) as altday, YEAR(fmu.makeupdate) as altyear,fmu.makeuproom as altroom, 
                                                     concat(fmu.makeupstarttime,' - ',fmu.makeupendtime) as alttime
												FROM mv_facultymakeup fmu join faculty f
																			on fmu.facultyid = f.facultyid
																		  join plantilla p
																		    on fmu.coursecode = p.coursecode
											   WHERE fmu.makeupdate >= CURDATE()
                                               group by 1,2,3,4,5,6,7,8,9,10,11,12,13;";
									
									$result = mysqli_query($dbc, $query);
									

									
									if($result){
										
										
										$count = 0;
										while($row = mysqli_fetch_array($result, MYSQLI_ASSOC) ){
											echo '<tr>';
											echo "<td>{$row['altroom']}</td>";
											echo "<td>{$row['facultyname']}</td>";
											echo "<td>{$row['alttime']}</td>";
											echo "<td>"; 
											echo date('F j Y D', mktime(0, 0, 0, $row['altmonth'], $row['altday'], $row['altyear'] )); 
											echo "</td>";
										
											echo "<td>
													<button class=\"btn btn-primary btn-xs\" data-toggle=\"modal\" data-target=\"#myModal$count\">
														Details
													</button>
													<!-- Modal -->
													<div class=\"modal fade\" id=\"myModal$count\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"myModalLabel\" aria-hidden=\"true\">
														<div class=\"modal-dialog\">
															<div class=\"modal-content\">
																<div class=\"modal-header\">
																	<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-hidden=\"true\">&times;</button>
																	<h4 class=\"modal-title\" id=\"myModalLabel\">Alternative class</h4>
																</div>
																<div class=\"modal-body\">
																	<ul class=\"list-group\" style=\"text-align:left;\">
																	  <li class=\"list-group-item\"><b>Subject:</b> {$row['course']}</li>
																	  <li class=\"list-group-item\"><b>Missed Class Schedule:</b>"; echo date('F j Y D', mktime(0, 0, 0, $row['abmonth'], $row['abday'], $row['abyear'] )).' '; echo "{$row['abtime']}</li>
																	  <li class=\"list-group-item\"><b>Alternative Class Schedule:</b>"; echo date('F j Y D', mktime(0, 0, 0, $row['altmonth'], $row['altday'], $row['altyear'] )).' '; echo "{$row['alttime']}</li>
																	  <li class=\"list-group-item\"><b>Scheduled Room:</b> {$row['altroom']}</li>
																	</ul>
																<div class=\"modal-footer\">
																	<button type=\"button\" class=\"btn btn-default\" data-dismiss=\"modal\">Close</button>
																</div>
															</div>
															<!-- /.modal-content -->
														</div>
														<!-- /.modal-dialog -->
													</div>
													<!-- /.modal -->
												</td>";  
											$count++;
											echo '</tr>';
										}
										
										
									}
									
								?>
								
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div><!--/.row-->	
				
		
		
							
			</div><!--/.col-->
		</div><!--/.row-->
	</div>	<!--/.main-->

	<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
	<script src="js/shim.js"></script>
<script src="js/jszip.js"></script>
<script src="js/xlsx.js"></script>
	<script src="js/bootstrap.min.js"></script>
		

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
		$('#data-table').DataTable({
		  "columnDefs": [
		    { "orderable": false, 
		      "targets": 4 }
		  ]
		} );
		
	
		

	</script>	

<script>
    var output;
    $('#my_file_input').change(function(){
        readFile();
    });
    

    function readFile() {
        var files=document.getElementById('my_file_input').files;

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
	    },
	     /*dataType: 'json'*/
	    }).done(function() {
	        alert( "second success" );
	    })
	    .fail(function() {
	        alert( "error" );
	    })
	    .always(function() {
	        alert( "finished" );
	    });
	 }
	 $('#myModalPlantilla').modal('hide');
});
    
</script>
</body>

</html>

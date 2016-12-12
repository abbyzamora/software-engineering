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

	$checkedRooms = "SELECT CONCAT(P.STARTTIME, ' - ',P.ENDTIME) AS T, P.roomCode, P.courseCode, CONCAT(F.FIRSTNAME, ' ',F.LASTNAME) AS FACULTYNAME, FA.ATTENDANCECODE, FA.REMARKS, RD.departmentName
  FROM (SELECT MA.COURSECODE, MA.FACULTYID, MA.DAYID, MA.SCHOOLYEAR, MA.TERM, MA.SECTION, MA.attendanceCode, MA.REMARKS
		  FROM FORM_ATTENDANCE FA JOIN MV_ATTENDANCE MA
									ON FA.FORMID = MA.FORMID
		 WHERE FA.DATE = CURDATE() ) FA JOIN PLANTILLA P
									 ON FA.COURSECODE = P.COURSECODE AND FA.FACULTYID = P.FACULTYID AND FA.DAYID = P.DAYID AND FA.SCHOOLYEAR = P.SCHOOLYEAR AND FA.TERM = P.TERM AND FA.SECTION = P.SECTION
									JOIN FACULTY F
                                      ON P.FACULTYID = F.FACULTYID
                                    JOIN REF_Department RD
                                      on F.departmentID = RD.departmentID;";
    $checkRow = mysqli_query($dbc,$checkedRooms);
	  
	
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


                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <svg class="glyph stroked male-user">
                                    <use xlink:href="#stroked-male-user"></use>
                                </svg> User <span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li>
                                    <a href="login.php">
                                        <svg class="glyph stroked cancel">
                                            <use xlink:href="#stroked-cancel"></use>
                                        </svg> Log out</a>
                                </li>
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
            </div>
            <!-- /.container-fluid -->
        </nav>


        <div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar helvetica">

            <ul class="nav menu">
                <li class="userID">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="row col-md-offset-1">
                                <p class="pull-left">
                                    <?php echo $row['completename']?>
                                </p> <br>
                                <p class="pull-left">
                                    <h4 id="accounttype"><b><?php echo $row['accounttypedescription']?></b></h4></p>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="parent">
                    <a href="admindashboard.php">
                        <svg class="glyph stroked dashboard-dial">
                            <use xlink:href="#stroked-app-window-with-content"></use>
                        </svg> Dashboard</a>
                </li>
                <li class="parent active">
                    <a href="#" data-toggle="collapse" data-target="#sub-item-1">
                        <span><svg class="glyph stroked chevron-down"><use xlink:href="#stroked-chevron-down"> </use></svg></span> Attendance Monitor
                    </a>
                    <ul class="children" id="sub-item-1">
                        <li>
                            <a href="scheduleclass.php">
                                <svg class="glyph stroked chevron-right">
                                    <use xlink:href="#stroked-chevron-right"></use>
                                </svg> Schedule a Class
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
                                <svg class="glyph stroked chevron-right">
                                    <use xlink:href="#stroked-chevron-right"></use>
                                </svg> Create new user account
                            </a>
                        </li>
                    </ul>
                </li>

                <li role="presentation" class="divider"></li>

                <li class="parent">
                    <a href="adminhelpdesk.php"><span><svg class="glyph stroked paperclip"><use xlink:href="#stroked-paperclip"/></svg>Help Desk | FAQs</span></a>
                </li>

            </ul>

        </div>
        <!--/.sidebar-->

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
                    <li>Attenance Tracker</li>
                    <li class="active"><a href="viewCheckedRooms.php">View Checked Roooms</a></li>
                </ol>
            </div>
            <!--/.row-->

            <div class="row">
                <div class="col-lg-12">
                    <h2 class="page-header">View Checked Rooms</h2>
                </div>
            </div>
            <!--/.row-->

            <div class="row">

                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <table data-toggle="table" class="data-table">
                                <thead>
                                    <tr>
                                        <th data-field="room">Time</th>
                                        <th data-field="room">Room</th>
                                        <th data-field="fname">Course</th>
                                        <th data-field="faculty">Faculty Name</th>
                                        <th data-field="department">Department Name</th>
                                        <th data-field="remarks">Code</th>
                                        <th data-field="actions">Remarks</th>
                                    </tr>
                                </thead>
                                <tbody>
                                	<?php foreach($checkRow as $cr){ ?>

                                    <tr>
                                    	<td><?php echo $cr['T']; ?></td>
                                    	<td><?php echo $cr['roomCode'];?></td>
                                    	<td><?php echo $cr['courseCode'];?></td>
                                    	<td><?php echo $cr['FACULTYNAME'];?></td>
                                    	<td><?php echo $cr['departmentName'];?></td>
                                    	<td><?php echo $cr['attendanceCode'];?></td>
                                    	<td><?php echo $cr['REMARKS'];?></td>

                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>


                        </div>
                        <!-- panel-body -->
                    </div>
                    <!-- panel -->
                </div>
                <!--/.col-md-12-->
            </div>
            <!--/.row-->
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
        ! function ($) {
            $(document).on("click", "ul.nav li.parent > a > span.icon", function () {
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
        $(document).ready(function () {
            $('table.data-table').DataTable({
                "columnDefs": [
                    {
                        "orderable": false,
                        "targets": -1
                    }
			  ]
            });
        });
    </script>

    <script>
        var output;
        $('input[type=file]').change(function () {
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

                    url: '/swengg/attendancecheck/insert.php',
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
                $.post({

                    url: '/swengg/attendancecheck/insertCheckedRooms.php',
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



</html>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Attendance Tracker</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/datepicker3.css" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet">
    <link href="css/bootstrap-table.css" rel="stylesheet">
    <link href="css/myStyle.css" rel="stylesheet">

    <!--Icons-->


</head>
<?php
	session_start();
	$_SESSION['adminemail'] = $_SESSION['user'];
	require_once('../mysql_connect.php');
	$printname = "select concat(a.firstName, ' ', a.lastName) as 'completename', ra.accounttypedescription from accounts a join ref_accounttype ra on a.accounttypeno = ra.accounttypeno where email = '{$_SESSION['adminemail']}'";
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


                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <svg class="glyph stroked male-user">
                                    <use xlink:href="#stroked-male-user"></use>
                                </svg> User <span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li>
                                    <a href="#">
                                        <svg class="glyph stroked male-user">
                                            <use xlink:href="#stroked-male-user"></use>
                                        </svg> Profile</a>
                                </li>
                                <li>
                                    <a href="#">
                                        <svg class="glyph stroked gear">
                                            <use xlink:href="#stroked-gear"></use>
                                        </svg> Settings</a>
                                </li>
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
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"> Import <span class="caret"></span></a>
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
                                <p class="pull-left">
                                    <?php echo $row['accounttypedescription']?>
                                </p>
                            </div>
                        </div>
                    </div>
                </li>
                <li>
                    <a href="admindashboard.php">
                        <svg class="glyph stroked dashboard-dial">
                            <use xlink:href="#stroked-dashboard-dial"></use>
                        </svg> Dashboard</a>
                </li>
                <li class="parent">
                    <a href="#" data-toggle="collapse" data-target="#sub-item-1">
                        <span><svg class="glyph stroked chevron-down"><use xlink:href="#stroked-chevron-down"></use></svg></span> Attendance Monitor
                    </a>
                    <ul class="children collapse" id="sub-item-1">
                        <li>
                            <a class="" href="makeUpClass.php">
                                <svg class="glyph stroked chevron-right active">
                                    <use xlink:href="#stroked-chevron-right"></use>
                                </svg> Add Alternative Class
                            </a>
                        </li>

                    </ul>
                </li>
                <li class="parent">
                    <a href="#" data-toggle="collapse" data-target="#sub-item-2">
                        <span data-toggle="collapse" href="#sub-item-2"><svg class="glyph stroked chevron-down"><use xlink:href="#stroked-chevron-down"></use></svg></span> Manage Users
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
                <li class="parent active">
                    <a href="#">
                        <span class="glyphicon glyphicon-download-alt" aria-hidden="true"></span> Download Excel File
                    </a>
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
                    <li>Attendance Monitor</li>
                    <li class="active"><a href="downloadExcelfile.php">Download Excel File</a></li>
                </ol>
            </div>
            <!--/.row-->


            <div class="row">
                <div class="panel panel-default">
                    <div class="panel-heading">Download Excel File</div>
                    <div class="panel-body">
                        <button type="button" class="btn btn-default btn-lg">
                            <span class="glyphicon glyphicon-download-alt" aria-hidden="true"></span>  Download Excel File
                        </button>

                    </div>
                </div>
            </div>
            <!--/.row-->
        </div>
        <!--/.main-->

        <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>

        <script src="js/shim.js"></script>
        <script src="js/jszip.js"></script>
        <script src="js/xlsx.js"></script>
        <script src="js/lumino.glyphs.js"></script>
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

                        url: '/Swengg/attendancecheck/insert.php',
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
        <script src="js/bootstrap.min.js"></script>
        <!-- <script src="js/chart.min.js"></script>
	<script src="js/chart-data.js"></script>
	<script src="js/easypiechart.js"></script>
	<script src="js/easypiechart-data.js"></script> -->
        <script src="js/bootstrap-datepicker.js"></script>
        <script src="js/bootstrap-table.js"></script>
        <script>
            $('.calendar').datepicker();

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
        </script>

    </body>

</html>
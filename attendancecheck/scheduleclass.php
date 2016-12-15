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
    date_default_timezone_set('Asia/Manila'); 
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
                                    <h4 id="accounttype"><?php echo $row['accounttypedescription']?></h4>
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
                <li class="parent active">
                    <a href="#" data-toggle="collapse" data-target="#sub-item-1">
                        <span><svg class="glyph stroked chevron-down"><use xlink:href="#stroked-chevron-down"></use></svg></span> Attendance Monitor
                    </a>
                    <ul class="children collapse" id="sub-item-1">
                        <li>
                            <a class="" href="makeUpClass.php">
                                <svg class="glyph stroked chevron-right active">
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
                    <li class="active"><a href="scheduleclass.php">Schedule Class</a></li>
                </ol>
            </div>
            <!--/.row-->


            <div class="row">
                <div class="panel panel-default">
                    <div class="panel-heading">Schedule a Class</div>
                    <div class="panel-body">
                        <form role="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                            <div class="col-md-12">
                                <center>
                                <div class="col-md-3">
                                    <select name = "coursecode" class="form-control" required>
                                        <?php
                                            $query = "SELECT C.COURSECODE AS 'COURSECODE'
                                                        FROM PLANTILLA C 
                                                        WHERE TERM = (SELECT MAX(TERM) from plantilla where schoolyear = YEAR(CURDATE()))
                                                        GROUP BY 1";
                                            $printresult = mysqli_query($dbc,$query);
                                            echo "<option value=''>--Select Course Code--</option>";
                                                while($row=mysqli_fetch_array($printresult,MYSQLI_ASSOC)){
                                                    $courseCode = $row['COURSECODE'];
                                                    if ($courseCode == $_POST['coursecode']){
                                                        echo "<option value='$courseCode' selected='selected'> $courseCode </option>";
                                                    } else {
                                                        echo "<option value='$courseCode'> $courseCode </option>";
                                                    }
                                                }
                                            
                                            
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-3" style="margin-right:-140px">
                                    <button type="submit" class="btn btn-default" name="makeup">Make-up Class</button>
                                </div>
                                <div class="col-md-3" style="margin-right:-140px">
                                    <button type="submit" class="btn btn-default" name="sub">Substitution</button>
                                </div>
                                <div class="col-md-3" style="margin-right:-130px">
                                    <button type="submit" class="btn btn-default" name="transfer">Room Transfer</button>
                                </div>
                                <div class="col-md-3" style="margin-right:-120px">
                                    <button type="submit" class="btn btn-default" name="changetime">Change in time</button>
                                </div>
                                <div class="col-md-3" style="margin-right:-140px">
                                    <button type="submit" class="btn btn-default" name="alternative">Alternative Class</button>
                                </div>
                                </center>
                            </div>
                        </form> <br><br><br>
                        <?php
                            if(isset($_POST['makeup'])){
                            $_SESSION['coursecode'] = $_POST['coursecode'];
                            echo   '<form method="post">
                                        <div class="form-group col-md-12"> 
                                            <div class="col-md-1">
                                                <label> Section: </label>
                                            </div>
                                            <div class="col-md-2">
                                                <select name="section" class="form-control" required>
                                                    <option value=""></option>';
                                                    // Get Latest School year and Term
                                                    $section = "SELECT section from plantilla 
                                                                where coursecode = '{$_SESSION['coursecode']}'
                                                                and TERM = (SELECT MAX(TERM) from plantilla where schoolyear = YEAR(CURDATE()))
                                                                group by section";
                                                    $getsection = mysqli_query($dbc, $section);
                                                    
                                                    while ($row = mysqli_fetch_array($getsection, MYSQLI_ASSOC)){
                            echo                   '<option value='.$row['section'].'>'.$row['section'].'</option>';
                                                    }
                           
                            echo               '</select>
                                            </div>
                                            <div class="col-md-1">
                                                <label>Scheduled Classroom:</label>
                                            </div>
                                            <div class="col-md-2">
                                                <input class="form-control" name="room" type="text" value="" required>
                                            </div>
                                            <div class="col-md-2">
                                                <label>Reason for the Missed Class: </label>
                                            </div>
                                            <div class="col-md-4">
                                                <select name = "reason" class="form-control" required>
                                                    <option value=""></option>';
                                                    $absent = "SELECT absentdescription as 'desc', absentcode as 'code'
                                                                FROM ref_absentreason";
                                                    $printabsent = mysqli_query($dbc,$absent);
                                                    while($row2=mysqli_fetch_array($printabsent,MYSQLI_ASSOC)){
                                                        $name = $row2['code'];
                                                        $desc = $row2['desc'];
                                                        echo "<option value='$name'> $desc </option>";
                                                    }

                            echo               '</select>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <div class="col-md-2">
                                                <label>Missed Class Date:</label>
                                            </div>
                                            <div class="col-md-4">
                                                <input class="form-control" class="date" name="misseddate" type="date" required>
                                            </div>
                                            <div class="col-md-2">
                                                <label>Make-up Class Date: </label>
                                            </div>
                                            <div class="col-md-4">
                                                <input class="form-control" class="date" name="makeupdate" type="date" required>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <div class="col-md-3 col-md-offset-2">
                                                <label>Make-up Class Start Time:</label>
                                            </div>
                                            <div class="col-md-2">
                                                <select name="mustarthour" class="form-control" required>
                                                    <option value="">HH</option>
                                                    <option value="07">07</option>
                                                    <option value="08">08</option>
                                                    <option value="09">09</option>
                                                    <option value="10">10</option>
                                                    <option value="11">11</option>
                                                    <option value="12">12</option>
                                                    <option value="13">13</option>
                                                    <option value="14">14</option>
                                                    <option value="15">15</option>
                                                    <option value="16">16</option>
                                                    <option value="17">17</option>
                                                    <option value="18">18</option>
                                                    <option value="19">19</option>
                                                    <option value="20">20</option>
                                                </select>
                                            </div>
                                            <div class="col-md-2">
                                                <select name="mustartminute" class="form-control" required>
                                                    <option value="">MM</option>
                                                    <option value="00">00</option>
                                                    <option value="15">15</option>
                                                    <option value="30">30</option>
                                                    <option value="45">45</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <center>
                                               <button type="submit" class="btn btn-primary" name="addmakeup">Create Class</button> 
                                            </center>
                                        </div>';
                            echo   '</form>';

                            
                            
                            }

                            

                            if (isset($_POST['sub'])){
                                $_SESSION['coursecode'] = $_POST['coursecode'];
                                echo '<form method="post">
                                        <div class="form-group col-md-12">
                                            <div class="col-md-1">
                                                <label> Section: </label>
                                            </div>
                                            <div class="col-md-2">
                                                <select name="section" class="form-control" required>
                                                    <option value=""></option>';
                                                    // Get Latest Term and Schoolyear
                                                    $section = "SELECT section from plantilla 
                                                    where coursecode = '{$_SESSION['coursecode']}'
                                                    and TERM = (SELECT MAX(TERM) from plantilla where schoolyear = YEAR(CURDATE())) 
                                                    group by section";
                                                    $getsection = mysqli_query($dbc, $section);
                                                    
                                                    while ($row = mysqli_fetch_array($getsection, MYSQLI_ASSOC)){
                                echo                   '<option value='.$row['section'].'>'.$row['section'].'</option>';
                                                    }
                                echo        '   </select>
                                            </div> 
                                            <div class="col-md-2">
                                                <label> Class Date: </label>
                                            </div>
                                            <div class="col-md-3">
                                                <input type="date" name="subdate" class="form-control" required>
                                            </div>
                                            <div class="col-md-1">
                                                <label> Substitute Faculty: </label>
                                            </div>
                                            <div class="col-md-3">
                                                <select name="facultysub" class="form-control" required>
                                                    <option value=""></option>';

                                                    $faculty = "SELECT facultyid from plantilla where coursecode = '{$_SESSION['coursecode']}'";
                                                    $getfaculty = mysqli_query($dbc, $faculty);
                                                    $row10 = mysqli_fetch_array($getfaculty, MYSQLI_ASSOC);

                                                    $facultydept = "SELECT rd.departmentid as deptid from ref_department rd join faculty f
                                                                    on rd.departmentid = f.departmentid where facultyid = '{$row10['facultyid']}'";
                                                    $getfacultydept = mysqli_query($dbc, $facultydept);
                                                    $row11 = mysqli_fetch_array($getfacultydept, MYSQLI_ASSOC);

                                                    $dept = "SELECT f.facultyid, concat(f.firstname, ' ', f.lastname) as facultyname from faculty f join ref_department rd
                                                            on rd.departmentid = f.departmentid where rd.departmentid = '{$row11['deptid']}'
                                                            and f.facultyid != '{$row10['facultyid']}'";
                                                    $getdept = mysqli_query($dbc, $dept);

                                                    while ($row9 = mysqli_fetch_array($getdept, MYSQLI_ASSOC)){
                                                        echo '<option value="'.$row9['facultyid'].'">'.$row9['facultyname'].'</option>';
                                                    }
                                echo            '</select>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <center>
                                            <button type="submit" class="btn btn-primary" name="substitution"> Create Class </button>
                                            </center>
                                        </div>';

                                echo '</form>';
                            }

                            if (isset($_POST['transfer'])){
                                $_SESSION['coursecode'] = $_POST['coursecode'];
                                echo '<form method="post">
                                        <div class="form-group col-md-12">
                                            <div class="col-md-1">
                                                <label> Section: </label>
                                            </div>
                                            <div class="col-md-2">
                                                <select name="section" class="form-control" required>
                                                    <option value=""></option>';
                                                    $section = "SELECT section from plantilla 
                                                                where coursecode = '{$_SESSION['coursecode']}' 
                                                                and TERM = (SELECT MAX(TERM) from plantilla where schoolyear = YEAR(CURDATE())) 
                                                                group by section";
                                                    $getsection = mysqli_query($dbc, $section);
                                                    
                                                    while ($row = mysqli_fetch_array($getsection, MYSQLI_ASSOC)){
                                echo                   '<option value='.$row['section'].'>'.$row['section'].'</option>';
                                                    }
                                echo        '   </select>
                                            </div> 
                                            <div class="col-md-2">
                                                <label> Transfer Room: </label>
                                            </div>
                                            <div class="col-md-2">
                                                <input type="text" name="room" class="form-control" required>
                                            </div>
                                            <div class="col-md-2"> 
                                                <label> Transfer Date: </label>
                                            </div>
                                            <div class="col-md-3">
                                                <input type="date" name="transferdate" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-md-offset-3">
                                            <div class="col-md-3">
                                                <label> <input type="radio" name="type" id="optionsRadios1" value="RT"> Temporary Transfer </label>
                                            </div>
                                            <div class="col-md-3">
                                                <label> <input type="radio" name="type" id="optionsRadios1" value="PR"> Permanent Transfer </label>
                                            </div>
                                            
                                        </div>
                                        <div class="col-md-12"> <br> 
                                            <center>
                                            <button type="submit" class="btn btn-primary" name="transferred"> Create Class </button>
                                            </center>
                                        </div>';
                                echo '</form>';
                            }


                            if (isset($_POST['changetime'])){
                                $_SESSION['coursecode'] = $_POST['coursecode'];
                                echo '<form method="post">
                                        <div class="form-group col-md-12">
                                            <div class="col-md-1">
                                                <label> Section: </label>
                                            </div>
                                            <div class="col-md-2">
                                                <select name="section" class="form-control" required>
                                                    <option value=""></option>';
                                                    $section = "SELECT section from plantilla 
                                                                where coursecode = '{$_SESSION['coursecode']}' 
                                                                and TERM = (SELECT MAX(TERM) from plantilla where schoolyear = YEAR(CURDATE())) 
                                                                group by section";
                                                    $getsection = mysqli_query($dbc, $section);
                                                    
                                                    while ($row = mysqli_fetch_array($getsection, MYSQLI_ASSOC)){
                            echo                   '<option value='.$row['section'].'>'.$row['section'].'</option>';
                                                    }
                           
                            echo               '</select>
                                            </div>
                                            <div class="col-md-2">
                                                <label> Scheduled Room: </label>
                                            </div>
                                            <div class="col-md-2">
                                                 <input class="form-control" name="room" type="text" required>
                                            </div>
                                            <div class="col-md-2">
                                                <label> Alternative Class Date: </label>
                                            </div>
                                            <div class="col-md-3">
                                                <input class="form-control" class="date" name="altdate" type="date" required>
                                            </div>
                                        </div>  
                                        <div class="form-group col-md-12">
                                            <div class="col-md-3">
                                                <label>Alternative Class Start Time:</label>
                                            </div>
                                            <div class="col-md-2">
                                                <select name="altstarthour" class="form-control" required>
                                                    <option value="">HH</option>
                                                    <option value="07">07</option>
                                                    <option value="08">08</option>
                                                    <option value="09">09</option>
                                                    <option value="10">10</option>
                                                    <option value="11">11</option>
                                                    <option value="12">12</option>
                                                    <option value="13">13</option>
                                                    <option value="14">14</option>
                                                    <option value="15">15</option>
                                                    <option value="16">16</option>
                                                    <option value="17">17</option>
                                                    <option value="18">18</option>
                                                    <option value="19">19</option>
                                                    <option value="20">20</option>
                                                </select>
                                            </div>
                                            <div class="col-md-2">
                                                <select name="altstartminute" class="form-control" required>
                                                    <option value="">MM</option>
                                                    <option value="00">00</option>
                                                    <option value="15">15</option>
                                                    <option value="30">30</option>
                                                    <option value="45">45</option>
                                                </select>
                                            </div>
                                            <div class="col-md-2">
                                                <label>Change in Time:</label>
                                            </div>
                                            <div class="col-md-3">
                                                <input class="form-control" class="date" name="change" type="date" required>
                                            </div>  
                                        </div>
                                        <center>
                                           <button type="submit" class="btn btn-primary" name="addchange">Create Class</button> 
                                        </center> ';
                                echo '</form>';
                            }

                            if (isset($_POST['alternative'])){
                                // Radio Button on Type of Class
                                $_SESSION['coursecode'] = $_POST['coursecode'];
                                echo '<form method="post">
                                        <div class="form-group col-md-12">
                                            <div class="col-md-1">
                                                <label> Section: </label>
                                            </div>
                                            <div class="col-md-2">
                                                <select name="section" class="form-control" required>
                                                    <option value=""></option>';
                                                    $section = "SELECT section from plantilla 
                                                                where coursecode = '{$_SESSION['coursecode']}' 
                                                                and TERM = (SELECT MAX(TERM) from plantilla where schoolyear = YEAR(CURDATE())) 
                                                                group by section";
                                                    $getsection = mysqli_query($dbc, $section);
                                                    
                                                    while ($row = mysqli_fetch_array($getsection, MYSQLI_ASSOC)){
                            echo                   '<option value='.$row['section'].'>'.$row['section'].'</option>';
                                                    }
                           
                            echo               '</select>
                                            </div>
                                            <div class="col-md-2">
                                                <label> Venue: </label>
                                            </div>
                                            <div class="col-md-2">
                                                <input type="text" name="venue" required class="form-control">
                                            </div>
                                            <div class="col-md-2">
                                                <label> Alternative Class Date: </label>
                                            </div>
                                            <div class="col-md-3">
                                                <input class="form-control" class="date" name="altdate" type="date" required>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <div class="col-md-2">
                                                <label>Alternative Class Start Time:</label>
                                            </div>
                                            <div class="col-md-2">
                                                <select name="altstarthour" class="form-control" required>
                                                    <option value="">HH</option>
                                                    <option value="07">07</option>
                                                    <option value="08">08</option>
                                                    <option value="09">09</option>
                                                    <option value="10">10</option>
                                                    <option value="11">11</option>
                                                    <option value="12">12</option>
                                                    <option value="13">13</option>
                                                    <option value="14">14</option>
                                                    <option value="15">15</option>
                                                    <option value="16">16</option>
                                                    <option value="17">17</option>
                                                    <option value="18">18</option>
                                                    <option value="19">19</option>
                                                    <option value="20">20</option>
                                                </select>
                                            </div>
                                            <div class="col-md-2">
                                                <select name="altstartminute" class="form-control" required>
                                                    <option value="">MM</option>
                                                    <option value="00">00</option>
                                                    <option value="15">15</option>
                                                    <option value="30">30</option>
                                                    <option value="45">45</option>
                                                </select>
                                            </div>
                                            <div class="col-md-2">
                                                <label>Alternative Class End Time:</label>
                                            </div>
                                            <div class="col-md-2">
                                                <select name="altendhour" class="form-control" required>
                                                    <option value="">HH</option>
                                                    <option value="07">07</option>
                                                    <option value="08">08</option>
                                                    <option value="09">09</option>
                                                    <option value="10">10</option>
                                                    <option value="11">11</option>
                                                    <option value="12">12</option>
                                                    <option value="13">13</option>
                                                    <option value="14">14</option>
                                                    <option value="15">15</option>
                                                    <option value="16">16</option>
                                                    <option value="17">17</option>
                                                    <option value="18">18</option>
                                                    <option value="19">19</option>
                                                    <option value="20">20</option>
                                                </select>
                                            </div>
                                            <div class="col-md-2">
                                                <select name="altendminute" class="form-control" required>
                                                    <option value="">MM</option>
                                                    <option value="00">00</option>
                                                    <option value="15">15</option>
                                                    <option value="30">30</option>
                                                    <option value="45">45</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="col-md-2 col-md-offset-3">
                                                <label> Class Type: </label>
                                            </div>
                                            <div class="col-md-2">
                                                <label> <input type="radio" name="type" id="optionsRadios1" value="FT"> Field Trip </label>
                                            </div>
                                            <div class="col-md-2">
                                                <label> <input type="radio" name="type" id="optionsRadios1" value="AC"> Others</label>
                                            </div>
                                        </div> 
                                        <div class="form-group col-md-12">
                                            <center><br>
                                               <button type="submit" class="btn btn-primary" name="addalternative">Create Class</button> 
                                            </center> 
                                        </div>';
                                echo '</form>';
                            }
                        ?>
                        <?php
                            if (isset($_POST['addmakeup'])){
                                $message = NULL;
                                $_SESSION['section'] = $_POST['section'];
                                $_SESSION['reason'] = $_POST['reason'];

                                $roomquery = "SELECT R.ROOMCODE as ROOM
                                           FROM ROOM R
                                          WHERE '{$_POST['room']}' = R.ROOMCODE";
                                $printroom = mysqli_query($dbc,$roomquery);
                                $row2 = mysqli_fetch_array($printroom, MYSQLI_ASSOC);
                                if($row2['ROOM'] != NULL){
                                    $_SESSION['room'] = $_POST['room'];
                                }
                                else{
                                    $_SESSION['room'] = NULL;
                                    $message.="<p>Invalid room code";
                                }

                                $date = new DateTime($_POST['misseddate']);
                                $day = date_format($date, 'd');
                                $month = date_format($date, 'm');
                                $year = date_format($date, 'Y');
                                if (date('D',mktime(0, 0, 0, $month, $day, $year )) == 'Sun') {
                                    $_SESSION['misseddate'] = NULL;
                                    $message.="<p> Missed Date cannot be sunday!";
                                } else if ($_POST['misseddate'] > date('Y-m-d')){
                                    $_SESSION['misseddate'] = NULL;
                                    $message = "<p> Missed Class Date Cannot be later than today!";
                                }
                                else{
                                    $_SESSION['misseddate'] = $_POST['misseddate'];
                                }

                                $mudate = new DateTime($_POST['makeupdate']);
                                $muday = date_format($mudate, 'd');
                                $mumonth = date_format($mudate, 'm');
                                $muyear = date_format($mudate, 'Y');
                                if (date('D',mktime(0, 0, 0, $mumonth, $muday, $muyear )) == 'Sun') {
                                    $_SESSION['makeupdate'] = NULL;
                                    $message.="<p> Make up Class Date cannot be sunday!";
                                }
                                else{
                                    if($_SESSION['misseddate'] > $_POST['makeupdate']){
                                        $message.="<p> Make up Class Date is Invalid!
                                                       You must select a date that exceeds the
                                                       Missed Class Date";
                                    } else if ($_POST['makeupdate'] <= date('Y-m-d')){
                                        $_SESSION['makeupdate'] = NULL;
                                        $message = "<p> Makeup Class Date Cannot be earlier than today!";
                                    }
                                    else{
                                        $_SESSION['makeupdate'] = $_POST['makeupdate'];
                                    }
                                }

                                $mustarttime = $_POST['mustarthour'].':'.$_POST['mustartminute']. ':00';

                                // Checks if Missed Class is Equal to Course Class Days
                                $course2 = "select coursecode, section, facultyid, dayid, YEAR(NOW()) as schoolyear, roomcode,
                                            concat(starttime,'-',endtime) as originaltime, starttime, endtime, term
                                             from plantilla
                                            where term = (select max(term)
                                                            from plantilla
                                                            where schoolyear = YEAR(NOW()))";
                                $check2 = mysqli_query($dbc,$course2);
                                $mdate = new DateTime($_SESSION['misseddate']);
                                $mday = date_format($mdate, 'd');
                                $mmonth = date_format($mdate, 'm');
                                $myear = date_format($mdate, 'Y');

                                $valid = 0;
                                while ($row3=mysqli_fetch_array($check2,MYSQLI_ASSOC)){
                                    if (substr(date('D', mktime(0,0,0, $mmonth, $mday, $myear)),0,1) == 'T') {
                                        if (strtoupper(substr(date('D', mktime(0,0,0, $mmonth, $mday, $myear)),1,1)) == 'U') {

                                            if (substr(date('D', mktime(0,0,0, $mmonth, $mday, $myear)),0,1) == "{$row3['dayid']}" &&
                                                $_SESSION['coursecode'] == "{$row3['coursecode']}" && 
                                                $_SESSION['section'] == "{$row3['section']}"){

                                                $valid = 1;

                                                $gday = $row3['dayid'];
                                                $coursestart = $row3['starttime'];
                                                $courseend = $row3['endtime'];

                                                $start = strtotime($coursestart);
                                                $end = strtotime($courseend);

                                                $ctr = 0;
                                                while ($end != $start){
                                                    $ctr += 15;
                                                    $end = strtotime('-15minutes',$end);
                                                }

                                                $temporarystart = strtotime($mustarttime);

                                                $newtime = strtotime('+'.$ctr.'minutes',$temporarystart);
                                                $muendtime = date('H:i:s', $newtime);
                                            }

                                        } else if (strtoupper(substr(date('D', mktime(0,0,0, $mmonth, $mday, $myear)),1,1)) == 'H') {

                                            if (strtoupper(substr(date('D', mktime(0,0,0, $mmonth, $mday, $myear)),1,1)) == "{$row3['dayid']}" &&
                                                $_SESSION['coursecode'] == "{$row3['coursecode']}" && 
                                                $_SESSION['section'] == "{$row3['section']}"){

                                                $valid = 1;

                                                $gday = $row3['dayid'];
                                                $coursestart = $row3['starttime'];
                                                $courseend = $row3['endtime'];

                                                $start = strtotime($coursestart);
                                                $end = strtotime($courseend);

                                                $ctr = 0;
                                                while ($end != $start){
                                                    $ctr += 15;
                                                    $end = strtotime('-15minutes',$end);
                                                }

                                                $temporarystart = strtotime($mustarttime);

                                                $newtime = strtotime('+'.$ctr.'minutes',$temporarystart);
                                                $muendtime = date('H:i:s', $newtime);
                                            }

                                        }
                                    } else {
                                        if (substr(date('D', mktime(0,0,0, $mmonth, $mday, $myear)),0,1) == "{$row3['dayid']}" &&
                                            $_SESSION['coursecode'] == "{$row3['coursecode']}" && 
                                            $_SESSION['section'] == "{$row3['section']}"){

                                            $valid = 1;

                                            $gday = $row3['dayid'];
                                            $coursestart = $row3['starttime'];
                                            $courseend = $row3['endtime'];

                                            $start = strtotime($coursestart);
                                            $end = strtotime($courseend);

                                            $ctr = 0;
                                            while ($end != $start){
                                                $ctr += 15;
                                                $end = strtotime('-15minutes',$end);
                                            }

                                            $temporarystart = strtotime($mustarttime);

                                            $newtime = strtotime('+'.$ctr.'minutes',$temporarystart);
                                            $muendtime = date('H:i:s', $newtime);

                                        }
                                    }
                                    
                                }
                                if ($valid == 0){
                                    $_SESSION['misseddate'] = NULL;
                                    $muendtime = NULL;
                                    $message.='<p> Missed Class Date Does Not Match with the Course Class Schedule!';
                                }

                                // Checks if make up class date has conflict to plantilla
                                $validity = 0;
                                $course3 = "select coursecode, section, facultyid, dayid, YEAR(NOW()) as schoolyear, roomcode,
                                        concat(starttime,'-',endtime) as originaltime, starttime, endtime, term
                                         from plantilla
                                        where term = (select max(term)
                                                        from plantilla
                                                        where schoolyear = YEAR(NOW()))";
                                $check3 = mysqli_query($dbc,$course3);
                                $adate = new DateTime($_SESSION['makeupdate']);
                                $aday = date_format($adate, 'd');
                                $amonth = date_format($adate, 'm');
                                $ayear = date_format($adate, 'Y');

                                while ($row4 = mysqli_fetch_array($check3, MYSQLI_ASSOC)){
                                    if (substr(date('D', mktime(0,0,0, $amonth, $aday, $ayear)),0,1) == 'T') {
                                        if (strtoupper(substr(date('D', mktime(0,0,0, $amonth, $aday, $ayear)),1,1)) == 'U') {

                                            if (substr(date('D', mktime(0,0,0, $amonth, $aday, $ayear)),0,1) == "{$row4['dayid']}" &&
                                                $mustarttime >= "{$row4['starttime']}" && $muendtime <= "{$row4['endtime']}" &&
                                                "{$row4['roomcode']}" == $_SESSION['room']) {

                                                $validity = 1;

                                            } else if (substr(date('D', mktime(0,0,0, $amonth, $aday, $ayear)),0,1) == "{$row4['dayid']}" &&
                                                $mustarttime >= "{$row4['starttime']}" && $mustarttime <= "{$row4['endtime']}" ||
                                                $muendtime <= "{$row4['endtime']}" && $muendtime >= "{$row4['starttime']}") {

                                                if ("{$row4['roomcode']}" == $_SESSION['room']) {
                                                    $validity = 1;
                                                }
                                               

                                            }

                                        } else if (strtoupper(substr(date('D', mktime(0,0,0, $amonth, $aday, $ayear)),1,1)) == 'H') {

                                            if (strtoupper(substr(date('D', mktime(0,0,0, $amonth, $aday, $ayear)),1,1)) == "{$row4['dayid']}" &&
                                                $mustarttime >= "{$row4['starttime']}" && $muendtime <= "{$row4['endtime']}" &&
                                                "{$row4['roomcode']}" == $_SESSION['room'] ){

                                                $validity = 1;

                                            } else if (strtoupper(substr(date('D', mktime(0,0,0, $amonth, $aday, $ayear)),1,1)) == "{$row4['dayid']}" &&
                                                $mustarttime >= "{$row4['starttime']}" && $mustarttime <= "{$row4['endtime']}" ||
                                                $muendtime <= "{$row4['endtime']}" && $muendtime >= "{$row4['starttime']}" ){

                                                if ("{$row4['roomcode']}" == $_SESSION['room'] ){
                                                   $validity = 1; 
                                                }
                                                

                                            }

                                        }
                                    } else {
                                        if (substr(date('D', mktime(0,0,0, $amonth, $aday, $ayear)),0,1) == "{$row4['dayid']}" &&
                                            $mustarttime >= "{$row4['starttime']}" && $muendtime <= "{$row4['endtime']}" &&
                                            "{$row4['roomcode']}" == $_SESSION['room'] ){

                                            $validity = 1;

                                        } else if (substr(date('D', mktime(0,0,0, $amonth, $aday, $ayear)),0,1) == "{$row4['dayid']}" &&
                                            $mustarttime >= "{$row4['starttime']}" && $mustarttime <= "{$row4['endtime']}" ||
                                            $muendtime <= "{$row4['endtime']}" && $muendtime >= "{$row4['starttime']}" ){

                                            if ("{$row4['roomcode']}" == $_SESSION['room'] ){
                                               $validity = 1;  
                                            }
                                           

                                        }
                                    }

                                }
                                if ($validity == 1){
                                    $message.='<p> Class scheduled has conflict with another class! </p>';
                                }

                                // Check for class schedule conflicts on Makeup Class 
                                $valid3 = 0;
                                $makeup = "SELECT makeupdate, makeupstarttime, makeupendtime, makeuproom from mv_facultymakeup";
                                $getmakeup = mysqli_query($dbc, $makeup);

                                while ($row5=mysqli_fetch_array($getmakeup, MYSQLI_ASSOC)){
                                    if ($_SESSION['makeupdate'] == "{$row5['makeupdate']}" && $mustarttime >= "{$row5['makeupstarttime']}"
                                        && $muendtime <= "{$row5['makeupendtime']}" && $_SESSION['room'] == "{$row5['makeuproom']}"){
                                        $valid3 = 1;
                                    } else if ($_SESSION['makeupdate'] == "{$row5['makeupdate']}" && $mustarttime >= "{$row5['makeupstarttime']}"
                                        && $mustarttime <= "{$row5['makeupendtime']}" || $muendtime >= "{$row5['makeupstarttime']}" &&
                                        $muendtime <= "{$row5['makeupendtime']}" ){

                                        if ($_SESSION['room'] == "{$row5['makeuproom']}"){
                                             $valid3 = 1;
                                        }
                                           
                                    } 

                                }
                                if($valid3 == 1){
                                    $message.='<p> Make up class has conflict with another class!</p>';
                                }

                                //Check if class schedule has conflict on room transfer
                                $valid4 = 0;
                                $roomtransfer = "SELECT transferdate, starttime, endtime, venue from mv_roomtransfer";
                                $gettransfer = mysqli_query($dbc, $roomtransfer);

                                while ($row8 = mysqli_fetch_array($gettransfer,MYSQLI_ASSOC)){
                                    if ($_SESSION['makeupdate'] == "{$row8['transferdate']}" && $mustarttime >= "{$row8['starttime']}"
                                    && $muendtime <= "{$row8['endtime']}" && $_SESSION['room'] == "{$row8['venue']}"){
                                        $valid4 = 1;
                                    } else if ($_SESSION['makeupdate'] == "{$row8['transferdate']}" && $mustarttime >= "{$row8['starttime']}"
                                    && $mustarttime <= "{$row8['endtime']}" || $muendtime <= "{$row8['endtime']}" && 
                                    $muendtime >= "{$row8['starttime']}"){

                                        if ($_SESSION['room'] == "{$row8['venue']}"){
                                             $valid4 = 1;
                                        }
                                       
                                    }
                                }
                                if($valid4 == 1){
                                    $message.='<p> Make up class has conflict with another class!</p>';
                                }

                                //get info
                                $getfaculty = "SELECT facultyid, term, schoolyear, roomcode
                                               from plantilla where coursecode = '{$_SESSION['coursecode']}'
                                               and section ='{$_SESSION['section']}'";
                                $faculty = mysqli_query($dbc,$getfaculty);
                                $row6 = mysqli_fetch_array($faculty,MYSQLI_ASSOC);

                                //get faculty department
                                $getdepartment = "SELECT departmentid from faculty f 
                                                where f.facultyid = '{$row6['facultyid']}'";
                                $department = mysqli_query($dbc, $getdepartment);
                                $row16 = mysqli_fetch_array($department, MYSQLI_ASSOC);

                                // get chairid
                                $getchair = "SELECT chairid from ref_chair rc join ref_department rd on rc.departmentid = rd.departmentid
                                            join faculty f on rd.departmentid = f.departmentid 
                                            where rd.departmentid = '{$row16['departmentid']}' group by 1";
                                $chair = mysqli_query($dbc, $getchair);
                                $row15 = mysqli_fetch_array($chair, MYSQLI_ASSOC);

                                // get deanid
                                $getdean = "SELECT deanid from ref_dean rd join ref_college rc on rd.collegecode = rc.collegecode
                                            join ref_department rdd on rc.collegecode = rdd.collegecode 
                                            join faculty f on rdd.departmentid = f.departmentid
                                            where rdd.departmentid = '{$row16['departmentid']}' group by 1";
                                $dean = mysqli_query($dbc, $getdean);
                                $row17 = mysqli_fetch_array($dean, MYSQLI_ASSOC);


                                // Insert Faculty attendance Form
                                $facultyattendanceform = "INSERT into form_facultyattendanceform(facultyid, chairid, deanid, remarks, facultyapproval,
                                                            chairapproval, deanapproval) VALUES ('{$row6['facultyid']}', '{$row15['chairid']}', 
                                                            '{$row17['deanid']}', 'remark', NOW(),NOW(),NOW()) ";
                                $facultyres = mysqli_query($dbc, $facultyattendanceform);



                                // Get Faculty Attendance Form with last insert id
                                // Gawin ko muna max nalang.
                                $fform = "select MAX(facultyattendanceformcode) as 'formid' from form_facultyattendanceform";
                                $fget = mysqli_query($dbc, $fform);
                                $get = mysqli_fetch_array($fget,MYSQLI_ASSOC);


                                //Insert to Database 
                                

                                if (!isset($message)){
                                    $insert = "insert into mv_facultymakeup(courseCode, facultyid, dayid, schoolyear, term,
                                               section, facultyattendanceformcode, absentcode, absentdate, roomcode, makeupdate,
                                               makeuproom, makeupstarttime, makeupendtime) 
                                               VALUES ('{$_SESSION['coursecode']}', '{$row6['facultyid']}', '$gday',
                                                '{$row6['schoolyear']}', '{$row6['term']}', '{$_SESSION['section']}', '{$get['formid']}',
                                                '{$_SESSION['reason']}', '{$_SESSION['misseddate']}', '{$row6['roomcode']}', '{$_SESSION['makeupdate']}',
                                                '{$_SESSION['room']}', '$mustarttime', '$muendtime')";
                                    $insertres = mysqli_query($dbc,$insert);
                                    if ($insertres){
                                        $message.='<p> Make up Class has been added!';
                                    } 
                                    
                                }


                                if (isset($message)){
                                    echo "<font color='green'>".$message."</font>";
                                }
                            }

                            if (isset($_POST['substitution'])){
                                $message = NULL;
                                $_SESSION['section'] = $_POST['section'];
                                $_SESSION['facultysub'] = $_POST['facultysub'];

                                //Subdate checking, must be advanced
                                 if ($_POST['subdate'] <= date('Y-m-d')){
                                    $_SESSION['subdate'] = NULL;
                                    $message = "<p> Class Date must be later than today!";
                                } else {
                                    $_SESSION['subdate'] = $_POST['subdate'];
                                }

                                //Check if Date equates to a class date, if yes capture dayid
                                $course2 = "select coursecode, section, facultyid, dayid, YEAR(NOW()) as schoolyear, roomcode,
                                            concat(starttime,'-',endtime) as originaltime, starttime, endtime, term
                                             from plantilla
                                            where term = (select max(term)
                                                            from plantilla
                                                            where schoolyear = YEAR(NOW()))";
                                $check2 = mysqli_query($dbc,$course2);
                                $mdate = new DateTime($_SESSION['subdate']);
                                $mday = date_format($mdate, 'd');
                                $mmonth = date_format($mdate, 'm');
                                $myear = date_format($mdate, 'Y');

                                $valid = 0;
                                while ($row3=mysqli_fetch_array($check2,MYSQLI_ASSOC)){
                                    if (substr(date('D', mktime(0,0,0, $mmonth, $mday, $myear)),0,1) == 'T') {
                                        if (strtoupper(substr(date('D', mktime(0,0,0, $mmonth, $mday, $myear)),1,1)) == 'U') {

                                            if (substr(date('D', mktime(0,0,0, $mmonth, $mday, $myear)),0,1) == "{$row3['dayid']}" &&
                                                $_SESSION['coursecode'] == "{$row3['coursecode']}" && 
                                                $_SESSION['section'] == "{$row3['section']}"){

                                                $valid = 1;

                                                $gday = $row3['dayid'];
                                                
                                            }

                                        } else if (strtoupper(substr(date('D', mktime(0,0,0, $mmonth, $mday, $myear)),1,1)) == 'H') {

                                            if (strtoupper(substr(date('D', mktime(0,0,0, $mmonth, $mday, $myear)),1,1)) == "{$row3['dayid']}" &&
                                                $_SESSION['coursecode'] == "{$row3['coursecode']}" && 
                                                $_SESSION['section'] == "{$row3['section']}"){

                                                $valid = 1;

                                                $gday = $row3['dayid'];
                                               
                                            }

                                        }
                                    } else {
                                        if (substr(date('D', mktime(0,0,0, $mmonth, $mday, $myear)),0,1) == "{$row3['dayid']}" &&
                                            $_SESSION['coursecode'] == "{$row3['coursecode']}" && 
                                            $_SESSION['section'] == "{$row3['section']}"){

                                            $valid = 1;

                                            $gday = $row3['dayid'];
                                            
                                        }
                                    }
                                    
                                }
                                if ($valid == 0){
                                    $_SESSION['subdate'] = NULL;
                                    $message.='<p> Class Date Does Not Match with the Course Class Schedule!';
                                }

                                // Check if there is conflict in Substitution
                                $valid5 = 0;
                                $subs = "SELECT coursecode, section, anticipateddate from mv_substitution";
                                $getsubs = mysqli_query($dbc, $subs);

                                while ($row13 = mysqli_fetch_array($getsubs,MYSQLI_ASSOC)) {
                                    if ($row13['coursecode'] == $_SESSION['coursecode'] && $row13['section'] == $_SESSION['section']
                                        && $row13['anticipateddate'] == $_SESSION['subdate']) {

                                        $valid5 = 1;
                                    }
                                }
                                if ($valid5 == 1){
                                    $message.="<p> Class has already been created!";
                                }

                                //get info
                                $getfaculty = "SELECT facultyid, term, schoolyear, roomcode
                                               from plantilla where coursecode = '{$_SESSION['coursecode']}'
                                               and section ='{$_SESSION['section']}'";
                                $faculty = mysqli_query($dbc,$getfaculty);
                                $row6 = mysqli_fetch_array($faculty,MYSQLI_ASSOC);

                                //get faculty department
                                $getdepartment = "SELECT departmentid from faculty f 
                                                where f.facultyid = '{$row6['facultyid']}'";
                                $department = mysqli_query($dbc, $getdepartment);
                                $row16 = mysqli_fetch_array($department, MYSQLI_ASSOC);

                                // get chairid
                                $getchair = "SELECT chairid from ref_chair rc join ref_department rd on rc.departmentid = rd.departmentid
                                            join faculty f on rd.departmentid = f.departmentid 
                                            where rd.departmentid = '{$row16['departmentid']}' group by 1";
                                $chair = mysqli_query($dbc, $getchair);
                                $row15 = mysqli_fetch_array($chair, MYSQLI_ASSOC);

                                // get deanid
                                $getdean = "SELECT deanid from ref_dean rd join ref_college rc on rd.collegecode = rc.collegecode
                                            join ref_department rdd on rc.collegecode = rdd.collegecode 
                                            join faculty f on rdd.departmentid = f.departmentid
                                            where rdd.departmentid = '{$row16['departmentid']}' group by 1";
                                $dean = mysqli_query($dbc, $getdean);
                                $row17 = mysqli_fetch_array($dean, MYSQLI_ASSOC);


                                // Insert Faculty attendance Form
                                $facultyattendanceform = "INSERT into form_facultyattendanceform(facultyid, chairid, deanid, remarks, facultyapproval,
                                                            chairapproval, deanapproval) VALUES ('{$row6['facultyid']}', '{$row15['chairid']}', 
                                                            '{$row17['deanid']}', 'remark', NOW(),NOW(),NOW()) ";
                                $facultyres = mysqli_query($dbc, $facultyattendanceform);

                                // Get Faculty Attendance Form with last insert id
                                // Gawin ko muna max nalang.
                                $fform = "select MAX(facultyattendanceformcode) as 'formid' from form_facultyattendanceform";
                                $fget = mysqli_query($dbc, $fform);
                                $get = mysqli_fetch_array($fget,MYSQLI_ASSOC);


                                //Insert into database

                                if (!isset($message)){
                                    $insert = "insert into mv_substitution(coursecode, facultyid, dayid, schoolyear, term,
                                               section, facultyattendanceformcode, substitutefacultyid, anticipateddate) 
                                               VALUES ('{$_SESSION['coursecode']}', '{$row6['facultyid']}', '$gday',
                                                '{$row6['schoolyear']}', '{$row6['term']}', '{$_SESSION['section']}', '{$get['formid']}',
                                                '{$_SESSION['facultysub']}', '{$_SESSION['subdate']}')";
                                    $insertres = mysqli_query($dbc,$insert);
                                    if ($insertres){
                                        $message.='<p> Class has been added!';
                                    } 
                                    
                                }

                                if (isset($message)){
                                    echo '<font color="green">'.$message.'</font>';
                                }
                            }

                            if(isset($_POST['transferred'])){
                                $message = NULL;
                                $_SESSION['section'] = $_POST['section'];

                                $roomquery = "SELECT R.ROOMCODE as ROOM
                                           FROM ROOM R
                                          WHERE '{$_POST['room']}' = R.ROOMCODE";
                                $printroom = mysqli_query($dbc,$roomquery);
                                $row2 = mysqli_fetch_array($printroom, MYSQLI_ASSOC);
                                if($row2['ROOM'] != NULL){
                                    $_SESSION['room'] = $_POST['room'];
                                }
                                else{
                                    $_SESSION['room'] = NULL;
                                    $message.="<p>Invalid room!";
                                }

                                if ($_POST['transferdate'] <= date('Y-m-d')){
                                    $_SESSION['transferdate'] = NULL;
                                    $message.= "<p> Transfer Date must be later than today!";
                                } else {
                                    $_SESSION['transferdate'] = $_POST['transferdate'];
                                }

                                //Transfer Date should be a class date, capture dayid
                                $course = "select coursecode, section, facultyid, dayid, YEAR(NOW()) as schoolyear, roomcode,
                                            concat(starttime,'-',endtime) as originaltime, starttime, endtime, term
                                             from plantilla
                                            where term = (select max(term)
                                                            from plantilla
                                                            where schoolyear = YEAR(NOW()))";
                                $check = mysqli_query($dbc,$course);
                                $mdate = new DateTime($_SESSION['transferdate']);
                                $mday = date_format($mdate, 'd');
                                $mmonth = date_format($mdate, 'm');
                                $myear = date_format($mdate, 'Y');

                                $valid = 0;
                                while ($row7=mysqli_fetch_array($check,MYSQLI_ASSOC)){
                                    if (substr(date('D', mktime(0,0,0, $mmonth, $mday, $myear)),0,1) == 'T') {
                                        if (strtoupper(substr(date('D', mktime(0,0,0, $mmonth, $mday, $myear)),1,1)) == 'U') {

                                            if (substr(date('D', mktime(0,0,0, $mmonth, $mday, $myear)),0,1) == "{$row7['dayid']}" &&
                                                $_SESSION['coursecode'] == "{$row7['coursecode']}" && 
                                                $_SESSION['section'] == "{$row7['section']}"){

                                                $valid = 1;

                                                $gday = $row7['dayid'];
                                                

                                            }

                                        } else if (strtoupper(substr(date('D', mktime(0,0,0, $mmonth, $mday, $myear)),1,1)) == 'H') {

                                            if (strtoupper(substr(date('D', mktime(0,0,0, $mmonth, $mday, $myear)),1,1)) == "{$row7['dayid']}" &&
                                                $_SESSION['coursecode'] == "{$row7['coursecode']}" && 
                                                $_SESSION['section'] == "{$row7['section']}"){

                                                $valid = 1;

                                                $gday = $row7['dayid'];
                                               

                                            }

                                        }
                                    } else {
                                        if (substr(date('D', mktime(0,0,0, $mmonth, $mday, $myear)),0,1) == "{$row7['dayid']}" &&
                                            $_SESSION['coursecode'] == "{$row7['coursecode']}" && 
                                            $_SESSION['section'] == "{$row7['section']}"){

                                            $valid = 1;

                                            $gday = $row7['dayid'];
                                            

                                        }
                                    }
                                    
                                }
                                if ($valid == 0){
                                    $_SESSION['transferdate'] = NULL;
                                    $message.='<p> Transfer Date Does Not Match with the Course Class Schedule!';
                                }

                                // Check if transferring has conflict to makeup, plantilla and alternatives
                                $gettime = "SELECT starttime, endtime from plantilla where coursecode = '{$_SESSION['coursecode']}'
                                            && section = '{$_SESSION['section']}'";
                                $time = mysqli_query($dbc, $gettime);
                                $row14 = mysqli_fetch_array($time, MYSQLI_ASSOC);

                                // Plantilla
                                $validity = 0;
                                $course3 = "select coursecode, section, facultyid, dayid, YEAR(NOW()) as schoolyear, roomcode,
                                        concat(starttime,'-',endtime) as originaltime, starttime, endtime, term
                                         from plantilla
                                        where term = (select max(term)
                                                        from plantilla
                                                        where schoolyear = YEAR(NOW()))";
                                $check3 = mysqli_query($dbc,$course3);
                                $adate = new DateTime($_SESSION['transferdate']);
                                $aday = date_format($adate, 'd');
                                $amonth = date_format($adate, 'm');
                                $ayear = date_format($adate, 'Y');

                                
                                while ($row4 = mysqli_fetch_array($check3, MYSQLI_ASSOC)){
                                    if (substr(date('D', mktime(0,0,0, $amonth, $aday, $ayear)),0,1) == 'T') {
                                        if (strtoupper(substr(date('D', mktime(0,0,0, $amonth, $aday, $ayear)),1,1)) == 'U') {

                                            if (substr(date('D', mktime(0,0,0, $amonth, $aday, $ayear)),0,1) == "{$row4['dayid']}" &&
                                                "{$row14['starttime']}" >= "{$row4['starttime']}" && "{$row14['endtime']}" <= "{$row4['endtime']}" &&
                                                "{$row4['roomcode']}" == $_SESSION['room']) {

                                                $validity = 1;

                                            }else if (substr(date('D', mktime(0,0,0, $amonth, $aday, $ayear)),0,1) == "{$row4['dayid']}" &&
                                                "{$row14['starttime']}" >= "{$row4['starttime']}" && "{$row14['starttime']}" <= "{$row4['endtime']}" ||
                                                "{$row14['endtime']}" <= "{$row4['endtime']}" && "{$row14['endtime']}" >= "{$row4['starttime']}" ) {

                                                if ("{$row4['roomcode']}" == $_SESSION['room']){
                                                    $validity = 1;
                                                }
                                                

                                            }

                                        } else if (strtoupper(substr(date('D', mktime(0,0,0, $amonth, $aday, $ayear)),1,1)) == 'H') {

                                            if (strtoupper(substr(date('D', mktime(0,0,0, $amonth, $aday, $ayear)),1,1)) == "{$row4['dayid']}" &&
                                                "{$row14['starttime']}" >= "{$row4['starttime']}" && "{$row14['endtime']}" <= "{$row4['endtime']}" &&
                                                "{$row4['roomcode']}" == $_SESSION['room'] ){

                                                $validity = 1;

                                            }else if (strtoupper(substr(date('D', mktime(0,0,0, $amonth, $aday, $ayear)),1,1)) == "{$row4['dayid']}" &&
                                                "{$row14['starttime']}" >= "{$row4['starttime']}" && "{$row14['starttime']}" <= "{$row4['endtime']}" ||
                                                "{$row14['endtime']}" <= "{$row4['endtime']}" && "{$row14['endtime']}" >= "{$row4['starttime']}" 
                                                ){

                                                if ("{$row4['roomcode']}" == $_SESSION['room']){
                                                    $validity = 1;
                                                }

                                                


                                            }

                                        }
                                    } else {
                                        if (substr(date('D', mktime(0,0,0, $amonth, $aday, $ayear)),0,1) == "{$row4['dayid']}" &&
                                            "{$row14['starttime']}" >= "{$row4['starttime']}" && "{$row14['endtime']}" <= "{$row4['endtime']}" &&
                                            "{$row4['roomcode']}" == $_SESSION['room'] ){

                                            $validity = 1;

                                        }else if (substr(date('D', mktime(0,0,0, $amonth, $aday, $ayear)),0,1) == "{$row4['dayid']}" &&
                                            "{$row14['starttime']}" >= "{$row4['starttime']}" && "{$row14['starttime']}" <= "{$row4['endtime']}" ||
                                            "{$row14['endtime']}" <= "{$row4['endtime']}" && "{$row14['endtime']}" >= "{$row4['starttime']}"){

                                            if ("{$row4['roomcode']}" == $_SESSION['room']){
                                                    $validity = 1;
                                            }

                                        }
                                    }

                                }
                                if ($validity == 1){
                                    $message.='<p> Class room scheduled has conflict with another class in plantilla! </p>';
                                }

                                //Make up class
                                $valid2 = 0;
                                $makeup = "SELECT makeupdate, makeupstarttime, makeupendtime, makeuproom from mv_facultymakeup";
                                $getmakeup = mysqli_query($dbc, $makeup);

                                while ($row5=mysqli_fetch_array($getmakeup, MYSQLI_ASSOC)){
                                    if ($_SESSION['transferdate'] == "{$row5['makeupdate']}" && "{$row14['starttime']}" >= "{$row5['makeupstarttime']}"
                                        && "{$row14['endtime']}" <= "{$row5['makeupendtime']}" && $_SESSION['room'] == "{$row5['makeuproom']}"){
                                        $valid2 = 1;    
                                    } else if ($_SESSION['transferdate'] == "{$row5['makeupdate']}" && "{$row14['starttime']}" >= "{$row5['makeupstarttime']}"
                                        && "{$row14['starttime']}" <= "{$row5['makeupendtime']}" || "{$row14['endtime']}" >= "{$row5['makeupstarttime']}" &&
                                        "{$row14['endtime']}" <= "{$row5['makeupendtime']}" ){

                                        if ($_SESSION['room'] == "{$row5['makeuproom']}"){
                                            $valid2 = 1;
                                        }
                                            
                                    } 

                                }
                                if($valid2 == 1){
                                    $message.='<p> Class Scheduled has conflict with another class in make up!</p>';
                                }


                                //Alternative class
                                $valid4 = 0;
                                $roomtransfer = "SELECT transferdate, starttime, endtime, venue from mv_roomtransfer";
                                $gettransfer = mysqli_query($dbc, $roomtransfer);

                                while ($row8 = mysqli_fetch_array($gettransfer,MYSQLI_ASSOC)){
                                    if ($_SESSION['transferdate'] == "{$row8['transferdate']}" && "{$row14['starttime']}" >= "{$row8['starttime']}"
                                    && "{$row14['endtime']}" <= "{$row8['endtime']}" && $_SESSION['room'] == "{$row8['venue']}"){
                                        $valid4 = 1;
                                    }else if ($_SESSION['altdate'] == "{$row8['transferdate']}" && "{$row14['starttime']}" >= "{$row8['starttime']}"
                                    && "{$row14['starttime']}" <= "{$row8['endtime']}" || "{$row14['endtime']}" <= "{$row8['endtime']}" && 
                                    "{$row14['endtime']}" >= "{$row8['starttime']}"){

                                        if ($_SESSION['room'] == "{$row8['venue']}"){
                                           $valid4 = 1; 
                                        }
                                        
                                    }
                                }
                                if($valid4 == 1){
                                    $message.='<p> Class Scheduled has conflict with another class in transfer!</p>';
                                }

                                // Insert Faculty attendance form
                                //get info
                                $getfaculty = "SELECT facultyid, term, schoolyear, roomcode, starttime, endtime
                                               from plantilla where coursecode = '{$_SESSION['coursecode']}'
                                               and section ='{$_SESSION['section']}'";
                                $faculty = mysqli_query($dbc,$getfaculty);
                                $row6 = mysqli_fetch_array($faculty,MYSQLI_ASSOC);

                                //get faculty department
                                $getdepartment = "SELECT departmentid from faculty f 
                                                where f.facultyid = '{$row6['facultyid']}'";
                                $department = mysqli_query($dbc, $getdepartment);
                                $row16 = mysqli_fetch_array($department, MYSQLI_ASSOC);

                                // get chairid
                                $getchair = "SELECT chairid from ref_chair rc join ref_department rd on rc.departmentid = rd.departmentid
                                            join faculty f on rd.departmentid = f.departmentid 
                                            where rd.departmentid = '{$row16['departmentid']}' group by 1";
                                $chair = mysqli_query($dbc, $getchair);
                                $row15 = mysqli_fetch_array($chair, MYSQLI_ASSOC);

                                // get deanid
                                $getdean = "SELECT deanid from ref_dean rd join ref_college rc on rd.collegecode = rc.collegecode
                                            join ref_department rdd on rc.collegecode = rdd.collegecode 
                                            join faculty f on rdd.departmentid = f.departmentid
                                            where rdd.departmentid = '{$row16['departmentid']}' group by 1";
                                $dean = mysqli_query($dbc, $getdean);
                                $row17 = mysqli_fetch_array($dean, MYSQLI_ASSOC);



                                // Insert Faculty attendance Form
                                $facultyattendanceform = "INSERT into form_facultyattendanceform(facultyid, chairid, deanid, remarks, facultyapproval,
                                                            chairapproval, deanapproval) VALUES ('{$row6['facultyid']}', '{$row15['chairid']}', 
                                                            '{$row17['deanid']}', 'remark', NOW(),NOW(),NOW()) ";
                                $facultyres = mysqli_query($dbc, $facultyattendanceform);

                                // Get Faculty Attendance Form with last insert id
                                // Gawin ko muna max nalang.
                                $fform = "select MAX(facultyattendanceformcode) as 'formid' from form_facultyattendanceform";
                                $fget = mysqli_query($dbc, $fform);
                                $get = mysqli_fetch_array($fget,MYSQLI_ASSOC);


                                //Insert into database
                                
                                if ($_POST['type'] == 'RT'){
                                    if (!isset($message)){
                                        $insert = "insert into mv_roomtransfer(coursecode, facultyid, dayid, schoolyear, term,
                                                   section, facultyattendanceformcode, transfercode, transferdate, venue,
                                                   starttime, endtime) 
                                                   VALUES ('{$_SESSION['coursecode']}', '{$row6['facultyid']}', '$gday',
                                                    '{$row6['schoolyear']}', '{$row6['term']}', '{$_SESSION['section']}', '{$get['formid']}',
                                                    'RT', '{$_SESSION['transferdate']}', '{$_SESSION['room']}', '{$row6['starttime']}', '{$row6['endtime']}')";
                                        $insertres = mysqli_query($dbc,$insert);
                                        if ($insertres){
                                            $message.='<p> Class has been added!';
                                        } 
                                        
                                    }
                                }
                                if ($_POST['type'] = 'PR'){
                                    if (!isset($message)){
                                        $insert = "INSERT into mv_roomtransfer(coursecode, facultyid, dayid, schoolyear, term,
                                                   section, facultyattendanceformcode, transfercode, transferdate, venue,
                                                   starttime, endtime) 
                                                   VALUES ('{$_SESSION['coursecode']}', '{$row6['facultyid']}', '$gday',
                                                    '{$row6['schoolyear']}', '{$row6['term']}', '{$_SESSION['section']}', '{$get['formid']}',
                                                    'PR', '{$_SESSION['transferdate']}', '{$_SESSION['room']}', '{$row6['starttime']}', '{$row6['endtime']}')";
                                        $insertres = mysqli_query($dbc,$insert);

                                        //Update Plantilla
                                        $update = "UPDATE plantilla set roomCode = '{$_SESSION['room']}' where coursecode = '{$_SESSION['coursecode']}'
                                                    and section = '{$_SESSION['section']}'";
                                        if ($dbc->query($update) == TRUE && $insertres) {
                                            $message.='<p> Class has been added!';
                                        } 
                                        
                                    }
                                }

                                if (isset($message)){
                                    echo '<font color="green">'.$message.'</font>';
                                }

                            }

                            if (isset($_POST['addchange'])){
                                $message = NULL;
                                $_SESSION['section'] = $_POST['section'];

                                $roomquery = "SELECT R.ROOMCODE as ROOM
                                           FROM ROOM R
                                          WHERE '{$_POST['room']}' = R.ROOMCODE";
                                $printroom = mysqli_query($dbc,$roomquery);
                                $row2 = mysqli_fetch_array($printroom, MYSQLI_ASSOC);
                                if($row2['ROOM'] != NULL){
                                    $_SESSION['room'] = $_POST['room'];
                                }
                                else{
                                    $_SESSION['room'] = NULL;
                                    $message.="<p>Invalid room code";
                                }

                                if ($_POST['altdate'] <= date('Y-m-d')){
                                    $_SESSION['altdate'] = NULL;
                                    $message.= "<p> Alternative Class Date must be later than today!";
                                } else {
                                    $_SESSION['altdate'] = $_POST['altdate'];
                                }

                                if ($_POST['change'] <= date('Y-m-d')){
                                    $_SESSION['change'] = NULL;
                                    $message.= "<p> Change in time must be later than today!";
                                } else {
                                    $_SESSION['change'] = $_POST['change'];
                                }   

                                $altstarttime =  $_POST['altstarthour'].':'.$_POST['altstartminute']. ':00';                           
                               

                                // Checks if Change in time is Equal to Course Class Days
                                $course = "select coursecode, section, facultyid, dayid, YEAR(NOW()) as schoolyear, roomcode,
                                            concat(starttime,'-',endtime) as originaltime, starttime, endtime, term
                                             from plantilla
                                            where term = (select max(term)
                                                            from plantilla
                                                            where schoolyear = YEAR(NOW()))";
                                $check = mysqli_query($dbc,$course);
                                $mdate = new DateTime($_SESSION['change']);
                                $mday = date_format($mdate, 'd');
                                $mmonth = date_format($mdate, 'm');
                                $myear = date_format($mdate, 'Y');

                                $valid = 0;
                                while ($row7=mysqli_fetch_array($check,MYSQLI_ASSOC)){
                                    if (substr(date('D', mktime(0,0,0, $mmonth, $mday, $myear)),0,1) == 'T') {
                                        if (strtoupper(substr(date('D', mktime(0,0,0, $mmonth, $mday, $myear)),1,1)) == 'U') {

                                            if (substr(date('D', mktime(0,0,0, $mmonth, $mday, $myear)),0,1) == "{$row7['dayid']}" &&
                                                $_SESSION['coursecode'] == "{$row7['coursecode']}" && 
                                                $_SESSION['section'] == "{$row7['section']}"){

                                                $valid = 1;

                                                $gday = $row7['dayid'];
                                                $coursestart = $row7['starttime'];
                                                $courseend = $row7['endtime'];

                                                $start = strtotime($coursestart);
                                                $end = strtotime($courseend);

                                                $ctr = 0;
                                                while ($end != $start){
                                                    $ctr += 15;
                                                    $end = strtotime('-15minutes',$end);
                                                }

                                                $temporarystart = strtotime($altstarttime);

                                                $newtime = strtotime('+'.$ctr.'minutes',$temporarystart);
                                                $altendtime = date('H:i:s', $newtime);

                                            }

                                        } else if (strtoupper(substr(date('D', mktime(0,0,0, $mmonth, $mday, $myear)),1,1)) == 'H') {

                                            if (strtoupper(substr(date('D', mktime(0,0,0, $mmonth, $mday, $myear)),1,1)) == "{$row7['dayid']}" &&
                                                $_SESSION['coursecode'] == "{$row7['coursecode']}" && 
                                                $_SESSION['section'] == "{$row7['section']}"){

                                                $valid = 1;

                                                $gday = $row7['dayid'];
                                                $coursestart = $row7['starttime'];
                                                $courseend = $row7['endtime'];

                                                $start = strtotime($coursestart);
                                                $end = strtotime($courseend);

                                                $ctr = 0;
                                                while ($end != $start){
                                                    $ctr += 15;
                                                    $end = strtotime('-15minutes',$end);
                                                }

                                                $temporarystart = strtotime($altstarttime);

                                                $newtime = strtotime('+'.$ctr.'minutes',$temporarystart);
                                                $altendtime = date('H:i:s', $newtime);

                                            }

                                        }
                                    } else {
                                        if (substr(date('D', mktime(0,0,0, $mmonth, $mday, $myear)),0,1) == "{$row7['dayid']}" &&
                                            $_SESSION['coursecode'] == "{$row7['coursecode']}" && 
                                            $_SESSION['section'] == "{$row7['section']}"){

                                            $valid = 1;

                                            $gday = $row7['dayid'];
                                            $coursestart = $row7['starttime'];
                                            $courseend = $row7['endtime'];

                                            $start = strtotime($coursestart);
                                            $end = strtotime($courseend);

                                            $ctr = 0;
                                            while ($end != $start){
                                                $ctr += 15;
                                                $end = strtotime('-15minutes',$end);
                                            }

                                            $temporarystart = strtotime($altstarttime);

                                            $newtime = strtotime('+'.$ctr.'minutes',$temporarystart);
                                            $altendtime = date('H:i:s', $newtime);

                                        }
                                    }
                                    
                                }
                                if ($valid == 0){
                                    $_SESSION['change'] = NULL;
                                    $altendtime = NULL;
                                    $message.='<p> Change in Time Does Not Match with the Course Class Schedule!';
                                }

                                //Checks if alternative has conflict in plantilla
                                $validity = 0;
                                $course3 = "select coursecode, section, facultyid, dayid, YEAR(NOW()) as schoolyear, roomcode,
                                        concat(starttime,'-',endtime) as originaltime, starttime, endtime, term
                                         from plantilla
                                        where term = (select max(term)
                                                        from plantilla
                                                        where schoolyear = YEAR(NOW()))";
                                $check3 = mysqli_query($dbc,$course3);
                                $adate = new DateTime($_SESSION['altdate']);
                                $aday = date_format($adate, 'd');
                                $amonth = date_format($adate, 'm');
                                $ayear = date_format($adate, 'Y');

                                while ($row4 = mysqli_fetch_array($check3, MYSQLI_ASSOC)){
                                    if (substr(date('D', mktime(0,0,0, $amonth, $aday, $ayear)),0,1) == 'T') {
                                        if (strtoupper(substr(date('D', mktime(0,0,0, $amonth, $aday, $ayear)),1,1)) == 'U') {

                                            if (substr(date('D', mktime(0,0,0, $amonth, $aday, $ayear)),0,1) == "{$row4['dayid']}" &&
                                                $altstarttime >= "{$row4['starttime']}" && $altendtime <= "{$row4['endtime']}" &&
                                                "{$row4['roomcode']}" == $_SESSION['room']) {

                                                $validity = 1;

                                            }else if (substr(date('D', mktime(0,0,0, $amonth, $aday, $ayear)),0,1) == "{$row4['dayid']}" &&
                                                $altstarttime >= "{$row4['starttime']}" && $altstarttime <= "{$row4['endtime']}" ||
                                                $altendtime <= "{$row4['endtime']}" && $altendtime >= "{$row4['starttime']}" ) {

                                                if ("{$row4['roomcode']}" == $_SESSION['room']){
                                                   $validity = 1;  
                                                }
                                               

                                            }

                                        } else if (strtoupper(substr(date('D', mktime(0,0,0, $amonth, $aday, $ayear)),1,1)) == 'H') {

                                            if (strtoupper(substr(date('D', mktime(0,0,0, $amonth, $aday, $ayear)),1,1)) == "{$row4['dayid']}" &&
                                                $altstarttime >= "{$row4['starttime']}" && $altendtime <= "{$row4['endtime']}" &&
                                                "{$row4['roomcode']}" == $_SESSION['room'] ){

                                                $validity = 1;

                                            }else if (strtoupper(substr(date('D', mktime(0,0,0, $amonth, $aday, $ayear)),1,1)) == "{$row4['dayid']}" &&
                                                $altstarttime >= "{$row4['starttime']}" && $altstarttime <= "{$row4['endtime']}" ||
                                                $altendtime <= "{$row4['endtime']}" && $altendtime >= "{$row4['starttime']}"){

                                                if ("{$row4['roomcode']}" == $_SESSION['room']){
                                                   $validity = 1;  
                                                }

                                            }

                                        }
                                    } else {
                                        if (substr(date('D', mktime(0,0,0, $amonth, $aday, $ayear)),0,1) == "{$row4['dayid']}" &&
                                            $altstarttime >= "{$row4['starttime']}" && $altendtime <= "{$row4['endtime']}" &&
                                            "{$row4['roomcode']}" == $_SESSION['room'] ){

                                            $validity = 1;

                                        }else if (substr(date('D', mktime(0,0,0, $amonth, $aday, $ayear)),0,1) == "{$row4['dayid']}" &&
                                            $altstarttime >= "{$row4['starttime']}" && $altstarttime <= "{$row4['endtime']}" ||
                                                $altendtime <= "{$row4['endtime']}" && $altendtime >= "{$row4['starttime']}" ){

                                            if ("{$row4['roomcode']}" == $_SESSION['room']){
                                                $validity = 1;  
                                            }

                                        }
                                    }

                                }
                                if ($validity == 1){
                                    $message.='<p> Class scheduled has conflict with another class! </p>';
                                }

                                //Checks if change in time(alternative date) has conflict to make up classes
                                $valid2 = 0;
                                $makeup = "SELECT makeupdate, makeupstarttime, makeupendtime, makeuproom from mv_facultymakeup";
                                $getmakeup = mysqli_query($dbc, $makeup);

                                while ($row5=mysqli_fetch_array($getmakeup, MYSQLI_ASSOC)){
                                    if ($_SESSION['altdate'] == "{$row5['makeupdate']}" && $altstarttime >= "{$row5['makeupstarttime']}"
                                        && $altendtime <= "{$row5['makeupendtime']}" && $_SESSION['room'] == "{$row5['makeuproom']}"){
                                        $valid2 = 1;    
                                    } else if ($_SESSION['altdate'] == "{$row5['makeupdate']}" && $altstarttime >= "{$row5['makeupstarttime']}"
                                        && $altstarttime <= "{$row5['makeupendtime']}" || $altendtime >= "{$row5['makeupstarttime']}" &&
                                        $altendtime <= "{$row5['makeupendtime']}" ){

                                        if ($_SESSION['room'] == "{$row5['makeuproom']}"){
                                            $valid2 = 1;  
                                        }
                                          
                                    } 

                                }
                                if($valid2 == 1){
                                    $message.='<p> Class Scheduled has conflict with another class!</p>';
                                }

                                //Checks if change in time is equal to room transfers
                                $valid4 = 0;
                                $roomtransfer = "SELECT transferdate, starttime, endtime, venue from mv_roomtransfer";
                                $gettransfer = mysqli_query($dbc, $roomtransfer);

                                while ($row8 = mysqli_fetch_array($gettransfer,MYSQLI_ASSOC)){
                                    if ($_SESSION['altdate'] == "{$row8['transferdate']}" && $altstarttime >= "{$row8['starttime']}"
                                    && $altendtime <= "{$row8['endtime']}" && $_SESSION['room'] == "{$row8['venue']}"){
                                        $valid4 = 1;
                                    }else if ($_SESSION['altdate'] == "{$row8['transferdate']}" && $altstarttime >= "{$row8['starttime']}"
                                    && $altstarttime <= "{$row8['endtime']}" || $altendtime <= "{$row8['endtime']}" && 
                                    $altendtime >= "{$row8['starttime']}" ){

                                        if ($_SESSION['room'] == "{$row8['venue']}"){
                                            $valid4 = 1;
                                        }
                                        
                                    }
                                }
                                if($valid4 == 1){
                                    $message.='<p> Class Scheduled has conflict with another class!</p>';
                                }

                                //Insert Faculty Attendance Form
                                //get info
                                $getfaculty = "SELECT facultyid, term, schoolyear, roomcode
                                               from plantilla where coursecode = '{$_SESSION['coursecode']}'
                                               and section ='{$_SESSION['section']}'";
                                $faculty = mysqli_query($dbc,$getfaculty);
                                $row6 = mysqli_fetch_array($faculty,MYSQLI_ASSOC);

                                //get faculty department
                                $getdepartment = "SELECT departmentid from faculty f 
                                                where f.facultyid = '{$row6['facultyid']}'";
                                $department = mysqli_query($dbc, $getdepartment);
                                $row16 = mysqli_fetch_array($department, MYSQLI_ASSOC);

                                // get chairid
                                $getchair = "SELECT chairid from ref_chair rc join ref_department rd on rc.departmentid = rd.departmentid
                                            join faculty f on rd.departmentid = f.departmentid 
                                            where rd.departmentid = '{$row16['departmentid']}' group by 1";
                                $chair = mysqli_query($dbc, $getchair);
                                $row15 = mysqli_fetch_array($chair, MYSQLI_ASSOC);

                                // get deanid
                                $getdean = "SELECT deanid from ref_dean rd join ref_college rc on rd.collegecode = rc.collegecode
                                            join ref_department rdd on rc.collegecode = rdd.collegecode 
                                            join faculty f on rdd.departmentid = f.departmentid
                                            where rdd.departmentid = '{$row16['departmentid']}' group by 1";
                                $dean = mysqli_query($dbc, $getdean);
                                $row17 = mysqli_fetch_array($dean, MYSQLI_ASSOC);


                                // Insert Faculty attendance Form
                                $facultyattendanceform = "INSERT into form_facultyattendanceform(facultyid, chairid, deanid, remarks, facultyapproval,
                                                            chairapproval, deanapproval) VALUES ('{$row6['facultyid']}', '{$row15['chairid']}', 
                                                            '{$row17['deanid']}', 'remark', NOW(),NOW(),NOW()) ";
                                $facultyres = mysqli_query($dbc, $facultyattendanceform);

                                // Get Faculty Attendance Form with last insert id
                                // Gawin ko muna max nalang.
                                $fform = "select MAX(facultyattendanceformcode) as 'formid' from form_facultyattendanceform";
                                $fget = mysqli_query($dbc, $fform);
                                $get = mysqli_fetch_array($fget,MYSQLI_ASSOC);


                                //Insert to Database 

                                if (!isset($message)){
                                    $insert = "insert into mv_roomtransfer(coursecode, facultyid, dayid, schoolyear, term,
                                               section, facultyattendanceformcode, transfercode, originaldate, transferdate, venue,
                                               starttime, endtime) 
                                               VALUES ('{$_SESSION['coursecode']}', '{$row6['facultyid']}', '$gday',
                                                '{$row6['schoolyear']}', '{$row6['term']}', '{$_SESSION['section']}', '{$get['formid']}',
                                                'CT', '{$_SESSION['change']}', '{$_SESSION['altdate']}', '{$_SESSION['room']}',
                                                '$altstarttime', '$altendtime')";
                                    //,'$altstarttime', '$altendtime'
                                    $insertres = mysqli_query($dbc,$insert);
                                    if ($insertres){
                                        $message.='<p> Class has been added!';
                                    } 
                                    
                                }

                                if (isset($message)){
                                    echo "<font color='green'>".$message."</font>";
                                }
                            }

                            if (isset($_POST['addalternative'])){
                                $message = NULL;
                                $_SESSION['section'] = $_POST['section'];
                                $_SESSION['type'] = $_POST['type'];
                                $_SESSION['venue'] = $_POST['venue'];

                                if ($_POST['altdate'] <= date('Y-m-d')){
                                    $_SESSION['altdate'] = NULL;
                                    $message.= "<p> Alternative Class Date must be later than today!";
                                } else {
                                    $_SESSION['altdate'] = $_POST['altdate'];
                                }

                                $altstarttime =  $_POST['altstarthour'].':'.$_POST['altstartminute']. ':00';                           
                                $altendtime = $_POST['altendhour'].':'.$_POST['altendminute']. ':00';

                                if ($altstarttime > $altendtime){
                                    $message.="<p> Start time cannot be greater than end time!";
                                    $gethr = 0;
                                } else {
                                    $start = strtotime($altstarttime);
                                    $end = strtotime($altendtime);

                                    $ctr = 0;
                                    while ($end != $start){
                                        $ctr += 15;
                                        $end = strtotime('-15minutes',$end);
                                    }

                                    $gethr = $ctr / 60;

                                    /**if ($gethr > 6){
                                        $message.="<p> Time alloted cannot be more than 6 hours!";
                                    }*/

                                }

                                // Check if less than 6 hours pa rin yung alternative class ng course and section
                                $checkhour = "SELECT starttime, endtime from mv_roomtransfer where coursecode = '{$_SESSION['coursecode']}' 
                                              and section = '{$_SESSION['section']}' and transfercode != 'CT' ";
                                $check = mysqli_query($dbc, $checkhour);

                                $ctr = 0;

                                while ($row9 = mysqli_fetch_array($check, MYSQLI_ASSOC)){
                                    $timestart = strtotime($row9['starttime']);
                                    $timeend = strtotime($row9['endtime']);

                                    while ($timeend != $timestart){
                                        $ctr += 15;
                                        $timeend = strtotime('-15minutes', $timeend);
                                    }
                                }
                                $numhour = $ctr / 60;

                                $totalhr = $numhour + $gethr;

                                if ($numhour == 6){
                                    $message.="<p> Limit for the alloted 6 hours alternative classes has exceeded! You cannot schedule an 
                                    alternative class anymore!";
                                } else if ($totalhr > 6){
                                    $print = 6 - $numhour;
                                    $message.="<p> Class will exceed the alloted 6 hours alternative class! Only ".$print." number of hour(s) are available for 
                                    scheduling";                                 
                                }
                                

                                //Check if alternative date has conflict with plantilla
                                $validity = 0;
                                $course3 = "select coursecode, section, facultyid, dayid, YEAR(NOW()) as schoolyear, roomcode,
                                        concat(starttime,'-',endtime) as originaltime, starttime, endtime, term
                                         from plantilla
                                        where term = (select max(term)
                                                        from plantilla
                                                        where schoolyear = YEAR(NOW()))";
                                $check3 = mysqli_query($dbc,$course3);
                                $adate = new DateTime($_SESSION['altdate']);
                                $aday = date_format($adate, 'd');
                                $amonth = date_format($adate, 'm');
                                $ayear = date_format($adate, 'Y');

                                while ($row4 = mysqli_fetch_array($check3, MYSQLI_ASSOC)){
                                    if (substr(date('D', mktime(0,0,0, $amonth, $aday, $ayear)),0,1) == 'T') {
                                        if (strtoupper(substr(date('D', mktime(0,0,0, $amonth, $aday, $ayear)),1,1)) == 'U') {

                                            if (substr(date('D', mktime(0,0,0, $amonth, $aday, $ayear)),0,1) == "{$row4['dayid']}" &&
                                                $altstarttime >= "{$row4['starttime']}" && $altendtime <= "{$row4['endtime']}" &&
                                                "{$row4['roomcode']}" == $_SESSION['venue']) {

                                                $validity = 1;

                                            } else if (substr(date('D', mktime(0,0,0, $amonth, $aday, $ayear)),0,1) == "{$row4['dayid']}" &&
                                                $altstarttime >= "{$row4['starttime']}" && $altstarttime <= "{$row4['endtime']}" ||
                                                $altendtime <= "{$row4['endtime']}" && $altendtime >= "{$row4['starttime']}" ) {

                                                if ("{$row4['roomcode']}" == $_SESSION['venue']) {
                                                   $validity = 1; 
                                                }
                                                

                                            }

                                        } else if (strtoupper(substr(date('D', mktime(0,0,0, $amonth, $aday, $ayear)),1,1)) == 'H') {

                                            if (strtoupper(substr(date('D', mktime(0,0,0, $amonth, $aday, $ayear)),1,1)) == "{$row4['dayid']}" &&
                                                $altstarttime >= "{$row4['starttime']}" && $altendtime <= "{$row4['endtime']}" &&
                                                "{$row4['roomcode']}" == $_SESSION['venue'] ){

                                                $validity = 1;

                                            }else if (strtoupper(substr(date('D', mktime(0,0,0, $amonth, $aday, $ayear)),1,1)) == "{$row4['dayid']}" &&
                                                $altstarttime >= "{$row4['starttime']}" && $altstarttime <= "{$row4['endtime']}" ||
                                                $altendtime <= "{$row4['endtime']}" && $altendtime >= "{$row4['starttime']}"){

                                                if ("{$row4['roomcode']}" == $_SESSION['venue']) {
                                                   $validity = 1; 
                                                }

                                            }

                                        }
                                    } else {
                                        if (substr(date('D', mktime(0,0,0, $amonth, $aday, $ayear)),0,1) == "{$row4['dayid']}" &&
                                            $altstarttime >= "{$row4['starttime']}" && $altendtime <= "{$row4['endtime']}" &&
                                            "{$row4['roomcode']}" == $_SESSION['venue'] ){

                                            $validity = 1;

                                        } else if (substr(date('D', mktime(0,0,0, $amonth, $aday, $ayear)),0,1) == "{$row4['dayid']}" &&
                                            $altstarttime >= "{$row4['starttime']}" && $altstarttime <= "{$row4['endtime']}" ||
                                            $altendtime <= "{$row4['endtime']}" && $altendtime >= "{$row4['starttime']}"){

                                            if ("{$row4['roomcode']}" == $_SESSION['venue']) {
                                               $validity = 1; 
                                            }

                                        }
                                    }

                                }
                                if ($validity == 1){
                                    $message.='<p> Class scheduled has conflict with another class! </p>';
                                }

                                // Check if alternative date has conflict with make up classes
                                $valid2 = 0;
                                $makeup = "SELECT makeupdate, makeupstarttime, makeupendtime, makeuproom from mv_facultymakeup";
                                $getmakeup = mysqli_query($dbc, $makeup);

                                while ($row5=mysqli_fetch_array($getmakeup, MYSQLI_ASSOC)){
                                    if ($_SESSION['altdate'] == "{$row5['makeupdate']}" && $altstarttime >= "{$row5['makeupstarttime']}"
                                        && $altendtime <= "{$row5['makeupendtime']}" && $_SESSION['venue'] == "{$row5['makeuproom']}"){
                                        $valid2 = 1;    
                                    } else if ($_SESSION['altdate'] == "{$row5['makeupdate']}" && $altstarttime >= "{$row5['makeupstarttime']}"
                                        && $altstarttime <= "{$row5['makeupendtime']}" || $altendtime >= "{$row5['makeupstarttime']}" &&
                                        $altendtime <= "{$row5['makeupendtime']}"){

                                        if ($_SESSION['venue'] == "{$row5['makeuproom']}"){
                                            $valid2 = 1;
                                        }
                                            
                                    } 

                                }
                                if($valid2 == 1){
                                    $message.='<p> Class Scheduled has conflict with another class!</p>';
                                }


                                // Check if alternative date has conflict with room transfer
                                $valid4 = 0;
                                $roomtransfer = "SELECT transferdate, starttime, endtime, venue from mv_roomtransfer";
                                $gettransfer = mysqli_query($dbc, $roomtransfer);

                                while ($row8 = mysqli_fetch_array($gettransfer,MYSQLI_ASSOC)){
                                    if ($_SESSION['altdate'] == "{$row8['transferdate']}" && $altstarttime >= "{$row8['starttime']}"
                                    && $altendtime <= "{$row8['endtime']}" && $_SESSION['venue'] == "{$row8['venue']}"){
                                        $valid4 = 1;
                                    } else if ($_SESSION['altdate'] == "{$row8['transferdate']}" && $altstarttime >= "{$row8['starttime']}"
                                    && $altstarttime <= "{$row8['endtime']}" || $altendtime <= "{$row8['endtime']}" && 
                                    $altendtime >= "{$row8['starttime']}" ){

                                        if ($_SESSION['venue'] == "{$row8['venue']}"){
                                             $valid4 = 1;
                                        }
                                       
                                    }
                                }
                                if($valid4 == 1){
                                    $message.='<p> Class Scheduled has conflict with another class!</p>';
                                }
                                
                                //Insert Faculty Attendance Form
                                //get info
                                $getfaculty = "SELECT facultyid, term, schoolyear, roomcode, dayid
                                               from plantilla where coursecode = '{$_SESSION['coursecode']}'
                                               and section ='{$_SESSION['section']}'";
                                $faculty = mysqli_query($dbc,$getfaculty);
                                $row6 = mysqli_fetch_array($faculty,MYSQLI_ASSOC);

                                //get faculty department
                                $getdepartment = "SELECT departmentid from faculty f 
                                                where f.facultyid = '{$row6['facultyid']}'";
                                $department = mysqli_query($dbc, $getdepartment);
                                $row16 = mysqli_fetch_array($department, MYSQLI_ASSOC);

                                // get chairid
                                $getchair = "SELECT chairid from ref_chair rc join ref_department rd on rc.departmentid = rd.departmentid
                                            join faculty f on rd.departmentid = f.departmentid 
                                            where rd.departmentid = '{$row16['departmentid']}' group by 1";
                                $chair = mysqli_query($dbc, $getchair);
                                $row15 = mysqli_fetch_array($chair, MYSQLI_ASSOC);

                                // get deanid
                                $getdean = "SELECT deanid from ref_dean rd join ref_college rc on rd.collegecode = rc.collegecode
                                            join ref_department rdd on rc.collegecode = rdd.collegecode 
                                            join faculty f on rdd.departmentid = f.departmentid
                                            where rdd.departmentid = '{$row16['departmentid']}' group by 1";
                                $dean = mysqli_query($dbc, $getdean);
                                $row17 = mysqli_fetch_array($dean, MYSQLI_ASSOC);


                                // Insert Faculty attendance Form
                                $facultyattendanceform = "INSERT into form_facultyattendanceform(facultyid, chairid, deanid, remarks, facultyapproval,
                                                            chairapproval, deanapproval) VALUES ('{$row6['facultyid']}', '{$row15['chairid']}', 
                                                            '{$row17['deanid']}', 'remark', NOW(),NOW(),NOW()) ";
                                $facultyres = mysqli_query($dbc, $facultyattendanceform);

                                // Get Faculty Attendance Form with last insert id
                                // Gawin ko muna max nalang.
                                $fform = "select MAX(facultyattendanceformcode) as 'formid' from form_facultyattendanceform";
                                $fget = mysqli_query($dbc, $fform);
                                $get = mysqli_fetch_array($fget,MYSQLI_ASSOC);


                                //Insert to Database 

                                if (!isset($message)){
                                    $insert = "insert into mv_roomtransfer(coursecode, facultyid, dayid, schoolyear, term,
                                               section, facultyattendanceformcode, transfercode, transferdate, venue,
                                               starttime, endtime) 
                                               VALUES ('{$_SESSION['coursecode']}', '{$row6['facultyid']}', '{$row6['dayid']}',
                                                '{$row6['schoolyear']}', '{$row6['term']}', '{$_SESSION['section']}', '{$get['formid']}',
                                                '{$_SESSION['type']}', '{$_SESSION['altdate']}', '{$_SESSION['venue']}',
                                                '$altstarttime', '$altendtime')";
                                    $insertres = mysqli_query($dbc,$insert);
                                    if ($insertres){
                                        $message.='<p> Class has been added!';
                                    } 
                                    
                                }

                                if (isset($message)){
                                   echo "<font color='green'>".$message."</font>"; 
                                }
                            }
                        ?>
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


    </body>

</html>
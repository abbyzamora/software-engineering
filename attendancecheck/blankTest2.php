<!DOCTYPE html>
<html>
	<head>
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<link href="css/datepicker3.css" rel="stylesheet">
		<link href="css/styles.css" rel="stylesheet">
		<link href="css/myStyle.css" rel="stylesheet">
		<link href="css/bootstrap-table.css" rel="stylesheet">

		<!--Icons-->
		<script src="js/lumino.glyphs.js"></script>
		<title></title>
	</head>
	<body>
		<button class="btn btn-primary btn-xs" data-toggle="modal" data-target="#myModal$count">
			Details
		</button>
		<!-- Modal -->
		<div class="modal fade" id="" tabindex="-1" role="dialog" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
			<div class="modal-dialog">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<div class="row">
						<h4 class="modal-title" id="myModalLabel">Classes in <u>{$buildingRow['buildingName']}</u></h4>
					</div>
					<h6>for this day: <u>$currentDate</u></h6>
				</div>
				<!-- /.modal-header -->
				<div class="modal-body">
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				</div>
				<!--/.modal-body -->
			</div>
			<!-- /.modal-dialog -->
		</div>

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
<!--
	<button class=\"btn btn-primary btn-xs\" data-toggle=\"modal\" data-target=\"#myModal$count\">
	Details
	</button>
	Modal 
	<div class="modal fade" id="" tabindex="-1" role="dialog" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
		<div class="modal-dialog">
			<div class=\"modal-header\">
					<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-hidden=\"true\">&times;</button>
					<div class=\"row\">
						<h4 class=\"modal-title\" id=\"myModalLabel\">Classes in <u>{$buildingRow['buildingName']}</u></h4>
					</div>
					<h6>for this day: <u>$currentDate</u></h6>
			</div>
			<!-- /.modal-header -->
			<div class="modal-body">
				<div class=\"modal-footer\">
					<button type=\"button\" class=\"btn btn-default\" data-dismiss=\"modal\">Close</button>
				</div>
			</div>
			<!--/.modal-body 
		</div>
		<!-- /.modal-dialog
	</div>
	<!-- 
	<div class=\"modal fade\" id=\"myModal$count\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"myModalLabel\" aria-hidden=\"true\">
		<div class=\"modal-dialog\">
			<div class=\"modal-content\">
				<div class=\"modal-header\">
					<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-hidden=\"true\">&times;</button>
					<div class=\"row\">
						<h4 class=\"modal-title\" id=\"myModalLabel\">Classes in <u>{$buildingRow['buildingName']}</u></h4>
					</div>
					<h6>for this day: <u>$currentDate</u></h6>
				</div>
				<div class=\"modal-body\">";
					
					<div class=\"modal-footer\">
						<button type=\"button\" class=\"btn btn-default\" data-dismiss=\"modal\">Close</button>
					</div>
					<!-- /.modal-footer
				</div>
				<!-- /.modal-content 
			</div>
			<!-- /.modal-dialog 
		</div>
		<!-- /.modal 

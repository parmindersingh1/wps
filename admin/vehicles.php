<?php

session_start();
require_once dirname(__FILE__).'/../api/class.user.php';
require_once dirname(__FILE__).'/../api/class.vehicle.php';
$user_login = new USER();
$user_vehicle = new Vehicle();

include('header.php'); 

	$stmt = $user_vehicle->runQuery('SELECT * FROM tbl_vehicles');
	$stmt->execute();
	$all_vehicles =  $stmt->fetchAll(PDO::FETCH_ASSOC);
	$livetracking = false;
	if(isset($_GET['livetracking'])) {
		$livetracking = true;
	}

 ?>
		
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			
		<div class="row">
			<ol class="breadcrumb">
				<li><a href="#"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
				<li class="active">Home</li>
			</ol>
		</div><!--/.row-->
		
		
		
		<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading">Users</div>
					<div class="panel-body">						
						<div class="table-responsive">
						<table id="vehicletable" class="table">
						   <thead>
						    <tr>						        
						        <th>Name</th>
						        <th>Type</th>
						        <th>Model No</th>
						        <th>Chassis No</th>
						        <th>color</th>	
						    </tr>
						    </thead>
						    <tbody>
						    	<?php
						    		foreach($all_vehicles as $vehicle) {
						    	?>		
						    			<tr>
										    <?php if($livetracking) {?>
							    				<td><a href="vehicle.php?id=<?= $vehicle['vehicleID'] ?>&livetracking"><?= $vehicle['name'] ?></a></td>
							    			<?php } else {?>
							    				 <td><a href="vehicle.php?id=<?= $vehicle['vehicleID'] ?>"><?= $vehicle['name'] ?></a></td>
							    			<?php }?>
									        <td><?= $vehicle['type'] ?></td>
									        <td><?= $vehicle['model_no'] ?></td>
									        <td><?= $vehicle['chassis_no'] ?></td>
									        <td><?= $vehicle['color'] ?></td>
									    </tr>
								<?php	    
						    		}
						    	?>
						    </tbody>
						</table>
						</div>
					</div>
				</div>
			</div>
		</div><!--/.row-->	
		
		
		
	</div><!--/.main-->

	<script src="js/jquery-1.11.1.min.js"></script>
	<script src="js/bootstrap.min.js"></script>	
	<script src="js/jquery.dataTables.min.js"></script>
	<script src="js/dataTables.bootstrap.js"></script>
	<script src="js/chart.min.js"></script>
	<script src="js/chart-data.js"></script>
	<script src="js/easypiechart.js"></script>
	<script src="js/easypiechart-data.js"></script>
	<script src="js/bootstrap-datepicker.js"></script>
	
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

		$(document).ready(function() {
		    $('#vehicletable').DataTable();
		} );
	</script>	
</body>

</html>

<?php

session_start();
require_once dirname(__FILE__).'/../api/class.user.php';
require_once dirname(__FILE__).'/../api/class.vehicle.php';
$user_login = new USER();
$user_vehicle = new Vehicle();

include('header.php'); 

	$stmt = $user_vehicle->runQuery('SELECT * FROM tbl_vehicles WHERE user_id = :user_id');
	$stmt->execute(array(":user_id"=>$currentUser->userID));
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
					<div class="panel-heading">Vehicles
					<?php
					if(!$livetracking) { 
						?>
						 <a href="create_vehicle.php" data-original-title="Create Vehicle" data-toggle="tooltip" type="button" class="btn btn-sm btn-info pull-right"><i class="glyphicon glyphicon-plus"></i> Create Vehicle </a>
					<?php	 
						}
					?>
					</div>
					<div class="panel-body">	

					<div class="alert alert-success" style="display:none;">
						<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					  
					</div>


					<?php if(isset($_GET['message'])) {
							echo '<div class="alert alert-success" >
								  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
								 <strong>Success !</strong>Vehicle Removed Successfully
								</div>';
						}	
					?>	

						
					<?php if(isset($_GET['error'])) {
							echo '<div class="alert alert-danger">
								  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
								  <strong>Warning !</strong>Atleast one Vehicle is Required
								</div>';
						}	
					?>			
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


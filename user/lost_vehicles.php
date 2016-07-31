<?php
session_start();
require_once dirname(__FILE__).'/../api/class.user.php';
require_once dirname(__FILE__).'/../api/class.vehicle.php';
$user_login = new USER();
$user_vehicle = new Vehicle();
include('header.php'); 
	$userID = $currentUser->userID;
	$stmt = $user_login->runQuery("SELECT lv.id as id, v.vehicleID as vehicle_id, v.name as vehicle_name,v.model_no as vehicle_no, v.chassis_no as chassis_no,lv.address as location, if(lv.is_lost, 'true', 'false') as is_lost, lv.date_of_lost as date_of_lost, CONCAT(u.first_name, ' ', u.last_name) as user_name, u.phone as phone FROM tbl_lost_vehicles as lv JOIN tbl_vehicles as v on v.vehicleID = lv.vehicle_id JOIN tbl_users as u on v.user_id = u.userID WHERE lv.is_lost = 1 ORDER BY lv.id DESC");
	    $stmt->bindparam(":user_id",$userID, PDO::PARAM_INT);
      $stmt->execute();
      $lostVehicles = $stmt->fetchAll(PDO::FETCH_ASSOC);
      
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
					<div class="panel-heading">User Notifications</div>
					<div class="panel-body">						
						<div class="table-responsive">
						<table id="vehicletable" class="table">
						   <thead>
						    <tr>						        
						        <th>User</th>
						        <th>Vehicle</th>
						        <th>Location</th>
						        <th>Date/Time</th>	
						        <th>Status</th>
						        <th>Action</th>
						    </tr>
						    </thead>
						    <tbody>
						    	<?php
						    		foreach($lostVehicles as $lostVehicle) {
						    	?>		
						    			<tr>
									        <td><a href="user_details.php?id=<?= $userID ?>"><?= $lostVehicle['user_name'] ?></a></td>
									        <td><a href="search_vehicle.php?id=<?= $lostVehicle['vehicle_id'] ?>"><?= $lostVehicle['vehicle_name'] ?></a></td>
									        <td><?= $lostVehicle['location'] ?></td>
									        <td><?= $lostVehicle['date_of_lost'] ?></td>
									        <td><?= filter_var($lostVehicle['is_found'], FILTER_VALIDATE_BOOLEAN) ? "Recovered": "Lost" ?></td>
									        <td><a href="delete_notification.php?notID=<?= $lostVehicle['id']?>" data-original-title="Remove" data-toggle="tooltip" type="button" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-remove"></i></a></td>
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
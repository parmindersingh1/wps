<?php

session_start();
require_once dirname(__FILE__).'/../api/class.user.php';
require_once dirname(__FILE__).'/../api/class.vehicle.php';
$user_login = new USER();
$user_vehicle = new Vehicle();

include('header.php'); 

	$stmt = $user_vehicle->runQuery("SELECT us.id as id,u.userID as user_id, v.vehicleID as vehicle_id,CONCAT_WS(' ',u.first_name,u.last_name) as name, v.name as vehicle_name, DATE_FORMAT(us.created_at,'%d %b %Y %r') as date, us.location as location FROM tbl_users_searches as us JOIN tbl_users as u on u.userID = us.user_id JOIN tbl_vehicles as v on v.vehicleID = us.vehicle_id");
	$stmt->execute();
	$all_searches =  $stmt->fetchAll(PDO::FETCH_ASSOC);


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
					<div class="panel-heading">Searches</div>
					<div class="panel-body">						
						<div class="table-responsive">
						<table id="vehicletable" class="table">
						   <thead>
						    <tr>						        
						        <th>User</th>
						        <th>Vehicle</th>
						        <th>Date/Time</th>	
						        <th>Location</th>		
						        <th>Delete</th>
						    </tr>
						    </thead>
						    <tbody>
						    	<?php
						    		foreach($all_searches as $search) {
						    	?>		
						    			<tr>
									        <td><a href="user.php?id=<?= $search['user_id'] ?>"><?= $search['name'] ?></a></td>
									        <td><a href="vehicle.php?id=<?= $search['vehicle_id'] ?>"><?= $search['vehicle_name'] ?></a></td>
									        <td><?= $search['date'] ?></td>
									         <td><?= $search['location'] ?></td>		
									        <td><a href="delete_search.php?searchID=<?= $search['id']?>" data-original-title="Remove" data-toggle="tooltip" type="button" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-remove"></i></a></td>
									        
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


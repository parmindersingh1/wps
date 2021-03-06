<?php

session_start();
require_once dirname(__FILE__).'/../api/class.user.php';
require_once dirname(__FILE__).'/../api/class.vehicle.php';
$user_login = new USER();
$user_vehicle = new Vehicle();

include('header.php'); 

	$stmt = $user_login->runQuery('SELECT * FROM tbl_users');
	$stmt->execute();
	$all_users =  $stmt->fetchAll(PDO::FETCH_ASSOC);


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
					<div class="panel-heading">Users Live Tracking</div>
					<div class="panel-body">						
						<div class="table-responsive">
						<table id="usertable" class="table">
						    <thead>
						    <tr>
						        <th>Email</th>
						        <th>Name</th>
						        <th>Date Of Birth</th>
						        <th>Gender</th>
						        <th>Phone</th>
						        <th>Adhar Card No</th>	
						        <th>Confirm Pin</th>
						        <th>Status</th>
						    </tr>
						    </thead>
						    <tbody>
						    	<?php
						    		foreach($all_users as $user) {
						    	?>		
						    	            <?php 
						    	               $userStatus = "";
									        	if(filter_var($user["is_blocked"], FILTER_VALIDATE_BOOLEAN)){
									        		$userStatus = "Blocked";
									        	} else if($user['userStatus']=="N") {
									        		$userStatus = "Deactivated";
									        	} else {
									        		$userStatus = "Activated";
									        	}

									        	$time = strtotime($user['date_of_birth']);
												$newformatDob = date('d/m/Y',$time);
									         ?>
						    			<tr>
									        <td><a href="user_vehicles.php?userID=<?= $user['userID'] ?>&livetracking"><?= $user['userEmail'] ?></a></td>
									        <td><?= $user['first_name'].' '.$user['last_name'] ?></td>
									        <td><?= $newformatDob ?></td>
									        <td><?= $user["gender"] ?></td>
									        <td><?= $user['phone'] ?></td>							        
									        <td><?= $user['adhar_card_no'] ?></td>	
									        <td><?= $user['tokenCode'] ?></td>
									        <td><?= $userStatus ?></td>
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
		    $('#usertable').DataTable();
		} );
	</script>	
</body>

</html>

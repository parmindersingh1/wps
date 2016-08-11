<?php

session_start();
require_once dirname(__FILE__).'/../api/class.user.php';
require_once dirname(__FILE__).'/../api/class.vehicle.php';
$user_login = new USER();
$user_vehicle = new Vehicle();

include('header.php'); 

	$userID = $currentUser->userID;
	$stmt = $user_login->runQuery("SELECT n.id as id, un.id as unID, n.message as notification FROM tbl_notifications as n JOIN `tbl_users_notifications` as un on un.notification_id = n.id  WHERE un.user_id = :user_id ORDER BY n.id DESC LIMIT 50");
	    $stmt->bindparam(":user_id",$userID, PDO::PARAM_INT);
      $stmt->execute();
      $notifications = $stmt->fetchAll(PDO::FETCH_ASSOC);
      



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
						        <th>Message</th>						        
						    </tr>
						    </thead>
						    <tbody>
						    	<?php
						    		foreach($notifications as $notification) {
						    	?>		
						    			<tr>
									        <td><a href="notification_details.php?notID=<?= $notification['id'] ?>"><?= substr($notification['notification'],0,20) ?>...</a></td>									        
									        <td><a href="delete_notification.php?notID=<?= $notification['unID']?>" data-original-title="Remove" data-toggle="tooltip" type="button" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-remove"></i></a></td>
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

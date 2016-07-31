<?php

session_start();
require_once dirname(__FILE__).'/../api/class.user.php';
require_once dirname(__FILE__).'/../api/class.vehicle.php';
$user_login = new USER();
$user_vehicle = new Vehicle();

include('header.php'); 
if($_GET['id']) {
	$vehicleID = $_GET['id'];
	 $sql    = "SELECT * FROM tbl_vehicles WHERE vehicleID = :vehicle_id";
	$stmt   = $user_vehicle->runQuery($sql);
	$result = $stmt->execute(array(":vehicle_id" => $vehicleID));
	$vehicle   = $stmt->fetch(PDO::FETCH_ASSOC);
} else {
	header('Location: ' . $_SERVER['HTTP_REFERER']);
}

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
					<div class="panel-heading"><?php echo ucwords($vehicle["name"])?></div>
					<div class="panel-body">	





					<div class="container">
				      <div class="row">
				      
				       <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9 col-xs-offset-0 col-sm-offset-0 col-md-offset-1 col-lg-offset-1 toppad">
				   
				   
				          <div class="panel panel-info">				           
				            <div class="panel-body">
				              <div class="row">
				                <div class="col-md-3 col-lg-3 " align="center"><?php
				                echo '<img src="data:image/jpeg;base64,'.base64_decode(base64_encode( $vehicle['photo'] )).' " class="img-circle img-responsive"/>';
				                ?>
				                 </div>
				                
				              
				                <div class=" col-md-9 col-lg-9 "> 
				                  <table class="table table-user-information">
				                    <tbody>				                     
				                      <tr>
				                        <td>Vehicle Name</td>
				                        <td><?php echo ucwords($vehicle["name"])?></td>
				                      </tr>

				                      <tr>
				                        <td>Type</td>
				                        <td><?php echo $vehicle['type']?></td>
				                      </tr>
				                   
				                         <tr>
				                             <tr>
				                        <td>Model No</td>
				                        <td><?php echo $vehicle['model_no']?></td>
				                      </tr>
				                        <tr>
				                        <td>Chassis No</td>
				                        <td><?php echo $vehicle['chassis_no']?></td>
				                      </tr>
				                      <tr>
				                        <td>Color</td>
				                        <td><?php echo $vehicle['color']?></td>
				                      </tr>	

				                                                 
				                      </tr>
				                     
				                    </tbody>
				                  </table>
				                  
				              <a href="user.php?id=<?= $vehicle["user_id"]?>" class="btn btn-primary">Vehicle Owner</a>
				               
				                </div>
				              </div>
				            </div>
                 <div class="panel-footer">                       
                        <span class="pull-right">
                        <?php if($livetracking) { ?>
                         <a href="track_vehicle.php?vehicleID=<?=  $vehicle["vehicleID"]?>" data-original-title="Edit this Vehicle" data-toggle="tooltip" type="button" class="btn btn-sm btn-info"><i class="glyphicon glyphicon-edit"></i> Track Vehicle</a>
                         <?php } ?>
                            <a href="edit_vehicle.php?vehicleID=<?=  $vehicle["vehicleID"]?>" data-original-title="Edit this Vehicle" data-toggle="tooltip" type="button" class="btn btn-sm btn-warning"><i class="glyphicon glyphicon-edit"></i> Edit Vehicle</a>
                            <a href="delete_vehicle.php?vehicleID=<?=  $vehicle["vehicleID"]?>" data-original-title="Remove this Vehicle" data-toggle="tooltip" type="button" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-remove"></i> Delete Vehicle</a>
                        </span>
                    </div>
            
          </div>
        </div>
      </div>
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

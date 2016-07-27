<?php

session_start();
require_once dirname(__FILE__).'/../api/class.user.php';
require_once dirname(__FILE__).'/../api/class.vehicle.php';
$user_login = new USER();
$user_vehicle = new Vehicle();

include('header.php'); 

if(isset($_POST['btn-edit']))
{
 
    $vehicleID = isset($_POST['vehicleID']) ? trim($_POST['vehicleID']) : '';
    $imei = isset($_POST['imei']) ? trim($_POST['imei']) : '';
	$subdate = isset($_POST['subdate']) ? trim($_POST['subdate']) : '';
	$subdt = date_create(str_replace('/','-',$subdate));
	$dos = date_format($subdt,"Y-m-d H:i:s");
		
	if($user_vehicle->subscribeVehicle($vehicleID,$imei,$dos)) {           
	    $msg = "
	    <div class='alert alert-success'>
	      <button class='close' data-dismiss='alert'>&times;</button>
	      <strong>Success!</strong>  Vehicle updated. 
	    </div>
	    ";      
	}
	else
	{
	  $msg = "Oops , Something Went Wrong...";
	} 
		  
    $sql    = "SELECT name,vehicleID,imei_no,DATE_FORMAT(date(subscriptiondate),'%d/%m/%Y') as subscriptiondate FROM tbl_vehicles WHERE vehicleID = :vehicle_id";
	$stmt   = $user_login->runQuery($sql);
	$result = $stmt->execute(array(":vehicle_id" => $vehicleID));
	$vehicle   = $stmt->fetch(PDO::FETCH_ASSOC);
  } else if($_GET['vehicleID']) {
	$vehicleID = $_GET['vehicleID'];
	$sql    = "SELECT name,vehicleID,imei_no,DATE_FORMAT(date(subscriptiondate),'%d/%m/%Y') as subscriptiondate FROM tbl_vehicles WHERE vehicleID = :vehicle_id";
	$stmt   = $user_login->runQuery($sql);
	$result = $stmt->execute(array(":vehicle_id" => $vehicleID));
	$vehicle   = $stmt->fetch(PDO::FETCH_ASSOC);
} else {
	header('Location: ' . $_SERVER['HTTP_REFERER']);
}


 ?>
		
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			
		<div class="user">
			<ol class="breadcrumb">
				<li><a href="#"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
				<li class="active">Home</li>
			</ol>
		</div><!--/.user-->
		
		
				
		<div class="user">
			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading"><?php echo ucwords($vehicle["name"])?></div>
					<div class="panel-body">	


				

					<div class="container">
				      <div class="user">
				      
				       <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 toppad">
				   
				   
				          <div class="panel panel-info">				           
				            <div class="panel-body">
				              <div class="user">
				               				                
				              
				                <div class=" col-md-9 col-lg-9 "> 
				                  
				                  <?php if(isset($msg)) echo $msg;  ?>
						            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" class="form-signin" method="post">      
						             
						              <div class="form-group">
						                <input type="text" class="form-control" placeholder="Imei No" name="imei" required value="<?php echo $vehicle['imei_no'] ?>"/>
						              </div>						              
						              
						            <div class="form-group">
						              <input type="text" id="subsDatepicker" class="form-control" placeholder="Subscription Date" name="subdate"  value="<?php echo $vehicle['subscriptiondate'] ?>"/>
						            </div>

						            <input type="hidden" name="vehicleID" value="<?= $vehicle['vehicleID'] ?>" />
						            					            

						            <hr />
						            <div class="form-group">
						              <button class="btn btn-large btn-primary" type="submit" name="btn-edit">Update</button>
						            </div>
						          </form>				                  
				                  
				               
				                </div>
				              </div>
				            </div>
                 
            
			          </div>
			        </div>
			      </div>
			    </div>






						
					</div>
				</div>
			</div>
		</div><!--/.user-->	
		
		
		
	</div><!--/.main-->

	<script src="js/jquery-1.11.1.min.js"></script>
	<script src="js/bootstrap.min.js"></script>	
	<script src="js/jquery.dataTables.min.js"></script>
	<script src="js/dataTables.bootstrap.js"></script>
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
		    $('#subsDatepicker').datepicker({
		    	format: 'dd/mm/yyyy'  	
		    });
		} );
	

	</script>	
</body>

</html>

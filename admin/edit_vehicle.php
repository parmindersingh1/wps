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
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';
	$type = isset($_POST['type']) ? trim($_POST['type']) : '';
	$model = isset($_POST['model_no']) ? trim($_POST['model_no']) : '';
	$chassis = isset($_POST['chassis_no']) ? trim($_POST['chassis_no']) : '';	
	$photo = isset($_POST['photo']) ? trim($_POST['photo']) : '';
	$colour = isset($_POST['colour']) ? trim($_POST['colour']) : '';


		if($user_vehicle->isValidVehicleNumber($model) && $user_vehicle->isValidChassisNumber($chassis)) {
			if($user_vehicle-> update($name,$type,$model,$chassis,$photo,$colour,$vehicleID)) {           
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
		} else {
			$msg = "Enter Valid Model or Chassis Number ";
		}    
    $sql    = "SELECT * FROM tbl_vehicles WHERE vehicleID = :vehicle_id";
	$stmt   = $user_login->runQuery($sql);
	$result = $stmt->execute(array(":vehicle_id" => $vehicleID));
	$vehicle   = $stmt->fetch(PDO::FETCH_ASSOC);
  } else if($_GET['vehicleID']) {
	$vehicleID = $_GET['vehicleID'];
	$sql    = "SELECT * FROM tbl_vehicles WHERE vehicleID = :vehicle_id";
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
				                <div class="col-md-3 col-lg-3 " align="center"><?php
				                echo '<img id="vehicleImg" src="data:image/jpeg;base64,'.base64_decode(base64_encode( $vehicle['photo'] )).' " class="img-circle img-responsive"/>';
				                ?>
				                <div class="row">
				                <input id="inputFileToLoad" type="file" name="uploadimage" multiple onchange="handleFileSelect(this)">
				                </div>
				                 </div>
				                
				              
				                <div class=" col-md-9 col-lg-9 "> 
				                  
				                  <?php if(isset($msg)) echo $msg;  ?>
						            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" class="form-signin" method="post">      
						             
						              <div class="form-group">
						                <input type="text" class="form-control" placeholder="Name" name="name" required value="<?php echo $vehicle['name'] ?>"/>
						              </div>						              
						              <div class="form-group">
						                <select class="form-control" name="type" required> 
						                 <option>Vehicle Type</option>
						                 <option value="2 Wheeler" <?php echo $vehicle['type'] == "2 Wheeler"? 'selected': '' ?> >2 Wheeler</option>
						                 <option value="3 Wheeler" <?php echo $vehicle['type'] == "3 Wheeler"? 'selected': '' ?>>3 Wheeler</option>
						                 <option value="4 Wheeler" <?php echo $vehicle['type'] == "4 Wheeler"? 'selected': '' ?>>4 Wheeler</option>
						               </select>
						             </div>						             					            
						            <div class="form-group">
						              <input type="text" class="form-control" placeholder="Model No" name="model_no"  value="<?php echo $vehicle['model_no'] ?>"/>
						            </div>
						            <div class="form-group">
						              <input type="text" class="form-control" placeholder="Chassis No" name="chassis_no"  value="<?php echo $vehicle['chassis_no'] ?>"/>
						            </div>
						            <div class="form-group">
						              <input type="text" class="form-control" placeholder="Colour" name="colour"  value="<?php echo $vehicle['color'] ?>"/>
						            </div>

						            <input type="hidden" name="vehicleID" value="<?= $vehicle['vehicleID'] ?>" />
						            <input type="hidden"  name="photo" value="<?= base64_decode(base64_encode( $vehicle['photo'] )) ?>" />

						            

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
		    $('#birthDatepicker').datepicker({
		    	format: 'dd/mm/yyyy'  	
		    });
		} );
		function handleFileSelect(input) {
			 if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function (e) {
                $('#vehicleImg').attr('src', e.target.result);
                $("input[name='photo'").val(e.target.result.split(',')[1]);
                console.log(e.target.result.split(',')[1]);
            }
            
            reader.readAsDataURL(input.files[0]);
        }
		}

	</script>	
</body>

</html>

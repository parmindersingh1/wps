<?php

session_start();
require_once dirname(__FILE__).'/../api/class.user.php';
require_once dirname(__FILE__).'/../api/class.vehicle.php';
$user_login = new USER();
$user_vehicle = new Vehicle();

include('header.php'); 

if(isset($_POST['btn-vehicle']))
{ 
	$userID = $currentUser->userID;
    if(isset($_POST['name']) && isset($_POST['type']) && isset($_POST['model_no']) && isset($_POST['chassis_no']) && isset($_POST['photo']) && isset($_POST['colour'])) {
		$name = isset($_POST['name']) ? trim($_POST['name']) : '';
		$type = isset($_POST['type']) ? trim($_POST['type']) : '';
		$model = isset($_POST['model_no']) ? trim($_POST['model_no']) : '';
		$chassis = isset($_POST['chassis_no']) ? trim($_POST['chassis_no']) : '';	
		$photo = isset($_POST['photo']) ? trim($_POST['photo']) : '';
		$colour = isset($_POST['colour']) ? trim($_POST['colour']) : ''; 
		if($user_vehicle->isValidVehicleNumber($model)) {
			$stmt = $user_vehicle->runQuery("SELECT * FROM tbl_vehicles WHERE LOWER(REPLACE(model_no, ' ', '')) = LOWER(REPLACE(:model_no, ' ', ''))  OR  LOWER(REPLACE(chassis_no, ' ', '')) = LOWER(REPLACE(:chassis_no, ' ', ''))");
			$stmt->bindparam(":model_no",$model);
			$stmt->bindparam(":chassis_no",$chassis);
			$stmt->execute();
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			

			if($stmt->rowCount() > 0) {
				$msg = "
			    <div class='alert alert-danger'>
			      <button class='close' data-dismiss='alert'>&times;</button>
			      <strong>Warning !</strong> Vehicle already exists , Please Try another one 
			    </div>
			    ";     				
			} else if($user_vehicle->save($name,$type,$model,$chassis,$photo,$colour,$userID)) {	
				$msg = "
			    <div class='alert alert-success'>
			      <button class='close' data-dismiss='alert'>&times;</button>
			      <strong>Success !</strong> Vehicle Created Successfully. 
			    </div>
			    ";   		
			}
			else
			{
				$msg = "
			    <div class='alert alert-danger'>
			      <button class='close' data-dismiss='alert'>&times;</button>
			      <strong>Warning !</strong> Vehicle already exists , Please Try another one. 
			    </div>
			    ";   				
			}	
		} else {	
			$msg = "
			    <div class='alert alert-danger'>
			      <button class='close' data-dismiss='alert'>&times;</button>
			      <strong>Warning !</strong> Enter Valid Vehicle Number ... 
			    </div>
			    ";   			
		}
    } else {	
		$msg = "
			    <div class='alert alert-danger'>
			      <button class='close' data-dismiss='alert'>&times;</button>
			      <strong>Warning !</strong> All fields mandatory. 
			    </div>
			    ";   	
	}
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
					<div class="panel-heading">Create Vehicle</div>
					<div class="panel-body">

					<div class="container">
				      <div class="user">
				      
				       <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 toppad">
				   
				   
				          <div class="panel panel-info">				           
				            <div class="panel-body">
				              <div class="user">
				                <div class="col-md-3 col-lg-3 " align="center">	
				                <?php
				                echo '<img id="vehicleImg"  class="img-circle img-responsive"/>';
				                ?>
				                <div class="row">

				                <label class="btn btn-default btn-file">
								    Vehicle Image <input type="file" id="inputFileToLoad" style="display: none;" name="uploadimage"  onchange="handleFileSelect(this)">
								</label>
				                
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
						                 <option value="2 Wheeler" >2 Wheeler</option>
						                 <option value="3 Wheeler" >3 Wheeler</option>
						                 <option value="4 Wheeler" >4 Wheeler</option>
						        	<option value="4 and above" >4 and above</option>   
							    </select>
						             </div>						             					            
						            <div class="form-group">
						              <input type="text" class="form-control" placeholder="Model No" name="model_no" />
						            </div>
						            <div class="form-group">
						              <input type="text" class="form-control" placeholder="Chassis No" name="chassis_no" />
						            </div>
						            <div class="form-group">
						              <input type="text" class="form-control" placeholder="Colour" name="colour" />
						            </div>

						            <input type="hidden"  name="photo" />
						            

						            <hr />
						            <div class="form-group">
						              <button class="btn btn-large btn-primary" type="submit" name="btn-vehicle">Create</button>
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
            }
            
            reader.readAsDataURL(input.files[0]);
        }
		}

	</script>	
</body>

</html>


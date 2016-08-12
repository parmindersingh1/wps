<?php

session_start();
require_once dirname(__FILE__).'/../api/class.user.php';
require_once dirname(__FILE__).'/../api/class.vehicle.php';
$user_login = new USER();
$user_vehicle = new Vehicle();

include('header.php'); 

$stmt = $user_vehicle->runQuery("SELECT * FROM tbl_vehicles WHERE user_id = :user_id");
$stmt->bindparam(":user_id",$currentUser->userID, PDO::PARAM_INT);
$stmt->execute();
$vehicles = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $user_vehicle->runQuery("SELECT theft_alerts FROM tbl_users_demos WHERE user_id = :user_id");
$stmt->bindparam(":user_id",$currentUser->userID, PDO::PARAM_INT);
$stmt->execute();
$alertCount = $stmt->fetchColumn();
// var_dump($alertCount);
// die();
?>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDOzwf7l3jIW3LA3aAKCDxKyi-99yWoZWo&libraries=places"></script>

<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			
	<div class="row">
		<ol class="breadcrumb">
			<li><a href="#"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
			<li class="active">Home</li>
		</ol>
	</div><!--/.row-->
	
	
<div class="modal fade" id="demoAlertCount" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Information (This is Demo)</h4>
        </div>
        <div class="modal-body">
          <p> You have <?= $alertCount ?> Demo Remaining</p>
        </div>
         <div class="modal-footer">
		    <button type="button" data-dismiss="modal" class="btn btn-primary" id="okBtn">Ok</button>
		  </div>
      </div>
      
    </div>
  </div>

	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">Demo Theft Alert</div>
				<div class="panel-body">	


					<div class="alert alert-success" style="display:none;">
						<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					  
					</div>

					

					<div class="alert alert-danger" style="display:none;">
						<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					  
					</div>
					<input type="hidden" id="alertCount" value="<?=$alertCount ?>">

					<div class="container">
						<div class="row">
							
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 toppad">
								
								
								<div class="panel panel-info">				           
									<div class="panel-body">
										<div class="row">
											
											<div class=" col-md-3 col-lg-3 col-md-offset-3 col-lg-offset-3"> 
				                  
						                  <?php if(isset($msg)) echo $msg;  ?>
								            <form action="<?php echo $_SERVER->PHP_SELF; ?>" id="form-alert" method="post">       
								              <div class="form-group">       
								               <select  name="vehicleID" class="form-control">
								               	<option value="">Select Vehicle</option>
								               	<?php  
								                  	foreach($vehicles as $vehicle) {
              											echo "<option value='".$vehicle['vehicleID']."'>".$vehicle['name']."</option>";
								                  	}
								               	  ?>
								               </select>       
								              </div>								              
								             
								              <div class="form-group">
								                 <input id="autocomplete" placeholder="Enter your Location" class="form-control" name="location"  type="text" required=""></input>
								              </div>				              
								            					            
								            			            
								           <input type="hidden" name="dol" value="" />
								           <input type="hidden" name="local" value="true" />
								            

								            <div class="form-group">
								             <center> <button class="btn btn-large btn-primary" type="submit" name="btn-edit">Alert</button></center>
								            </div>
								          </form>				                  
						                  
						               
						                </div>
						                <div class="clearfix"></div>
						                <hr>
						                

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
	
	<script>
		!function ($) {
			$(document).on("click","ul.nav li.parent > a > span.icon", function(){		  
				$(this).find('em:first').toggleClass("glyphicon-minus");	  
			}); 
			$(".sidebar span.icon").find('em:first').addClass("glyphicon-plus");
		}(window.jQuery);

		function initialize() {

			var input = document.getElementById('autocomplete');
			var autocomplete = new google.maps.places.Autocomplete(input);
		}

		google.maps.event.addDomListener(window, 'load', initialize);

		$(window).on('resize', function () {
			if ($(window).width() > 768) $('#sidebar-collapse').collapse('show')
		})
		$(window).on('resize', function () {
			if ($(window).width() <= 767) $('#sidebar-collapse').collapse('hide')
		})

		$(document).ready(function() {
			$('#usertable').DataTable();
			 $('#demoAlertCount').modal({ backdrop: 'static', keyboard: false })
			 	.one('click', '#okBtn', function (e) {	
			 		if(parseInt($("#alertCount").val()) <= 0) {
			 			window.location.href = 'index.php';
			 		} 

			 	});

			$("#form-alert").on("submit",function (event) {
				$("input[name='dol']").val((new Date()).toISOString());
				event.preventDefault();
				var vehID = $("select[name='vehicleID']").val();
				var location = $("input[name='location']").val();
				var sendData = $(this).serialize();
				if(!isEmpty(vehID) && !isEmpty(location)) {	
					$('#confirmDemoAlert').modal({ backdrop: 'static', keyboard: false })
	        		.one('click', '#delete', function (e) {		

						$('.preloader').fadeIn();	

						$.post('../api/demo_alert.php',sendData,function (data) {
							$('.preloader').fadeOut();				
							
							if(data.success) {
								// $(".alert-success").empty()
								// 		  .html('<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong>Success </strong>'+data.message)
								// 		  .show();

								window.location.href = 'index.php';
								
							} else {
								$(".alert-danger").empty()
										  .html('<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong>Warning </strong>'+data.message)
										  .show();
							}
							
						});
					});
				} else {
					$(".alert-danger").empty()
									  .html('<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong>Warning </strong>All Feilds Required')
									  .show();
				}



			});

			function isEmpty(str) {
				return str.length === 0
			}


		} );

	 

	</script>	
</body>

</html>


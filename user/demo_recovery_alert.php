<?php

session_start();
require_once dirname(__FILE__).'/../api/class.user.php';
require_once dirname(__FILE__).'/../api/class.vehicle.php';
$user_login = new USER();
$user_vehicle = new Vehicle();

include('header.php'); 
// if(isset($_GET['id']) && isset($_GET['lvID'])){
	// $vehicleID = $_GET['id'];
	// $sql    = "SELECT * FROM tbl_vehicles WHERE vehicleID = :vehicle_id";
	// $stmt   = $user_vehicle->runQuery($sql);
	// $result = $stmt->execute(array(":vehicle_id" => $vehicleID));
	// $vehicle  = $stmt->fetch(PDO::FETCH_ASSOC);
	// $alertId = $_GET['lvID'];

	// $stmt = $user_vehicle->runQuery("SELECT * FROM  tbl_lost_vehicles  WHERE id = :alert_id");
	// $stmt->bindparam(":alert_id",$alertId, PDO::PARAM_INT);
	// $stmt->execute();
	// $alert  = $stmt->fetch(PDO::FETCH_ASSOC);
    $currAlert = array();
    $currAlert["setPhone"] = "98XXXXXXXX";
    $currAlert["chassis_no"]= "CHXXXXXXX";
    $currAlert["date_of_lost"]= date('d/m/Y g:i a');
    $currAlert["id"]= 0;
    $currAlert["is_lost"]= true;
    $currAlert["location"]= "XXXXXX XXXXX";
    $currAlert["user_name"]= "Demo User";
    $currAlert["vehicle_name"]= "Demo Vehicle";
    $currAlert["vehicle_no"]= "XX XXXXXX";
    $alertId = $currAlert["id"];
// } else {
// 	header('Location: ' . $_SERVER['HTTP_REFERER']);
// }

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
					<div class="panel-heading"><?php echo ucwords($currAlert["vehicle_name"])?></div>
					<div class="panel-body">	

					<div class="alert alert-success" style="display:none;">
						<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					  
					</div>

					

					<div class="alert alert-danger" style="display:none;">
						<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					  
					</div>




					<div class="container">
				      <div class="row">
				      
				       <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9 col-xs-offset-0 col-sm-offset-0 col-md-offset-1 col-lg-offset-1 toppad">
				   
				   
				          <div class="panel panel-info">				           
				            <div class="panel-body">
				              <div class="row">
				                <div class="col-md-3 col-lg-3 " align="center"><?php
				                echo '<img src="../images/demo.jpg" class="img-circle img-responsive"/>';
				                ?>
				                 </div>
				                
				              
				                <div class=" col-md-9 col-lg-9 "> 
				                <div class="table-responsive">
				                  <table class="table table-user-information">
				                    <tbody>				                     
				                      <tr>
				                        <td>Vehicle Name</td>
				                        <td><?php echo ucwords($currAlert["vehicle_name"])?></td>
				                      </tr>

				                      <tr>
				                        <td>Vehicle Number</td>
				                        <td><?php echo $currAlert['vehicle_no']?></td>
				                      </tr>
				                   
				                      <tr>
				                        <td>Chassis No</td>
				                        <td><?php echo $currAlert['chassis_no']?></td>
				                      </tr>
				                      <tr>
				                        <td>Date of Lost</td>
				                        <td><?php echo $currAlert['date_of_lost']?></td>
				                      </tr>	
				                      <tr>
				                        <td>Location</td>
				                        <td><?php echo $currAlert['location']?></td>
				                      </tr>	

				                      <tr>
				                        <td>Status</td>
				                        <td><?php echo (filter_var($currAlert['is_lost'], FILTER_VALIDATE_BOOLEAN))?  "Lost" :"Recovered"   ?></td>
				                      </tr>

				                                                 
				                      </tr>
				                     
				                    </tbody>
				                  </table>
				                  </div>
				             
				               
				                </div>
				              </div>
				            </div>

				         <input type="hidden" id="userId" value="<?= $userId ?>">   
				<?php if (filter_var($currAlert['is_lost'], FILTER_VALIDATE_BOOLEAN)) { ?>           
                 <div class="panel-footer">                       
                        <span class="pull-right">
                            <a href="#" id="foundNotification" data-not="<?= $alertId ?>" data-original-title="Vehicle Recovered" data-toggle="tooltip" type="button" class="btn btn-sm btn-warning"><i class="glyphicon glyphicon-edit"></i>Recovered</a>
                            
                        </span>
                    </div>
                 <?php } ?>   
            
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

		$("#foundNotification").on("click",function (event) {
			// body...			
			var me = this;
			event.preventDefault();
			$('#confirmRecovery').modal({ backdrop: 'static', keyboard: false })
	        	.one('click', '#delete', function (e) {
	        		$('.preloader').fadeIn();
	        		var data = {
	        					alertId: $(me).data("not"),
	        					userId: $("#userId").val()
	        					};
					$.post('../api/demo_recover.php',data,function (data) {
						$('.preloader').fadeOut();	
						if(data.success) {
							$(".alert-success").empty()
									  .html('<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong>Success </strong>'+data.message)
									  .show();
									  location.reload();
							
						} else {
							$(".alert-danger").empty()
									  .html('<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong>Warning </strong>'+data.message)
									  .show();
						}

					});        		
	            	
	        });

			
		});
	</script>	
</body>

</html>


<?php

session_start();
require_once dirname(__FILE__).'/../api/class.user.php';
require_once dirname(__FILE__).'/../api/class.vehicle.php';
$user_login = new USER();
$user_vehicle = new Vehicle();

include('header.php'); 



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
				<div class="panel-heading"><?php echo ucwords($currentUser->first_name.' '.$currentUser->last_name)?></div>
				<div class="panel-body">	





					<div class="container">
						<div class="row">
							
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 toppad">
								
								
								<div class="panel panel-info">				           
									<div class="panel-body">
										<div class="row">
											<div class="col-md-3 col-lg-3 " align="center"><?php
												echo '<img src="data:image/jpeg;base64,'.base64_decode(base64_encode( $currentUser->photo )).' " class="img-circle img-responsive"/>';
												?>
											</div>
											
											
											<div class=" col-md-9 col-lg-9 "> 
											<div class="table-responsive">
												<table class="table table-user-information">
													<tbody>				                     
														<tr>
															<td>Full Name</td>
															<td><?php echo ucwords($currentUser->first_name.' '.$currentUser->last_name)?></td>
														</tr>

														<tr>
															<td>Date of Birth</td>
															<?php $time = strtotime($currentUser->date_of_birth);
															$newformatDob = date('d/m/Y',$time);?>
															<td><?php echo $newformatDob ?></td>
														</tr>
														
														<tr>
															<tr>
																<td>Gender</td>
																<td><?php echo $currentUser->gender?></td>
															</tr>
															<tr>
																<td>Phone</td>
																<td><?php echo $currentUser->phone?></td>
															</tr>
															<tr>
																<td>Email</td>
																<td><a href="mailto:<?php echo $currentUser->userEmail?>"><?php echo $currentUser->userEmail?></a></td>
															</tr>	
															
															<tr>
																<td>Adhar Card No</td>
																<td><?php echo  $currentUser->adhar_card_no?></td>
															</tr>	
															<tr>
																<td>Pan Card</td>
																<td><?php echo $currentUser->pan_card_no?></td>
															</tr>	
															<tr>
																<td>Voter Card</td>
																<td><?php echo $currentUser->voter_card_no?></td>
															</tr>	
															
														</tbody>
													</table>
													</div>
													<a href="change_password.php" class="btn btn-primary">Change Password</a>
													
													
												</div>
											</div>
										</div>
										<div class="panel-footer">                       
											<span class="pull-right">
												<a href="edit_user.php" data-original-title="Edit this user" data-toggle="tooltip" type="button" class="btn btn-sm btn-info"><i class="glyphicon glyphicon-edit"></i> Edit Profile</a>	
												<a href="#" id="deactivateLink" data-userid="<?= $currentUser->userID ?>" data-original-title="Deacivate Account" data-toggle="tooltip" type="button" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-remove"></i>Deactivate Account</a>		                           
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
		




  <!-- Modal -->
  <div class="modal fade" id="confirmDeactivate" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Confirmation</h4>
        </div>
        <div class="modal-body">
          <p> Are you sure to Deactivate Account?</p>
        </div>
         <div class="modal-footer">
		    <button type="button" data-dismiss="modal" class="btn btn-primary" id="delete">Delete</button>
		    <button type="button" data-dismiss="modal" class="btn">Cancel</button>
		  </div>
      </div>
      
    </div>
  </div>
  
</div>






		

		
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

		$(window).on('resize', function () {
			if ($(window).width() > 768) $('#sidebar-collapse').collapse('show')
		})
		$(window).on('resize', function () {
			if ($(window).width() <= 767) $('#sidebar-collapse').collapse('hide')
		})

		$(document).ready(function() {
			$('#usertable').DataTable();
		} );
		$("#deactivateLink").on("click",function (event) {
			// body...			
			var me = this;
			event.preventDefault();
			$('#confirmDeactivate').modal({ backdrop: 'static', keyboard: false })
	        	.one('click', '#delete', function (e) {
	        		$('.preloader').fadeIn();
	        		var data = {userID: $(me).data("userid")};
					$.post('../api/deactivate.php',data,function (data) {
						$('.preloader').fadeOut();	
						if(data.success) {
							window.location.href = "../logout.php"
						} else {
							alert(data.message);
						}

					});        		
	            	
	        });

			
		});
	</script>	
</body>

</html>


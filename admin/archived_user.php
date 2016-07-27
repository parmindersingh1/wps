<?php

session_start();
require_once dirname(__FILE__).'/../api/class.user.php';
require_once dirname(__FILE__).'/../api/class.vehicle.php';
$user_login = new USER();
$user_vehicle = new Vehicle();

include('header.php'); 
if($_GET['id']) {
	$userID = $_GET['id'];
	 $sql    = "SELECT * FROM tbl_archived_users WHERE userID = :user_id";
	$stmt   = $user_login->runQuery($sql);
	$result = $stmt->execute(array(":user_id" => $userID));
	$user   = $stmt->fetch(PDO::FETCH_ASSOC);
} else {
	header('Location: ' . $_SERVER['HTTP_REFERER']);
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
					<div class="panel-heading"><?php echo ucwords($user["first_name"].' '.$user['last_name'])?></div>
					<div class="panel-body">	





					<div class="container">
				      <div class="row">
				      
				       <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 toppad">
				   
				   
				          <div class="panel panel-info">				           
				            <div class="panel-body">
				              <div class="row">
				                <div class="col-md-3 col-lg-3 " align="center"><?php
				                echo '<img src="data:image/jpeg;base64,'.base64_decode(base64_encode( $user['photo'] )).' " class="img-circle img-responsive"/>';
				                ?>
				                 </div>
				                
				              
				                <div class=" col-md-9 col-lg-9 "> 
				                  <table class="table table-user-information">
				                    <tbody>				                     
				                      <tr>
				                        <td>Full Name</td>
				                        <td><?php echo ucwords($user["first_name"].' '.$user['last_name'])?></td>
				                      </tr>

				                      <tr>
				                        <td>Date of Birth</td>
				                        <td><?php echo $user['date_of_birth']?></td>
				                      </tr>
				                   
				                         <tr>
				                             <tr>
				                        <td>Gender</td>
				                        <td><?php echo $user['gender']?></td>
				                      </tr>
				                        <tr>
				                        <td>Phone</td>
				                        <td><?php echo $user['phone']?></td>
				                      </tr>
				                      <tr>
				                        <td>Email</td>
				                        <td><a href="mailto:<?php echo $user['userEmail']?>"><?php echo $user['userEmail']?></a></td>
				                      </tr>	

				                      <tr>
				                        <td>Adhar Card</td>
				                        <td><?php echo  htmlentities($user['adhar_card_info'])?></td>
				                      </tr>	
				                       <tr>
				                        <td>Adhar Card No</td>
				                        <td><?php echo  $user['adhar_card_no']?></td>
				                      </tr>	
				                       <tr>
				                        <td>Pan Card</td>
				                        <td><?php echo $user['pan_card_no']?></td>
				                      </tr>	
				                       <tr>
				                        <td>Voter Card</td>
				                        <td><?php echo $user['voter_card_no']?></td>
				                      </tr>	
				                      <tr>
				                        <td>Active</td>
				                        <td><?php echo $user['userStatus']? "Yes": "No"?></td>
				                      </tr>				                        			                           
				                      </tr>
				                     
				                    </tbody>
				                  </table>				                  
				                 
				               
				                </div>
				              </div>
				            </div>
                 <div class="panel-footer">                       
                        <span class="pull-right">
                            <a href="edit.html" data-original-title="Edit this user" data-toggle="tooltip" type="button" class="btn btn-sm btn-warning"><i class="glyphicon glyphicon-edit"></i></a>
                            <a data-original-title="Remove this user" data-toggle="tooltip" type="button" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-remove"></i></a>
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

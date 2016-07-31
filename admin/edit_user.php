<?php

session_start();
require_once dirname(__FILE__).'/../api/class.user.php';
require_once dirname(__FILE__).'/../api/class.vehicle.php';
$user_login = new USER();
$user_vehicle = new Vehicle();

include('header.php'); 

if(isset($_POST['btn-edit']))
{
 
  $userId = isset($_POST['userID']) ? trim($_POST['userID']) : '';
  $email = isset($_POST['email']) ? trim($_POST['email']) : '';

  $fname = isset($_POST['fname']) ? trim($_POST['fname']) : '';
  $lname = isset($_POST['lname']) ? trim($_POST['lname']) : '';
  $gender = isset($_POST['gender']) ? trim($_POST['gender']) : '';
  $dbirth = isset($_POST['dob']) ? trim($_POST['dob']) : '';

  $phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
  $photo = isset($_POST['photo']) ? base64_encode(base64_decode(trim($_POST['photo']))) : '';
  $adhar_card = isset($_POST['adhar_card']) ? trim($_POST['adhar_card']) : ''; 
  $pan_card = isset($_POST['pan_card']) ? trim($_POST['pan_card']) : '';
  $voter_card = isset($_POST['voter_card']) ? trim($_POST['voter_card']) : '';
  $dob =  date("Y-m-d", strtotime(str_replace('/', '-', $dbirth)));


  $updatedUser = $user_login->update($email,$fname,$lname,$dob,$gender,$phone,$photo,$userId,$pan_card,$voter_card); 
  if($updatedUser)
   {           
    $msg = "
    <div class='alert alert-success'>
      <button class='close' data-dismiss='alert'>&times;</button>
      <strong>Success!</strong>  Your Account updated. 
    </div>
    ";      
	}
    else
    {
      $msg = "Oops , Something Went Wrong...";
    }     
    $sql    = "SELECT * FROM tbl_users WHERE userID = :user_id";
	$stmt   = $user_login->runQuery($sql);
	$result = $stmt->execute(array(":user_id" => $userId));
	$user   = $stmt->fetch(PDO::FETCH_ASSOC);
  } else if($_GET['userID']) {
	$userID = $_GET['userID'];
	$sql    = "SELECT * FROM tbl_users WHERE userID = :user_id";
	$stmt   = $user_login->runQuery($sql);
	$result = $stmt->execute(array(":user_id" => $userID));
	$user   = $stmt->fetch(PDO::FETCH_ASSOC);
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
					<div class="panel-heading"><?php echo ucwords($user["first_name"].' '.$user['last_name'])?></div>
					<div class="panel-body">	


					<?php
						$time = strtotime($user['date_of_birth']);

						$newformatDob = date('d/m/Y',$time);						
					?>


					<div class="container">
				      <div class="user">
				      
				       <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 toppad">
				   
				   
				          <div class="panel panel-info">				           
				            <div class="panel-body">
				              <div class="user">
				                <div class="col-md-3 col-lg-3 " align="center"><?php
				                echo '<img id="userImg" src="data:image/jpeg;base64,'.base64_decode(base64_encode( $user['photo'] )).' " class="img-circle img-responsive"/>';
				                ?>
				                <div class="row">
				                <input id="inputFileToLoad" type="file" name="uploadimage" multiple onchange="handleFileSelect(this)">
				                </div>
				                 </div>
				                
				              
				                <div class=" col-md-9 col-lg-9 "> 
				                  
				                  <?php if(isset($msg)) echo $msg;  ?>
						            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" class="form-signin" method="post">       
						              <div class="form-group">       
						                <input type="email" class="form-control" placeholder="Email address" name="email" required value="<?php echo $user['userEmail'] ?>" />       
						              </div>
						              <div class="form-group">
						                <input type="text" class="form-control" placeholder="First Name" name="fname" required value="<?php echo $user['first_name'] ?>"/>
						              </div>
						              <div class="form-group">
						                <input type="text" class="form-control" placeholder="Last Name" name="lname" required value="<?php echo $user['last_name']?>"/>
						              </div>
						              <div class="form-group">
						                <input type="text" class="form-control" placeholder="Mobile" name="phone" required value="<?php echo $user['phone']?>"/>
						              </div>
						              <div class="form-group">
						                <select class="form-control" name="gender" required> 
						                 <option>Gender</option>
						                 <option value="Male" <?php echo $user['gender'] == "Male"? 'selected': '' ?> >Male</option>
						                 <option value="Female" <?php echo $user['gender'] == "Female"? 'selected': '' ?>>Female</option>
						               </select>
						             </div>
						             <div class="form-group">
						              <input type="text" id="birthDatepicker" class="form-control" placeholder="dob" name="dob" required value="<?php echo $newformatDob ?>"/>
						            </div>						            
						            <div class="form-group">
						              <input type="text" class="form-control" placeholder="Adhar Card No" name="adhar_card"  value="<?php echo $user['adhar_card_no'] ?>"/>
						            </div>
						            <div class="form-group">
						              <input type="text" class="form-control" placeholder="Pan Card No" name="pan_card"  value="<?php echo $user['pan_card_no'] ?>"/>
						            </div>
						            <div class="form-group">
						              <input type="text" class="form-control" placeholder="Voter Card No" name="voter_card"  value="<?php echo $user['voter_card_no'] ?>"/>
						            </div>

						            <input type="hidden" name="userID" value="<?= $user['userID'] ?>" />
						            <input type="hidden"  name="photo" value="<?= base64_decode(base64_encode( $user['photo'] )) ?>" />

						            

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
                $('#userImg').attr('src', e.target.result);
                $("input[name='photo'").val(e.target.result.split(',')[1]);
                console.log(e.target.result.split(',')[1]);
            }
            
            reader.readAsDataURL(input.files[0]);
        }
		}

	</script>	
</body>

</html>


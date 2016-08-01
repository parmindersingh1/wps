<?php

session_start();
require_once dirname(__FILE__).'/../api/class.user.php';
require_once dirname(__FILE__).'/../api/class.vehicle.php';
$user_login = new USER();
$user_vehicle = new Vehicle();

include('header.php'); 

if(isset($_POST['btn-edit']))
{
 
  $userId = $currentUser->userID;
  $email = isset($_POST['email']) ? trim($_POST['email']) : $currentUser->userEmail;

  $fname = isset($_POST['fname']) ? trim($_POST['fname']) : $currentUser->first_name;
  $lname = isset($_POST['lname']) ? trim($_POST['lname']) : $currentUser->last_name;
  $gender = isset($_POST['gender']) ? trim($_POST['gender']) : $currentUser->gender;
  $dbirth = isset($_POST['dob']) ? trim($_POST['dob']) : $currentUser->date_of_birth;

  $phone = isset($_POST['phone']) ? trim($_POST['phone']) : $currentUser->phone;
  $photo = isset($_POST['photo']) ? base64_encode(base64_decode(trim($_POST['photo']))) : $currentUser->photo;
  $adhar_card = isset($_POST['adhar_card']) ? trim($_POST['adhar_card']) : $currentUser->adhar_card_no; 
  $pan_card = isset($_POST['pan_card']) ? trim($_POST['pan_card']) : $currentUser->pan_card_no;
  $voter_card = isset($_POST['voter_card']) ? trim($_POST['voter_card']) : $currentUser->voter_card_no;
  $dob =  date("Y-m-d", strtotime(str_replace('/', '-', $dbirth)));

  

  if($user_login->update($email,$fname,$lname,$dob,$gender,$phone,$photo,$userId,$pan_card,$voter_card))
   {           
	    $msg = "
	    <div class='alert alert-success'>
	      <button class='close' data-dismiss='alert'>&times;</button>
	      <strong>Success!</strong>  Your Account updated. 
	    </div>
	    ";      

	    if(($email != $currentUser->userEmail) || ($phone != $currentUser->phone)) {
			$tokenCode = rand(100000, 999999);
			$stmt = $user_login->runQuery("UPDATE tbl_users SET userStatus='N', tokenCode=:tokenCode WHERE userID = :user_id");
			$stmt->bindparam(":user_id",$userId, PDO::PARAM_INT);
			$stmt->bindparam(":tokenCode",$tokenCode);
			$stmt->execute();
			$id = base64_encode($userId);
			$code = $tokenCode;			


			// if(($phone != $currentUser->phone)) {
			$msg = "Check Your Messages in Phone for Verification Code";
			$user_login->send_sms($phone,$fname,$code);	
			// } else {
			// 	$msg = "Check Your Inbox or Spam for Verification Code";
			// 	$message = "Hello, Your Wcarps Verification Code is $tokenCode. OR Go to Link 
			// 	<a href=".$user_login->apiurl()."verify.php?id=$id&code=$code";	

			// 	$subject = "Confirm Updation";
			// 	$user_login->send_mail($email,$message,$subject);	
			// }


			$user_login->logout();
			header('Location: ../index.php?message');
		} 

	}
    else
    {
      $msg = "Oops , Something Went Wrong...";
    }  




    $sql    = "SELECT * FROM tbl_users WHERE userID = :user_id";
	$stmt   = $user_login->runQuery($sql);
	$result = $stmt->execute(array(":user_id" => $userId));
	$currentUser   = $stmt->fetch(PDO::FETCH_OBJ);
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
					<div class="panel-heading"><?php echo ucwords($currentUser->first_name.' '.$currentUser->last_name)?></div>
					<div class="panel-body">	


					<?php
						$time = strtotime($currentUser->date_of_birth);

						$newformatDob = date('d/m/Y',$time);						
					?>


					<div class="container">
				      <div class="user">
				      
				       <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 toppad">
				   
				   
				          <div class="panel panel-info">				           
				            <div class="panel-body">
				              <div class="user">
				                <div class="col-md-3 col-lg-3 " align="center"><?php
				                echo '<img id="userImg" src="data:image/jpeg;base64,'.base64_decode(base64_encode( $currentUser->photo )).' " class="img-circle img-responsive"/>';
				                ?>
				                <div class="row">
				                <input id="inputFileToLoad" type="file" name="uploadimage" multiple onchange="handleFileSelect(this)">
				                </div>
				                 </div>
				                
				              
				                <div class=" col-md-9 col-lg-9 "> 
				                  
				                  <?php if(isset($msg)) echo $msg;  ?>
						            <form action="<?php echo $_SERVER->PHP_SELF; ?>" class="form-signin" method="post">       
						              <div class="form-group">       
						                <input type="email" class="form-control" placeholder="Email address" name="email" required value="<?php echo $currentUser->userEmail ?>" />       
						              </div>
						             
						              <div class="form-group">
						                <input type="text" class="form-control" placeholder="Mobile" name="phone" required value="<?php echo $currentUser->phone?>"/>
						              </div>				              
						            					            
						            
						            <div class="form-group">
						              <input type="text" class="form-control" placeholder="Pan Card No" name="pan_card"  value="<?php echo $currentUser->pan_card_no ?>"/>
						            </div>
						            <div class="form-group">
						              <input type="text" class="form-control" placeholder="Voter Card No" name="voter_card"  value="<?php echo $currentUser->voter_card_no ?>"/>
						            </div>

						           
						            <input type="hidden"  name="photo" value="<?= base64_decode(base64_encode( $currentUser->photo )) ?>" />

						            

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

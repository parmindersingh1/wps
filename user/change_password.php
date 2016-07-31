  <?php

  session_start();
  require_once dirname(__FILE__).'/../api/class.user.php';
  $user_login = new USER();

  
  include('header.php');

  if(isset($_POST['change-pass'])) {
  		$oldpass =   trim($_POST['currentpass']) ;
		$upass =     trim($_POST['newpass']);
		$cpass =     trim($_POST['confirmpass']);	
		$userId = $currentUser->userID;

			if($upass == $cpass) {				
				if($currentUser->userPass == md5($oldpass)) {
					if($user_login->updatePassword($oldpass,$upass,$cpass,$userId))
					{			
						$msg = "
					    <div class='alert alert-success'>
					      <button class='close' data-dismiss='alert'>&times;</button>
					      <strong>Success!</strong>  Password updated. 
					    </div>
					    ";   			
					}
					else
					{
						$msg = "
						    <div class='alert alert-danger'>
						      <button class='close' data-dismiss='alert'>&times;</button>
						      <strong>Error!</strong>  Something Went Wrong. 
						    </div>
						    ";   
					}
				}	else {
					$msg = "
						    <div class='alert alert-danger'>
						      <button class='close' data-dismiss='alert'>&times;</button>
						      <strong>Error!</strong>  Wrong old Password. 
						    </div>
						    ";  
				}	
			}	else {
				$msg = "
						    <div class='alert alert-danger'>
						      <button class='close' data-dismiss='alert'>&times;</button>
						      <strong>Error!</strong> Password Dont Match. 
						    </div>
						    ";
			}	



  }

  ?>
  <section id="services" class="section section-padded">
    <div class="container">
  <div id="loginbox" style="margin-top:50px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">    
    <div class="panel panel-info" >
      <div class="panel-heading">
        <div class="panel-title">Change Password</div>                
      </div>     
      <div style="padding-top:30px" class="panel-body" >     

      	<!-- <div class='alert alert-success'>
         <strong>Hello !</strong>  <?php echo $row['userName'] ?> you are here to Change password.
       </div> -->
       <form class="form-signin" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">       
        <?php
        if(isset($msg))
        {
         echo $msg;
       }
       ?>
       <div style="margin-bottom: 25px" class="input-group">
          <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
          <input id="login-password" type="password" class="form-control"  name="currentpass" placeholder="Current Password" required>
       </div>

       <div style="margin-bottom: 25px" class="input-group">
          <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
          <input id="login-password" type="password" class="form-control" name="newpass" placeholder="New Password" required>
       </div>

       <div style="margin-bottom: 25px" class="input-group">
          <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
          <input id="login-password" type="password" class="form-control" name="confirmpass" placeholder="Confirm Password" required>
       </div>       
       
       <hr />
       <button class="btn btn-large btn-primary" type="submit" name="change-pass">Update Password</button>

     </form>
   </div></div></div>
 </div> <!-- /container -->
 <div class="cut cut-bottom"></div>
</section>
 <?php include('footer.php') ?>
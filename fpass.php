<?php

session_start();
require_once dirname(__FILE__).'/api/class.user.php';
$user_login = new USER();

if($user_login->is_logged_in()!="")
{
	$user_login->redirect('user/index.php');
} 

if(isset($_POST['btn-forgot']))
{
	$email = $_POST['email'];
	
	$stmt = $user_login->runQuery("SELECT userID FROM tbl_users WHERE userEmail=:email LIMIT 1");
	$stmt->execute(array(":email"=>$email));
	$row = $stmt->fetch(PDO::FETCH_ASSOC);	


	if($stmt->rowCount() == 1)
	{
		$id = base64_encode($row['userID']);
		$code = md5(uniqid(rand()));
		
		$stmt = $user_login->runQuery("UPDATE tbl_users SET tokenCode=:token WHERE userEmail=:email");
		$stmt->execute(array(":token"=>$code,"email"=>$email));
		
		$message= "
		Hello , $email
		<br /><br />
		We got requested to reset your password, if you do this then just click the following link to reset your password, if not just ignore                   this email,
		<br /><br />
		Click Following Link To Reset Your Password 
		<br /><br />
		<a href='".$user_login->url()."resetpass.php?id=$id&code=$code'>click here to reset your password</a>
		<br /><br />
		thank you :)
		";
		$subject = "Password Reset";
		
		$user_login->send_mail($email,$message,$subject);
		
		$msg = "<div class='alert alert-success'>
			<button class='close' data-dismiss='alert'>&times;</button>
			We've sent an email to $email.
			Please click on the password reset link in the email to generate new password. 
			<a href='".$user_login->url()."resetpass.php?id=$id&code=$code'>
		</div>";
	}
	else
		{
			$msg = "<div class='alert alert-danger'>
				<button class='close' data-dismiss='alert'>&times;</button>
				<strong>Sorry!</strong>  this email not found. 
			</div>";
		}
}


?>
<!DOCTYPE html>

<html lang="en">
<head>

<!-- Html Page Specific -->
<meta charset="utf-8">
<title>WCarPs</title>
<meta name="description" content="WCarPs">
<meta name="author" content="WCarPs | WCarPs.com">

<!-- Mobile Specific -->
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">

<!--[if lt IE 9]>
    <script type="text/javascript" src="scripts/html5shiv.js"></script>
<![endif]-->

<!-- CSS -->
<link rel="stylesheet" href="css/bootstrap.min.css"/>
<link rel="stylesheet" href="css/animate.css"/>
<link rel="stylesheet" href="css/simple-line-icons.css"/>
<link rel="stylesheet" href="css/icomoon-soc-icons.css"/>
<link rel="stylesheet" href="css/magnific-popup.css"/>
<link rel="stylesheet" href="css/style.css"/>

<!-- Favicons -->
<link rel="icon" href="images/favicon.png">
<link rel="apple-touch-icon" href="images/apple-touch-icon.png">
<link rel="apple-touch-icon" sizes="72x72" href="images/apple-touch-icon-72x72.png">
<link rel="apple-touch-icon" sizes="114x114" href="images/apple-touch-icon-114x114.png">
</head>

<body data-spy="scroll" data-target=".navMenuCollapse">

<!-- PRELOADER -->
<div id="preloader">
  <div class="battery inner">
    <div class="load-line"></div>
  </div>
</div>

<div id="wrap"> 

	<div id="passbox" style="margin-top:50px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">                    
		<div class="panel panel-info" >
			<div class="panel-heading">
				<div class="panel-title">Forgot Password</div>				
			</div>     

			<div style="padding-top:30px" class="panel-body" >

				<form action="<?php echo $_SERVER['PHP_SELF']; ?>" class="form-signin" method="post">				

					<?php
					if(isset($msg))
					{
						echo $msg;
					}
					else
					{
						?>
						<div class='alert alert-info'>
							Please enter your email address. You will receive a link to create a new password via email.!
						</div>  
						<?php
					}
					?>

					   <div  class="form-group">
                                <input id="login-username" type="email" class="form-control" name="email" value="" placeholder="Email address" required>                                        
                        </div>
					<div style="margin-top:10px" class="form-group">
					<button class="btn btn-danger btn-primary" type="submit" name="btn-forgot">Generate new Password</button>
					</div>
					<p><a href="index.php">Back to Home page</a></p>
				</form>
			</div>
		</div>
	</div> <!-- /container -->

	<?php include('footer.php') ?>

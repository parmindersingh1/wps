<?php

session_start();
require_once dirname(__FILE__).'/api/class.user.php';
$user_login = new USER();

if($user_login->is_logged_in()!="")
  {    
    if($_SESSION['oldURL'] !="") {
      $url = $_SESSION['oldURL'];
      $_SESSION['oldURL'] ="";
      $user_login->redirect($url);
    } else {
      $user_login->redirect('user/index.php');
    }
  } 

if(isset($_POST['btn-login']))
{
	$login = trim($_POST['login']);
	$upass = trim($_POST['upass']);
	
	if($user_login->login($login,$upass))
	{
		if($_SESSION['oldURL'] !="") {
      $user_login->redirect($_SESSION['oldURL']);
    } else {
      $user_login->redirect('user/index.php');
    }
	}
}

// include('header.php');

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



    <div  style="margin-top:50px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">                    
        <div class="panel panel-info" >
            <div class="panel-heading">
                <div class="panel-title">Sign In</div>
            </div>     

            <div style="padding-top:30px" class="panel-body" >

                <?php
                if(isset($_GET['inactive']))
                {
                    ?>
                    <div class='alert alert-danger col-sm-12'>
                        <a class='close' data-dismiss='alert'>&times;</a>
                        <strong>Sorry!</strong> This Account is not Activated Go to your Inbox and Activate it.Click here to resend code <a href='<?php echo "resend.php?id=".$_GET["id"] ?>'>resend</a> 
                    </div>
                    <?php  } ?>                      
                    <?php
                    if(isset($_GET['error']))
                    {
                        ?>
                        <div class='alert alert-danger col-sm-12'>
                            <a class='close' data-dismiss='alert'>&times;</a>
                            <strong>Wrong Details!</strong> 
                        </div>
                    <?php } 

                    if(isset($_GET['message']))
                    {
                    ?>
                    <div class='alert alert-success col-sm-12'>
                        <a class='close' data-dismiss='alert'>&times;</a>
                        <strong>Success!</strong> Please Check confirmation Email.
                    </div>
                    <?php  } ?> 
                        

                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" id="loginform" class="form-horizontal" role="form" method="post">

                            <div  class="form-group">
                                <input id="login-username" type="text" class="form-control" name="login" value="" placeholder="phone or email">                                        
                            </div>

                            <div  class="form-group">
                                <input id="login-password" type="password" class="form-control" name="upass" placeholder="password">
                            </div>



                            <div class="input-group">
                              <div class="checkbox">
                                <label>
                                  <input id="login-remember" type="checkbox" name="remember" value="1"> Remember me
                              </label>
                          </div>
                      </div>


                      <div style="margin-top:10px" class="form-group">
                        <!-- Button -->

                        <div class="col-sm-12 controls">
                          <button  id="btn-login" type="submit"  name="btn-login" class="btn btn-success" >Login  </button>                                    

                        </div>
                        <p> <a href="fpass.php">Forgot password?</a></p>
                       <p> <a href="index.php">Back to Home page</a></p>
                  </div>


              </form>     



          </div>                     
      </div>  
 </div>

</div> 
</div>




<?php include('footer.php'); ?>

<?php
session_start();
require_once dirname(__FILE__).'/class.user.php';
require_once dirname(__FILE__).'/class.vehicle.php';
$user_login = new USER();
$user_vehicle = new VEHICLE();

header('Content-Type: application/json');
$response = array();

if(isset($_POST['login']) && isset($_POST['upass']) )
{
	$login = trim($_POST['login']);
	$upass = trim($_POST['upass']);
	$user = $user_login->loginApi($login,$upass);
	if($user)
	{
    if(!filter_var($user["is_blocked"], FILTER_VALIDATE_BOOLEAN)) { 
      if($user['userStatus']=="Y")
          {
            if($user['userPass']==md5($upass))
            {
              $_SESSION['userSession'] = $user['userID'];
              $response["success"] = true;
              $response["message"] = "Logged in Successfully";
              unset($user['userName']);
              unset($user['tokenCode']);
              unset($user['userPass']);
              unset($user['userStatus']);
              unset($user['is_blocked']);
              
              $user['vehicles'] = $user_vehicle->userVehicles($user['userID']);
              $response["loginUser"] = $user;
              echo json_encode($response);            
            }
            else
            {
              $response["success"] = false;
              $response["message"] = "Invalid Credentials...";
              echo json_encode($response);
            }
          }
       else {
          $response["success"] = false;
          $response["message"] = "User not Activated...";
          echo json_encode($response);
      }   
		} else {
          $response["success"] = false;
          $response["message"] = "User Blocked...";
          echo json_encode($response);
    }   
	} else {
    $response["success"] = false;
    $response["message"] = "Invalid Credentials...";
    echo json_encode($response);
  }
} else {
        $response["success"] = false;
        $response["message"] = "invalid request...";
        echo json_encode($response);
}



?>

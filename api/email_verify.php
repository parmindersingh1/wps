<?php

session_start();
require_once dirname(__FILE__).'/class.user.php';
require_once dirname(__FILE__).'/class.vehicle.php';

$reg_user = new USER();
$reg_vehicle = new VEHICLE();

header('Content-Type: application/json');
$response = array();

// file_put_contents( 'debug' . time() . '.log', var_export( $_POST, true));

if(isset($_POST['email']) && isset($_POST['phone']) && isset($_POST['licence'])) {
	$phone = $_POST['phone'];
    $email = $_POST['email'];
    $licence = $_POST['licence'];

    if(!$reg_user->isValidPhone($phone)) {
		$response["success"] = false;
        $response["message"] = "invalid phone...";
        echo json_encode($response);
	}
	else if(!$reg_user->isValidEmail($email)) {
		$response["success"] = false;
        $response["message"] = "invalid email...";
        echo json_encode($response);
	} else {
			if($reg_user->isEmailExists($email)) {
				$response["success"] = false;
		        $response["message"] = "Sorry ! email already exists , Please Try another one";
		        echo json_encode($response);
			} else if($reg_user->isPhoneExists($phone)) {
				$response["success"] = false;
		        $response["message"] = "Sorry ! phone already exists , Please Try another one";
		        echo json_encode($response);
			} if($reg_user->isLicenceExists($licence)) {
				$response["success"] = false;
		        $response["message"] = "Sorry ! licence number already exists , Please Try another one";
		        echo json_encode($response);
			} else {
				$response["success"] = true;
		        $response["message"] = "Success";
		        echo json_encode($response);
			}
	}
} else {
	$response["success"] = false;
    $response["message"] = "Invalid Request ....";
    echo json_encode($response);
}



?>

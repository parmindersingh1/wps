<?php

session_start();
require_once dirname(__FILE__).'/class.user.php';
require_once dirname(__FILE__).'/class.vehicle.php';

$reg_user = new USER();
$reg_vehicle = new VEHICLE();

header('Content-Type: application/json');
$response = array();

// file_put_contents( 'debug' . time() . '.log', var_export( $_POST, true));
$statusY = "Y";
$statusN = "N";
if(isset($_POST['phone'])) {
	$phone = $_POST['phone'];
   
    if(!$reg_user->isValidPhone($phone)) {
		$response["success"] = false;
        $response["message"] = "invalid phone...";
        echo json_encode($response);
	}
	else {
			$user = $reg_user->isPhoneExists($phone);
			if($user) {		
		        if($user['userStatus'] == $statusN) {
		        	$response["success"] = true;
			        $response["message"] = "Success ! Account exists";
			        echo json_encode($response);
		        } else {
		        	$response["success"] = false;
			        $response["message"] = "Account Already Activated";
			        echo json_encode($response);
		        }

			} else {
				$response["success"] = false;
		        $response["message"] = "Sorry ! No Account Exists";
		        echo json_encode($response);
			}
	}
} else {
	$response["success"] = false;
    $response["message"] = "Invalid Request ....";
    echo json_encode($response);
}



?>

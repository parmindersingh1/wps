<?php

session_start();
require_once dirname(__FILE__).'/class.user.php';
$reg_user = new USER();


header('Content-Type: application/json');
$response = array();
if($_POST['phone']) {
        $phone = $_POST['phone'];
        $stmt = $reg_user->runQuery("SELECT tokenCode AS code,first_name, phone, userStatus FROM tbl_users WHERE phone = :phone");
        $stmt->bindparam(':phone',$phone);
		$stmt->execute();

		$statusY = "Y";
		$statusN = "N";

		
		$obj = $stmt->fetch(PDO::FETCH_OBJ);
		if($obj) {
			$code = $obj->code;
			$fname = $obj->first_name;
			$phone = $obj->phone;
			$userStatus = $obj->userStatus;
			if($userStatus==$statusN) {			
				if($code) {
					// $message = "Hello, Your Wcarps Verification Code is $code.";		
					// $subject = "Confirm Registration";
											
					$reg_user->send_sms($phone,$fname,$code);	
					// $reg_user->send_mail($email,$message,$subject);	
								
					$response["success"] = true;
					$response["message"] = "We've sent an message to $phone. Please Check Message.";
								//logToFile('mylog.log',$response);
					echo json_encode($response);
				} else {
			  		$response["success"] = false;
			        $response["message"] = "No Account Found...";
			        echo json_encode($response);
				}
			} else {
				$response["success"] = false;
		        $response["message"] = "Account Already Activated...";
		        echo json_encode($response);
			}
		} else {
			$response["success"] = false;
	        $response["message"] = "No Account Found...";
	        echo json_encode($response);
		}	


} else {
	   $response["success"] = false;
        $response["message"] = "invalid phone...";
        echo json_encode($response);
}

?>
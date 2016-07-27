<?php

session_start();
require_once dirname(__FILE__).'/class.user.php';
$reg_user = new USER();


header('Content-Type: application/json');
$response = array();
if($_POST['email_id']) {
        $email = $_POST['email_id'];
        $stmt = $reg_user->runQuery("SELECT tokenCode AS code FROM tbl_users WHERE userEmail = :email_id");
        $stmt->bindparam(':email_id',$email);
		$stmt->execute();
		
		$code = $stmt->fetch(PDO::FETCH_OBJ)->code;
		
		if($code) {
			$message = "Hello, Your Wcarps Verification Code is $code.";		
			$subject = "Confirm Registration";
									
			$reg_user->send_mail($email,$message,$subject);	
						
			$response["success"] = true;
			$response["message"] = "We've sent an email to $email. Please Check inbox or spam.";
						//logToFile('mylog.log',$response);
			echo json_encode($response);
		} else {
	  		$response["success"] = false;
	        $response["message"] = "No Acoount Found...";
	        echo json_encode($response);
		}



} else {
	   $response["success"] = false;
        $response["message"] = "invalid phone...";
        echo json_encode($response);
}

?>
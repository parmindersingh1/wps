<?php
require_once dirname(__FILE__).'/class.user.php';

$reg_user = new USER();

// file_put_contents( 'debug' . time() . '.log', var_export( $_POST, true));
header('Content-Type: application/json');
$response = array();
if(isset($_POST['userId'])){

	$userId = $_POST['userId'];
	$stmt = $reg_user->runQuery("SELECT * FROM tbl_users WHERE userID = :user_id");
	$stmt->execute(array(":user_id"=>$userId));
	$user = $stmt->fetch(PDO::FETCH_ASSOC);
	
	$uname = isset($_POST['uname']) ? trim($_POST['uname']) : $user['userName'];
	$email = isset($_POST['email']) ? trim($_POST['email']) : $user['userEmail'];
	$fname = isset($_POST['fname']) ? trim($_POST['fname']) : $user['first_name'];
	$lname = isset($_POST['lname']) ? trim($_POST['lname']) : $user['last_name'];
	$gender = isset($_POST['gender']) ? trim($_POST['gender']) : $user['gender'];
	$dbirth = isset($_POST['dob']) ? trim($_POST['dob']) : $user['date_of_birth'];	
	$phone = isset($_POST['phone']) ? trim($_POST['phone']) : $user['phone'];
	$photo = isset($_POST['photo']) ? trim($_POST['photo']) : $user['photo'];
	$voter = isset($_POST['voter']) ? trim($_POST['voter']) : $user['voter_card_no'];
	$pan = isset($_POST['pan']) ? trim($_POST['pan']) : $user['pan_card_no'];

	$mil =  $dbirth;
	$seconds = $mil / 1000;
	$dob =  date("Y-m-d H:i:s", strtotime($dbirth));
	$msg = "";
	

	if(!$reg_user->isValidPhone($phone)) {
		$response["success"] = false;
        $response["message"] = "invalid phone...";
        echo json_encode($response);

	}
	else if(!$reg_user->isValidEmail($email)) {
		$response["success"] = false;
        $response["message"] = "invalid email...";
        echo json_encode($response);
	} else if (($_POST['email'] != $user['userEmail']) && $reg_user->isEmailExists($_POST['email'])) {
		$response["success"] = false;
        $response["message"] = "Email Already Exists...";
        echo json_encode($response);
	} else if (($_POST['phone'] != $user['phone']) && $reg_user->isPhoneExists($_POST['phone'])) {
		$response["success"] = false;
        $response["message"] = "Phone Already Exists...";
        echo json_encode($response);
	} else {	
		if($reg_user->update($email,$fname,$lname,$dob,$gender,$phone,$photo,$userId,$pan,$voter))
		{		
			if(($_POST['email'] != $user['userEmail']) || ($_POST['phone'] != $user['phone'])) {
				$tokenCode = rand(100000, 999999);
				$stmt = $reg_user->runQuery("UPDATE tbl_users SET userStatus='N', tokenCode=:tokenCode WHERE userID = :user_id");
				$stmt->bindparam(":user_id",$userId, PDO::PARAM_INT);
				$stmt->bindparam(":tokenCode",$tokenCode);
				$stmt->execute();

				if(($_POST['phone'] != $user['phone'])) {
					$reg_user->send_sms($phone,$fname,$tokenCode);	
				} else {
					$msg = "Check Your Inbox or Spam for Verification Code";
					$message = "Hello, Your Wcarps Verification Code is $tokenCode.";		
					$subject = "Confirm Updation";
											
					$reg_user->send_mail($email,$message,$subject);	
				}
				
			} 	
			$response["success"] = true;
			$response["message"] = "Success! Your Account updated.".$msg;
			echo json_encode($response);			
		}
		else
		{
			$response["success"] = false;
			$response["message"] = "Sorry , There Were No Changes...";
			echo json_encode($response);
		}		

	}
} else {	
	$response["success"] = false;
	$response["message"] = "Not Logged in ...";
	echo json_encode($response);
}
?>


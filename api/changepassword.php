<?php
session_start();
require_once dirname(__FILE__).'/class.user.php';

$reg_user = new USER();


header('Content-Type: application/json');
$response = array();


	if(isset($_POST['currentpass']) && isset($_POST['newpass']) && isset($_POST['confirmpass']) && isset($_POST['userID'])) {

		$userId = $_POST['userID'];
		$stmt = $reg_user->runQuery("SELECT * FROM tbl_users WHERE userID = :user_id");
		$stmt->bindparam(":user_id",$userId, PDO::PARAM_INT);
		$stmt->execute();
		$user = $stmt->fetch(PDO::FETCH_ASSOC);
		
		$oldpass =   trim($_POST['currentpass']) ;
		$upass =     trim($_POST['newpass']);
		$cpass = trim($_POST['confirmpass']);	


			if($upass == $cpass) {				
				if($user['userPass']==md5($oldpass)) {
					if($reg_user->updatePassword($oldpass,$upass,$cpass,$userId))
					{			
						$response["success"] = true;
						$response["message"] = "Success! Your Password updated.";		
						echo json_encode($response);			
					}
					else
					{
						$response["success"] = false;
						$response["message"] = "sorry , Something Went Wrong...";
						echo json_encode($response);
					}
				}	else {
					$response["success"] = false;
					$response["message"] = "Wrong Old Password...";
					echo json_encode($response);
				}	
			}	else {
				$response["success"] = false;
				$response["message"] = "Password Don't Match...";
				echo json_encode($response);
			}		
} else {
	$response["success"] = false;
	$response["message"] = "wrong json...";
	echo json_encode($response);
}	

?>

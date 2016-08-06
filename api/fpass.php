<?php
session_start();
require_once dirname(__FILE__).'/class.user.php';
$user = new USER();

header('Content-Type: application/json');
$response = array();


if(isset($_POST['email']))
{
	$email = $_POST['email'];
	
	$stmt = $user->runQuery("SELECT userID FROM tbl_users WHERE userEmail=:email LIMIT 1");
	$stmt->execute(array(":email"=>$email));
	$row = $stmt->fetch(PDO::FETCH_ASSOC);	
	if($stmt->rowCount() > 0)
	{
		$id = base64_encode($row['userID']);
		$pass= uniqid(rand());
		$code = md5($pass);
		
		$stmt = $user->runQuery("UPDATE tbl_users SET userPass=:token WHERE userEmail=:email");
		$stmt->execute(array(":token"=>$code,"email"=>$email));
		
		$message= "Hello, Your Wcarps Password is $pass.";
		$subject = "Password Reset";
		
		$user->send_mail($email,$message,$subject);

		$response["success"] = true;
	    $response["message"] = "We've sent an email to $email. Please Check inbox or spam.";
	    echo json_encode($response);		
		
	}
	else
	{
		$response["success"] = false;
	    $response["message"] = "Sorry! this email not found.";
	    echo json_encode($response);		
	}
} else {
	$response["success"] = false;
	$response["message"] = "invalid json.";
	echo json_encode($response);
}
?>

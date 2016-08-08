<?php
require_once dirname(__FILE__).'/class.user.php';
$user = new USER();

header('Content-Type: application/json');
$response = array();

if(isset($_POST['code']))
{
	$code = $_POST['code'];
	
	$statusY = "Y";
	$statusN = "N";
	
	$stmt = $user->runQuery("SELECT userID,userStatus FROM tbl_users WHERE  tokenCode=:code LIMIT 1");
	$stmt->execute(array(":code"=>$code));
	$row=$stmt->fetch(PDO::FETCH_ASSOC);
	if($stmt->rowCount() > 0)
	{
		if($row['userStatus']==$statusN)
		{
			$stmt = $user->runQuery("UPDATE tbl_users SET userStatus=:status WHERE userID=:uID");
			$stmt->bindparam(":status",$statusY);
			$stmt->bindparam(":uID",$row['userID']);
			$stmt->execute();	
			
			$response["success"] = true;
			$response["message"] = "Your Account is Now Activated";
			echo json_encode($response);				
		}
		else
		{
			$response["success"] = false;
			$response["message"] = "Your Account is already Activated";
			echo json_encode($response);				
		}
	}
	else
	{
		$response["success"] = false;
		$response["message"] = "Wrong Code :";
		echo json_encode($response);		
	}	
} else {	
	$response["success"] = false;
	$response["message"] = "Not Logged in ...";
	echo json_encode($response);
}

?>

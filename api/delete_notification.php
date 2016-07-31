<?php
require_once dirname(__FILE__).'/class.user.php';

$reg_user = new USER();


header('Content-Type: application/json');
$response = array();
if(isset($_POST['notId']) && isset($_POST['userId'])) {
	$notID = $_POST['notId'];
  $userID = $_POST['userId'];
	$stmt = $reg_user->runQuery("DELETE  FROM tbl_users_notifications WHERE notification_id = :notification_id AND user_id = :user_id");
	    $stmt->bindparam(":notification_id",$notID, PDO::PARAM_INT);
      $stmt->bindparam(":user_id",$userID, PDO::PARAM_INT);  
      
      if ($stmt->execute()) {
            $response["success"] = true;
            $response["message"] = "successfully!";
      } else {
        $response["success"] = false;
        $response["message"] = "Some Problem...";
      }
 
      echo json_encode($response);
  } else {
        $response["success"] = false;
	      $response["message"] = "Invalid Request...";
	    echo json_encode($response);
  }
?>

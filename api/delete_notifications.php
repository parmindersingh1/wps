<?php
require_once dirname(__FILE__).'/class.user.php';

$reg_user = new USER();


header('Content-Type: application/json');
$response = array();

if(isset($_POST['notifications']) && isset($_POST['userId'])) {
  $notArray = json_decode($_POST['notifications']);
  $userID = $_POST['userId'];

  $inQuery = join(', ', $notArray);
  $sql = "DELETE  FROM tbl_users_notifications WHERE notification_id in (".$inQuery.") AND user_id = :user_id";

  $stmt = $reg_user->runQuery($sql);

      $stmt->bindparam(":user_id",$userID, PDO::PARAM_INT);  
      
      if ($stmt->execute()) {
            $response["success"] = true;
            $response["message"] = "Successfully Deleted!";
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

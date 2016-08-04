<?php
require_once dirname(__FILE__).'/class.user.php';

$reg_user = new USER();


header('Content-Type: application/json');
$response = array();

if(isset($_POST['searches']) && isset($_POST['userId'])) {
  $searchArray = json_decode($_POST['searches']);
  $userID = $_POST['userId'];

  $inQuery = join(', ', $searchArray);

  $sql = "DELETE FROM tbl_users_searches  WHERE id in (".$inQuery.")";
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
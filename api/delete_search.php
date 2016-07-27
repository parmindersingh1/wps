<?php
require_once dirname(__FILE__).'/class.user.php';

$reg_user = new USER();


header('Content-Type: application/json');
$response = array();
if(isset($_POST['searchID'])) {

	$searchID = $_POST['searchID'];
  $sql    = "DELETE FROM tbl_users_searches  WHERE id = :search_id";  
  $stmt   = $reg_user->runQuery($sql);
  $result = $stmt->execute(array(":search_id" => $searchID)); 
      
      if ($result) {
            $response["success"] = true;
            $response["message"] = "successfully Deleted!";
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


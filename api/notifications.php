<?php
require_once dirname(__FILE__).'/class.user.php';

$reg_user = new USER();


header('Content-Type: application/json');
$response = array();
if(isset($_POST['userId'])) {
	$userID = $_POST['userId'];
	$stmt = $reg_user->runQuery("SELECT n.id as id, n.message as notification FROM tbl_notifications as n JOIN `tbl_users_notifications` as un on un.notification_id = n.id  WHERE un.user_id = :user_id ORDER BY n.id DESC LIMIT 50 ");
	    $stmt->bindparam(":user_id",$userID, PDO::PARAM_INT);
      $stmt->execute();
      $notifications = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $response["success"] = true;
        $response["message"] = "successfully!";
        $response["notifications"] = $notifications;
       //file_put_contents( 'debug.log', var_export( $response, true));      
 
 
      echo json_encode($response);
  } else {
        $response["success"] = false;
	    $response["message"] = "Invalid Request...";
	    echo json_encode($response);
  }
?>


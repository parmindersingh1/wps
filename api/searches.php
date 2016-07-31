<?php
require_once dirname(__FILE__).'/class.user.php';

$reg_user = new USER();

// file_put_contents( 'debug' . time() . '.log', var_export( $_POST, true));
header('Content-Type: application/json');
$response = array();
if(isset($_POST['userId'])) {
	$userID = $_POST['userId'];
	$stmt = $reg_user->runQuery("SELECT us.id as id,CONCAT_WS(' ',u.first_name,u.last_name) as name,u.userEmail as email, u.phone as phone,u.gender as gender, v.name as vehicle_name, v.model_no as vehicle_model, us.created_at as date_time,us.location as location, u.photo as photo FROM tbl_users_searches as us JOIN tbl_users as u on u.userID = us.user_id JOIN tbl_vehicles as v on v.vehicleID = us.vehicle_id WHERE v.user_id = :user_id");

	    $stmt->bindparam(":user_id",$userID, PDO::PARAM_INT);
      $stmt->execute();
      $searches = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $response["success"] = true;
        $response["message"] = "successfully!";
        $response["searches"] = $searches;
       //file_put_contents( 'debug.log', var_export( $response, true));      
 
      echo json_encode($response);
  } else {
        $response["success"] = false;
	    $response["message"] = "Invalid Request...";
	    echo json_encode($response);
  }
?>


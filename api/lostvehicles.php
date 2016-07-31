<?php
require_once dirname(__FILE__).'/class.user.php';

$reg_user = new USER();


header('Content-Type: application/json');
$response = array();
if(isset($_POST['userId'])) {
	// $userID = $_POST['userId'];
	$stmt = $reg_user->runQuery("SELECT lv.id as id, v.name as vehicle_name,v.model_no as vehicle_no, v.chassis_no as chassis_no,lv.address as location, if(lv.is_lost, 'true', 'false') as is_lost, lv.date_of_lost as date_of_lost, CONCAT(u.first_name, ' ', u.last_name) as user_name, u.phone as phone FROM tbl_lost_vehicles as lv JOIN tbl_vehicles as v on v.vehicleID = lv.vehicle_id JOIN tbl_users as u on v.user_id = u.userID WHERE lv.is_lost = 1");
	    // $stmt->bindparam(":user_id",$userID, PDO::PARAM_INT);
      $stmt->execute();
      $lostVehicles = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $response["success"] = true;
        $response["message"] = "successfully!";
        $response["lostVehicles"] = $lostVehicles;
       //file_put_contents( 'debug.log', var_export( $response, true));      
 
 
      echo json_encode($response);
  } else {
        $response["success"] = false;
	    $response["message"] = "Invalid Request...";
	    echo json_encode($response);
  }
?>
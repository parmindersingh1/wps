<?php

session_start();
require_once dirname(__FILE__).'/class.user.php';
require_once dirname(__FILE__).'/class.vehicle.php';

$reg_user = new USER();
$reg_vehicle = new VEHICLE();

header('Content-Type: application/json');
$response = array();

// file_put_contents( 'debug' . time() . '.log', var_export( $_POST, true));

if(isset($_POST['adhar_card'])) {
	    $adhar_card = $_POST['adhar_card'];
		$stmt = $reg_user->runQuery("SELECT * FROM tbl_users WHERE adhar_card_no=:adhar_card_no");
		$stmt->execute(array(":adhar_card_no"=>$adhar_card));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		if($stmt->rowCount() > 0)
		{
			$response["success"] = false;
	        $response["message"] = "Sorry ! Adhar Card already exists";
	        echo json_encode($response);
		} else {
			$response["success"] = true;
	        $response["message"] = "Success";
	        echo json_encode($response);
		}
	} else {
	$response["success"] = false;
    $response["message"] = "Invalid Request ....";
    echo json_encode($response);
}


?>
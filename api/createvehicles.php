<?php
session_start();
require_once dirname(__FILE__).'/class.user.php';
require_once dirname(__FILE__).'/class.vehicle.php';

$reg_user = new USER();
$vehicle = new VEHICLE();

header('Content-Type: application/json');
$response = array();

if($reg_user->is_logged_in()!=""){

$userID = $_SESSION['userSession'];

if(isset($_POST['vehicles'])) {
    $data = $_POST['vehicles'];    
    if (is_array($data)) {
    	$vehicles = array();

        foreach ($data as $record) {
                $name = isset($record['name']) ? trim($record['name']) : '';
				$type = isset($record['type']) ? trim($record['type']) : '';
				$model = isset($record['model']) ? trim($record['model']) : '';
				$chassis = isset($record['chassis']) ? trim($record['chassis']) : '';	
				$photo = isset($record['photo']) ? trim($record['photo']) : '';
				$colour = isset($record['colour']) ? trim($record['colour']) : '';

                if ($vehicle->save($name,$type,$model,$chassis,$photo,$colour,$userID)) {
                	$vehicles[$model] = $vehicle->lastID();
                }	
      		  }   
      		  $response["success"] = true;
              $response["message"] = "Success! Vehicle Created Successfully.";
              $response["vehicles"] = $vehicles;
			  echo json_encode($response);	     
	    } 
	    else {
	        $response["success"] = false;
	        $response["message"] = "Sorry! Not Array";
	    }
	} else {
	        $response["success"] = false;
	        $response["message"] = "Invalid Json..";
	}
} else {	
	$response["success"] = false;
	$response["message"] = "Not Logged in ...";
	echo json_encode($response);
}
?>

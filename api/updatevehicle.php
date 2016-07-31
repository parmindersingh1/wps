<?php
require_once dirname(__FILE__).'/class.user.php';
require_once dirname(__FILE__).'/class.vehicle.php';

$reg_user = new USER();
$vehicle = new VEHICLE();

header('Content-Type: application/json');
$response = array();

if(isset($_POST['vehicleID'])) {
    		
  		$stmt = $vehicle->runQuery("SELECT * FROM tbl_vehicles WHERE vehicleID = :vehicle_id");
		$stmt->execute(array(":vehicle_id"=>$_POST['vehicleID']));
		$vcl = $stmt->fetch(PDO::FETCH_ASSOC);
	
		$name = isset($_POST['name']) ? trim($_POST['name']) : $vcl['name'];
		$type = isset($_POST['type']) ? trim($_POST['type']) : $vcl['type'];
		$model = isset($_POST['model']) ? trim($_POST['model']) : $vcl['model_no'];
		$chassis = isset($_POST['chassis']) ? trim($_POST['chassis']) : $vcl['chassis_no'];	
		$photo = isset($_POST['photo']) ? trim($_POST['photo']) : $vcl['photo'];
		$colour = isset($_POST['colour']) ? trim($_POST['colour']) : $vcl['colour'];
		$vehicleID = trim($_POST['vehicleID']) ;

		if($vehicle->isValidVehicleNumber($model)) {
			if($vehicle-> update($name,$type,$model,$chassis,$photo,$colour,$vehicleID))
			{			
				$response["success"] = true;
				$response["message"] = "Success! Vehicle Updated Successfully.";			
				echo json_encode($response);			
			}
			else
			{
				$response["success"] = false;
				$response["message"] = "No Updation Occurred...";
				echo json_encode($response);
			}
		} else {	
			$response["success"] = false;
			$response["message"] = "Invalid Vehicle Number ...";
			echo json_encode($response);
		}		
    } else {	
		$response["success"] = false;
		$response["message"] = "Wrong Json ...";
		echo json_encode($response);
	}	

?>

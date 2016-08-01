<?php

session_start();
require_once dirname(__FILE__).'/class.user.php';
require_once dirname(__FILE__).'/class.vehicle.php';
date_default_timezone_set("Asia/Kolkata");
$reg_user = new USER();
$reg_vehicle = new VEHICLE();

header('Content-Type: application/json');
$response = array();
if(isset($_POST['user'])) {
    $data = $_POST['user'];    
    $uData = json_decode($data, true);        


	if(!$reg_user->isValidPhone($uData['phone'])) {
		$response["success"] = false;
        $response["message"] = "invalid phone...";
        echo json_encode($response);

	}
	else if(!$reg_user->isValidEmail($uData['userEmail'])) {
		$response["success"] = false;
        $response["message"] = "invalid email...";
        echo json_encode($response);
	}
	else {
			$uname = isset($uData['uname']) ? trim($uData['uname']) : '';
			$email = isset($uData['userEmail']) ? trim($uData['userEmail']) : '';
			$upass = isset($uData['userPass']) ? trim($uData['userPass']) : '';
			$fname = isset($uData['first_name']) ? trim($uData['first_name']) : '';
			$lname = isset($uData['last_name']) ? trim($uData['last_name']) : '';
			$gender = isset($uData['gender']) ? trim($uData['gender']) : '';
			$dbirth = isset($uData['date_of_birth']) ? trim($uData['date_of_birth']) : '';
			$adhar_card_info = isset($uData['adhar_card_info']) ? trim($uData['adhar_card_info']) : '';
			$licence = isset($uData['licence_no']) ? trim($uData['licence_no']) : '';
			$code = rand(100000, 999999);
			
			
			$mil =  $dbirth;
			$seconds = $mil / 1000;
			$dob =  date("Y-m-d H:i:s", $seconds);

			$adhar_card = isset($uData['adhar_card_no']) ? trim($uData['adhar_card_no']) : ''; 
			$pan_card = isset($uData['pan_card_no']) ? trim($uData['pan_card_no']) : '';
			$voter_card = isset($uData['voter_card_no']) ? trim($uData['voter_card_no']) : '';

			$phone = isset($uData['phone']) ? trim($uData['phone']) : '';
			$user_photo = isset($uData['photo']) ? trim($uData['photo']) : '';
			$role =  trim($reg_user->roles[1]);


			

			$record =$uData['vehicles'][0];
			$vname = isset($record['name']) ? trim($record['name']) : '';
			$vtype = isset($record['type']) ? trim($record['type']) : '';
			$vmodel = isset($record['model_no']) ? trim($record['model_no']) : '';
			$vchassis = isset($record['chassis_no']) ? trim($record['chassis_no']) : '';	
			$vphoto = isset($record['photo']) ? trim($record['photo']) : '';
			$vcolour = isset($record['color']) ? trim($record['color']) : ''; 


			$stmt = $reg_user->runQuery("SELECT * FROM tbl_vehicles WHERE LOWER(REPLACE(model_no, ' ', '')) = LOWER(REPLACE(:model_no, ' ', ''))  OR  LOWER(REPLACE(chassis_no, ' ', '')) = LOWER(REPLACE(:chassis_no, ' ', ''))");
			$stmt->bindparam(":model_no",$vmodel);
			$stmt->bindparam(":chassis_no",$vchassis);
			$stmt->execute();
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			

			if($stmt->rowCount() > 0) {
				$response["success"] = false;
		        $response["message"] = "Sorry ! Vehicle already exists , Please Try another one";
		        echo json_encode($response);
			} else {
				if($reg_user->register($uname,$email,$upass,$fname,$lname,$dob,$gender,$phone,$adhar_card_info,$user_photo,$adhar_card,$pan_card,$voter_card,$code, $role, $licence))
				{			
					$id = $reg_user->lasdID();	
					$user_id = $id;	
					$key = base64_encode($id);
					$id = $key;

					$reg_vehicle->save($vname,$vtype,$vmodel,$vchassis,$vphoto,$vcolour,$user_id);        




					// foreach ($uData['vehicles'] as $record) {						

					 //    $vname = isset($record['name']) ? trim($record['name']) : '';
						// $vtype = isset($record['type']) ? trim($record['type']) : '';
						// $vmodel = isset($record['model_no']) ? trim($record['model_no']) : '';
						// $vchassis = isset($record['chassis_no']) ? trim($record['chassis_no']) : '';	
						// $vphoto = isset($record['photo']) ? trim($record['photo']) : '';
						// $vcolour = isset($record['color']) ? trim($record['color']) : ''; 

						// if($reg_vehicle->isValidVehicleNumber($vmodel)) {

						// 	if ($reg_vehicle->save($vname,$vtype,$vmodel,$vchassis,$vphoto,$vcolour,$user_id)) {
			   //              	$vehicles[$vmodel] = $reg_vehicle->lastID();
			   //              }	
			   //          }

					// }
					
					// $message = "Hello, Your Wcarps Verification Code is $code.";		
					// $subject = "Confirm Registration";

					$message = '<html>
						    <head>
						        <title>Welcome to WCarPs</title>
						    </head>
						    <body>
						        <h1>Thanks you for joining with us!</h1>
						        <table cellspacing="0" style="border: 2px dashed #FB4314; width: 300px; height: 200px;">
						            <tr>
						                <th>Name:</th><td>'.$fname.' '.$lname.'</td>
						            </tr>
						            <tr style="background-color: #e0e0e0;">
						                <th>Email:</th><td>'.$email.'</td>
						            </tr>
						             <tr style="background-color: #e0e0e0;">
						                <th>Phone:</th><td>'.$phone.'</td>
						            </tr>
						            <tr>
						                <th>Website:</th><td><a href="http://www.wcaprs.com">www.wcarps.com</a></td>
						            </tr>
						        </table>
						    </body>
						    </html>';		
					$subject = "Welcome to WCarPs";
											
					$reg_user->send_mail($email,$message,$subject);	
								
					$reg_user->send_sms($phone,$fname,$code);	
					
					$response["success"] = true;
					$response["message"] = "We've sent a message to $phone. Please Check Message.";
					echo json_encode($response);
				}
				else
				{	
					$response["success"] = false;
		        	$response["message"] = "sorry , Something went wrong...";
		        	echo json_encode($response);
				}		
			}
	}

}
else {
		$response["success"] = false;
        $response["message"] = "Invalid request...";
        echo json_encode($response);
}
?>





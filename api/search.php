<?php
session_start();
require_once dirname(__FILE__).'/class.user.php';
require_once dirname(__FILE__).'/class.vehicle.php';

$reg_user = new USER();
$vehicle = new VEHICLE();

header('Content-Type: application/json');
$response = array();


if(isset($_POST['query']) && isset($_POST['userID']) && isset($_POST['location'])) {
    $query = $_POST['query'];   
    $location = $_POST['location'];
        $userId = $_POST['userID'];
		$stmt = $reg_user->runQuery("SELECT * FROM tbl_users WHERE userID = :user_id");
		$stmt->bindparam(":user_id",$userId, PDO::PARAM_INT);
		$stmt->execute();
		$user = $stmt->fetch(PDO::FETCH_ASSOC);

     $searchedUser = $vehicle->search($query);
    if ($searchedUser) { 
    	if($searchedUser['userID'] != $userId) {  	  
		    	    $vehicleID = $searchedUser['vehicleID'];
		    	    unset($searchedUser['vehicleID']);
		            unset($searchedUser['userName']);
		            unset($searchedUser['tokenCode']);
		            unset($searchedUser['userPass']);
		            unset($searchedUser['userStatus']);
		            unset($searchedUser['is_blocked']);

		          $response["success"] = true;
		          $response["message"] = "Success! Vehicle Found.";
		          $response["loginUser"] = $searchedUser;
				  echo json_encode($response);	    


		           
		        $stmt = $reg_user->runQuery("INSERT INTO tbl_users_searches(user_id,vehicle_id,location) 
		        	values(:user_id, :vehicle_id, :location) ");
				$stmt->bindparam(":user_id",$userId, PDO::PARAM_INT);
				$stmt->bindparam(":vehicle_id",$vehicleID, PDO::PARAM_INT);
				$stmt->bindparam(":location",$location);
				$stmt->execute();		

				$stmt = $reg_user->runQuery("SELECT MAX(id) AS max FROM tbl_users_searches");
				$stmt->execute();
				$searchID = $stmt->fetch(PDO::FETCH_OBJ)->max;         

		            
		  		 
				  $message = '
		            <html>
			        <head>
			         <title>Test</title>
			        </head>
			        <body>	           
			           <p>'.$user['first_name'].' '.$user['last_name'].' searched your vehicle with model or chassis no '.$query.'</p>
			           For More Details <a href="http://wcarps.com/user/search_user.php?searchID='.$searchID.'">Click Here</a>
			        </body>
			        </html> ';
			        			 
					$subject = "WCarPs Vehicle Search Info";

					$headers  = "From: info@wcarps.com". "\r\n"; 
					$headers .= "MIME-Version: 1.0\r\n";
					$headers .= "Content-Type: text/html; charset=UTF-8\r\n";

		            mail($searchedUser['userEmail'],$subject,$message,$headers); 
		        } else {
		        	$response["success"] = false;
			        $response["message"] = "Sorry! No Search Result, it's Your Vehicle...";
			        echo json_encode($response);
		        }
	    } 
	    else {
	        $response["success"] = false;
	        $response["message"] = "Sorry! No Vehicle Found...";
	        echo json_encode($response);
	    }
	} else {
	        $response["success"] = false;
	        $response["message"] = "Invalid Json..";
	        echo json_encode($response);
	}

?>


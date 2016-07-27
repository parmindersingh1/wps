<?php
require_once dirname(__FILE__).'/class.user.php';

$reg_user = new USER();

// file_put_contents( 'debug' . time() . '.log', var_export( $_POST, true));
header('Content-Type: application/json');
$response = array();
 
if (isset($_POST['regId']) && $_POST['regId'] != '' && isset($_POST['userId']) && $_POST['userId'] != '') {
    $regId = $_POST['regId'];
    $userId = $_POST['userId'];
 
    $result = $reg_user->updateUserGcmRegId($regId, $userId);
 
    if ($result != NULL) { 		
        $response["success"] = true;
        $response["message"] = "GCM Registration Id Updated successfully!";
    } else {
    	$response["success"] = false;
        $response["message"] = "Sorry! Failed to create your account.";
    }
     
     
} else {
    $response["success"] = false;
    $response["message"] = "Sorry! Mobile OR GCM Registration Id is missing.";
}
 
 
echo json_encode($response);
?>

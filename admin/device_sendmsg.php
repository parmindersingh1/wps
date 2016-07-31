<?php
if (isset($_GET["regId"]) && isset($_GET["message"])) {
    $regId = $_GET["regId"];
    $message = $_GET["message"];

    include_once dirname(__FILE__).'/../api/gcm_sendmsg.php';
     
    $gcm = new GCM();
 
    $registration_ids = array($regId);
    $message = array("message" => $message);
 
    $result = $gcm->sendMultiple($registration_ids, $message, "WCarPs");
 	
    echo $result;
} else {
	echo false;
}
?>
<?php
// require_once dirname(__FILE__).'/class.user.php';

// $reg_user = new USER();


header('Content-Type: application/json');
$response = array();


file_put_contents( 'debug' . time() . '.log', var_export($_POST, true));

      $response["success"] = true;
      $response["message"] = "We've sent an message to $phone. Please Check Message.";
            //logToFile('mylog.log',$response);
      echo json_encode($response);
?>

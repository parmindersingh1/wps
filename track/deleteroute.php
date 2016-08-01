<?php
    require_once dirname(__FILE__).'/../api/class.user.php';
    require_once dirname(__FILE__).'/../api/class.vehicle.php';
    
    $user_login = new USER();
    $user_vehicle = new Vehicle();
    
    $sessionid   = isset($_GET['sessionid']) ? $_GET['sessionid'] : '0';
    
    $stmt = $user_vehicle->runQuery('CALL prcDeleteRoute(:sessionID);');     
         

    $stmt->execute(array(':sessionID' => $sessionid));

?>

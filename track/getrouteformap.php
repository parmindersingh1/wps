<?php
    require_once dirname(__FILE__).'/../api/class.user.php';
    require_once dirname(__FILE__).'/../api/class.vehicle.php';
    
    $user_login = new USER();
    $user_vehicle = new Vehicle();
    
    $sessionid  = isset($_GET['sessionid']) ? $_GET['sessionid'] : '0';
    
    $stmt = $user_vehicle->runQuery('CALL prcGetRouteForMap(:sessionID)');         

    $stmt->execute(array(':sessionID' => $sessionid));
    
    $json = '{ "locations": [';

    foreach ($stmt as $row) {
        $json .= $row['json'];
        $json .= ',';
    }

    $json = rtrim($json, ",");
    $json .= '] }';

    header('Content-Type: application/json');
    echo $json;

?>
<?php

    require_once dirname(__FILE__).'/../api/class.user.php';
    require_once dirname(__FILE__).'/../api/class.vehicle.php';
    
    $user_login = new USER();
    $user_vehicle = new Vehicle();

    $vehicleid   = isset($_GET['vehicleid']) ? $_GET['vehicleid'] : '0';

   
    $stmt = $user_vehicle->runQuery('CALL prcGetLiveRouteForMap(:vehicleID);');
   

    $stmt->execute(array(':vehicleID' => $vehicleid));

    $json = '{ "locations": [';

    foreach ($stmt as $row) {
        $json .= $row['json'];
        $json .= ',';
    }
    // var_dump($json);
    $json = rtrim($json, ",");
    $json .= '] }';

    header('Content-Type: application/json');
    echo $json;

?>
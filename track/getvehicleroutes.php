<?php
    require_once dirname(__FILE__).'/../api/class.user.php';
    require_once dirname(__FILE__).'/../api/class.vehicle.php';
    
    $user_login = new USER();
    $user_vehicle = new Vehicle();

    $vehicleID   = isset($_GET['vehicleid']) ? $_GET['vehicleid'] : 0;
    $routeDate = isset($_GET['dateSelect']) ? $_GET['dateSelect'] : '0000-00-00 00:00:00';

    $stmt = $user_vehicle->runQuery('CALL prcGetVehicleRoutes(:vehicleid,:routedate);');
    
    $stmt->execute(array(':vehicleid' => $vehicleID , ':routedate'=> $routeDate));

    $json = '{ "routes": [';

    foreach ($stmt as $row) {
        $json .= $row['json'];
        $json .= ',';
    }
   
    $json = rtrim($json, ",");
    $json .= '] }';

    header('Content-Type: application/json');
    echo $json;
?>

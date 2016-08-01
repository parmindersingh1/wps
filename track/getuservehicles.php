<?php
    require_once dirname(__FILE__).'/../api/class.user.php';
    require_once dirname(__FILE__).'/../api/class.vehicle.php';
    
    $user_login = new USER();
    $user_vehicle = new Vehicle();
    
    $userid   = isset($_GET['userid']) ? $_GET['userid'] : 0;
    
    $stmt = $user_vehicle->runQuery("SELECT CONCAT('{ \"vehicleID\": \"', vehicleID, '\", \"vehicleName\": \"', name, '\" }') json FROM tbl_vehicles WHERE user_id = :userid");     
    
    $stmt->execute(array(':userid' => $userid));
    
    $json = '{ "vehicles": [';

    foreach ($stmt as $row) {
        $json .= $row['json'];
        $json .= ',';
    }

    $json = rtrim($json, ",");
    $json .= '] }';

    header('Content-Type: application/json');
    echo $json;

?>
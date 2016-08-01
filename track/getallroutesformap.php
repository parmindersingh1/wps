<?php

    require_once dirname(__FILE__).'/../api/class.user.php';
    require_once dirname(__FILE__).'/../api/class.vehicle.php';
    
    $user_login = new USER();
    $user_vehicle = new Vehicle();

    $userID   = isset($_GET['userid']) ? $_GET['userid'] : 0;

    
    $stmt = $user_vehicle->runQuery('CALL prcGetAllRoutesForMap(:userid);');
            
           

    $stmt->execute(array(':userid' => $userID));

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
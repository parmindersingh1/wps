<?php
    require_once dirname(__FILE__).'/../api/class.user.php';
    require_once dirname(__FILE__).'/../api/class.vehicle.php';
    
    $user_login = new USER();
    $user_vehicle = new Vehicle();

    $userid  = isset($_GET['userid']) ? $_GET['userid'] : '0';
    
    $stmt = $user_vehicle->runQuery('CALL prcGetRoutes(:userid);');

    $stmt->execute(array(':userid' => $userid ));

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

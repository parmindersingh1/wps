<?php
    session_start();
    require_once dirname(__FILE__).'/../api/class.user.php';
    require_once dirname(__FILE__).'/../api/class.vehicle.php';
    $user_login = new USER();
    $user_vehicle = new Vehicle();
    file_put_contents( 'debug' . time() . '.log', var_export( $_GET, true));
    if(isset($_GET['id']))
    {  
        $vehicleID = $_GET['id'];
        $stmt = $user_login->runQuery("SELECT * FROM tbl_users WHERE userID = (SELECT user_id FROM tbl_vehicles WHERE vehicleID = :vehicle_id)");
        $stmt->execute(array(":vehicle_id"=>$vehicleID));
        $currentUser = $stmt->fetch(PDO::FETCH_OBJ);
    } else {
        header("Location: ../login.php"); //
    }

   

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Gps Tracker</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDOzwf7l3jIW3LA3aAKCDxKyi-99yWoZWo&libraries=places"></script>
    <script src="js/maps.js"></script>
    <script src="js/leaflet-0.7.5/leaflet.js"></script>
    <script src="js/leaflet-plugins/google.js"></script>
    <script src="js/leaflet-plugins/bing.js"></script>
    <script src="js/leaflet-routing-machine.min.js"></script>  
    <script src="js/bootstrap-datepicker.min.js"></script>  
    <link rel="stylesheet" href="js/leaflet-0.7.5/leaflet.css">    
    <!-- 
        to change themes, select a theme here:  http://www.bootstrapcdn.com/#bootswatch_tab 
        and then change the word after 3.2.0 in the following link to the new theme name
    -->    
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootswatch/3.3.5/cerulean/bootstrap.min.css">
    <link rel="stylesheet" href="css/leaflet-routing-machine.css">    
    <link rel="stylesheet" href="css/bootstrap-datepicker.min.css">    
    <link rel="stylesheet" href="css/styles.css">
            
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-4" id="toplogo">
                <img id="halimage" src="../images/logo_nav.png">WCarsPs Live Tracking
            </div>
            <div class="col-sm-8" id="messages"></div>
        </div>
        <div class="row">
            <div class="col-sm-12" id="mapdiv">
                <div id="map-canvas"></div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6" id="datediv">
                <input type="text" id="dateSelect" tabindex="1" class="form-control datepicker"  />
            </div>
            <div class="col-sm-6" id="selectdiv">
                <select id="routeSelect" tabindex="1" class="form-control"></select>
            </div>
        </div>
        <div class="row">
        <div class="col-sm-4 viewalldiv">
                <input type="button" id="liveTrack" value="Live Tracking" tabindex="5" class="btn btn-primary">
            </div>
            
             <div class="col-sm-4 refreshdiv">
                <input type="button" id="refresh" value="Refresh" tabindex="4" class="btn btn-primary">
            </div>

            <div class="col-sm-4 deletediv">
                <input type="button" id="delete" value="Delete Route" tabindex="2" class="btn btn-primary">
            </div>
            <!-- <div class="col-sm-3 autorefreshdiv">
                <input type="button" id="autorefresh" value="Auto Refresh Off" tabindex="3" class="btn btn-primary">
            </div> -->          
            
        </div>

        <input type="hidden" name="userid" value="<?= $currentUser->userID ?>">
        <input type="hidden" name="vehicleid" value="<?= $vehicleID ?>">
    </div>       
    
</body>
</html>
    

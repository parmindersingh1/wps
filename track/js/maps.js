  
jQuery(document).ready(function($) {
    'use strict';
    var routeSelect = document.getElementById('routeSelect');
    var vehicleSelect = document.getElementById('vehicleSelect');
    var map = document.getElementById('map-canvas');
    var autoRefresh = false;
    var intervalID = 0;
    var userid = $("input[name='userid']").val();
    var vehicleid = $("input[name='vehicleid']").val();
    var sessionIDArray = [];
    var vehicleIDArray = [];
    var viewingLiveRoutes = false;
    var dateSelected;

    Date.prototype.toYMD = Date_toYMD;
    function Date_toYMD() {
        var year, month, day;
        year = String(this.getFullYear());
        month = String(this.getMonth() + 1);
        if (month.length == 1) {
            month = "0" + month;
        }
        day = String(this.getDate());
        if (day.length == 1) {
            day = "0" + day;
        }
        return year + "-" + month + "-" + day;
    }

    var d = new Date();   
    $('.datepicker').val(d.getDate()+'/'+(d.getMonth()+1)+'/'+d.getFullYear());
    $('.datepicker').datepicker({
        format: "dd/mm/yyyy" ,
        endDate: new Date()
    })
     .on("changeDate", function(e) {
         // `e` here contains the extra attributes
        loadVehicleRoutesIntoDropdownBox();   
    });


        
    // getAllRoutesForMap();
    // loadRoutesIntoDropdownBox();
    loadVehicleRoutesIntoDropdownBox();
    // loadVehiclesIntoDropdownBox();
    getlivelocation();

    $("#routeSelect").change(function() {
        if (hasMap()) {
            viewingLiveRoutes = false;
            
            getRouteForMap();
        } 
    });
    
    // $("#vehicleSelect").change(function() {
    //     getAllVehicleRoutesForMap($(this).val());
    // });
       
    $("#refresh").click(function() {
        if (viewingLiveRoutes) {
            getlivelocation(); 
        } else {
            if (hasMap()) {
                getRouteForMap();             
            }          
        }
        loadVehicleRoutesIntoDropdownBox();
    });
       
    $("#delete").click(function() {
        deleteRoute();
    });       
        
    $('#autorefresh').click(function() { 
        if (autoRefresh) {
            turnOffAutoRefresh();           
        } else {
            turnOnAutoRefresh();                     
        }
    }); 
    
    $("#liveTrack").click(function() {
        getlivelocation();
    });

   function getlivelocation() {
        viewingLiveRoutes = true;
        routeSelect.selectedIndex = 0;
        loadliverouteformap(vehicleid);
    }
        
    // function getAllRoutesForMap() {
    //     viewingLiveRoutes = true;
    //     routeSelect.selectedIndex = 0;
    //     showPermanentMessage('Please select a route below');
                   
    //     $.ajax({
    //         url: 'getallroutesformap.php',
    //         type: 'GET',
    //         data: {userid: userid},
    //         // dataType: 'json',
    //         success: function(data) {
    //             console.log(data);
    //             loadGPSLocations(data);
    //     },
    //     error: function (xhr, status, errorThrown) {
    //         console.log("error status: " + xhr.status);
    //         console.log("errorThrown: " + errorThrown);
    //     }
    //     });
    // }  

    // function getAllVehicleRoutesForMap(vehicleID) {
    //     viewingLiveRoutes = true;
    //     routeSelect.selectedIndex = 0;
    //     showPermanentMessage('Please select a route below');
    //     loadVehicleRoutesIntoDropdownBox(vehicleID);

    //     $.ajax({
    //         url: 'getallvehicleroutesformap.php',
    //         type: 'GET',
    //         data: {vehicleid: vehicleID},
    //         // dataType: 'json',
    //         success: function(data) {
    //             console.log(data);
    //             loadGPSLocations(data);
    //     },
    //     error: function (xhr, status, errorThrown) {
    //         console.log("error status: " + xhr.status);
    //         console.log("errorThrown: " + errorThrown);
    //     }
    //     });
    // }                   
        
    // function loadRoutesIntoDropdownBox() {      
    //     $.ajax({
    //         url: 'getroutes.php',
    //         type: 'GET',
    //         data: {userid: userid},
    //         dataType: 'json',
    //         success: function(data) {
    //         loadRoutes(data);
    //     },
    //     error: function (xhr, status, errorThrown) {
    //         console.log("status: " + xhr.status);
    //         console.log("errorThrown: " + errorThrown);
    //     }
    //     });
    // }    
        
    function loadliverouteformap(vehicleID) {
        $.ajax({
            url: 'getliverouteformap.php',
            type: 'GET',
            data: {vehicleid: vehicleID},
            dataType: 'json',
            success: function(data) {
                console.log(data);
                loadGPSLocations(data);
        },
        error: function (xhr, status, errorThrown) {
            console.log("error status: " + xhr.status);
            console.log("errorThrown: " + errorThrown);
        }
        });
    }
    function loadVehicleRoutesIntoDropdownBox() {  
        dateSelected = $("#dateSelect").datepicker("getDate");
        $.ajax({
            url: 'getvehicleroutes.php',
            type: 'GET',
            data: {vehicleid: vehicleid, dateSelect: dateSelected.toYMD()},
            dataType: 'json',
            success: function(data) {
            loadRoutes(data);
        },
        error: function (xhr, status, errorThrown) {
            console.log("status: " + xhr.status);
            console.log("errorThrown: " + errorThrown);
        }
        });
    }    
    // function loadVehiclesIntoDropdownBox() {
         
    //     $.ajax({
    //         url: 'getuservehicles.php',
    //         type: 'GET',
    //         data: {userid: userid},
    //         dataType: 'json',
    //         success: function(data) {
    //         loadVehicles(data);
    //     },
    //     error: function (xhr, status, errorThrown) {
    //         console.log("status: " + xhr.status);
    //         console.log("errorThrown: " + errorThrown);
    //     }
    //     });

    // }

    function loadRoutes(json) {        
        if (json.length == 0) {
            showPermanentMessage('There are no routes available to view');
        }
        else {
            // create the first option of the dropdown box
            var option = document.createElement('option');
            option.setAttribute('value', '0');
            option.innerHTML = 'Select Route...';
            $(routeSelect).empty();
            routeSelect.appendChild(option);

            // when a user taps on a marker, the position of the sessionID in this array is the position of the route
            // in the dropdown box. it's used below to set the index of the dropdown box when the map is changed
            sessionIDArray = [];
            
            // iterate through the routes and load them into the dropdwon box.
            $(json.routes).each(function(key, value){
                var option = document.createElement('option');
                option.setAttribute('value', '?sessionid=' + $(this).attr('sessionID'));

                sessionIDArray.push($(this).attr('sessionID'));

                option.innerHTML = $(this).attr('vehicleName') + " " + $(this).attr('times');
                routeSelect.appendChild(option);
            });

            // need to reset this for firefox
            routeSelect.selectedIndex = 0;

            showPermanentMessage('Please select a route below');
        }
    }

    // function loadVehicles(json) {        
    //     if (json.length == 0) {
    //         showPermanentMessage('There are no vehicle available to view');
    //     }
    //     else {
    //         // create the first option of the dropdown box
    //         var option = document.createElement('option');
    //         option.setAttribute('value', '0');
    //         option.innerHTML = 'Select Vehicle...';
    //         vehicleSelect.appendChild(option);

    //         // when a user taps on a marker, the position of the sessionID in this array is the position of the route
    //         // in the dropdown box. it's used below to set the index of the dropdown box when the map is changed
    //         vehicleIDArray = [];
            
    //         // iterate through the routes and load them into the dropdwon box.
    //         $(json.vehicles).each(function(key, value){
    //             var option = document.createElement('option');
    //             option.setAttribute('value', $(this).attr('vehicleID'));

    //             vehicleIDArray.push($(this).attr('vehicleID'));

    //             option.innerHTML = $(this).attr('vehicleName');
    //             vehicleSelect.appendChild(option);
    //         });

    //         // need to reset this for firefox
    //         vehicleSelect.selectedIndex = 0;

    //         showPermanentMessage('Please select a vehicle');
    //     }
    // }

    function getRouteForMap() { 
        if (hasMap()) {
            // console.log($("#routeSelect").prop("selectedIndex"));

           var url = 'getrouteformap.php' + $('#routeSelect').val();

            $.ajax({
                   url: url,
                   type: 'GET',
                   dataType: 'json',
                   success: function(data) {
                      loadGPSLocations(data);
                   },
                   error: function (xhr, status, errorThrown) {
                       console.log("status: " + xhr.status);
                       console.log("errorThrown: " + errorThrown);
                    }
               });
        
        } 
    }

    function loadGPSLocations(json) {
        // console.log(JSON.stringify(json));
        // turnOnAutoRefresh();                     
        if (json.locations.length == 0) {
            showPermanentMessage('There is no tracking data to view');
            map.innerHTML = '';
        }
        else {
            if (map.id == 'map-canvas') {
                // clear any old map objects
                document.getElementById('map-canvas').outerHTML = "<div id='map-canvas'></div>";
           
                // use leaflet (http://leafletjs.com/) to create our map and map layers
                var gpsTrackerMap = new L.map('map-canvas',{
                    maxZoom: 16
                });
            
                var openStreetMapsURL = ('https:' == document.location.protocol ? 'https://' : 'http://') +
                 '{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';
                var openStreetMapsLayer = new L.TileLayer(openStreetMapsURL,
                {attribution:'&copy;2014 <a href="http://openstreetmap.org">OpenStreetMap</a> contributors'});

                // need to get your own bing maps key, http://www.microsoft.com/maps/create-a-bing-maps-key.aspx
                // var bingMapsLayer = new L.BingLayer("GetAKey");
                var googleMapsLayer = new L.Google('ROADMAP');
            
                // this fixes the zoom buttons from freezing
                // https://github.com/shramov/leaflet-plugins/issues/62
                L.polyline([[0, 0], ]).addTo(gpsTrackerMap);

                // this sets which map layer will first be displayed
                gpsTrackerMap.addLayer(googleMapsLayer);

                // this is the switcher control to switch between map types
                gpsTrackerMap.addControl(new L.Control.Layers({
                    // 'Bing Maps':bingMapsLayer,
                    'Google Maps':googleMapsLayer,
                    'OpenStreetMaps':openStreetMapsLayer
                }, {}));
            }

                var finalLocation = false;
                var counter = 0;
                var locationArray = [];
                
                // iterate through the locations and create map markers for each location
                $(json.locations).each(function(key, value){
                    var latitude =  $(this).attr('latitude');
                    var longitude = $(this).attr('longitude');
                    var tempLocation = new L.LatLng(latitude, longitude);
                    
                    locationArray.push(tempLocation);                    
                    counter++;

                    // want to set the map center on the last location
                    if (counter == $(json.locations).length) {
                        //gpsTrackerMap.setView(tempLocation, zoom);  if using fixed zoom
                        finalLocation = true;
                    
                        // if (!viewingLiveRoutes) {
                            displayCityName(latitude, longitude);
                        // }
                    }
                    var marker = createMarker(
                        latitude,
                        longitude,
                        $(this).attr('speed'),
                        $(this).attr('direction'),
                        $(this).attr('distance'),
                        $(this).attr('locationMethod'),
                        $(this).attr('gpsTime'),
                        $(this).attr('vehicleName'),
                        $(this).attr('sessionID'),
                        $(this).attr('accuracy'),
                        $(this).attr('extraInfo'),
                        $(this).attr('vehicleImage'),
                        gpsTrackerMap, finalLocation);
                });

    //             var polyline = L.polyline(locationArray, {color: 'red'}).addTo(gpsTrackerMap);

				// // zoom the map to the polyline
				// gpsTrackerMap.fitBounds(polyline.getBounds());

				var routingControl = L.Routing.control({
				    waypoints: locationArray,
				    routeWhileDragging: false,
				    draggableWaypoints: false,
				    addWaypoints: false,
				    show: false,
                    lineOptions: {
                          styles: [{color: '#5eb9ed', opacity: 1, weight: 5}]
                       },
				    createMarker: function() { return null; }
				}).addTo(gpsTrackerMap);

                setTimeout(function() {
                   gpsTrackerMap.removeControl(routingControl);
                }, 2000);
               
                
                // fit markers within window
                var bounds = new L.LatLngBounds(locationArray);
                gpsTrackerMap.fitBounds(bounds);
                
                // restarting interval here in case we are coming from viewing all routes
                if (autoRefresh) {
                    restartInterval();
                } 
            }
    }

    function createMarker(latitude, longitude, speed, direction, distance, locationMethod, gpsTime,
                          vehicleName, sessionID, accuracy, extraInfo, icon, map, finalLocation) {
        var iconUrl;

        if(viewingLiveRoutes){
            iconUrl = 'images/'+icon+'.png';
        } else if (finalLocation) {
            iconUrl = 'images/'+icon+'_end.png';
        } else {
            iconUrl = 'images/'+icon+'.png';
        }

        var markerIcon = new L.Icon({
                iconUrl:      iconUrl,
                iconSize:     [25, 35],
                iconAnchor:   [6, 20],
                popupAnchor:  [-3, -25]
        });

        var lastMarker = "</td></tr>";

        // when a user clicks on last marker, let them know it's final one
        if (finalLocation) {
            lastMarker = "</td></tr><tr><td align=left>&nbsp;</td><td><b>Final location</b></td></tr>";
        }

        // convert from meters to feet
        accuracy = parseInt(accuracy * 3.28);

        var popupWindowText = "<table border=0 style=\"font-size:95%;font-family:arial,helvetica,sans-serif;color:#000;\">" +
            "<tr><td align=right>&nbsp;</td><td>&nbsp;</td><td rowspan=2 align=right>" +
            "<img src=images/" + getCompassImage(direction) + ".jpg alt= />" + lastMarker +
            "<tr><td align=right>Speed:&nbsp;</td><td>" + speed +  " mph</td></tr>" +
            "<tr><td align=right>Distance:&nbsp;</td><td>" + distance +  " mi</td><td>&nbsp;</td></tr>" +
            "<tr><td align=right>Time:&nbsp;</td><td colspan=2>" + gpsTime +  "</td></tr>" +
            "<tr><td align=right>Name:&nbsp;</td><td>" + vehicleName + "</td><td>&nbsp;</td></tr>" +
            "<tr><td align=right>Accuracy:&nbsp;</td><td>" + accuracy + " ft</td><td>&nbsp;</td></tr></table>";


        var gpstrackerMarker;
        var title = vehicleName + " - " + gpsTime;

        // make sure the final red marker always displays on top 
        if (finalLocation) {
            gpstrackerMarker = new L.marker(new L.LatLng(latitude, longitude), {title: title, icon: markerIcon, zIndexOffset: 999}).bindPopup(popupWindowText).addTo(map);
        } else {
            gpstrackerMarker = new L.marker(new L.LatLng(latitude, longitude), {title: title, icon: markerIcon}).bindPopup(popupWindowText).addTo(map);
        }
        
        // if we are viewing all routes, we want to go to a route when a user taps on a marker instead of displaying popupWindow
        // if (viewingLiveRoutes) {
        //     gpstrackerMarker.unbindPopup();
            
        //     gpstrackerMarker.on("click", function() {        
        //         var url = 'getrouteformap.php?sessionid=' + sessionID;

        //         viewingLiveRoutes = false;
 
        //         var indexOfRouteInRouteSelectDropdwon = sessionIDArray.indexOf(sessionID) + 1;
        //         routeSelect.selectedIndex = indexOfRouteInRouteSelectDropdwon;

        //         if (autoRefresh) {
        //             restartInterval(); 
        //         }

        //         $.ajax({
        //             url: url,
        //             type: 'GET',
        //             dataType: 'json',
        //             success: function(data) {
        //                 loadGPSLocations(data);
        //             },
        //             error: function (xhr, status, errorThrown) {
        //                 console.log("status: " + xhr.status);
        //                 console.log("errorThrown: " + errorThrown);
        //             }
        //          });
        //     }); // on click
        // } 
    }

    function getCompassImage(azimuth) {
        if ((azimuth >= 337 && azimuth <= 360) || (azimuth >= 0 && azimuth < 23))
                return "compassN";
        if (azimuth >= 23 && azimuth < 68)
                return "compassNE";
        if (azimuth >= 68 && azimuth < 113)
                return "compassE";
        if (azimuth >= 113 && azimuth < 158)
                return "compassSE";
        if (azimuth >= 158 && azimuth < 203)
                return "compassS";
        if (azimuth >= 203 && azimuth < 248)
                return "compassSW";
        if (azimuth >= 248 && azimuth < 293)
                return "compassW";
        if (azimuth >= 293 && azimuth < 337)
                return "compassNW";

        return "";
    }
    
    // check to see if we have a map loaded, don't want to autorefresh or delete without it
    function hasMap() {
        if (routeSelect.selectedIndex == 0) { // means no map
            return false;
        }
        else {
            return true;
        }
    }

    function displayCityName(latitude, longitude) {
        var lat = parseFloat(latitude);
        var lng = parseFloat(longitude);
        var latlng = new google.maps.LatLng(lat, lng);
        var reverseGeocoder = new google.maps.Geocoder();
        reverseGeocoder.geocode({'latLng': latlng}, function(results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                // results[0] is full address
                if (results[1]) {
                    var reverseGeocoderResult = results[1].formatted_address; 
                    showPermanentMessage(reverseGeocoderResult);
                }
            } else {
                console.log('Geocoder failed due to: ' + status);
            }
        });
    }

    function turnOffAutoRefresh() {
        showMessage('Auto Refresh Off');
        $('#autorefresh').val('Auto Refresh Off');
    
        autoRefresh = false;
        clearInterval(intervalID);         
    }

    function turnOnAutoRefresh() {
        showMessage('Auto Refresh On (1 min)'); 
        $('#autorefresh').val('Auto Refresh On');
        autoRefresh = true;

        restartInterval();         
    }
    
    function restartInterval() {
        // if someone is viewing all routes and then switches to a single route
        // while autorefresh is on then the setInterval is going to be running with getAllRoutesForMap
        // and not getRouteForMap 

        clearInterval(intervalID);
        
        if (viewingLiveRoutes) {
            intervalID = setInterval(getlivelocation, 5 * 1000);// one minute 
        }
        //  else if(hasMap()){
        //     intervalID = setInterval(getRouteForMap, 5 * 1000);          
        // }        
    }

    function deleteRoute() {
        if (hasMap()) {
		
    		// comment out these two lines to get delete working
    		// confirm("Disabled here on test website, this works fine.");
    		// return false;
		
            var answer = confirm("This will permanently delete this route\n . Do you want to delete?");
            if (answer){
                var url = 'deleteroute.php' + $('#routeSelect').val();

                $.ajax({
                       url: url,
                       type: 'GET',
                       success: function() {
                          deleteRouteResponse();
                          getlivelocation();
                       }
                   });
            }
            else {
                return false;
            }
        }
        else {
            alert("Please select a route before trying to delete.");
        }
    }

    function deleteRouteResponse() {
        routeSelect.length = 0;

        document.getElementById('map-canvas').outerHTML = "<div id='map-canvas'></div>";
        loadVehicleRoutesIntoDropdownBox();
        // $.ajax({
        //        url: 'getroutes.php',
        //        type: 'GET',
        //        success: function(data) {
        //           loadRoutes(data);
        //        }
        //    });
    }

    // message visible for 7 seconds
    function showMessage(message) {
        // if we show a message like start auto refresh, we want to put back our current address afterwards
        var tempMessage =  $('#messages').html();
        
        $('#messages').html(message);
        setTimeout(function() {
            $('#messages').html(tempMessage);
        }, 7 * 1000); // 7 seconds
    }

    function showPermanentMessage(message) {
        $('#messages').html(message);
    }

    // for debugging, console.log(objectToString(map));
    function objectToString (obj) {
        var str = '';
        for (var p in obj) {
            if (obj.hasOwnProperty(p)) {
                str += p + ': ' + obj[p] + '\n';
            }
        }
        return str;
    }
    
    function setTheme() {
        //var bodyBackgroundColor = $('body').css('backgroundColor');
        //$('.container').css('background-color', bodyBackgroundColor);
        //$('body').css('background-color', '#ccc');
        // $('head').append('<link rel="stylesheet" href="style2.css" type="text/css" />');        
    }
});


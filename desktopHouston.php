<?php 
session_start(); // Starting Session
include('session.php');
if ($mobile==true)
{
    //header("location: getMobile.php");
}
if ($level_session>1){
    header("location: index.php");
}
if(!isset($_SESSION['login_user'])){
    header("location: index.php");
}
//check if it's been active for 1 hour, otherwise close it
if ($_SESSION['start'] + (7*60*60) < time()) {
     header("location: php/logout.php");
  }
?>

<!DOCTYPE html>
<html>

<head>
    <script>
        // window.location = "http://marathon.iems.northwestern.edu";
    </script>
    <meta charset=utf-8 />
    <title>Chevron Houston Marathon</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/d3/3.5.6/d3.min.js" charset="utf-8"></script>
    <script src="js/dimple.js"></script>
    <script src='https://api.tiles.mapbox.com/mapbox.js/v2.2.1/mapbox.js'></script>
    <link href='https://api.tiles.mapbox.com/mapbox.js/v2.2.1/mapbox.css' rel='stylesheet' />
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

    <link rel="stylesheet" href="css/leaflet.awesome-markers.css">
    <script src="js/leaflet.awesome-markers.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.simpleWeather/3.0.2/jquery.simpleWeather.min.js"></script>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Lato">

    <link rel='stylesheet' type='text/css' href='css/desktop_style.css'>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <script src='js/generalInfo.js' type='text/javascript'></script>
    
    <style>

    </style>

    <!--Including own scripts -->
    <script src='js/updateAll.js'></script>
</head>

<body onload="updatePage(); setInterval('updatePage()',1000)">

    <body>
        <div class="container-fluid">

            <div class="row" id='mediumRow'>
                <div class="col-sm-12 full" id='topBar'>

                    <div class="col-sm-1 full">
                        <div id="marathonLogo"></div>
                    </div>
                    
                    <div class="col-sm-1 full">
                        <div id="aramcoLogo"></div>
                    </div>
                    <a href="profile.php">
                    <div class="col-sm-2 full">
                        <div id="NUlogo"></div>
                    </div> </a>


                    <div class="col-sm-1 full"><!--Runners on course stat-->
                        <div class="row" class='to'>
                            On Course<br><div class='col-sm-12 full' id='RunnersOnCourse'> </div>
                        </div>
                        <!--end row div-->
                    </div>
                    <div class="col-sm-1 full"><!--Runners finished stat-->
                        <div class="row">
                            Finished<br><div class='col-sm-12 full' id='RunnersFinished'> </div>
                        </div>
                    </div>
                    <div class="col-sm-3 full" class='times'>
                        <div class='row'>Time</div>
                        <div class='row'>
                            <span id='clock'>&nsbp</span>
                        </div>
                    </div>
                    <div class="col-sm-2 full" class='times'>
                        <div class='row'>Race Time</div>
                        <div class='row'>
                            <span id='elapsedTime'>&nsbp</span>
                        </div> 
                    </div>
                    <div class='col-sm-1 full' class='refresh'>
                        <div class='row refreshButton' >
                            <button class='refreshButton' onclick="refreshPage()">REFRESH</button>
                        </div>
                    </div>

                </div>
            </div>

            <div class="row" id='smallRow'>
                <div class="col-sm-12  full" id='alertBar'>
                    <div class='col-sm-12 full' id='alertText'> </div>
                    
                </div>
            </div>

            <div class="row" id="xLargeRow">
                <div class="col-sm-7 full" id='map'>
                    <script src='js/generateMaps.js'></script>
                    <div class="row">
                          <div class='col-sm-11 full' id='infoBox'>

                            <div class="row">
                                <div class='col-sm-6 full' id='HospitalTransports'> </div>
                                <div class='col-sm-6 full' id='PatientsSeen'> </div>
                            </div>

                        </div>
                        <!--end infobox-->
                    </div>
                </div>
                <div class='col-sm-5 full' id='sidebar'>
                    <div class="row" id="sidebarTopRow">
                        <!--<div class='col-sm-1 full' id='legend'></div>-->
                        <div class='col-sm-3 full' id='legend'>
                         
                         <div class='legend'>
                             <div class='legend-scale'>
                                Runner Density
                                 <ul class='legend-labels'>
                                    <li><span style='background:#a6a6a6; float:left'></span>0 - 500</li> 
                                    <li><span style='background:#0BB50B; float:left'></span>500 - 1000</li>
                                    <li><span style='background:#FFDC00; float:left'></span>1000 - 2000</li>
                                    <li><span style='background:#FFA500; float:left'></span>2000 - 3000</li>
                                    <li><span style='background:#FF0000; float:left'></span>3000 - 4000</li>
                                 </ul>
                             </div><!--end legend-scale-->
                         </div><!--end class legend-->
                        </div><!--end 2 col density legend div-->
                        
                        <div class='col-sm-3 full' id='legend'>

                            <div class='legend'>
                             <div class='legend-scale'>
                                Bed Occupancy
                                 <ul class='legend-labels'>
                                    <li><span style='background:#0BB50B;'></span>&lt;50% full</li>
                                    <li><span style='background:#FFDC00;'></span>50% - 90%</li>
                                    <li><span style='background:#FF0000;'></span>>90%</li>
                                    <li><span style='background:#878787;'></span>Closed</li>
                                 </ul>
                             </div><!--end legend-scale-->
                         </div><!--end class legend-->
                        </div><!--end of next legend-->
                        
                        
                        <div class='col-sm-6 full' id='weather'>
                            <script src='js/weather.js' type='text/javascript'></script>
                        </div>
                        <!--end weather div-->
                    </div>
                    <!--end sidebarTopRow-->


                    <div class="row" id="sidebarGraphs">


                        <div class='col-sm-6 full' id='aidStation'>
                            <!--Here is Aid station-->
                            <script src='js/graphAidStations_Houston.js' type='text/javascript'></script>
                        </div>
                        <div class='col-sm-6 full' id='medicalTent'>
                            <!--Here goes medical tent-->
                            <script src='js/medicalTents_Houston.js' type='text/javascript'></script>
                        </div>

                    </div>
                    <div class="row" id="sidebarGraphs">

                        <div class='col-sm-7 full' id='densityPlot'>
                             <svg class='fullChart'></svg>
                        </div>
                        
                        <div class='col-sm-5 full' id='densityPlotH'>
                             <svg class='halfChart'></svg>
                             
                        </div>
                    
                    
                    <div class='row' style="margin:0; padding:0" >
                        <div class='legend'>
                        <div class='densityLegend legend-scale'>
                        <ul class='legend-labels'>

                        <div class='col-sm-5 full'>
                                        <li><span style='background:#A56FBF;'></span>Half marathon</li>
                        </div>
                        <div class='col-sm-5 full'>
                                        <li><span style='background:#460061;'></span>Full marathon</li>
                        </div>
                         </ul>
                        </div>
                        </div><!--end legend class-->
                    </div>
                    </div>
                    
                    
                    <script src='js/densityPlot.js' type='text/javascript'></script>
                    <script src='js/densityPlotH.js' type='text/javascript'></script>
                </div>
                <!--end 5 col div for sidebar-->

            </div>
            <!--end xlarge row-->



<!-- here is the tooltip that goes on the info bars -->
<div id="tooltip" class="hidden">
    <p><span id="tooltipHeader">Aid Station</span></p>
    <p><span id="value">100</span></p>
</div>

        </div>

    </body>

</html>

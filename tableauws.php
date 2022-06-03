<?php

$urlsalle = "http://192.168.0.28/appliwebold/tableaux.php?salle=1";
$components = parse_url($urlsalle, PHP_URL_QUERY);
parse_str($components, $results);
$salle=$_GET['salle'];

$connect = mysqli_connect("192.168.0.28", "mathis_carrere", "sbRQi87R7", "BEnOcean");

$DateTemp = array();
$Temp     = array();

$DateElec = array();
$Elec     = array();

$DateHumid = array();
$Humid     = array();

$sqltemperature = "SELECT sensor_value, date_value 
FROM TTemperature t, TModules m, TRoom r 
WHERE t.date_value > DATE_SUB(NOW(), INTERVAL 24 HOUR) 
AND t.module_id = m.module_id
AND m.room_id = r.room_id 
AND r.room_id =".$salle;
$resulttemperature = mysqli_query($mysqli, $sqltemperature);

while ($rowtemp = mysqli_fetch_array($resulttemp)) {
    $DateTemp[] = $rowtemp['date_value'];
    if ($rowtemp['module_id'] <= 100000000) {
        $Temp[] = $rowtemp['sensor_value'];
    }
}

$sqlelecconsumption = "SELECT cons_value, date_value 
FROM TElecConsumption e, TModules m, TRoom r 
WHERE e.date_value > DATE_SUB(NOW(), INTERVAL 24 HOUR) 
AND e.module_id = m.module_id
AND m.room_id = r.room_id 
AND r.room_id =".$salle;
$resultelecconsumption = mysqli_query($mysqli, $sqlelecconsumption);

while ($rowelec = mysqli_fetch_array($resultelec)) {
    $DateElec[] = $rowelec['date_value'];
    if ($rowelec['module_id'] <= 100000000) {
        $Elec[] = $rowelec['cons_value'];
    }
}


$sqlhumidity = "SELECT sensor_value, date_value 
FROM THumidity h, TModules m, TRoom r 
WHERE h.date_value > DATE_SUB(NOW(), INTERVAL 24 HOUR) 
AND h.module_id = m.module_id
AND m.room_id = r.room_id 
AND r.room_id =".$salle;
$resulthumidity = mysqli_query($mysqli, $sqlhumidity);

while ($rowhumid = mysqli_fetch_array($resulthumid)) {
    $DateHumid[] = $rowhumid['date_value'];
    if ($rowhumid['module_id'] <= 100000000) {
        $Humid[] = $rowhumid['sensor_value'];
    }
}

header('Content-Type: application/json');
echo json_encode(array(
    'DateTemp' => $DateTemp,
    'Temp' => $Temp,
    'DateElec' => $DateElec,
    'Elec' => $Elec,
    'DateHumid' => $DateHumid,
    'Humid' => $Humid
));

?>
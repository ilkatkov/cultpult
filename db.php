<?php

include_once "functions/xml.php";
include_once "functions/mysql.php";

$name = $_POST['name'];
$date = $_POST['date'];
$type = $_POST['type'];
$lat = $_POST['lat'];
$lon = $_POST['lon'];


$link = connectDB();
$query_insert = "INSERT INTO events (name, type, lat, lon, date) VALUES ('" . mysqli_real_escape_string($link, $name) . "', '" . mysqli_real_escape_string($link, $type) . "', '" . mysqli_real_escape_string($link, $lat) . "', '" . mysqli_real_escape_string($link, $lon) . "', '" . mysqli_real_escape_string($link, $date) . "')";
mysqli_query(connectDB(), $query_insert);

?>
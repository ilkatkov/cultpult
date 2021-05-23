<?php

include_once "../functions/xml.php";
include_once "../functions/mysql.php";

session_start();

$userEvent = $_POST['event'];
//$userEvent = "Выставка «Не допусти! Останови! Погаси!»";

if (!empty($_SESSION['LoggedIn']) && !empty($_SESSION['Username'])) {
    $events = getEvents();
    foreach ($events as $event){
        if ($event['name'] == $userEvent)
        {
            echo $event['date'];
        }
    }
}
?>

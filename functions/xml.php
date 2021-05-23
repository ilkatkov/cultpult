<?php

function getParticipantInfo($pin)
{
    // получаем информацию об участнике
    $link = connectDB();
    $query_participants = "SELECT * FROM participants WHERE pin = '" . md5(mysqli_real_escape_string($link, $pin . "welcomebelgorod")) . "'";
    $participants_sql = mysqli_query($link, $query_participants);
    for ($participants_data = []; $row = mysqli_fetch_assoc($participants_sql); $participants_data[] = $row);
    if (count($participants_data) == 0) {
        return [['name' => "False"]];
    }
    return $participants_data[0];
}



function getRegisterParticipants($name)
{
    // получаем список записавшихся участников мероприятия
    $link = connectDB();
    $query_participants = "SELECT * FROM participants WHERE event='" . $name . "'";
    $participants_sql = mysqli_query($link, $query_participants);
    for ($participants_data = []; $row = mysqli_fetch_assoc($participants_sql); $participants_data[] = $row);
    return $participants_data;
}

function getArriveParticipants($name)
{
    // получаем список пришедших участников мероприятия
    $link = connectDB();
    $query_participants = "SELECT * FROM archive WHERE event='" . $name . "'";
    $participants_sql = mysqli_query($link, $query_participants);
    for ($participants_data = []; $row = mysqli_fetch_assoc($participants_sql); $participants_data[] = $row);
    return $participants_data;
}

function getParticipantFullName($id)
{
    $link = connectDB();
    $query_participants = "SELECT `name`, `surname`, `patronymic` FROM participants WHERE `id` ='" . $id . "'";
    $participants_sql = mysqli_query($link, $query_participants);
    for ($participants_data = []; $row = mysqli_fetch_assoc($participants_sql); $participants_data[] = $row);
    return $participants_data;
}

function geteventInfo($id)
{
    $events = getevents();
    foreach ($events as $event) {
        if ($event["id"] == $id) {
            $name_arr = explode(" ", $event["curator"]);
            $fio = $name_arr[0] . " " . substr($name_arr[1], 0, 2) . "." . substr($name_arr[2], 0, 2) . ".";
            return array("name" => $event["name"], "curator" => $fio);
        }
    }
    return false;
}

//simple for geteventInfo ↓
// $pcs41 = geteventInfo("00140");
// echo "<p>". $pcs41["name"]. " - " . $pcs41["curator"]. "</p>";

function getEvents()
{
    // получаем список мероприятий
    $link = connectDB();
    $query_events = "SELECT * FROM events";
    $events_sql = mysqli_query($link, $query_events);
    $events_data = [];
    for ($events_data = []; $row = mysqli_fetch_assoc($events_sql); $events_data[] = $row);
    return $events_data;
}

function getEventsByDates($start, $end)
{
    // получаем список мероприятий
    $link = connectDB();
    $query_events = "SELECT * FROM events WHERE date BETWEEN '" . $start . "' AND '" . $end . "'";
    $events_sql = mysqli_query($link, $query_events);
    $events_data = [];
    for ($events_data = []; $row = mysqli_fetch_assoc($events_sql); $events_data[] = $row);
    return $events_data;
}


//simple for getevents ↓
// $events = getevents();
// for ($i = 0; $i < count($events); $i++){
//     echo "<p>".  $events[$i]["code"]. " - " . $events[$i]["name"]. " - " . $events[$i]["curator"]. "</p>";
// }

function geteventCodeOnName($name)
{
    $events = getevents();
    foreach ($events as $event) {
        if ($event["name"] == $name) {
            return $event["id"];
        }
    }
    return false;
}

function getNameOnCode($code)
{
    $events = getevents();
    foreach ($events as $event) {
        if ($event["id"] == $code) {
            return $event["name"];
        }
    }
    return false;
}

function getForm($event_id)
{
    $link = connectDB();
    $query_participants = "SELECT form FROM events WHERE id='" . $event_id . "'";
    $participants_sql = mysqli_query($link, $query_participants);
    for ($participants_data = []; $row = mysqli_fetch_assoc($participants_sql); $participants_data[] = $row);
    return $participants_data[0]['form'];
}

function getCuratorOnName($name)
{
    $events = getEvents();
    foreach ($events as $event) {
        if ($event["name"] == $name) {
            return $event["curator"];
        }
    }
    return false;
}
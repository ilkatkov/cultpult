<?php
include_once "../../functions/mysql.php";

// secret
$userSecret = $_POST['secret'];
$rightSecret = "Error while signing up for meal!";


// data
$userID = $_POST['participantID'];
$userPIN = md5($_POST['participantPIN'] . "welcomebelgorod");

if (!empty($_POST['date'])){
    $date = new DateTime($_POST['date']);
}

header("Content-type: application/json");

if ($userSecret != $rightSecret || empty($userID) || empty($userPIN) || empty($date)) 
{
    http_response_code(422);
    $errors = array();
    if (empty($userSecret)){
        $errors["secret"] = "field secret can not be blank";
    }
    else if ($userSecret != $rightSecret)
    {
        $errors["secret"] = "Wrong secret";
    }
    if (empty($userID)){
        $errors["participantID"] = "field participantID can not be blank";
    }
    if (empty($userID)){
        $errors["participantPIN"] = "field participantPIN can not be blank";
    }
    if (empty($date)){
        $errors["date"] = "field date can not be blank";
    }
    echo json_encode(array("error" => array("code" => http_response_code(), "message" => "Validation error", "errors" => $errors)));
}
else {

    insertArchive($userID, $userPIN, $date->format("Y-m-d"));
    http_response_code(200);
}

?>

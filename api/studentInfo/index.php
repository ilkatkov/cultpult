<?php
include_once "../../functions/mysql.php";

$userSecret = $_POST['secret'];
$rightSecret = "Error while signing up for meal!";

$userID = $_POST['participantID'];
$userPIN = md5($_POST['participantPIN'] . "welcomebelgorod");

header("Content-type: application/json");

if ($userSecret != $rightSecret || empty($userID) || empty($userPIN))
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
    if (empty($userPIN)){
        $errors["participantPIN"] = "field participantPIN can not be blank";
    }
    echo json_encode(array("error" => array("code" => http_response_code(), "message" => "Validation error", "errors" => $errors)));
}
else {

    echo json_encode(getparticipantInfo_app($userID, $userPIN)[0]);
    http_response_code(200);
}


?>
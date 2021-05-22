<?php
include_once "../../functions/mysql.php";

$userSecret = $_POST['secret'];
$rightSecret = "Error while signing up for meal!";

$userID = $_POST['participantID'];

header("Content-type: application/json");

if ($userSecret != $rightSecret || empty($userID)) 
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
    echo json_encode(array("error" => array("code" => http_response_code(), "message" => "Validation error", "errors" => $errors)));
}
else {

    $dates = getDates5();
    $is_lunch = array();
    for ($date = 0; $date < count($dates['full']); $date++){
        $temp_date = new DateTime($dates['full'][$date]);
        if (!empty(checkLunch($userID, (string)$temp_date->format('Y-m-d')))) {
            array_push($is_lunch, $dates['full'][$date]);
       }
    }
    echo json_encode(array("dates" => $is_lunch));
    http_response_code(200);
}
?>

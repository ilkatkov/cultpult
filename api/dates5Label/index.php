<?php

include_once "../../functions/mysql.php";

$userSecret = $_POST['secret'];
$rightSecret = "Error while signing up for meal!";

header("Content-type: application/json");

if ($userSecret != $rightSecret)
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
    echo json_encode(array("error" => array("code" => http_response_code(), "message" => "Validation error", "errors" => $errors)));
}
else {

    echo json_encode(array("dates" => getDates5Label()));
    http_response_code(200);
}


?>
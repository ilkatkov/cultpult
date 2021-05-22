<?php

include_once "../../functions/xml.php";
include_once "../../functions/mysql.php";

session_start();


$username = $_SESSION['Username'];
$password = $_POST['password'];
$state = getState($username);

if (!empty($_SESSION['LoggedIn']) && !empty($_SESSION['Username']) && $state != "3" && $state != "1" && userAuth($_SESSION['Username'], $password)) {
    $events = getevents();
    for ($i = 0; $i < count($events); $i++) {
        $link = connectDB();
        $query_update = "UPDATE events SET time = '00:00' WHERE id = '" . mysqli_real_escape_string($link, $events[$i]['id']) . "'";
        mysqli_query($link, $query_update) or trigger_error(mysqli_error($link) . $query_update);
    }
} else {
?>
    <form>
        <p class="login_mes">Возврат на главную...</p>
        <meta http-equiv='refresh' content='1;../index.php'>
    </form>
<?php
}
?>
<?php
include_once "../../functions/xml.php";
include_once "../../functions/mysql.php";

session_start();


$username = $_SESSION['Username'];
$password = $_POST['password'];
$state = getState($username);

if (!empty($_SESSION['LoggedIn']) && !empty($_SESSION['Username']) && $state != "3" && $state != "1" && userAuth($_SESSION['Username'], $password)) {
    $link = connectDB();

    $events = getevents();
    $query_truncate = "TRUNCATE events";
    mysqli_query($link, $query_truncate);
    $query_truncate = "TRUNCATE participants";
    mysqli_query($link, $query_truncate);
    for ($i = 0; $i < count($events); $i++) {
        $query_insert = "INSERT INTO events (id, time) VALUES ('" . $events[$i]['code'] .  "', '00:00')";
        mysqli_query($link, $query_insert) or trigger_error(mysqli_error($link) . $query_insert);
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
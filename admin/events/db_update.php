<?php
include_once "../../functions/xml.php";
include_once "../../functions/mysql.php";

session_start();

$event_id = $_POST['event_id'];

$username = $_SESSION['Username'];
$state = getState($username);

if (!empty($_SESSION['LoggedIn']) && !empty($_SESSION['Username'])) {
    deleteEvent($event_id);
} else {
?>
    <form>
        <p class="login_mes">Возврат на главную...</p>
        <meta http-equiv='refresh' content='1;../index.php'>
    </form>
<?php
}
?>
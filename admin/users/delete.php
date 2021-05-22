<?php
include_once "../../functions/xml.php";
include_once "../../functions/mysql.php";

session_start();

$state = getState($_SESSION['Username']);
$login = $_POST['login'];
if (!empty($_SESSION['LoggedIn']) && !empty($_SESSION['Username']) && $state == "5" && !empty($login)) {
    deleteUser($login);
    $_SESSION['LoggedIn'] = "";
    $_SESSION['Username'] = "";
    session_destroy();
} else {
?>
    <form>
        <p class="login_mes">Возврат на главную...</p>
        <meta http-equiv='refresh' content='1;../index.php'>
    </form>
<?php
}
?>
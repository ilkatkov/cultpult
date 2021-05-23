<?php
include_once "../functions/mysql.php";
$new_password = $_POST['new_password'];
$check_password = '';
if ($new_password != '') {
    $link = connectDB();
    $old_password = md5(mysqli_real_escape_string($link, $_POST['old_password']));
    $new_password = md5(mysqli_real_escape_string($link, $_POST['new_password']));
    $username = mysqli_real_escape_string($link, $_SESSION['Username']);
    $change = true;
    $check_password = mysqli_query($link, "SELECT * FROM users WHERE login = '" . $username . "' AND password = '" . $old_password . "'");
}

if (!empty($_SESSION['LoggedIn']) && !empty($_SESSION['Username'])) {
?>
    <form id="change_password" method="POST">
        <!-- Заголовок -->
        <?php
        if ($change && mysqli_num_rows($check_password) == 1) {
            mysqli_query($link, "UPDATE users SET password = '" . $new_password . "' WHERE login = '" . $username . "'");
        ?>
            <form>
                <p style='color:#2ECC71;' class="login_mes">Успех!</p>
                <p style='font-size:20px;'>Пароль успешно изменен!</p>
                <meta http-equiv='refresh' content='2;index.php'>
            </form>
        <?php
        } else if ($change && mysqli_num_rows($check_password) == 0) {
        ?>
            <form>
                <p style='color:#E74C3C;' class="login_mes">Ошибка!</p>
                <p style='font-size:20px;'>Старый пароль введен неверно!</p>
                <meta http-equiv='refresh' content='2;index.php'>
            </form>
        <?php
        } else {
        ?>
            <div class="div title_div">
                <p style="font-size:40px; font-family: 'Akrobat';">Организатор</p>
            </div>
            <!-- Пароль -->
            <div class = "auth_inputs">
                <label for="old_password" style="font-size:20px;">Старый пароль</label><br><input class = "admin_input" type="password" name="old_password" id="old_password" autofocus>
            </div>
            <br>
            <!-- Пароль еще раз -->
            <div class = "auth_inputs">
                <label for="new_password" style="font-size:20px;">Новый пароль</label><br><input class = "admin_input" type="password" name="new_password" id="new_password">
            </div>

            <!-- Применить -->
            <input class="btn mt8px btn_menu1" type="submit" id="accept" value="Применить">
    </form>
    <!-- Форма для выхода -->
    <form action="index.php">
        <input class="btn mt8px btn_menu3" type="submit" value="Назад">
    </form>
<?php
        }
    } else {
?>
<form>
    <p class="login_mes">Возврат на главную...</p>
    <meta http-equiv='refresh' content='1;index.php'>
</form>
<?php
    }
?>
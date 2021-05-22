<?php
include_once "../../functions/mysql.php";

session_start();

$link = connectDB();
$company_name = mysqli_real_escape_string($link, $_POST['company_name']);
$company_fullname = mysqli_real_escape_string($link, $_POST['company_fullname']);
$company_address = mysqli_real_escape_string($link, $_POST['company_address']);
$company_department = mysqli_real_escape_string($link, $_POST['company_department']);
$company_manager = mysqli_real_escape_string($link, $_POST['company_manager']);
$company_director = mysqli_real_escape_string($link, $_POST['company_director']);
$company_responsible = mysqli_real_escape_string($link, $_POST['company_responsible']);
$company_resource = mysqli_real_escape_string($link, $_POST['company_resource']);
$company_contract = mysqli_real_escape_string($link, $_POST['company_contract']);
$company_price = mysqli_real_escape_string($link, $_POST['company_price']);
$dr_number = mysqli_real_escape_string($link, (int)$_POST['dr_number']);
?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../../favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="../../styles/style.css">
    <title>Ведомости КультПульт</title>
</head>

<body>
    <div class="page">
        <!-- Шапка -->
        <header>
            <div class="logo_div"><a href = "/admin"><img src="../../img/logo.svg" class="logo_img"></a><a href = "/admin" class = "admin_link"><p class="logo_word">КультПульт</p></a></div>
        </header>
        <!-- Контент -->
        <content>
            <form>
                <?php
                $state = getState($_SESSION['Username']);
                if (!empty($_SESSION['LoggedIn']) && !empty($_SESSION['Username']) && $state != "2" && $state != "1") {
                    $link = connectDB();
                    mysqli_query($link, "TRUNCATE settings");
                    $insert_query = "INSERT INTO settings (company_name, company_fullname, company_address, company_department, company_manager, company_responsible, company_director, company_resource, company_contract, company_price, dr_number) VALUES ('" . $company_name . "', '" . $company_fullname . "', '" . $company_address . "', '" . $company_department . "', '" . $company_manager . "', '" . $company_responsible . "', '" . $company_director ."', '" . $company_resource . "', '" . $company_contract . "', '" . $company_price . "', '" . $dr_number . "')";
                    mysqli_query($link, $insert_query);
                ?>
                    <div>
                        <p style='color:#2ECC71;' class="login_mes">Успех!</p>
                        <p style='font-size:20px;'>Настройки изменены!</p>
                        <div class="ring">
                            <span></span>
                        </div>
                        <meta http-equiv='refresh' content='2;settings.php'>
                    </div>
                <?php
                } else {
                    ?>
                        <form>
                            <p class="login_mes">Возврат на главную...</p>
                            <meta http-equiv='refresh' content='1;../index.php'>
                        </form>
                    <?php
                    }
                    ?>

            </form>
        </content>
        <!-- Подвал -->
        <footer>

        </footer>
    </div>
</body>

</html>
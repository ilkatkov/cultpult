<?php
include_once "../../../functions/mysql.php";

session_start();

// в календарь ставим дату на день позже
$date_for_calendar = (string)date("Y-m-d");

?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../../../favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="../../../styles/style.css">
    <script src="../../../js/jquery-3.5.1.min.js"></script>
    <script src="../../../js/on_month.js"></script>
    <title>Панель управления</title>
</head>

<body>
    <div class="page">
        <!-- Шапка -->
        <header>
            <div class="logo_div"><a href = "/admin"><img src="../../../img/logo.svg" class="logo_img"></a><a href = "/admin" class = "admin_link"><p class="logo_word">КультПульт</p></a></div>
        </header>
        <!-- Контент -->
        <content>
            <?php
            // пользователь уже авторизован
            $state = getState($_SESSION['Username']);
            if (!empty($_SESSION['LoggedIn']) && !empty($_SESSION['Username']) && $state != "1") {
                // в календарь ставим сегодняшнюю дату
                $link = connectDB();
                $date_for_calendar = mysqli_real_escape_string($link, (string)date("Y-m-d"));
            ?>
                <div class="div title_div">
                    <p style='font-size:20px;'>Ведомости КультПульт</p>
                </div>
                <br>
                <hr>
                <!-- Word форма -->
                    <p style='font-size:20px;'>Выберите месяц и нажмите<br>"Получить"</p>

                    <!-- Выбор даты -->
                <div class = 'statements_div'>
                    <select name="month" id = "month">
                        <?php
                        $month_number = date('n');
                        $month = date('F');
                        switch ($month) {
                            case "January":
                                $month =  "Январь";
                                break;
                            case "February":
                                $month =  "Февраль";
                                break;
                            case "March":
                                $month = "Март";
                                break;
                            case "April":
                                $month = "Апрель";
                                break;
                            case "May":
                                $month = "Май";
                                break;
                            case "June":
                                $month = "Июнь";
                                break;
                            case "July":
                                $month = "Июль";
                                break;
                            case "August":
                                $month = "Август";
                                break;
                            case "September":
                                $month = "Сентябрь";
                                break;
                            case "October":
                                $month = "Октябрь";
                                break;
                            case "November":
                                $month = "Ноябрь";
                                break;
                            case "December":
                                $month = "Декабрь";
                                break;
                        }
                        echo "<option disabled selected value = '" . $month_number ."'>" . $month . "</option>"
                        ?>
                        <option value = "01">Январь</option>
                        <option value = "02">Февраль</option>
                        <option value = "03">Март</option>
                        <option value = "04">Апрель</option>
                        <option value = "05">Май</option>
                        <option value = "06">Июнь</option>
                        <option value = "07">Июль</option>
                        <option value = "08">Август</option>
                        <option value = "09">Сентябрь</option>
                        <option value = "10">Октбярь</option>
                        <option value = "11">Ноябрь</option>
                        <option value = "12">Декабрь</option>
                    </select>
                    <select name="year" id = "year">
                        <?php
                        $year = date('Y');
                        echo "<option disabled selected value = '" . $year ."'>" . $year . "</option>";
                        for ($i= $year-5; $i <= $year; $i++){
                            echo "<option value = '" . $i . "' > " . $i ."</option>";
                        }
                        ?>
                    </select>
                    <?php
                    echo "<a id = 'btn_excel' class = 'btn_download' href = 'download_excel.php?month=" . $month_number . "&year= " . $year ."'><input class='btn btn_ok' type='submit' value='Получить Excel'></a>"
                    ?>
                </div>



                <!-- Форма для выхода -->
                <form action="../">
                    <input class="btn btn_back" type="submit" value="Назад">
                </form>
            <?php
            } else {
                ?>
                    <form>
                        <p class="login_mes">Возврат на главную...</p>
                        <meta http-equiv='refresh' content='1;../../index.php'>
                    </form>
                <?php
                }
                ?>
        </content>
        <!-- Подвал -->
        <footer>
            
        </footer>
    </div>
</body>

</html>
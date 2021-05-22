<?php
include_once "../../functions/mysql.php";

session_start();
?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../../favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="../../styles/style.css">
    <script src="../../js/Chart.js"></script>
    <script src="../../js/statements.js"></script>
    <title>Панель управления</title>
</head>

<body>
    <div class="page">
        <!-- Шапка -->
        <header>
            <div class="logo_div"><a href = "/admin"><img src="../../img/logo.svg" class="logo_img"></a><a href = "/admin" class = "admin_link"><p class="logo_word">КультПульт</p></a></div>
        </header>
        <!-- Контент -->
        <content>
            <?php
            $state = getState($_SESSION['Username']);
            // пользователь уже авторизован
            if (!empty($_SESSION['LoggedIn']) && !empty($_SESSION['Username'])) {
            ?>
                <!-- Основная форма -->
                <form id="statements_form">
                    <!-- Заголовок -->
                    <div class="div title_div">
                        <p style='font-size:20px;'>Ведомости КультПульт</p>
                    </div>
                    <hr>
                    <?php if ($state == "1") { // если зашел куратор
                    ?>
                        <input class="btn btn_menu" type="button" id="on_event" value="Ведомость по группе">
                    <?php } else if ($state != "1") {
                    ?>
                        <input class="btn btn_menu" type="button" id="total" value="Ведомость за день">
                        <input class="btn btn_menu" type="button" id="on_month" value="Ведомость за месяц">
                        <input class="btn btn_menu" type="button" id="on_event" value="Ведомость по группе">
<!--                    <input class="btn btn_menu" type="button" id="akt_unused" value="Акт выдачи невостр. пит.">-->
                        <?php
                        if ($state != "2") { ?>
                            <input class="btn btn_menu" type="button" id="settings" value="Настройки">
                        <?php } ?>
                    <?php
                    } else {
                        echo "<form><p style='font-size:20px;'>Страница недоступна.</p></form>";
                    }
                    ?>
                </form>
                <!-- Форма для выхода -->
                <form action="../">
                    <input class="btn btn_back" type="submit" value="Назад">
                </form>
                <div class="diagramma">
                    <canvas id="myChart" width="300px" height="250px"></canvas>
                    <script>
                        var ctx = document.getElementById('myChart').getContext('2d');
                        var date = new Date();

                        date.setDate(date.getDate() - 4);
                        var first = date.getDate();
                        date.setDate(date.getDate() + 1);
                        var second = date.getDate();
                        date.setDate(date.getDate() + 1);
                        var third = date.getDate();
                        date.setDate(date.getDate() + 1);
                        var four = date.getDate();
                        date.setDate(date.getDate() + 1);
                        var fifth = date.getDate();
                        date.setDate(date.getDate() + 1);
                        var sixth = date.getDate();
                        date.setDate(date.getDate() + 1);
                        var seventh = date.getDate();
                        date.setDate(date.getDate() + 1);
                        var eighth = date.getDate();
                        date.setDate(date.getDate() + 1);
                        var ninth = date.getDate();
                        date.setDate(date.getDate() + 1);
                        var tenth = date.getDate();
                        var myChart = new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: [
                                    first,
                                    second,
                                    third,
                                    four,
                                    fifth,
                                    sixth,
                                    seventh,
                                    eighth,
                                    ninth,
                                    tenth
                                ],
                                datasets: [{
                                    label: ' питающихся студентов',
                                    data: [
                                        <?php if ($state != "1") {
                                            echo getAllLunchOnday((string)date("Y-m-d", strtotime("-4 day"))) . ",";
                                            echo getAllLunchOnday((string)date("Y-m-d", strtotime("-3 day"))) . ",";
                                            echo getAllLunchOnday((string)date("Y-m-d", strtotime("-2 day"))) . ",";
                                            echo getAllLunchOnday((string)date("Y-m-d", strtotime("-1 day"))) . ",";
                                            echo getAllLunchOnday((string)date("Y-m-d")) . ",";
                                            echo getAllLunchOnday((string)date("Y-m-d", strtotime("+1 day"))) . ",";
                                            echo getAllLunchOnday((string)date("Y-m-d", strtotime("+2 day"))) . ",";
                                            echo getAllLunchOnday((string)date("Y-m-d", strtotime("+3 day"))) . ",";
                                            echo getAllLunchOnday((string)date("Y-m-d", strtotime("+4 day"))) . ",";
                                            echo getAllLunchOnday((string)date("Y-m-d", strtotime("+5 day")));
                                        } else {
                                            echo getAllLunchOnDayAndevent((string)date("Y-m-d", strtotime("-4 day")), geteventOnCurator($_SESSION['Username'])) . ",";
                                            echo getAllLunchOnDayAndevent((string)date("Y-m-d", strtotime("-3 day")), geteventOnCurator($_SESSION['Username'])) . ",";
                                            echo getAllLunchOnDayAndevent((string)date("Y-m-d", strtotime("-2 day")), geteventOnCurator($_SESSION['Username'])) . ",";
                                            echo getAllLunchOnDayAndevent((string)date("Y-m-d", strtotime("-1 day")), geteventOnCurator($_SESSION['Username'])) . ",";
                                            echo getAllLunchOnDayAndevent((string)date("Y-m-d"), geteventOnCurator($_SESSION['Username'])) . ",";
                                            echo getAllLunchOnDayAndevent((string)date("Y-m-d", strtotime("+1 day")), geteventOnCurator($_SESSION['Username'])) . ",";
                                            echo getAllLunchOnDayAndevent((string)date("Y-m-d", strtotime("+2 day")), geteventOnCurator($_SESSION['Username'])) . ",";
                                            echo getAllLunchOnDayAndevent((string)date("Y-m-d", strtotime("+3 day")), geteventOnCurator($_SESSION['Username'])) . ",";
                                            echo getAllLunchOnDayAndevent((string)date("Y-m-d", strtotime("+4 day")), geteventOnCurator($_SESSION['Username'])) . ",";
                                            echo getAllLunchOnDayAndevent((string)date("Y-m-d", strtotime("+5 day")), geteventOnCurator($_SESSION['Username']));
                                        } ?>
                                    ],
                                    backgroundColor: [
                                        'rgba(255, 159, 64, 0.2)',
                                        'rgba(255, 159, 64, 0.2)',
                                        'rgba(255, 159, 64, 0.2)',
                                        'rgba(255, 159, 64, 0.2)',
                                        'rgba(255, 159, 64, 0.2)',
                                        'rgba(255, 159, 64, 0.2)',
                                        'rgba(255, 159, 64, 0.2)',
                                        'rgba(255, 159, 64, 0.2)',
                                        'rgba(255, 159, 64, 0.2)',
                                        'rgba(255, 159, 64, 0.2)'

                                    ],
                                    borderColor: [
                                        'rgba(255, 159, 64, 1)',
                                        'rgba(255, 159, 64, 1)',
                                        'rgba(255, 159, 64, 1)',
                                        'rgba(255, 159, 64, 1)',
                                        'rgba(255, 159, 64, 1)',
                                        'rgba(255, 159, 64, 1)',
                                        'rgba(255, 159, 64, 1)',
                                        'rgba(255, 159, 64, 1)',
                                        'rgba(255, 159, 64, 1)',
                                        'rgba(255, 159, 64, 1)'
                                    ],
                                    borderWidth: 1
                                }]
                            },
                            options: {
                                scales: {
                                    yAxes: [{
                                        ticks: {
                                            beginAtZero: true
                                        }
                                    }]
                                }
                            }
                        });
                    </script>
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
        </content>
        <!-- Подвал -->
        <footer>

        </footer>
    </div>
</body>

</html>
<?php
include_once "../../functions/xml.php";
include_once "../../functions/mysql.php";

session_start();

$event_id = (string)$_GET['event_id'];

?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="content-language" content="ru">
    <link rel="icon" href="../../favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="../../styles/style.css">
    <script src="../../js/jquery-1.4.3.min.js"></script>
    <script src="../../js/events.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
          integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
          crossorigin=""/>
    <!-- Make sure you put this AFTER Leaflet's CSS -->
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
            integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
            crossorigin=""></script>
    <script type="text/javascript" src="../../js/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
    <script type="text/javascript" src="../../js/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
    <link rel="stylesheet" type="text/css" href="../../js/fancybox/jquery.fancybox-1.3.4.css" media="screen"/>
    <title>Мероприятия КультПульт</title>
</head>

<body>
<div class="page">
    <!-- Шапка -->
    <header>
        <div class="logo_div"><a href="/admin"><img src="../../img/logo.svg" class="logo_img"></a><a href="/admin"
                                                                                                     class="admin_link">
                <p class="logo_word">КультПульт</p></a></div>
    </header>
    <!-- Контент -->
    <content>

        <?php
        // пользователь уже авторизован
        $state = getState($_SESSION['Username']);
        if (!empty($_SESSION['LoggedIn']) && !empty($_SESSION['Username']) && $state != "3" && $state != "1") {
            $events = getevents(); // получаем весь список групп
            if (!empty($event_id) && geteventInfo($event_id) == false) {
                echo "<form><p style='font-size:20px;'>Страница недоступна.</p></form>";
            } else if (empty($event_id)) {


        $events = getEvents();
        $geos = array("type" => "FeatureCollection", "features" => array());
        for ($event = 0; $event < count($events); $event++) {
            $geo = array('type' => 'Feature', "geometry" => array("type" => "Point", "coordinates" => array($events[$event]['lon'], $events[$event]['lat'])), "properties" => array("name" => $events[$event]['name'], "popupContent" => $events[$event]['date']));
            array_push($geos["features"], $geo);
        }

        ?>
                <!-- Основная форма -->
                <form id="main_form">
                    <!-- Заголовок -->
                    <div class="div title_div">
                        <p style='font-size:20px;'>Мероприятия КультПульт</p>
                    </div>
                    <hr>
                    <!-- Leaflet beginning -->
                    <div id="mapid"></div>
                    <script>
                        // Map init
                        var mymap = L.map('mapid').setView([50.6, 36.6], 9);
                        L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoidGltdXgiLCJhIjoiY2tvem13M2lrMDc2eDJubnZmcGVxNWVicyJ9.P2WIMw5wzvQqEayS72sP-Q', {
                            attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
                            maxZoom: 18,
                            id: 'mapbox/streets-v11',
                            tileSize: 512,
                            zoomOffset: -1,
                            accessToken: 'pk.eyJ1IjoidGltdXgiLCJhIjoiY2tvem13M2lrMDc2eDJubnZmcGVxNWVicyJ9.P2WIMw5wzvQqEayS72sP-Q'
                        }).addTo(mymap);

                        // Adding individual markers
                        //var marker1 = L.marker([50.5924481, 36.587910590625]).addTo(mymap);
                        //var marker2 = L.marker([50.5924481, 36.587910590625]).addTo(mymap);
                        //var marker3 = L.marker([50.86075335957002, 37.36932992935181]).addTo(mymap);
                        // ...and popups for them
                        //marker1.bindPopup("<b>Hello world!</b><br>I am a popup #1.").openPopup();
                        //marker2.bindPopup("<b>Hello world!</b><br>I am a popup #2.").openPopup();
                        //marker3.bindPopup("<b>Hello world!</b><br>I am a popup #3.").openPopup();

                        // GeoJSON
                        function onEachFeature(feature, layer) {
                            // does this feature have a property named popupContent?
                            if (feature.properties && feature.properties.popupContent) {
                                layer.bindPopup(feature.properties.popupContent);
                            }
                        }

                        var geojsonFeature = <?= json_encode($geos) ?>;



                        L.geoJSON(geojsonFeature, {
                            onEachFeature: onEachFeature
                        }).addTo(mymap);
                    </script>
                    <!-- Leaflet end -->
</div>
<!--                    <table class='table_style' id='tab'>-->
<!--                        <tr class='main_tr_events'>-->
<!--                            <td><b>№ п/п</b></td>-->
<!--                            <td><b>Мероприятие</b></td>-->
<!--                            <td><img class="edit_img" src='../../img/students.svg'></td>-->
<!--                            <td><b>Опции</b></td>-->
<!--                            --><?php
//                            for ($row = 0; $row < count($events); $row++) {
//                                $temp_event = $events[$row]['name'];
//                                $temp_curator = $events[$row]['curator'];
//                                $temp_code = $events[$row]['name'];
//                                $temp_count = count(getRegisterParticipants($temp_code));
//                                echo "<tr class = 'events'>";
//                                echo "<td>" . (string)($row + 1) . "</td>";
//                                echo "<td>" . $temp_event . "</td>";
//                                echo "<td>" . $temp_count . "</td>";
//                                echo "<td><img class = 'edit_img' src='../../img/edit.svg' width=15% onclick=" . "editevent('" . $temp_code . "')></td>";
//                                echo "</tr>";
//                            }
//                            ?>
<!--                    </table>-->
                    <input class="btn btn_back" type="button" id="btn_back_tab" value="Назад">
                </form>
                <?php
            } else { // редактируем выбранную группу
                $choosen_event = geteventInfo($event_id);
                $choosen_time = $times[array_search($event_id, array_column($times, 'id'))]['time'];
                $participants_count = count(getparticipants($event_id));
                $teacher = getTeacher($event_id);
                $form = getForm($event_id);
                if (empty($teacher)) {
                    $teacher = "Выберите преподавателя";
                }
                $teachers = getTeachers();
                ?>
                <form action="edit.php" method="post" id="event_form">
                    <!-- Заголовок -->
                    <div class="div title_div">
                        <p style='font-size:20px;'>Мероприятия КультПульт</p>
                    </div>
                    <hr>
                    <table class='table_participants_style' id='tab'>
                        <tr>
                            <td class='main_td_participants'>ID:</td>
                            <td><input type='text' class='input input_event' name='event_id' id="event_id"
                                       value='<?= $event_id ?>' readonly></td>
                        </tr>
                        <tr>
                            <td class='main_td_participants'>Группа:</td>
                            <td><input type='text' class='input input_event' name='event_name'
                                       value='<?= $choosen_event["name"] ?>' readonly></td>
                        </tr>
                        <tr>
                            <td class='main_td_participants'>Студентов:</td>
                            <td><input type='text' class='input input_event' name='event_count'
                                       value='<?= $participants_count ?>' readonly></td>
                        </tr>
                        <tr>
                            <td class='main_td_participants'>Обучение:</td>
                            <td>
                                <select class='input input_event' name="event_form">
                                    <?php
                                    if ($form == "1") {
                                        $old_form = "СПО";
                                        echo "<option value='1'>СПО</option>";
                                        echo "<option value='2'>НПО</option>";
                                    } else if ($form == "2") {
                                        echo "<option value='2'>НПО</option>";
                                        echo "<option value='1'>СПО</option>";
                                    } ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td class='main_td_participants'>Время:</td>
                            <td>
                                <input type='time' class='input input_event' name='old_time'
                                       value='<?= $choosen_time ?>' hidden>
                                <input type='time' class='input input_event' name='event_time'
                                       value='<?= $choosen_time ?>' autofocus required>
                            </td>
                        </tr>
                        <!--                            <tr>-->
                        <!--                                <td class = 'main_td_participants'>Преподаватель:</td>-->
                        <!--                                <td>-->
                        <!--                                    <select class='input input_event' name="event_teacher">-->
                        <!--                                        <option disabled selected>-->
                        <?//= $teacher ?><!--</option>-->
                        <!--                                        --><?php
                        //                                        for ($i = 1; $i < count($teachers); $i++) {
                        //                                            echo "<option value = '" . $teachers[$i] . "'>" . $teachers[$i] . "</option>";
                        //                                        }
                        //                                        ?>
                        <!--                                    </select>-->
                        <!--                                </td>-->
                        <!--                            </tr>-->
                        <tr>
                            <td class='main_td_participants'>Куратор:</td>
                            <td><input type='text' class='input input_event' name='event_curator'
                                       value='<?= $choosen_event["curator"] ?>' readonly></td>
                        </tr>
                    </table>
                    <p style="font-size:14px; line-height: 16px;">Если группа не учится,<br>то необходимо поставить
                        время питания 00:00.</p>

                    <!-- Кнопки -->
                    <input class="btn btn_ok" type="submit" value="Применить">
                    <?php if ($state == "5") {
                        ?>
                        <input class="btn btn_menu" type="button" name="btn_create_pin" id="btn_create_pin"
                               value="Сгенерировать PIN-коды">
                        <?php
                    }
                    ?>
                    <input class="btn btn_back" type="button" id="btn_back_edit" value="Назад">
                </form>
                <?php
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
    </content>
    <!-- Подвал -->
    <footer>

    </footer>
</div>
</body>

</html>
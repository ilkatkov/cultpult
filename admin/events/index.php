<?php
include_once "../../functions/xml.php";
include_once "../../functions/mysql.php";

session_start();

$event_id = (string)$_GET['event_id'];

$today = $_GET['start'];
$date = $_GET['end'];

if (empty($today)){
    $dt1 = new DateTime();
    $today = $dt1->format("Y-m-d");
}

if (empty($date)){
    $dt2 = new DateTime("+1 month");
    $date = $dt2->format("Y-m-d");
}

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
        <div class="logo_div"><a href = "/admin"><img src="../../img/logo_mini.svg" class="logo_img"></a></div>
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


        $events = getEventsByDates($today, $date);
        $geos = array("type" => "FeatureCollection", "features" => array());
        for ($event = 0; $event < count($events); $event++) {
            $geo = array('type' => 'Feature', "geometry" => array("type" => "Point", "coordinates" => array($events[$event]['lon'], $events[$event]['lat'])), "properties" => array("name" => $events[$event]['name'], "popupContent" => "<a href='index.php?event_id=" . $events[$event]['id'] . "'>" . $events[$event]['name'] . "</a>" . "<br>" . (string)DateTime::createFromFormat('Y-m-d', $events[$event]['date'])->format('d.m.Y')));
            array_push($geos["features"], $geo);
        }

        ?>
                <!-- Основная форма -->
                <form id="main_form">
                    <!-- Заголовок -->
                    <div class="div title_div">
                        <p style="font-size:40px; font-family: 'Akrobat';">Организатор</p>
                    </div>

                    <div class = "panel_dates" action="index.php" method="GET">
                        <p style="font-size:30px; font-family: 'Manrope';">Даты проведения мероприятий</p>
                        <input type="date" name = "start" value="<?= $today ?>">
                        <input type="date" name = "end" value="<?= $date ?>">
                        <input class = "go_date" type = "submit" value = "Обновить">
                    </div>

                    <div class = "events_div">
                        <div class = "list">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas lobortis imperdiet bibendum. In eget libero odio. Mauris posuere, massa sed maximus tincidunt, elit nunc finibus est, sed lobortis ipsum nisi sit amet quam. Morbi porttitor egestas porttitor. Aenean placerat erat arcu, eget consequat sem efficitur in. Etiam est nibh, ultricies eu est ut, feugiat mollis odio. Donec ex urna, vestibulum nec mauris ac, pellentesque luctus nisl.
                            Pellentesque vitae nisi massa. Donec in consectetur tellus, ac vehicula mi. Integer ac euismod libero. Sed pellentesque ante vitae porta laoreet. Quisque libero augue, cursus id cursus vel, sodales vitae massa. Proin feugiat turpis a augue vulputate, pellentesque consectetur est feugiat. Praesent consequat fermentum diam, lacinia ultrices neque suscipit id. Nam a pulvinar tellus. Morbi lobortis augue in est porta sodales. Maecenas vel faucibus lacus, non rutrum orci. Ut et tempor dolor. Vivamus quis lobortis diam.
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas lobortis imperdiet bibendum. In eget libero odio. Mauris posuere, massa sed maximus tincidunt, elit nunc finibus est, sed lobortis ipsum nisi sit amet quam. Morbi porttitor egestas porttitor. Aenean placerat erat arcu, eget consequat sem efficitur in. Etiam est nibh, ultricies eu est ut, feugiat mollis odio. Donec ex urna, vestibulum nec mauris ac, pellentesque luctus nisl.
                            Pellentesque vitae nisi massa. Donec in consectetur tellus, ac vehicula mi. Integer ac euismod libero. Sed pellentesque ante vitae porta laoreet. Quisque libero augue, cursus id cursus vel, sodales vitae massa. Proin feugiat turpis a augue vulputate, pellentesque consectetur est feugiat. Praesent consequat fermentum diam, lacinia ultrices neque suscipit id. Nam a pulvinar tellus. Morbi lobortis augue in est porta sodales. Maecenas vel faucibus lacus, non rutrum orci. Ut et tempor dolor. Vivamus quis lobortis diam.</div>
                        <div class = "map_and_btn">
                            <div class = "map" id="mapid"></div>
                            <input class="btn btn_menu3" type="button" id="btn_back_tab" value="Назад">
                        </div>
                    </div>

                    <!-- Leaflet beginning -->

                    <script>
                        // Map init
                        var mymap = L.map('mapid').setView([50.6, 36.6], 9);
                        L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoidGltdXgiLCJhIjoiY2tvem13M2lrMDc2eDJubnZmcGVxNWVicyJ9.P2WIMw5wzvQqEayS72sP-Q', {
                            attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
                            maxZoom: 18,
                            id: 'timux/ckp02bah8422n17o1r9gj5pvc',
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

                </form>
                <?php
            } else { // редактируем выбранную группу
                $choosen_event = getEvent($event_id)[0];

                $participants_count = count(getRegisterParticipants($choosen_event['name']));


                ?>
                <form action="edit.php" method="post" id="event_form">
                    <!-- Заголовок -->
                    <div class="div title_div">
                        <p style="font-size:40px; font-family: 'Akrobat';">Организатор</p>
                    </div>
                    <table class='table_participants_style' id='tab'>
                        <tr>
                            <td class='main_td_participants'>ID:</td>
                            <td><input type='text' class='input input_event' name='event_id' id="event_id"
                                       value='<?= $event_id ?>' readonly></td>
                        </tr>
                        <tr>
                            <td class='main_td_participants'>Мероприятие:</td>
                            <td><input type='text' class='input input_event' name='event_name'
                                       value='<?= $choosen_event["name"] ?>' readonly></td>
                        </tr>
                        <tr>
                            <td class='main_td_participants'>Участников:</td>
                            <td><input type='text' class='input input_event' name='event_count'
                                       value='<?= $participants_count ?>' readonly></td>
                        </tr>
                        <tr>
                            <td class='main_td_participants'>Куратор:</td>
                            <td><input type='text' class='input input_event' name='event_curator'
                                       value='<?= $choosen_event["curator"] ?>' readonly></td>
                        </tr>
                    </table>
                    <!-- Кнопки -->
                    <input class="btn btn_menu3" type="button" id="btn_back_edit" value="Назад">
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
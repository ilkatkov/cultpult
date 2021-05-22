<?php

// функция определения мобильного устройства
function isMobile()
{
    return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
}

function isAndroid()
{
    $ua = strtolower($_SERVER['HTTP_USER_AGENT']);
    return (stripos($ua, 'android') !== false); // && stripos($ua,'mobile') !== false) {
}

function isIOS()
{
    $ua = strtolower($_SERVER['HTTP_USER_AGENT']);
    return (stripos($ua, 'iPhone') !== false || stripos($ua, 'iPad') !== false); // && stripos($ua,'mobile') !== false) {
}
?>
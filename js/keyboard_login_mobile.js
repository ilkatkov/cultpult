window.onload = function() {
    try {
        var block = false;
        var login = document.getElementById("participant_id_mobile");
        var k1 = document.getElementById("k1");
        var k2 = document.getElementById("k2");
        var k3 = document.getElementById("k3");
        var k4 = document.getElementById("k4");
        var k5 = document.getElementById("k5");
        var k6 = document.getElementById("k6");
        var k7 = document.getElementById("k7");
        var k8 = document.getElementById("k8");
        var k9 = document.getElementById("k9");
        var k0 = document.getElementById("k0");
        var backspace = document.getElementById("backspace");
        var accept = document.getElementById("accept");

        k1.onclick = function() {
            if (login.value.length != 8) {
                login.value = login.value + "1";
            }
        }
        k2.onclick = function() {
            if (login.value.length != 8) {
                login.value = login.value + "2";
            }
        }
        k3.onclick = function() {
            if (login.value.length != 8) {
                login.value = login.value + "3";
            }
        }
        k4.onclick = function() {
            if (login.value.length != 8) {
                login.value = login.value + "4";
            }
        }
        k5.onclick = function() {
            if (login.value.length != 8) {
                login.value = login.value + "5";
            }
        }
        k6.onclick = function() {
            if (login.value.length != 8) {
                login.value = login.value + "6";
            }
        }
        k7.onclick = function() {
            if (login.value.length != 8) {
                login.value = login.value + "7";
            }
        }
        k8.onclick = function() {
            if (login.value.length != 8) {
                login.value = login.value + "8";
            }
        }
        k9.onclick = function() {
            if (login.value.length != 8) {
                login.value = login.value + "9";
            }
        }
        k0.onclick = function() {
            if (login.value.length != 8) {
                login.value = login.value + "0";
            }
        }
        backspace.onclick = function() {
            if (block == false) {
                login.value = login.value.slice(0, -1);
            }
        }

        accept.onclick = function() {
            if (login.value.length != 8) {
                return false;
            } else {
                accept.value = "Проверяю..";
                block = true;
                accept.style.opacity = 0.5;
            }
        }
    } catch (error) {}
}
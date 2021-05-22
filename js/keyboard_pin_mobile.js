window.onload = function() {
    try {
        var block = false;
        var pin = document.getElementById('participant_pin_mobile');
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
            if (pin.value.length != 4) {
                pin.value = pin.value + "1";
            }
        }
        k2.onclick = function() {
            if (pin.value.length != 4) {
                pin.value = pin.value + "2";
            }
        }
        k3.onclick = function() {
            if (pin.value.length != 4) {
                pin.value = pin.value + "3";
            }
        }
        k4.onclick = function() {
            if (pin.value.length != 4) {
                pin.value = pin.value + "4";
            }
        }
        k5.onclick = function() {
            if (pin.value.length != 4) {
                pin.value = pin.value + "5";
            }
        }
        k6.onclick = function() {
            if (pin.value.length != 4) {
                pin.value = pin.value + "6";
            }
        }
        k7.onclick = function() {
            if (pin.value.length != 4) {
                pin.value = pin.value + "7";
            }
        }
        k8.onclick = function() {
            if (pin.value.length != 4) {
                pin.value = pin.value + "8";
            }
        }
        k9.onclick = function() {
            if (pin.value.length != 4) {
                pin.value = pin.value + "9";
            }
        }
        k0.onclick = function() {
            if (pin.value.length != 4) {
                pin.value = pin.value + "0";
            }
        }
        backspace.onclick = function() {
            if (block == false) {
                pin.value = pin.value.slice(0, -1);
            }
        }

        accept.onclick = function() {
            if (pin.value.length != 4) {
                return false;
            } else {
                accept.innerHTML = "Отправляем поварам";
                block = true;
                accept.style.background = "#2ECC71";
                accept.style.opacity = 0.5;
            }
        }
    } catch (error) {}
}
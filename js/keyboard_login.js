window.onload = function() {
    try {
        var block = false;
        var login = document.getElementById("participant_id");
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
                accept.value = "Проверяю студента";
                block = true;
                accept.style.background = "#2ECC71";
                accept.style.opacity = 0.5;
            }
        }
    } catch (error) {}
}


document.addEventListener("keydown", function(e) {
    try {
        var login = document.getElementById("participant_id");
        if (login.value.length < 8) {
            if (e.keyCode == 49 || e.keyCode == 97) {
                login.value += "1";
            } else if (e.keyCode == 50 || e.keyCode == 98) {
                login.value += 2;
            } else if (e.keyCode == 51 || e.keyCode == 99) {
                login.value += 3;
            } else if (e.keyCode == 52 || e.keyCode == 100) {
                login.value += 4;
            } else if (e.keyCode == 53 || e.keyCode == 101) {
                login.value += 5;
            } else if (e.keyCode == 54 || e.keyCode == 102) {
                login.value += 6;
            } else
            if (e.keyCode == 55 || e.keyCode == 103) {
                login.value += 7;
            } else
            if (e.keyCode == 56 || e.keyCode == 104) {
                login.value += 8;
            } else if (e.keyCode == 57 || e.keyCode == 105) {
                login.value += 9;
            } else if (e.keyCode == 48 || e.keyCode == 96) {
                login.value += 0;
            } else if (e.keyCode == 8) {
                login.value = login.value.slice(0, -1);
            }
        } else if (e.keyCode == 8) {
            login.value = login.value.slice(0, -1);
        } else if (e.keyCode == 13) {
            if (login.value.length != 6) {
                return false;
            } else {
                document.id_form.submit();
            }
        }
    } catch (error) {}
});
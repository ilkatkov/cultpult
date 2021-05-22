document.addEventListener("keydown", function(e) {
    try {
        if (e.keyCode == 13) {
            var k1 = document.getElementById("monday");
            var k2 = document.getElementById("tuesday");
            var k3 = document.getElementById("wednesday");
            var k4 = document.getElementById("thursday");
            var k5 = document.getElementById("friday");
            if (!(k1.checked || k2.checked || k3.checked || k4.checked || k5.checked)) {
                return false;
            } else {
                document.choosing_form.submit();
            }
        }
    } catch (error) {
        console.log("Что-то пошло не так..");
    }

});
function editevent(id) {
    location.href = "?event_id=" + id;
}

window.onload = function() {
    try {
        var btn_back_tab = document.forms.main_form.btn_back_tab;
        btn_back_tab.onclick = function() {
            location.href = "../";
        }
    } catch (error) {}

    try {
        var btn_back_edit = document.forms.event_form.btn_back_edit;
        btn_back_edit.onclick = function() {
            location.href = ".";
        }
    } catch (error) {}

    try {
        var btn_db_update = document.getElementById("update_password_ok");
        btn_db_update.onclick = function() {
            var password = document.getElementById("update_password").value;
            $.ajax({
                type: "POST",
                url: "db_update.php",
                cache: false,
                data: { password: password },
                success: function(x) {
                    location.href = './';
                }
            });
        }
    } catch (error) {}

    try {
        var btn_clear_time = document.getElementById("clear_password_ok");
        btn_clear_time.onclick = function() {
            var password = document.getElementById("clear_password").value;
            $.ajax({
                type: "POST",
                data: { password: password },
                url: "clear_time.php",
                cache: false,
                success: function(x) {
                    location.href = './';
                }
            });
        }
    } catch (error) {}

    try {
        var btn_create_pin = document.forms.event_form.btn_create_pin;
        var choosen_event = document.getElementById('event_id').value;
        btn_create_pin.onclick = function() {
            var result = confirm('ПРЕДЫДУЩИЕ PIN-КОДЫ БУДУТ СБРОШЕНЫ.\nСоздаются новые PIN-коды и выгружаются в документ Word.');
            if (result) {
                location.href = 'create_pin.php?event=' + choosen_event;
            }

        }
    } catch (error) {}


}
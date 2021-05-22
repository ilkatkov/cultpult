function editparticipant(id) {
    location.href = "?participant_id=" + id;
}

window.onload = function() {
    try {
        var participant_id = document.getElementById("participant_id").value;
        var history = document.getElementById("btn_story");
        var insertArchive = document.getElementById("btn_insertArchive");
        var fancybox_overlay = document.getElementById("fancybox-overlay");
        var fancybox_close = document.getElementById("fancybox-close");


        history.onclick = function() {
            var participant = "";
            participant = document.getElementById("participant_id").value;
            var history_data = document.getElementById('history_data');
            history_data.innerHTML = "<p id='history_date'> Загрузка...</p>";
            var story_table = document.getElementById('story_table');
            story_table.innerHTML = "<table border = 1 class = 'table_module' id = 'participants'>";
            $.ajax({
                type: 'post',
                url: 'look_history.php',
                data: { participant_id: participant },
                success: function(lunches) {
                    try {
                        data = JSON.parse(lunches);
                        count = data.length;
                        story_table = document.getElementById("story_table");
                        document.getElementById("history_data").innerHTML = "<p>Студент " + document.getElementById("participant_name").value + "</p>";
                        story_table.innerHTML = "<table class = 'table_module' id = 'story_table' border = 1><tr><td align = 'center'>№ п/п</td><td align = 'center'>Дата обеда</td><td>Дата и время регистрации</td></tr>";
                        for (row = 0; row < count; row++) {
                            story_table.innerHTML += ("<tr><td align = 'center'>" + (row + 1) + "</td><td align = 'left'>" + data[row]['date'] + "</td><td align = 'left'>" + data[row]['reg_time'] + "</td></tr>");
                        }
                        story_table.innerHTML += "</table>";
                    } catch (error) {
                        history_data.innerHTML = "<p>Ошибка загрузки данных.</p>";
                    }
                }
            }, );
            return false;
        }

        fancybox_overlay.onclick = function() {
            location.href = "participants.php?participant_id=" + participant_id;
        }
        fancybox_close.onclick = function() {
            location.href = "participants.php?participant_id=" + participant_id;
        }
    } catch (error) {}


    try {
        var btn_back_tab = document.forms.main_form.btn_back_tab;
        btn_back_tab.onclick = function() {
            location.href = ".";
        }
    } catch (error) {}

    try {
        var btn_back_edit = document.forms.participant_form.btn_back_edit;
        var event = document.forms.participant_form.participant_event;
        btn_back_edit.onclick = function() {
            location.href = "participants.php?select_events=" + event.value;
        }
    } catch (error) {}

    try {
        var btn_edit_pin = document.forms.participant_form.btn_edit_pin;
        var participant = document.forms.participant_form.participant_id;
        btn_edit_pin.onclick = function() {
            location.href = "edit_pin.php?participant=" + participant.value;
        }
    } catch (error) {}

}
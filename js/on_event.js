window.onload = function() {
    var look_participants = document.getElementById("look_participants");
    var fancybox_overlay = document.getElementById("fancybox-overlay");
    var fancybox_close = document.getElementById("fancybox-close");
    look_participants.onclick = function() {
        var user_event = "";
        user_event = document.getElementById("select_events").value;
        var user_date = document.getElementById("date").value;
        var event_date = "";
        event_date = document.getElementById("event_date");
        var participants = document.getElementById("participants");
        event_date.innerHTML = "<p id='event_date'> Загрузка...</p>";
        participants.innerHTML = "<table border = 1 class = 'table_module' id = 'participants'>";
        $.ajax({
            type: 'post',
            url: 'look_participants.php',
            data: { select_events: user_event, date: user_date },
            success: function(participants) {
                try {
                    data = JSON.parse(participants);
                    count = data.length;
                    participants = document.getElementById("participants");
                    try {
                        document.getElementById("event_date").innerHTML = "<p>Группа " + document.getElementById("show_event").value + " " + document.getElementById("date").value + "</p>";
                    } catch (error) {
                        document.getElementById("event_date").innerHTML = "<p>Группа " + document.getElementById("select_events").options[document.getElementById("select_events").options.selectedIndex].text + " " + document.getElementById("date").value + "</p>";
                    }
                    participants.innerHTML = "<table class = 'table_module' id = 'participants' border = 1><tr><td align = 'center'>№ п/п</td><td align = 'center'>ФИО студента</td><td>Дата и время регистрации</td></tr>";
                    for (row = 0; row < count; row++) {
                        participants.innerHTML += ("<tr><td align = 'center'>" + data[row]["id"] + "</td><td align = 'left'>" + data[row]["name"] + "</td><td align = 'left'>" + data[row]["reg_time"] + "</td></tr>");
                    }
                    participants.innerHTML += "</table>";
                } catch (error) {
                    document.getElementById("event_date").innerHTML = "<p>Ошибка загрузки данных.</p><p>Возможно, никто из студентов этой группы не записался на обед.</p>";
                }
            }
        }, );
        return false;
    }
    fancybox_overlay.onclick = function() {
        location.href = "./";
    }
    fancybox_close.onclick = function() {
        location.href = "./";
    }
}
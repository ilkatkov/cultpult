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
        var btn_db_update = document.getElementById("btn_delete");
        btn_db_update.onclick = function() {
            let ans = confirm("Вы действительно хотите удалить данное мероприятие?");
            if (ans) {
                var id = document.getElementById("event_id").value;
                $.ajax({
                    type: "POST",
                    url: "db_update.php",
                    cache: false,
                    data: { event_id: id },
                    success: function(x) {
                        location.href = './';
                    }
                });
            }
        }
    } catch (error) {}





}
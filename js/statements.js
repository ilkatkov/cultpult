window.onload = function() {
    try {
        var total = document.forms.statements_form.total;
        total.onclick = function() {
            location.href = "total/";
        }
    } catch (error) {}

    try {
        var on_event = document.forms.statements_form.on_event;
        on_event.onclick = function() {
            location.href = "on_event/";
        }
    } catch (error) {}

    try {
        var on_month = document.forms.statements_form.on_month;
        on_month.onclick = function() {
            location.href = "on_month/";
        }
    } catch (error) {}

    try {
        var akt_unused = document.forms.statements_form.akt_unused;
        akt_unused.onclick = function() {
            location.href = "akt_unused/";
        }
    } catch (error) {}

    try {
        var settings = document.forms.statements_form.settings;
        settings.onclick = function() {
            location.href = "settings.php";
        }
    } catch (error) {}

}
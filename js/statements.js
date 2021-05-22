window.onload = function() {
    try {
        var total = document.forms.statements_form.total;
        total.onclick = function() {
            location.href = "total/";
        }
    } catch (error) {}

    try {
        var on_register = document.forms.statements_form.on_register;
        on_register.onclick = function() {
            location.href = "on_register/";
        }
    } catch (error) {}

    try {
        var on_arrive = document.forms.statements_form.on_arrive;
        on_arrive.onclick = function() {
            location.href = "on_arrive/";
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
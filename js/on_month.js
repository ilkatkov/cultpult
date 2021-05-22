window.onload = function() {
    try {
        var settings = document.forms.statements_form.settings;
        settings.onclick = function() {
            location.href = "settings.php";
        }
    } catch (error) {}

    let user_month = document.getElementById('month');
    let user_year = document.getElementById('year');
    let btn_excel = document.getElementById('btn_excel');
    user_month.onchange = function (){
        btn_excel.href = "download_excel.php?month=" + user_month.value + "&year=" + user_year.value;
    }
    user_year.onchange = function (){
        btn_excel.href = "download_excel.php?month=" + user_month.value + "&year=" + user_year.value;
    }

}
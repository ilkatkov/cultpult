window.onload = function() {
    try {
        var settings = document.forms.statements_form.settings;
        settings.onclick = function() {
            location.href = "settings.php";
        }
    } catch (error) {}

    let date = document.getElementById('date');
    let btn_word = document.getElementById('btn_word');
    let btn_excel = document.getElementById('btn_excel');
    date.onchange = function (){
        btn_word.href = "download_word.php?date=" + date.value;
        btn_excel.href = "download_excel.php?date=" + date.value;
    }

}
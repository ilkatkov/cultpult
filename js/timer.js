let time = 0;
$(document).ready(function() {

    //здесь функция срабатывает раз в секунду
    let interval = setInterval(idleTimer, 1000);

    //тут можно добавлять все события которые не должны срабатывать
    $(this).on('mousemove', function(e) {
        time = 0;
    });
    $(this).on('mousedown', function(e) {
        time = 0;
    });
});

//тут задаем время простоя, сейчас стоит 25 секунд
function idleTimer() {
    let timer = document.getElementById("timer");
    timer.innerHTML = "Возврат на главную через " + (25 - time);
    time = time + 1;
    if (time > 25) {
        document.location.href = "index.php";
    }
}
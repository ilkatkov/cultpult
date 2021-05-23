window.onload = function() {
    var select_events = document.getElementById('select_events');
    console.log(select_events.options[select_events.selectedIndex].text);
    select_events.onchange = function() {
        var event = select_events.options[select_events.selectedIndex].text;
        $.ajax({
            type: 'post',
            url: 'dates.php',
            data: { event: event},
            success: function(dates) {
                let date = document.getElementById('date');
                date.value = dates;
            },
            error: function (e){
                console.log(e);
            }
        }, );
        return false;
    }
}
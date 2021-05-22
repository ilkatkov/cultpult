window.onload = function (){
    let inputs = document.getElementsByTagName('input');
    var checkboxes = [];
    for (var i = 0; i < inputs.length; i++) {
        if (inputs[i].type == "checkbox") {
            checkboxes.push(inputs[i]);
        }
    }
    for (var i = 0; i < checkboxes.length; i++) {
        checkboxes[i].onchange = function (e){
            var data = e.target.id;
            var participant_id = data.substr(0, data.indexOf('_'));
            var date = data.substr(data.indexOf('_')+1);
            var checked = e.target.checked;
            if (checked){
                $.ajax({
                    type: 'POST',
                    url: 'add_lunch.php',
                    data: {participant_id: participant_id, date: date},
                    success: function (data){
                        console.log(participant_id + " записан на " + date);
                    },
                    error: function (){
                        console.log("Что-то пошло не так");
                    }
                });
            }
            else {
                $.ajax({
                    type: 'POST',
                    url: 'del_lunch.php',
                    data: {participant_id: participant_id, date: date},
                    success: function (data) {
                        console.log(participant_id + " отписан с " + date);
                    },
                    error: function () {
                        console.log("Что-то пошло не так");
                    }
                });
            }
        }
    }
    try {
        var btn_back_edit = document.forms.orders_form.btn_back_edit;
        btn_back_edit.onclick = function() {
            location.href = ".";
        }
    } catch (error) {}


    try {
        var btn_back_tab = document.forms.main_form.btn_back_tab;
        btn_back_tab.onclick = function() {
            location.href = "..";
        }
    } catch (error) {}
}
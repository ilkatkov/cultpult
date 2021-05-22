window.onload = function() {

    try {
        editUser = function(login) {
            location.href = "settings_user.php?login=" + login;
        }

    } catch (error) {}

    try {
        var add_btn_user = document.forms.users_form.btn_add_user;
        add_btn_user.onclick = function() {
            location.href = "add_user.php";
        }
    } catch (error) {}
    try {
        var add_btn_curator = document.forms.users_form.btn_add_curator;
        add_btn_curator.onclick = function() {
            location.href = "add_curator.php";
        }
    } catch (error) {}
}
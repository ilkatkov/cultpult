window.onload = function() {
    try {
        var btn_delete_user = document.getElementById('btn_delete_user');
        var user_login = document.getElementById('login_update').value;
        btn_delete_user.onclick = function() {
            var result = confirm('Вы действительно хотите удалить пользователя ' + user_login + '?');
            if (result) {
                $.ajax({
                    type: "POST",
                    url: "delete.php",
                    data: { login: user_login },
                    error: function(xhr, textStatus) {
                        alert([xhr.status, textStatus]);
                    }
                });
                location.href = "./index.php";
            }
        }
    } catch (error) {}
}
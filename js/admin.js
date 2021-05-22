window.onload = function() {
    try {
        var events = document.forms.setup.events;
        events.onclick = function() {
            location.href = "events";
        }
    } catch (error) {}

    try {
        var participants = document.forms.setup.participants;
        participants.onclick = function() {
            location.href = "participants";
        }
    } catch (error) {}

    try {
        var statements = document.forms.setup.statements;
        statements.onclick = function() {
            location.href = "statements";
        }
    } catch (error) {}

    try {
        var users = document.forms.setup.users;
        users.onclick = function() {
            location.href = "users";
        }
    } catch (error) {}

    try {
        var users = document.forms.setup.orders;
        users.onclick = function() {
            location.href = "orders";
        }
    } catch (error) {}

    try {
        var change_password = document.forms.setup.change_password;
        change_password.onclick = function() {
            location.href = "?page=" + "change_password";
        }
    } catch (error) {}
}
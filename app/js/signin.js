function signin() {
    username = document.getElementById("username").value;
    password = document.getElementById("password").value;
    var request = "username=" + username + "&password=" + password;
    const xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            var response = JSON.parse(this.responseText);
            if (response.success === true) {
                setTimeout(alert(response.messages.join('\n')), 50);
                window.location.replace("/gallery");
            }
            else {
                alert(response.messages.join('\n'));
            }
        }
    };
    xhr.open("POST", "/signin");
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send(request);
}

function reset() {
    username = document.getElementById("username_for_reset").value;
    var request = "username=" + username;
    document.getElementById("username_for_reset").value = "";
    const xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            var response = JSON.parse(this.responseText);
            alert(response.messages.join('\n'));
        }
    };
    xhr.open("POST", "/reset");
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send(request);
}
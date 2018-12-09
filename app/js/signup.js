function signup() {
    username = document.getElementById("username").value;
    mail = document.getElementById("mail").value;
    password = document.getElementById("password").value;
    confirmation = document.getElementById("confirmation").value;
    var request = "username=" + username + "&mail=" + mail + "&password=" + password + "&confirmation=" + confirmation;
    const xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            var response = JSON.parse(this.responseText);
            if (response.success === true) {
                setTimeout(alert(response.messages.join('\n')), 50);
                window.location.replace("/signin");
            }
            else {
                alert(response.messages.join('\n'));
            }
        }
    };
    xhr.open("POST", "/signup");
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send(request);
}
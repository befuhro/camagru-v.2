var vars = {};
window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function (m, key, value) {
    vars[key] = value;
});
username = vars["username"];
key = vars["key"];
var request = "username=" + username + "&key=" + key;
const xhr = new XMLHttpRequest();
xhr.onreadystatechange = function () {
    if (this.readyState === 4 && this.status === 200) {
        var response = JSON.parse(this.responseText);
        if (response.success === true) {
            setTimeout(alert(response.messages.join('\n')), 50);
            window.location.replace("/signin");
        }
        else {
            setTimeout(alert(response.messages.join('\n')), 50);
            window.location.replace("/signup");
        }
    }
};
xhr.open("POST", "/confirmation");
xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
xhr.send(request);


console.log(vars);
function update(elt) {
    var value = elt.previousSibling.previousSibling.value;
    var key = elt.id;
    var request = key + "=" + value;
    const xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            var response = JSON.parse(this.responseText);
            alert(response.messages.join('\n'));
        }
    };
    xhr.open("POST", "/update");
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send(request);
}
function delete_picture(elt) {
    let path = elt.parentElement.childNodes[1].src;
    let request = "path=" + path;
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            alert(this.responseText);
            elt.parentElement.remove();
        }
    };
    xhr.open("POST", "/delete_picture");
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send(request);
}
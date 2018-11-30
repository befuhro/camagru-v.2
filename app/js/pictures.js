function delete_picture(elt) {
    let path = elt.parentElement.childNodes[1].src;
    let request = "path=" + path;
    let xhr = new XMLHttpRequest();

    xhr.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200){
            alert("Picture has been deleted.");
        }
        else {
            alert("Picture deletion has failed");
        }
    };
    xhr.open("POST", "/delete_picture", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send(request);
    elt.parentElement.remove();
}
function deletePicture(elt) {
    var pictureID = elt.parentNode.parentNode.id;
    var request = "pictureID=" + pictureID;
    const xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            alert(this.responseText);
            console.log(this.responseText);
            elt.parentNode.parentNode.remove();
        }
    };
    xhr.open("POST", "/delete_picture");
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send(request);
}
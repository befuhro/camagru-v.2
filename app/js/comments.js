function post_comment(elt) {
    if (elt.previousSibling.value !== '') {
        var comment = elt.previousSibling.value;
        var pictureID = elt.parentElement.childNodes[1].id;
        var request = "comment=" + comment + "&pictureID=" + pictureID;
        var p = document.createElement("p");
        var div = elt.previousSibling.previousSibling;
        const xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
            if (this.readyState === 4 && this.status === 200) {
                var response = JSON.parse(this.responseText);
                if (response.success === true) {
                    p.innerHTML = "<b>" + response.username + "</b><br>" + comment;
                    div.appendChild(p);
                }
            }
        };
        xhr.open("POST", "/post_comment");
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.send(request);
        elt.previousSibling.value = "";
    }
}
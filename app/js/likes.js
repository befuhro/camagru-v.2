function like_button(elt) {
    if (elt.src.includes("miniature/empty_like.png")) {
        elt.src = "miniature/full_like.png";
    }
    else if (elt.src.includes("miniature/full_like.png")) {
        elt.src = "miniature/empty_like.png";
    }

    str = elt.parentNode.childNodes[1].src;
    request = "str=" + str;
    let xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200){
            alert(this.responseText);
        }
    };
    xhr.open("POST", "handle_like.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send(request);
}
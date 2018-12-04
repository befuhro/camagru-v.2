function like_button(elt) {
    if (elt.src.includes("miniature/empty_like.png")) {
        elt.src = "miniature/full_like.png";
    }
    else if (elt.src.includes("miniature/full_like.png")) {
        elt.src = "miniature/empty_like.png";
    }
    let id = elt.parentNode.childNodes[1].id;
    let request = "id=" + id;
    let xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200){
            alert(this.responseText);
        }
    };
    xhr.open("POST", "/like_button");
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send(request);
}
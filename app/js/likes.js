function like_button(elt) {
    if (elt.src.includes("assets/like_buttons/disliked.png")) {
        elt.src = "/assets/like_buttons/liked.png";
    }
    else if (elt.src.includes("assets/like_buttons/liked.png")) {
        elt.src = "/assets/like_buttons/disliked.png";
    }
    var id = elt.parentNode.childNodes[2].id;
    var request = "id=" + id;
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200){
            alert(this.responseText);
        }
    };
    xhr.open("POST", "/like_button");
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send(request);
}
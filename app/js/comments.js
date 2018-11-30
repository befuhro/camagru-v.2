function post_comment(elt) {
    let comment = elt.parentElement.childNodes[6].value;
    let path = elt.parentElement.childNodes[1].src;
    let request = "comment=" + comment + "&path=" + path;
    let xhr = new XMLHttpRequest();
    let div = elt.parentElement.childNodes[5].firstChild;
    let p = document.createElement("p");
    elt.parentElement.childNodes[6].value = "";
    xhr.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200){
            let username = this.responseText;
            p.innerHTML = "<b>" + username + "</b><br>" + comment;
            div.appendChild(p);
        }
    };
    xhr.open("POST", "../controllers/handle_comment.php");
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send(request);
}

function display_comments(elt) {
    for (i = 0; i < elt.length; i++) {
        let tag = document.createElement("div");
        let path = elt[i].parentNode.childNodes[1].src;
        let xhr = new XMLHttpRequest();
        let request = "path=" + path;
        xhr.onreadystatechange = function () {



            console.log(xhr.responseText);

            if (this.readyState == 4 && this.status == 200) {
                let json = JSON.parse(this.responseText);
                for (j = 0; j < json.length; j += 2) {
                    tag.innerHTML += "<p><b>" + json[j] + "</b><br>" + json[j + 1] + "</p>";
                }
            }
        };
        xhr.open("POST", "../controllers/get_comments.php");
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.send(request);
        elt[i].appendChild(tag);
    }
}

comment_tags = document.getElementsByClassName("comments");
display_comments(comment_tags);
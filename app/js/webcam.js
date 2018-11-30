var video = document.querySelector("#video");
var width, height;
var aside = document.getElementById("aside");
var duplicate = document.getElementById("duplicate");
var mont = document.getElementById("mont");
var index = 0;

if (navigator.mediaDevices.getUserMedia) {
    navigator.mediaDevices.getUserMedia({video: true})
        .then(function (stream) {
            video.srcObject = stream;
            let div = document.getElementById("buttons");
            let tag = document.createElement("button");
            tag.id = "take_pic";
            tag.onclick = take_pic;
            tag.innerText = "take a picture";
            div.appendChild(tag);

        })
        .catch(function (err0r) {
            let file = document.createElement("input");
            let upload = document.createElement("button");
            let div = document.getElementById("buttons");
            let tag = document.createElement("button");
            let background = document.createElement("img");

            background.id = "output";
            background.src = "/miniature/white.png";
            tag.id = "take_pic";
            tag.onclick = take_picture;
            tag.innerText = "take a picture";
            file.setAttribute("type", "file");
            file.setAttribute("accept", "image/*");
            file.id = "uploaded_file";
            upload.onclick = add_pic;
            upload.innerText = "upload file";
            div.appendChild(file);
            div.appendChild(upload);
            div.appendChild(tag);
            document.getElementById("montage").appendChild(background);
        });
}

video.addEventListener("loadedmetadata", function () {
    width = video.videoWidth;
    height = video.videoHeight;
}, false);

function add_icon(e) {
    let canvas = document.getElementById("image");
    let context = canvas.getContext('2d');
    let img = new Image();

    img.id = "selected_icon";
    img.src = e.src;
    canvas.width = 640;
    canvas.height = 480;
    if (img.src.split("/")[img.src.split("/").length - 1] == "thug-life.png")
        context.drawImage(img, 250, 150, img.width, img.height);
    else
        context.drawImage(img, 150, 150, img.width, img.height);
    if (document.getElementById("selected_icon"))
        document.getElementById("selected_icon").remove();
    img.src = canvas.toDataURL("image/png");
    hidden.appendChild(img);
}

function add_pic() {
    let file = document.getElementById("uploaded_file");
    let img = file.files[0];
    let reader = new FileReader();
    let imgtag = document.createElement("img");

    if (img == null) {
        alert("You must upload a picture before making a collage");
        return;
    }
    reader.onload = function(e) {
        imgtag.src = e.target.result;
        let canvas = document.createElement("canvas");
        var context = canvas.getContext("2d");
        context.drawImage(imgtag, 0, 0);
        canvas.width = 640;
        canvas.height = 480;
        var context = canvas.getContext("2d");
        context.drawImage(imgtag, 0, 0, 640, 480);
        let dataurl = canvas.toDataURL("image/png");
        document.getElementById("output").src = dataurl;
    };
    reader.readAsDataURL(img);
}

function take_pic() {
    let canvas = document.createElement("canvas");
    let context = canvas.getContext('2d');
    let cpy = document.getElementById("selected_icon");
    let button = document.createElement("button");
    let div = document.createElement("div");
    let hide = document.createElement("input");
    let img = new Image();
    let icon = new Image();

    hide.setAttribute("type", "hidden");
    if (cpy == null) {
        alert("You must choose a miniature before taking a picture");
        return;
    }
    icon.src = cpy.src;
    div.className = "mini";
    button.innerText = "upload picture";
    button.id = "add_button";
    canvas.width = width;
    canvas.height = height;
    context.fillRect(0, 0, width, height);
    context.drawImage(video, 0, 0, width, height);
    img.src = canvas.toDataURL("image/png");
    context.drawImage(icon, 0, 0, icon.width, icon.height);
    button.onclick = function () {
        let request = "img=" + img.src + "\n&icon=" + icon.src;
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200){
                console.log(this.responseText);
            }
        }
        xhr.open("POST", "../controllers/treat_upload.php", false);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.send(request);
        console.log(xhr.responseText);
    };
    hide.appendChild(img);
    hide.appendChild(icon);
    div.appendChild(canvas);
    div.appendChild(hide);
    div.appendChild(button);
    aside.appendChild(div);
}

function take_picture() {
    let canvas = document.createElement("canvas");
    let context = canvas.getContext('2d');
    let cpy = document.getElementById("selected_icon");
    let button = document.createElement("button");
    let div = document.createElement("div");
    let hide = document.createElement("input");
    let tag_picture = document.getElementById("output");
    let img = new Image();
    let icon = new Image();
    let src = new Image();

    hide.setAttribute("type", "hidden");
    if (cpy == null) {
        alert("You must choose a miniature before taking a picture");
        return;
    }
    src.src = tag_picture.src;
    icon.src = cpy.src;
    div.className = "mini";
    button.innerText = "upload picture";
    button.id = "add_button";
    canvas.width = 640;
    canvas.height = 480;
    context.fillRect(0, 0, 640, 480);
    context.drawImage(src, 0, 0, 640, 480);
    img.src = canvas.toDataURL("image/png");
    context.drawImage(icon, 0, 0, icon.width, icon.height);
    button.onclick = function () {
        let request = "img=" + img.src + "\n&icon=" + icon.src;
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200){
                console.log(this.responseText);
            }
        }
        xhr.open("POST", "../controllers/treat_upload.php", false);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.send(request);
        console.log(xhr.responseText);
    };
    hide.appendChild(img);
    hide.appendChild(icon);
    div.appendChild(canvas);
    div.appendChild(hide);
    div.appendChild(button);
    aside.appendChild(div);
}
document.addEventListener('DOMContentLoaded', function () {
    if (navigator.mediaDevices.getUserMedia) {

        let div = document.getElementById("buttons");
        let tag = document.createElement("button");
        tag.onclick = takePicture;
        tag.innerText = "take a picture";
        navigator.mediaDevices.getUserMedia({video: true})
            .then(function (stream) {
                const video = document.querySelector("video");
                video.srcObject = stream;
                video.id = "output";
                div.appendChild(tag);
            })
            .catch(function () {
                let upload = document.createElement("button");
                let file = document.createElement("input");
                let background = new Image();
                background.id = "output";
                background.src = "/assets/white.png";
                file.setAttribute("type", "file");
                file.setAttribute("accept", "image/*");
                file.id = "uploaded_file";
                upload.onclick = importImage;
                upload.innerText = "upload file";
                div.append(file, upload, tag);
                document.getElementById("montage").appendChild(background);
            });
    }
});

function addIcon(e) {
    let canvas = document.getElementById("image");
    let context = canvas.getContext('2d');
    let img = new Image();

    document.getElementById("hidden").appendChild(img);
    if (document.getElementById("selected_icon")) {
        document.getElementById("selected_icon").remove();
    }
    img.id = "selected_icon";
    img.src = e.src;
    canvas.width = 640;
    canvas.height = 480;
    context.drawImage(e, 150, 150, img.width, img.height);
    img.src = canvas.toDataURL("image/png");
}

const drawImage = (context, image, width, height) => (new Promise(resolve => {
    context.drawImage(image, 0, 0, width, height);
    resolve();
}));

function importImage() {
    let file = document.getElementById("uploaded_file");
    let input = file.files[0];
    let reader = new FileReader();

    if (input == null) {
        alert("You must upload a picture before making a collage");
        return;
    }
    reader.onloadend = function (e) {
        const output = document.getElementById("output");
        let image = new Image();
        let canvas = document.createElement("canvas");
        let context = canvas.getContext("2d");
        image.src = e.target.result;
        canvas.width = 640;
        canvas.height = 480;
        drawImage(context, image, 640, 480).then(() => {
            output.src = canvas.toDataURL("image/png");
        });
    };
    reader.readAsDataURL(input);
}

function takePicture() {
    let div = document.createElement("div");
    var aside = document.getElementById("aside");
    let canvas = document.createElement("canvas");
    let context = canvas.getContext('2d');
    let cpy = document.getElementById("selected_icon");
    let button = document.createElement("button");
    let hide = document.createElement("input");
    let src = document.getElementById("output");
    let img = new Image();
    let icon = new Image();

    if (cpy == null) {
        alert("You must choose a miniatures before taking a picture");
        return;
    }
    aside.append(div);
    div.append(canvas, hide, button);
    hide.append(img, icon);
    hide.setAttribute("type", "hidden");
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
            if (this.readyState === 4 && this.status === 200) {
                alert(this.responseText);
            }
        };
        xhr.open("POST", "/add_picture");
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.send(request);
    };
}
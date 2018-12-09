var page = 0;

appendPage();
window.onscroll = function(ev) {
    if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight + 50) {
        appendPage();
    }
};

function appendPage() {
    const xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            var div = document.createElement("div");
            div.innerHTML = this.responseText;
            document.getElementById("section").appendChild(div);
        }
    };
    xhr.open("GET", "/paginate?page=" + page);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send();
    page++;
}
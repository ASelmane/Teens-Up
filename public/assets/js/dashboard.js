var dislikes = document.querySelectorAll("a.js-dislike");
var likes = document.querySelectorAll("a.js-like");

function next(e) {
    e.preventDefault();
    let type = e.path[1].id;

    var url = this.href;
    console.log(url);
    axios.get(url);
    if (type == "like") {
        e.path[3].children[0].className = "div_totale_like";
    } else if (type == "dislike") {
        e.path[3].children[0].className = "div_totale_dislike";
    }
    setTimeout(function () {
        e.path[4].removeChild(e.path[3]);
    }, 250);
}

likes.forEach((like) => {
    like.addEventListener("click", next);
});

dislikes.forEach((dislike) => {
    dislike.addEventListener("click", next);
});

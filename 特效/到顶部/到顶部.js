window.onscroll = function() {
    var div1 = document.getElementById("div1");
    if (window.addEventListener) {
        if (window.pageYOffset > 200) {
            div1.style.display = "block";
        } else {
            div1.style.display = "none";
        }
    } else {
        if (document.document.pageYOffset > 200) {
            div1.style.display = "block";
        } else {
            div1.style.display = "none";
        }
    }
    div1.onclick = function() {
        window.scrollTo(0, 0);
    }
}
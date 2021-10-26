function Nume() {
    document.getElementById("banner").scrollLeft += 10;
    if (document.getElementById("banner").scrollLeft >= window.innerWidth * 0.15625 * 6.4) {
        document.getElementById("contents").appendChild(document.getElementById("contents").children[0]);
        document.getElementById("banner").scrollLeft = 0;
    } else {
        i = setTimeout("Nume()", 100);
    }

}
j = setInterval("Nume()", 1500);
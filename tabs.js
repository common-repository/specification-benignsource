function openBsjava(evt, spbsName) {

    var i, tabbscontent, tablinks;

    tabbscontent = document.getElementsByClassName("tabbscontent");
    for (i = 0; i < tabbscontent.length; i++) {
        tabbscontent[i].style.display = "none";
    }


    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }

    document.getElementById(spbsName).style.display = "block";
    evt.currentTarget.className += " active";
}
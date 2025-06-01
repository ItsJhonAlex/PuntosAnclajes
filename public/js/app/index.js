document.addEventListener("DOMContentLoaded", function (event) {
    var myAlert = document.getElementById("alert-index");
    if (myAlert != null) {
        myAlert.style.display = "block";
        setTimeout(function () {
            console.log("hola");

            myAlert.style.display = "none";
        }, 10000);
    }
});

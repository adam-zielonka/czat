function Login(form) {
    $.ajax({
        type: "POST",
        url: "/index.php?strona=function.login",
        data: form,
        processData: false,  // tell jQuery not to process the data
        contentType: false,   // tell jQuery not to set contentType
        success: function (msg) {
            $("#komunikat").html(msg);
        },
        error: function () {
            ReadError();
        }
    })
}

function Logout(form) {
    $.ajax({
        type: "POST",
        url: "/index.php?strona=function.logout",
        success: function (msg) {
            $("#komunikat").html(msg);
        },
        error: function () {
            ReadError();
        }
    })
}

$("#zaloguj").click(function () {
     var fd = new FormData(document.querySelector("form[id='logowanie']"));
     $("#komunikat").html("Trwa logowanie...");
     Login(fd);
});


$("#wyloguj").click(function () {
    $("#komunikat").html("Trwa wylogowanie...");
    stopAjax = 1;
    Logout();
});

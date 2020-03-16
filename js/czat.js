var czat;
var user;
var nr = 0;
var time = 0;
var timeUser = 0; //10000;
var stopAjax = 0;

function LoadUser() {
    $.ajax({
        type: "GET",
        url: "/index.php?strona=function.czat-user",
        dataType: 'json',
        success: function (json) {
            user = json;
            ReadUser();
            if (!(stopAjax))
                setTimeout(function () { LoadUser(); }, timeUser);
            
        },
        error: function (xhr) {
            if (!(stopAjax))
                setTimeout(function () { LoadUser(); }, timeUser);            
        }
    })
}

function ReadUser() {
    var i = 1;
    var out = 'Online: ';
    var count = Object.keys(user).length;
    for (i = 0; i < count; i++) {
        out += '';
        out += user[i].user;
        out += ', ';
    }
    $("#online").html(out);
}

function LoadAjax() {
    $.ajax({
        type: "GET",
        url: "/index.php?strona=function.czat-txt&nr=" + nr,
        dataType: 'json',
        success: function (json) {
            czat = json;
            Read();
            if (!(stopAjax))
                setTimeout(function () { LoadAjax(); }, time);
        },
        error: function () {
            if (!(stopAjax))
                setTimeout(function () { LoadAjax(); }, time);
        }
    })
}

function FirstLoadAjax() {
    $.ajax({
        type: "GET",
        url: "/index.php?strona=function.czat-txt&nr=" + nr,
        dataType: 'json',
        success: function (json) {
            czat = json;
            $("#czat").html(' ');
            Read();
            if (!(stopAjax))
                setTimeout(function () { LoadAjax(); }, time);
        },
        error: function () {
            if (!(stopAjax))
                $("#czat").html('Nic nie ma :-) Pisz :-)');
            setTimeout(function () { FirstLoadAjax(); }, time);
        }
    })
}

$(document).ready(function () {
    FirstLoadAjax();
    LoadUser();
});

function Read() {
    var i = 1;
    var out = '';
    var count = Object.keys(czat).length;
    for (i = 0; i < count; i++) {
        out += '<p><span class="time">';
        out += czat[i].time;
        out += '</span><br><span style="font-weight: bold;" class="' + czat[i].user + '">';
        out += czat[i].user;
        out += ':</span> ';
        out += czat[i].msg;
        out += '</p>';
    }
    nr = czat[count - 1].id;
    $("#czat").append(out);
    $('#czat').scrollTop($('#czat')[0].scrollHeight);
}


$("#sendmsg").click(function () {
    $("#sendmsg").prop("disabled", true);
    $("#msg").prop("disabled", true);
    SendMsg();
})


function SendMsg() {
    var msg = $("#msg").val();
    $.ajax({
        type: "POST",
        url: "/index.php?strona=function.czat-send",
        data: {
            msg: msg
        },
        success: function () {
            $("#sendmsg").removeAttr('disabled');
            $("#msg").removeAttr('disabled');
            $("#msg").val('');
        },
        error: function () {
            $("#sendmsg").removeAttr('disabled');
            $("#msg").removeAttr('disabled');
            $("#msg").val('');
        }
    })
}

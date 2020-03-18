var czat;
var nr = 0;
var stopAjax = 0;
var delay = 2000;

function FirstLoadAjax() {
  $.ajax({
    type: "POST",
    url: "/index.php?strona=function.czat",
    dataType: 'json',
    data: {
      nr: nr
    },
    success: function (json) {
      czat = json;
      $("#czat").html(' ');
      Read();
      if (!(stopAjax))
        setTimeout(function() { LoadAjax(); }, delay);
        
    },
    error: function () {
      $("#online").html("Błąd połączenia :-( Sprawdź czy masz internet.");
      $("#sendmsg").prop("disabled", true);
      $("#msg").prop("disabled", true);
      if (!(stopAjax))
        setTimeout(function() { ErrorLoadAjax(); }, delay);
    }
  })
}

function LoadAjax() {
  $.ajax({
    type: "POST",
    url: "/index.php?strona=function.czat",
    dataType: 'json',
    data: {
      nr: nr
    },
    success: function (json) {
      czat = json;
      Read();
      if (!(stopAjax))
        setTimeout(function() { LoadAjax(); }, delay);
    },
    error: function () {
      $("#online").html("Błąd połączenia :-( Sprawdź czy masz internet.");
      $("#sendmsg").prop("disabled", true);
      $("#msg").prop("disabled", true);
      if (!(stopAjax))
        setTimeout(function() { ErrorLoadAjax(); }, delay);
    }
  })
}

function ErrorLoadAjax() {
  $.ajax({
    type: "POST",
    url: "/index.php?strona=function.czat",
    dataType: 'json',
    data: {
      nr: nr
    },
    success: function (json) {
      czat = json;
      Read();
      $("#sendmsg").removeAttr('disabled');
      $("#msg").removeAttr('disabled');
      if (!(stopAjax))
        setTimeout(function() { LoadAjax(); }, delay);
    },
    error: function () {
      if (!(stopAjax))
        setTimeout(function() { ErrorLoadAjax(); }, delay);
    }
  })
}

$(document).ready(function () {
  FirstLoadAjax();
});

function Read() {
  var i = 1;

  var out = 'Online: ';
  var count = Object.keys(czat.users).length;
  for (i = 0; i < count; i++) {
    out += '';
    out += czat.users[i].user;
    out += ', ';
  }
  $("#online").html(out);

  out = '';
  count = Object.keys(czat.msg).length;
  if (count != 0) {
    for (i = 0; i < count; i++) {
      out += '<p><span class="time">';
      out += czat.msg[i].time;
      out += '</span><br><span style="font-weight: bold;" class="' + czat.msg[i].user + '">';
      out += czat.msg[i].user;
      out += ':</span> ';
      out += czat.msg[i].msg;
      out += '</p>';
    }
    nr = czat.msg[count - 1].id;
    $("#czat").append(out);
    $('#czat').scrollTop($('#czat')[0].scrollHeight);
  }
}

//Wysłanie wiadomości
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

var nr = 0;
var stopAjax = 0;
var delay = 2000;

function fetchChat() {
  $.ajax({
    type: "POST",
    url: "/index.php?strona=function.czat",
    dataType: 'json',
    data: {
      nr: nr
    },
    success: function (json) {
      if(nr === 0) $("#czat").html(' ');
      render(json);
      $("#sendmsg").removeAttr('disabled');
      $("#msg").removeAttr('disabled');
      if (!(stopAjax))
        setTimeout(function() { fetchChat(); }, delay);
    },
    error: function () {
      $("#online").html("Błąd połączenia :-( Sprawdź czy masz internet.");
      $("#sendmsg").prop("disabled", true);
      $("#msg").prop("disabled", true);
      if (!(stopAjax))
        setTimeout(function() { fetchChat(); }, delay);
    },
  })
}

$(document).ready(function () {
  fetchChat();
});

function render(czat) {
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
      if(nr < czat.msg[i].id) {
        out += '<p><span class="time">';
        out += czat.msg[i].time;
        out += '</span><br><span style="font-weight: bold;" class="' + czat.msg[i].user + '">';
        out += czat.msg[i].user;
        out += ':</span> ';
        out += czat.msg[i].msg;
        out += '</p>';
      }
    }
    nr = czat.msg[count - 1].id;
    $("#czat").append(out);
    $('#czat').scrollTop($('#czat')[0].scrollHeight);
  }
}

$("#sendmsg").click(function () {
  $("#sendmsg").prop("disabled", true);
  $("#msg").prop("disabled", true);
  SendMsg();
})

function afterSend(json) {
  if(json) render(json);
  $("#sendmsg").removeAttr('disabled');
  $("#msg").removeAttr('disabled');
  $("#msg").val('');
}

function SendMsg() {
  var msg = $("#msg").val();
  if(msg) $.ajax({
    type: "POST",
    url: "/index.php?strona=function.czat",
    dataType: 'json',
    data: {
      msg: msg,
      nr: nr,
    },
    success: afterSend,
    error: afterSend
  })
}

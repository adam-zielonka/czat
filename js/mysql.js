var users;

function LoadAjax(){
        $.ajax({
        type: "POST",
        url: "/index.php?strona=function.dane",
        dataType : 'json',
        success : function(json) {
            users = json;
            Read();
        },
        error: function() {
            ReadError();
        }
    })
}

$(document).ready(function () {
    //users = $('#mysqldane').val();
    LoadAjax();
});

function ReadError()
{
    var out = 'Błąd pobierania danych :-(';
    document.getElementById("dane").innerHTML = out;
}

function Loading()
{
    var out = 'Ładowanie danych...';
    document.getElementById("dane").innerHTML = out;
}

function UploadError()
{
    var out = 'Błąd wysyłania danych :-(';
    document.getElementById("dane").innerHTML = out;
}

function Read()
{
    var i=1;
    var out = '<table class="dane">';
    var count = Object.keys(users).length;
    for(i = 0; i < count; i++) {
	    out += '<tr class="dane"><td class="dane">' + 
	    users[i].id +
        '</td><td class="dane">' +
	    users[i].Name +
        '</td><td class="dane">' +
	    users[i].Imie +
        '</td><td class="dane">' +
        users[i].Nazwisko +
        '</td><td class="dane">' +
        '<img src="' + users[i].Picture + '" alt="' + users[i].Picture + '" height="40" />' +
        '</td><td class="dane">' +
        '<button type="button" onclick="Delete('+users[i].id+')">Kasuj</button>'+
	    '</td></tr>';
    }
    out += '</table>';
    document.getElementById("dane").innerHTML = out;
}

function Delete(id){
    Loading();
    $.ajax({
        type: "GET",
        url: "/index.php?strona=function.send?del=" + id,
        processData: false,  // tell jQuery not to process the data
        contentType: false,   // tell jQuery not to set contentType
        success: function (msg) {
            LoadAjax();
        },
        error: function () {
            UploadError();
        }
    })
}

$("#dodajDoBazy").click(function () {

    if(Sprawdz() == true) {
    Loading();
    var fd = new FormData(document.querySelector("form[id='formDB']"));
    fd.append("CustomField", "This is some extra data");
    $.ajax({
        type: "POST",
        url: "/index.php?strona=function.send",
        data: fd,
        processData: false,  // tell jQuery not to process the data
        contentType: false,   // tell jQuery not to set contentType
        success: function (msg) {
            LoadAjax();
        },
        error: function () {
            UploadError();
        }
    })
    }
})


function Sprawdz()
{
    var name = document.getElementById("name").value;
    var imie = document.getElementById("imie").value;
    var nazwisko = document.getElementById("nazwisko").value;
    var photo = document.getElementById("photo").value;

    var error = false;
	
	var WzorN = /^[A-Za-z]{1,}$/i
	if (!WzorN.test(imie)) {
        error = true;
    }
    if (!WzorN.test(nazwisko)) {
        error = true;
    }
    if (!WzorN.test(name)) {
        error = true;
    }
	if (photo == '') {
        error = true;
	}

    return !error;
}

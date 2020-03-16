function Sprawdz()
{
    var imie = document.getElementById("imie").value;
    var nazwisko = document.getElementById("nazwisko").value;
    var wiek =  document.getElementById("wiek").value;
    var email = document.getElementById("email").value;
    var telefon = document.getElementById("telefon").value;
    var miasto = document.getElementById("miasto").value;

    var error = false;

	if(wiek<18 || wiek>100){
        $("#testwiek").html("X");
        error = true;
	}
    else {
        $("#testwiek").html("V");
    }
    var WzorMaila = /^[0-9a-z_.-]+@[0-9a-z.-]+\.[a-z]{2,3}$/i
    if (!WzorMaila.test(email)) {
        $("#testemail").html("X");
        error = true;
    }
    else {
        $("#testemail").html("V");
    }
	
	var WzorN = /^[A-Za-z]{1,}$/i
	if (!WzorN.test(imie)) {
        $("#testimie").html("X");
        error = true;
    }
    else {
        $("#testimie").html("V");
    }
    if (!WzorN.test(nazwisko)) {
        $("#testnazwisko").html("X");
        error = true;
    }
    else {
        $("#testnazwisko").html("V");
    }
	
	var WzorT = /^[0-9]{9}$/i
	if (!WzorT.test(telefon)) {
	    $("#testtelefon").html("X");
        error = true;
	}
    else {
        $("#testtelefon").html("V");
    }

    var WzorM = /^[A-Ża-ż]{1,}$/i
	if (!WzorM.test(miasto)) {
	    $("#testmiasto").html("X");
        error = true;
	}
    else {
        $("#testmiasto").html("V");
    }

    return !error;
}

function ClearForm(){
    document.getElementById("imie").value = "";
    document.getElementById("nazwisko").value  = "";
    document.getElementById("wiek").value  = "";
    document.getElementById("email").value  = "";
    document.getElementById("telefon").value  = "";
    document.getElementById("miasto").value  = "";

    $("#testimie").html("");
    $("#testnazwisko").html("");
    $("#testwiek").html("");
    $("#testemail").html("");
    $("#testtelefon").html("");
    $("#testmiasto").html("");
}


$("input").keyup(function () {
    Sprawdz();
});

var users;
$(document).ready(function () {
    $.get('/dane/data.json.txt', function (dane) {
        users = JSON.parse(dane);
        Read();
    });
});

function Read()
{
    var i=1;
    var out = '<table class="dane">';
    var count = Object.keys(users.employees.employee).length;	
    for(i = 0; i < count; i++) {
        var html = 'Telefon: ' + users.employees.employee[i].phone +
        '; E-mail: ' + users.employees.employee[i].email +
        '; Wiek: ' + users.employees.employee[i].age;
	    out += '<tr class="dane"><td class="dane">' + 
	    users.employees.employee[i].id +
        '</td><td class="dane">' +
	    users.employees.employee[i].firstName +
        '</td><td class="dane">' +
	    users.employees.employee[i].lastName +
        '</td><td class="dane">' +
        '<input type="button" onclick="alert(\''+
        html +
        '\')" value="Więcej">' +
        '</td><td class="dane">' +
		'<input type="button" onclick="Delete('+users.employees.employee[i].id+')" value="Delete" id="#del">' +
		'</td><td class="dane">' +
		'<input type="button" value="Pogoda" onclick="Pogoda('+"'" + users.employees.employee[i].weather + "'"+')" >' +
	    '</td></tr>';
    }
    out += '</table>';
    document.getElementById("dane").innerHTML = out;
}

function MaxID()
{
    var id = 0;
    var count = Object.keys(users.employees.employee).length;
    for (i = 0; i < count; i++) {
        if (users.employees.employee[i].id > id)
            id = users.employees.employee[i].id;
    }
    return id;
}

function Create()
{
    if(Sprawdz()){
        var id = MaxID();
	    id++;
        users.employees.employee.push({ "id": id, "firstName": document.getElementById("imie").value, "lastName": document.getElementById("nazwisko").value,"age": document.getElementById("wiek").value, "email": document.getElementById("email").value, "phone": document.getElementById("telefon").value, "weather": document.getElementById("miasto").value });
        ClearForm();
        Read();
    }
    else {
        alert("Nie wszystko jest dobrze wypełnione.")
    }

}

function SzukajID(numer)
{
    var id = -1;
    var count = Object.keys(users.employees.employee).length;
    for (i = 0; i < count; i++) {
        if (users.employees.employee[i].id == numer)
            id = i;
    }
    return id;
}

function Delete(id)
{
		var id2 = SzukajID(id);
        users.employees.employee.splice(id2, 1);
        Read();
}

function Pogoda(miasto){
    $(document).ready(function () {
        var link = 'http://api.openweathermap.org/data/2.5/forecast/daily?q=' + miasto + '&mode=xml&units=metric&cnt=7&appid=23766fd4774176927c13f3510b23f1e2';
        $.get(link, function (d) {
            var nazwa = $(d).find('name').text();
            var html = 'Pogoda dla miasta ' + nazwa + '\n';

            $(d).find('time').each(function () {

                var $time = $(this);
                var data = $time.attr("day");
                var temp = $time.find('temperature').attr('day');
                var symbol = $time.find('symbol').attr('name');

                html += '' + data + '\t\t';
                html += '' + temp + '\xB0' + 'C\t\t';
                html += '' + symbol + '';
                html += '\n';

                $('.loadingPic').fadeOut(1400);
            });
            alert(html);
        });
    });
}

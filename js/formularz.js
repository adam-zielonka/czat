var users;
$(document).ready(function () {
    $.get('dane/dane.txt', function (dane) {
        users = JSON.parse(dane);
        Read();
    });
});

function Read()
{
    var i=1;
    var out = '<table class="dane">';
    var count = Object.keys(users.uzytkownicy).length;			
    for(i = 0; i < count; i++) {
	    out += '<tr class="dane"><td class="dane">' + 
	    users.uzytkownicy[i].id +
        '</td><td class="dane">' +
	    users.uzytkownicy[i].imie +
        '</td><td class="dane">' +
	    users.uzytkownicy[i].nazwisko +
        '</td><td class="dane">' +
	    users.uzytkownicy[i].email +
	    '</td></tr>';
    }
    out += '</table>';
    document.getElementById("dane").innerHTML = out;
}

function SzukajID(numer)
{
    var id = -1;
    var count = Object.keys(users.uzytkownicy).length;
    for (i = 0; i < count; i++) {
        if (users.uzytkownicy[i].id == numer)
            id = i;
    }
    return id;
}

function ReadByID()
{
	var id = SzukajID(document.getElementById("idID").value);
    if(id == -1)
    {
        document.getElementById("imie").value = "";
	    document.getElementById("nazwisko").value = "";
        document.getElementById("email").value =  "";
        document.getElementById("error").value =  "Błedne ID";
    }
    else
    {
        document.getElementById("imie").value = users.uzytkownicy[id].imie;
	    document.getElementById("nazwisko").value = users.uzytkownicy[id].nazwisko;
        document.getElementById("email").value = users.uzytkownicy[id].email;
        document.getElementById("error").value =  "";
    }
	
}

function Create()
{
    if (document.getElementById("idID").value == 0 || document.getElementById("imie").value == 0 || document.getElementById("nazwisko").value == 0 || document.getElementById("email").value == 0)
    {
        document.getElementById("error").value = "Uzupełni wszystko!";
    }
    else {
        var id = SzukajID(document.getElementById("idID").value);
        if (id == -1) {
            users.uzytkownicy.push({ "id": document.getElementById("idID").value, "imie": document.getElementById("imie").value, "nazwisko": document.getElementById("nazwisko").value, "email": document.getElementById("email").value });
            document.getElementById("idID").value = "";
            document.getElementById("imie").value = "";
            document.getElementById("nazwisko").value = "";
            document.getElementById("email").value = "";
            document.getElementById("error").value = "Dodano :-)";
        }
        else {
            document.getElementById("error").value = "To ID już istnieje";
        }
    }
    
    Read();
}

function Update()
{
	var id = SzukajID(document.getElementById("idID").value);
    if(id == -1)
    {
        document.getElementById("error").value =  "Błedne ID";
    }
    else
    {
        if(document.getElementById("imie").value != "") users.uzytkownicy[id].imie = document.getElementById("imie").value;
	    if(document.getElementById("nazwisko").value != "") users.uzytkownicy[id].nazwisko = document.getElementById("nazwisko").value;
        if(document.getElementById("email").value != "") users.uzytkownicy[id].email = document.getElementById("email").value;
        document.getElementById("error").value =  "Zaktualizowano";
        document.getElementById("idID").value = "";
        document.getElementById("imie").value = "";
	    document.getElementById("nazwisko").value = "";
        document.getElementById("email").value =  "";
        Read();
    }
	
}

function Delete()
{
    var id = SzukajID(document.getElementById("idID").value);
    if(id == -1)
    {
        document.getElementById("error").value =  "Błedne ID";
    }
    else
    {
        users.uzytkownicy.splice(id, 1);
        document.getElementById("imie").value = "";
	    document.getElementById("nazwisko").value = "";
        document.getElementById("email").value =  "";
        document.getElementById("idID").value = "";
        document.getElementById("error").value =  "Skasowano";
        Read();
    }
}
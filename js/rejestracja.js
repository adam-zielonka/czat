function SprawdzEmail() {
	var email = $("#email").val();

	var WzorMaila = /^[0-9a-z_.-]+@[0-9a-z.-]+\.[a-z]{2,3}$/i
	if (!WzorMaila.test(email)) {
		$("#testemail").html("Wymagane.");
	}
	else {
		$("#testemail").html("Sprawdzanie...");
		CheckEmail(email);
	}
}

function SprawdzLogin() {
	var login = $("#login").val();

	var WzorLogin = /^[A-Ża-ż0-9_.-]{5,}$/i
	if (!WzorLogin.test(login)) {
		$("#testlogin").html("Wymagane, min 5 znaków (A-Ża-ż0-9_.-)");
	}
	else {
		$("#testlogin").html("Sprawdzanie...");
		CheckLogin(login);
	}
}

function SprawdzHaslo() {
	var error = false;
	var haslo = $("#password").val();

	var WzorHaslo = /(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}/
	if (!WzorHaslo.test(haslo)) {
		$("#testpassword").html("Wymagane, min 6 znaków (przynajmniej jedna mała litera, duża litera i cyfra).");
	}
	else {
		$("#testpassword").html("OK");
		error = true;
	}
}

function SprawdzHasla() {
	var error = false;
	var haslo = $("#password").val();
	var haslo2 = $("#passwordrepeat").val();

	if (haslo != haslo2) {
		$("#testpasswordrepeat").html("Wymagane, takie same jak wyżej :-)");
	}
	else {
		$("#testpasswordrepeat").html("OK");
		error = true;
	}
	return error;
}

$("#login").keyup(function () {
	SprawdzLogin();
}).change(function () {
	SprawdzLogin();
}).bind(function () {
	SprawdzLogin();
}).click(function () {
	SprawdzLogin();
});

$("#email").keyup(function () {
	SprawdzEmail();
}).change(function () {
	SprawdzEmail();
}).bind(function () {
	SprawdzEmail();
}).click(function () {
	SprawdzEmail();
});

$("#password").keyup(function () {
	SprawdzHaslo();
	SprawdzHasla();
}).change(function () {
	SprawdzHaslo();
	SprawdzHasla();
}).bind(function () {
	SprawdzHaslo();
	SprawdzHasla();
}).click(function () {
	SprawdzHaslo();
	SprawdzHasla();
});

$("#passwordrepeat").keyup(function () {
	SprawdzHasla();
}).change(function () {
	SprawdzHasla();
}).bind(function () {
	SprawdzHasla();
}).click(function () {
	SprawdzHasla();
});

ajaxElement = 0;
ajaxSpr = 0;
$("#send").click(function () {

	SprawdzEmail();
	SprawdzHasla();
	SprawdzHaslo();
	SprawdzLogin();
	ajaxSpr = 1;
	$(document).ajaxStop(function () {
		if (ajaxElement == 0 && ajaxSpr == 1) {
			ajaxSpr = 0;
			if (
			($("#testemail").html() == "OK") &&
			($("#testpassword").html() == "OK") &&
			($("#testpasswordrepeat").html() == "OK") &&
			($("#testlogin").html() == "OK")) {
				var fd = new FormData(document.querySelector("form[id='rejestracja']"));
				$("#formularz").html("Trwa rejestrowanie...");
				Rejestruj(fd);
			}
		}
	});
})

function CheckEmail(email) {
	ajaxElement++;
	$.ajax({
		type: "POST",
		url: "/index.php?strona=function.createuser",
		data: {
			checkemail: email
		},
		success: function (msg) {
			ajaxElement--;
			if (msg == 0) {
				$("#testemail").html("OK");
			}
			else
				$("#testemail").html("E-mail już istnieje :-(");
		},
		error: function () {
			ReadError();
		}
	})
}

function CheckLogin(login) {
	ajaxElement++;
	$.ajax({
		type: "POST",
		url: "/index.php?strona=function.createuser",
		data: {
			checklogin: login
		},
		success: function (msg) {
			ajaxElement--;
			if (msg == 0) {
				$("#testlogin").html("OK");
			}
			else
				$("#testlogin").html("Login już istnieje :-(");
		},
		error: function () {
			ReadError();
		}
	})
}

function CheckPhoto(photo) {
	ajaxElement++;
	$.ajax({
		type: "POST",
		url: "/index.php?strona=function.createuser&checkphoto=1",
		data: photo,
		processData: false,  // tell jQuery not to process the data
		contentType: false,   // tell jQuery not to set contentType
		success: function (msg) {
			ajaxElement--;
			if (msg == '') {
				$("#testphoto").html("OK");
			}
			else
				$("#testphoto").html(msg);
		},
		error: function () {
			ReadError();
		}
	})
}

function Rejestruj(form) {
	$.ajax({
		type: "POST",
		url: "/index.php?strona=function.createuser&rejestruj=1",
		data: form,
		processData: false,  // tell jQuery not to process the data
		contentType: false,   // tell jQuery not to set contentType
		success: function (msg) {
			$("#formularz").html(msg);
		},
		error: function () {
			ReadError();
		}
	})
}

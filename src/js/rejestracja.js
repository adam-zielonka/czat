function isEmailOK() {
  const email = $$("email").value
  const regex = /^[0-9a-z_.-]+@[0-9a-z.-]+\.[a-z]{2,}$/i

  if (!regex.test(email)) {
    $$('testemail').innerHTML = "Wymagane."
  }
  else {
    $$('testemail').innerHTML = "Sprawdzanie..."
    fetchCheck('checkemail', email, msg => {
      if (msg == 0) {
        $$('testemail').innerHTML = "OK"
      }
      else
        $$('testemail').innerHTML = "E-mail już istnieje :-("
    })
  }
}

function isUserNameOK() {
  const login = $$("login").value
  const regex = /^[A-Ża-ż0-9_.-]{3,}$/i

  if (!regex.test(login)) {
    $$("testlogin").innerHTML = "Wymagane, min 3 znaków (A-Ża-ż0-9_.-)"
  }
  else {
    $$("testlogin").innerHTML = "Sprawdzanie..."
    fetchCheck('checklogin', login, msg => {
      if (msg == 0)
        $$("testlogin").innerHTML = "OK"
      else
        $$("testlogin").innerHTML = "Login już istnieje :-("
    })
  }
}

function isPasswordOK() {
  const password = $$("password").value
  const regex = /.{3,}/

  if (!regex.test(password)) {
    $$("testpassword").innerHTML = "Wymagane, min 3 znaków"
  }
  else {
    $$("testpassword").innerHTML = "OK"
  }
}

function isPasswordsMatch() {
  const pass1 = $$("password").value
  const pass2 = $$("passwordrepeat").value

  if (pass1 != pass2)
    $$("testpasswordrepeat").innerHTML = "Wymagane, takie same jak wyżej :-)"
  else
    $$("testpasswordrepeat").innerHTML = "OK"
}

$$('login').on('input', () => isUserNameOK())
$$('email').on('input', () => isEmailOK())
$$('password').on('input', () => { isPasswordOK(); isPasswordsMatch() })
$$('passwordrepeat').on('input', () => isPasswordsMatch())

ajaxElement = 0
ajaxSpr = 0

function lastCheck() {
  if(ajaxElement) setTimeout(lastCheck)
  else {
    if (ajaxElement == 0 && ajaxSpr == 1) {
      ajaxSpr = 0;
      if (
      ($$('testemail').innerHTML === 'OK') &&
      ($$('testpassword').innerHTML === 'OK') &&
      ($$('testpasswordrepeat').innerHTML === 'OK') &&
      ($$('testlogin').innerHTML === 'OK')) {
        var fd = new FormData(document.querySelector("form[id='rejestracja']"));
        $$('formularz').innerHTML = "Trwa rejestrowanie..."
        createUser(fd);
      }
    }
  }
}

$$('send').on('click', () => {
  isEmailOK()
  isPasswordsMatch()
  isPasswordOK()
  isUserNameOK()
  ajaxSpr = 1
  setTimeout(lastCheck)
})

function fetchCheck(key, value, callback) {
  ajaxElement++
  fetch("/index.php?strona=function.user", { 
    body: new URLSearchParams([[key, value]]),
    method: 'POST' 
  })
  .then(response => response.text())
  .then(v => { 
    ajaxElement--
    callback(v)
  })
}

function createUser(form) {
  fetch("/index.php?strona=function.user&rejestruj=1", { 
    body: new URLSearchParams(form),
    method: 'POST' 
  })
  .then(response => response.text())
  .then(msg => $$('formularz').innerHTML = msg)
}

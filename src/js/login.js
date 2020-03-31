function login(form) {
  fetch("/index.php?strona=function.login", { 
    body: new URLSearchParams(form),
    method: 'POST' 
  })
  .then(response => {
    if(response.status === 200) location.reload()
    return response.text()
  })
  .then(msg => $$('komunikat').innerHTML = msg)
}

function logout() {
  fetch("/index.php?strona=function.logout", {
    method: 'POST' 
  })
  .then(response => {
    if(response.status === 200) location.reload()
    return response.text()
  })
  .then(msg => $$('komunikat').innerHTML = msg)
}

$$('zaloguj') && $$('zaloguj').on('click', () => {
  $$("komunikat").innerHTML = "Trwa logowanie..."
  login(new FormData(document.querySelector("form[id='logowanie']")))
})

$$('wyloguj') && $$('wyloguj').on('click', () => {
  $$("komunikat").innerHTML = "Trwa wylogowanie..."
  stopAjax = 1
  logout()
})

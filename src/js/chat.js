let nr = 0
let stopAjax = 0
let delay = 2000

function disableForm() {
  $$('sendmsg').disable()
  $$('msg').disable()
}

function enableForm() {
  $$('sendmsg').enable()
  $$('msg').enable()
}

function fetchChat() {
  fetch('/index.php?strona=function.czat', { 
    body: new URLSearchParams([['nr', nr]]),
    method: 'POST' 
  })
  .then((response) => response.json())
  .then((json) => {
    if (nr === 0) $$('czat').innerHTML = ''

    render(json)
    enableForm()

    if (!stopAjax) setTimeout(fetchChat, delay)
  })
  .catch((error) => {
    console.log(error)

    $$('online').innerHTML = 'Błąd połączenia :-( Sprawdź czy masz internet.'
    disableForm()

    if (!stopAjax) setTimeout(fetchChat, delay)
  })
}

(function () {
  fetchChat()
})()


function render(czat) {
  $$('online').innerHTML = 'Online: ' + czat.users.map(u => u.user).join(', ')

  czat.msg.filter((msg) => nr < msg.id)
  .map(({time, user, msg, id}) => {
    nr = id
    const p = document.createElement('p')
    p.innerHTML = `
      <span class="time">${time}</span><br/>
      <span style="font-weight: bold;" class="${user}">${user}:</span>
      ${msg}
    `
    return p
  }).forEach(out => {
    $$('czat').append(out)
    $$('czat').scrollTop = $$('czat').scrollHeight
  })
}

$$('sendmsg').on('click', () => {
  if($$('msg').value) {
    disableForm()
    sendMsg()
  }
})

function afterSend(json) {
  if(json) render(json)
  enableForm()
  $$('msg').value = ''
}

function sendMsg() {
  fetch("/index.php?strona=function.czat", { 
    body: new URLSearchParams([['nr', nr], ['msg', $$('msg').value]]),
    method: 'POST' 
  })
  .then((response) => response.json())
  .then(afterSend)
  .catch(() => afterSend())
}

window.$$ = document.getElementById.bind(document)

Node.prototype.on = window.on = function (name, fn) {
  this.addEventListener(name, fn)
}

Node.prototype.disable = window.disable = function (name, fn) {
  this.setAttribute('disabled', true)
}

Node.prototype.enable = window.enable = function (name, fn) {
  this.removeAttribute('disabled')
}

function chatFetch(url, options = {}) {
  const headers = new Headers(options.headers)
  headers.set('X-CSRF-Token', document.querySelector('meta[name="csrf-token"]').content)
  return fetch(url, { ...options, headers })
}

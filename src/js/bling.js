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

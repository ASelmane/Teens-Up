var modal = document.getElementById("myModal");

var btn = document.getElementById("myBtn");

var span = document.getElementsByClassName("close")[0];

btn.onclick = function() {
console.log('oui')
    modal.classList.toggle("active")
}

span.onclick = function() {
    modal.classList.toggle("active")
}

window.onclick = function(event) {
  if (event.target == modal) {
    modal.classList.toggle("active")
  }
}
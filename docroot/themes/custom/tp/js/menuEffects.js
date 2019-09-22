window.onscroll = function () {
  changeMenuColor();
};

function changeMenuColor() {
  var navbar = document.getElementById('navbar');

  if (!navbar) return null;

  if (document.body.scrollTop > 100 || document.documentElement.scrollTop > 100 || document.body.offsetTop > 100) {
    navbar.classList.add('opaque');
  } else {
    navbar.classList.remove('opaque');
  }
}

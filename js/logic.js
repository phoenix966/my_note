
let hamburger = document.querySelector(".hamburger");
let overlay = document.querySelector('.blog__overlay');
let sidebar = document.querySelector('.blog__sidebar');
hamburger.addEventListener("click", function () {
  hamburger.classList.toggle("is-active");
  overlay.classList.toggle('blog__overlay--active');
  sidebar.classList.toggle('blog__sidebar--active');
});


let scroll = document.querySelector('.header__scroll');
let header = document.querySelector('.header');
let isOpen = false;
scroll.addEventListener('click', function () {
  isOpen ? scroll.innerText = 'закрыть' : scroll.innerText = 'открыть';
  isOpen ? isOpen = false : isOpen = true;
  header.classList.toggle('header--hide');
});


overlay.addEventListener('click', function () {
  hamburger.classList.remove("is-active");
  overlay.classList.remove('blog__overlay--active');
  sidebar.classList.remove('blog__sidebar--active');
});


let modalOverlay = document.querySelector('.modal__overlay');
let topBtn = document.querySelector('.header__btn--round');
let modalPanel = document.querySelector('.modal__window');
topBtn.addEventListener('click', function (e) {
  e.preventDefault();
  modalOverlay.classList.toggle('modal__overlay--active');
  modalPanel.classList.toggle('modal__window--active');
});
modalOverlay.addEventListener('click', function () {
  modalOverlay.classList.remove('modal__overlay--active');
  modalPanel.classList.remove('modal__window--active');
});



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

let catRemover = document.querySelectorAll('.blog__del');
catRemover.forEach(function (item) {
    item.addEventListener('click', function (e) {
        e.preventDefault();
        let value = e.currentTarget.value;
        $.ajax({
            url: '/my_note/pages/categorie-remover.php',
            type: 'GET',
            data: {
                id: `${value}`,
            }, success: () => {
                window.location.href = "/my_note/index.php";
            }
        });
    })
});
let catSearch = document.querySelector('.blog__search_btn');
if (catSearch) {
    catSearch.addEventListener('click', function (e) {
        e.preventDefault();
        let value = this.value;
        $.ajax({
            url: '/my_note/pages/sort-cat.php',
            type: 'GET',
            data: {
                'tempId': `${value}`
            }, success: function (data) {
                window.location.href = "/my_note/pages/sort.php";
            }
        })

    })
}

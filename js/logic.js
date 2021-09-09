
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

// Удаление категорий

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

// Удаление постов

const removeBtn = document.querySelectorAll('.blog__btn--delete');
    removeBtn.forEach((removeBtn) => {
        removeBtn.addEventListener('click', function () {
            let value = this.value;
            // console.log(value);
            $.ajax({
                url: '/my_note/pages/delete.php',
                type: 'GET',
                data: {
                    'removeKey': value
                },
                success: function (data) {
                    window.location.href = "/my_note/index.php";

                }
            });

        })
    });



//Живой поиск категорий

let blogCatForm = document.querySelector('.blog__search');
    let blogCats = document.querySelectorAll('.blog__cat');
    let blogItems = document.querySelectorAll('.blog__item');

    blogCatForm.addEventListener('input',function(e){
        e.preventDefault();
        let value = blogCatForm.elements.catSearch.value;

        for(let i=0;i < blogItems.length;i++){
            let item = blogItems[i];
            let cat = blogCats[i];
            if(value){
              if(cat.innerText.includes(value)){
                item.classList.remove('blog__cat--hide');
            } else{
                item.classList.add('blog__cat--hide');
             }
            }else{
              item.classList.remove('blog__cat--hide');
            }
        }
            

    })
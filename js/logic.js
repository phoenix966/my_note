
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

// Переход на создание новой страницы

let btn = document.querySelector('.header__btn--new');
    if(btn){
      btn.addEventListener('click', function (e) {
        e.preventDefault();
        window.location.href = "./pages/post-editor.php?type=new";
    })  
    }

// Общий поиск записей

 let defaultSearchResult = [];

  $.ajax({
    url:'/my_note/pages/default_search_api.php',
    type: 'GET',
    data:{
      isTrue: true
    },success: (data)=>{
      let result = JSON.parse(data);
      result ? defaultSearchResult = result : defaultSearchResult[0] = 'Ничего нет';
    }
  })


let defaultSearchInput = document.querySelector('.header__input');
let defaultSearch = document.querySelector('.header__searchbar');
let defaultSearchForm = document.querySelector('.header__form');
let defaultSearchBar = document.querySelector('.header__searchbar-list'); 

defaultSearchForm.addEventListener('input',function(e){
    let value = e.target.value;
    // var reg = new RegExp(valueTemp, "i");
    // value = reg(valueTemp);
    // console.log(value)

    let createElement = (item)=>{
        let element = document.createElement('li');
        element.classList.add('header__searchbar-item');
        element.innerHTML = `<a href="/my_note/pages/post-editor.php?type=read&id=${item.id}" class="header__searchbar-link">${item.title}</a>`;
        return element;
    }

    defaultSearchBar.innerHTML = '';
    defaultSearchResult.forEach((item)=>{
        if(item.title.includes(value) && value){
                defaultSearchBar.append(createElement(item));
            }
    })
    if(value) {
        defaultSearch.classList.add('header__searchbar--active');
    }else{
        defaultSearch.classList.remove('header__searchbar--active');
    }
})


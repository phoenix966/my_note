<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Post</title>
  <link rel="stylesheet" href="../css/style.css">
</head>

<body>
  <div class="wrapper">
    <header class="header">
      <div class="container header__container">
        <div class="header__wrapper">
          <div class="header__burger">
            <button class="hamburger hamburger--emphatic" type="button">
              <span class="hamburger-box">
                <span class="hamburger-inner"></span>
              </span>
            </button>
          </div>
          <div class="header__logo">
            <a href="../index.php"><img src="../img/logo.png" alt="logo" class="header__img"></a>
          </div>
          <form>
        </div>
        <div class="header__wrap">
          <input type="text" class="header__input" placeholder="Найти запись...">
          <button class="header__btn">Поиск</button>
        </div>
        <button class="header__btn header__btn--round header__btn--action">Создать+</button>
        </form>
      </div>
      <div class="container">
        <button class="header__scroll">закрыть</button>
      </div>
      <div class="modal">
        <div class="modal__overlay"></div>
        <form>
          <div class="modal__window">
            <div class="modal__wrapper">
              <p class="modal__title">Название: </p>
              <input type="text" class="modal__input modal__name" id="title">
            </div>
            <div class="modal__wrapper">
              <p class="modal__title">Категория: </p>
              <input type="text" class="modal__input modal__cat" id="cat">
            </div>
            <!-- <div class="modal__wrapper">
              <p class="modal__title">Содержимое: </p>
              <textarea name="area" class="modal__area"></textarea>
            </div> -->
            <button class="modal__btn">Добавить</button>
          </form>
          </div>
      </div>
    </header>
    <section class="post">
      <div class="container post__container">
        <!-- <div class="post__wrapper">
          <form class="post__form">
            <div class="post__row">
              <input type="text" class="post__input" placeholder="Напишите название записи">
            </div>
            <div class="post__row">
              <input type="text" class="post__cat" placeholder="Напишите название категории">
            </div>
            </form>
          </div> -->
        <!-- <h1 class="post__title">Название записи</h1> -->
        <!-- <button  class="post__btn" onclick="addNewFile ()">Добавить</button> -->
        <div class="post__editor" style="height: 70vh" id="editor">
          
        </div>
        <div class="post__test"></div>
      </div>
      <div class="blog__overlay"></div>
      <div class="blog__sidebar post__sidebar">
        <ul class="blog__note">
          <li class="blog__item">Loren</li>
          <li class="blog__item">Loren</li>
          <li class="blog__item">Loren</li>
        </ul>
      </div>
    </section>
    <footer class="footer">
      <p class="footer__text">All rights reserved by Phoenix</p>
    </footer>
  </div>


  <script src="../js/jquery.min.js"></script>
  <script src="../js/logic.js"></script>
  <script src="../js/quill.js"></script>

  <script>

    let toolbarOptions = [
      [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
      [{ 'font': [] }],
      ['bold', 'italic', 'underline', 'strike'],        // toggled buttons
      ['blockquote', 'code-block'],
      ['link', 'image'],
      [{ 'list': 'ordered' }, { 'list': 'bullet' }],
      // [{ 'script': 'sub' }, { 'script': 'super' }],      // superscript/subscript
      [{ 'indent': '-1' }, { 'indent': '+1' }],          // outdent/indent
      [{ 'direction': 'rtl' }],                         // text direction

      [{ 'color': [] }, { 'background': [] }],          // dropdown with defaults from theme
      [{ 'align': [] }],

      ['clean']                                         // remove formatting button
    ];

    let quill = new Quill('#editor', {
      modules: {
        toolbar: toolbarOptions
      },
      placeholder: 'Начните что-нибудь писать ...',
      theme: 'snow'
    });
  </script>

 <script>
 //рабочий скрипт
let addBtn = document.querySelector('.modal__btn');
addBtn.addEventListener('click',function(e){
  e.preventDefault();
    let text =  quill.root.innerHTML;
    let title = document.querySelector('.modal__name').value;
    let cat = document.querySelector('.modal__cat').value;
    let obj = {
      'title': `${title}`,
      'text': `${text}`,
      'cat_id': `${cat}`
    }
    $.ajax({
      url:'foo.php',
      type: "POST",
      data: obj,
      success: function(data)
        {
           alert(`Готово` );
          window.location.href = "../index.php";
        }
});
})
 </script>
<script>
  let modalOverlay = document.querySelector('.modal__overlay');
  let topBtn = document.querySelector('.header__btn--action');
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
</script>

</body>

</html>

<!-- // let edit = document.querySelector('.ql-editor');
    // function logHtmlContent() {
    //   let text = '';
    //   // var delta = quill.getContents();
    //   // text = quill.root.innerHTML;
    //   text = edit.innerHTML
    //   edit.innerHTML = text
    //   alert(edit.innerHTML)
    //   // let str = text.toString()
    //   // console.log(text);
    //   // quill.root.innerHTML = str
    //   // test.innerHTML = text 
    // }; -->
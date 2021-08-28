<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit post</title>
  <link rel="stylesheet" href="../css/style.css">
</head>

<body>
  <?php
    $connection = mysqli_connect('localhost:8889','root','root','note_db');

    if($connection == false){
      echo 'не удалось подключится к базе данных!<br>';
      echo mysqli_connect_error();
      exit();
    }
  ?>
   <?php
      $result = mysqli_query($connection,"SELECT `id` FROM `temp_id`");
      $temp_id = mysqli_fetch_assoc($result);
      $value = $temp_id['id'];
      $res = mysqli_query($connection,"SELECT * FROM `articles` WHERE  `id` = '$value' ");
      $info = mysqli_fetch_assoc($res);
      // print_r($info);
    ?>
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
        <button class="header__btn header__btn--round header__btn--action">Изменить+</button>
        </form>
      </div>
      <div class="container">
        <button class="header__scroll">закрыть</button>
      </div>
      <div class="modal">
        <div class="modal__overlay"></div>
        <form class="modal__form">
          <div class="modal__window">
            <div class="modal__wrapper">
              <p class="modal__title">Название: </p>
              <input type="text" class="modal__input modal__name" name="title" value="<?php echo $info['title']; ?>">
            </div>
            <div class="modal__wrapper">
              <p class="modal__title">Категория: </p>
              <div class="modal__row">
                <select name="catSelect" class="modal__select">
                <?php
                    $temp_cat = mysqli_query($connection," SELECT * FROM `articles_categories` ");
                    // $cat = mysqli_fetch_assoc($temp_cat);
                    // print_r($cat);
                    $selected_cat_id = $info['categorie_id'];
                    while(($cat = mysqli_fetch_assoc($temp_cat)) ){
                      if($cat['id'] == $selected_cat_id){
                        echo '<option selected="true" value="'. $cat['id'] .'">' . $cat['categorie_title'] . '</option>';
                        continue;
                      }
                        echo '<option value="'. $cat['id'] .'">' . $cat['categorie_title'] . '</option>';
                    }
                  ?>
              </select>
              <button class="modal__btn modal__btn--show">+</button>
                <div class="modal__bar">
                  <input type="text" class="modal__new-category" name="newCat" placeholder="Новая категория...">
                </div>
              </div>
              
            </div>
            <button value="<?php echo $value; ?>" type="submit" class="modal__btn modal__btn--add">Изменить</button>
          </form>
          </div>
      </div>
    </header>
    <section class="post">
      <div class="container post__container">
        <h1 class="post__title"> <?php echo $info['title']; ?> </h1>
        
        <!-- <p class="post__title"><?php echo $info['categorie_id'] ?></p> -->

        <button class="post__btn post__btn--redact">Включен режим редактирования<div class="post__btn-dot post__btn-dot--unlock"></div></button>

        <div class="post__editor" style="height: 70vh" id="editor">
          <?php echo $info['text']; ?>
        </div>
        <div class="post__test"></div>
      </div>
      <div class="blog__overlay"></div>
      <!-- <div class="blog__sidebar post__sidebar">
        <ul class="blog__note">
          <li class="blog__item">Loren</li>
          <li class="blog__item">Loren</li>
          <li class="blog__item">Loren</li>
        </ul>
      </div> -->
      <div class="blog__sidebar blog__sidebar--mix">
        <form>
          <div class="blog__row">
            <input class="blog__input" type="text" >
            <button class="blog__btn">Поиск</button>
          </div>
        </form>
      <?php
            $result = mysqli_query($connection, "SELECT * FROM `articles_categories` " );
            if( mysqli_num_rows($result) == 0){
              echo 'Категорий не найдено!';
            } else{
            ?>
              <ul class="blog__note">
                <?php
                  while(($cat = mysqli_fetch_assoc($result)) ){
                    // print_r ($cat);
                    $articles_count = mysqli_query($connection, "SELECT COUNT(`id`) AS `total_count` FROM `articles`
                    WHERE `categorie_id` = " . $cat['id']);
                    $articles_count_result = mysqli_fetch_assoc($articles_count);
                    echo '<li class="blog__item">'.
                          '<span class="blog__cat" id="'. $cat['id'] .'">'
                             . $cat['categorie_title'] . '[' . $articles_count_result['total_count'] .']'.
                          '</span>' .
                          '<div class="blog__id"> </div>' . 
                        '</li>';
                  }
                }
                mysqli_close($connection);
                  ?>
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
    let isTrue = false;
    let toolbarOptions = [
      [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
      // [{ 'font': [] }],
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
      theme: 'snow',
      readOnly: false,
    });


  </script>
  <script>
    let showNewCat = document.querySelector('.modal__btn--show');
    let bar = document.querySelector('.modal__bar');
    let select = document.querySelector('.modal__select');
    let isNewCatActive = false;
    showNewCat.addEventListener('click',(e)=>{
      e.preventDefault();
      bar.classList.toggle('modal__bar--active');
      isNewCatActive ? isNewCatActive = false : isNewCatActive = true;
      isNewCatActive ? select.disabled = true : select.disabled = false;
    });

  </script>
  <script>  
  let addBtn = document.querySelector('.modal__btn--add');
  document.querySelector('.modal__form').addEventListener('submit',(e)=>{
    e.preventDefault();
    const form = document.querySelector('.modal__form');
    let textTemp = quill.root.innerHTML;
    let textArray = textTemp.split('');
    let text = '';
    for(let value of textArray){
      if(value == "'"){
        value = '"';
        text += value;
      } else{
        text += value;
      }
    }
    let value = addBtn.value;
    let obj = {
      updateKey: value,
      'title': `${form.elements.title.value}`,
      'text': `${text}`,
    }
    if(!isNewCatActive){
      obj.cat_id = `${form.elements.catSelect.value}`;
    }else{
      obj.new_cat = `${form.elements.newCat.value}`;
    }
    
    console.log(obj);
    $.ajax({
      url:'update.php',
      type: "POST",
      data: obj,
      success: function(data)
        {
           alert(`Готово` );
          window.location.href = "../index.php";
        }
});
  });

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
<script>
  
  let redactBtn = document.querySelector('.post__btn--redact');
  redactBtn.addEventListener('click',function(){
    window.location.href = "./post-read.php";
  });

</script>
<script>
  let buttonsCatSort = document.querySelectorAll('.blog__cat');
  let blog_ids = document.querySelectorAll('.blog__id');
  buttonsCatSort.forEach((cat)=>{
    cat.addEventListener('click',function(e){
      let tempId = this.id;
      $.ajax({
        url:'./sort-cat.php',
        type:'GET',
        data:{
          'tempId':`${tempId}`
        },success: function(data){
          window.location.href = "./sort.php";
        }
      });

    })
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
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Read post</title>
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
        <button class="header__btn header__btn--round header__btn--action" disabled>Изменить+</button>
        </form>
      </div>
      <div class="container">
        <button class="header__scroll">закрыть</button>
      </div>
    </header>
    <section class="post">
      <div class="container post__container">
          <?php
            $result = mysqli_query($connection,"SELECT `id` FROM `temp_id`");
            $temp_id = mysqli_fetch_assoc($result);
            $value = $temp_id['id'];
            $res = mysqli_query($connection,"SELECT * FROM `articles` WHERE  `id` = '$value' ");
            $info = mysqli_fetch_assoc($res);
          ?>
        <h1 class="post__title"> <?php echo $info['title']; ?> </h1>

        <button class="post__btn post__btn--redact post__btn--down">Включен режим чтения<div class="post__btn-dot"></div></button>

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
      <div class="blog__sidebar">
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
    let toolbarOptions = [];
    let quill = new Quill('#editor', {
      modules: {
        toolbar: toolbarOptions
      },
      placeholder: 'Начните что-нибудь писать ...',
      theme: 'snow',
      readOnly: true,
    });
  </script>

 <script>
  let redactBtn = document.querySelector('.post__btn--redact');
  redactBtn.addEventListener('click',function(){
    window.location.href = "./post-editor.php";
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
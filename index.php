<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Main</title>
  <link rel="stylesheet" href="css/style.css">
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
            <a href="./index.php"><img src="./img/logo.png" alt="logo" class="header__img"></a>
          </div>
          <form>
        </div>
        <div class="header__wrap">
          <input type="text" class="header__input" placeholder="Найти запись...">
          <button class="header__btn">Поиск</button>
        </div>
        <button class="header__btn  header__btn--round header__btn--new">Новая+</button>
        </form>
      </div>
      <div class="container">
        <button class="header__scroll">закрыть</button>
      </div>

    </header>
    <section class="blog">
      <div class="blog__posts">
        <div class="container blog__container">

          <ul class="blog__list">
            <li class="blog__post">
              <div class="blog__head">
                <div class="blog__pin">id</div>
                <a class="blog__link" href="./pages/post-redact.php"><h2 class="blog__category">Переход</h2></a>
              </div>
              <div class="blog__info">
                <div class="blog__sticky"></div>
                <p class="blog__text">
                  Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptates quidem deleniti dicta vel, animi
                  suscipit id omnis hic ullam similique reprehenderit recusandae itaque? Nihil adipisci, iusto
                  consequuntur accusantium expedita tempore placeat molestias reprehenderit eum quis facilis odit
                  similique animi omnis. Eveniet quas, commodi quisquam placeat necessitatibus itaque suscipit ipsum
                  expedita impedit laboriosam, iusto accusamus? Autem, ipsum explicabo numquam ut aperiam nam a culpa,
                  error reprehenderit quo hic. Molestias, molestiae nisi nihil commodi enim porro quo deleniti harum?
                  Reiciendis suscipit rem nostrum in sed tempore quia dolore voluptate atque voluptatibus? Tempora
                  asperiores aliquam quae sunt dicta aliquid voluptates nam nesciunt architecto.
                </p>
              </div>
              <div class="blog__wrap">
                <button class="blog__btn">Del</button>
                <button class="blog__btn">Red</button>
              </div>
            </li>
           
          </ul>
        </div>
      </div>
      <div class="blog__overlay"></div>
      <div class="blog__sidebar">
      <?php
            $result = mysqli_query($connection, "SELECT * FROM `articles_categories` " );
            if( mysqli_num_rows($result) == 0){
              echo 'Категорий не найдено!';
            } else{
            ?>
              <ul class="blog__note">
                <?php
                  while(($cat = mysqli_fetch_assoc($result)) ){
                    $articles_count = mysqli_query($connection, "SELECT COUNT(`id`) AS `total_count` FROM `articles`
                    WHERE `categorie_id` = " . $cat['id']);
                    $articles_count_result = mysqli_fetch_assoc($articles_count);
                    echo '<li class="blog__item">' . $cat['categorie_title'] . '(' . $articles_count_result['total_count'] .')</li>';
                  }
                }
                mysqli_close($connection);
                  ?>
                </ul>
        <!-- <ul class="blog__note">
          <li class="blog__item">Loren</li>
          <li class="blog__item">Loren</li>
          <li class="blog__item">Loren</li>
        </ul> -->
      </div>
    </section>
    <footer class="footer">
      <p class="footer__text">All rights reserved by Phoenix</p>
    </footer>
  </div>

<script src="./js/logic.js"></script>
<script>
  let btn = document.querySelector('.header__btn--new');
  btn.addEventListener('click',function(e){
    e.preventDefault();
    window.location.href = "./pages/post-new.php";
  })
</script>
</body>
</html>
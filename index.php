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
        <?php
          $articles = mysqli_query($connection, "SELECT * FROM `articles`" );
          if( mysqli_num_rows($articles) == 0){
            echo 'Записей не найдено!';
          } else{
              while($item = mysqli_fetch_assoc($articles)){
                echo '<li class="blog__post">'.'<div class="blog__head"><div class="blog__pin">' . '</div>' 
                      . '<h2 class="blog__category">' . $item['title'] . '</h2>
                      </div><div class="blog__info"><div class="blog__sticky">' . '</div><div class="blog__text">' . $item['text'] . '</div></div>' .
                      '<div class="blog__wrap"><button class="blog__btn blog__btn--delete" value="'. $item['id'] .'" >Delete</button><button value="'. $item['id'] .'" class="blog__btn blog__btn--redact">Open</button></div></li>';
              }
          }
          ?>
        </ul>
          <!-- <ul class="blog__list">
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
            </li> -->
           
          </ul>
        </div>
      </div>
      <div class="blog__overlay"></div>
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
                          '<button value="'. $cat['id'] .'" class="blog__del">[X]</button>' . 
                        '</li>';
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
<script src="./js/jquery.min.js"></script>
<script>
  let btn = document.querySelector('.header__btn--new');
  btn.addEventListener('click',function(e){
    e.preventDefault();
    window.location.href = "./pages/post-new.php";
  })
</script>
<script>

  const lists = document.querySelectorAll('.blog__btn--redact');
  lists.forEach((list) => {
    list.addEventListener('click',function() {
      let value = this.value;
      // console.log(value);
      $.ajax({
        url: './pages/link.php',
        type: 'POST',
        data:{
          'temp_id': value
        },
        success: function(data)
        {
          //  alert(`Готово` );
          window.location.href = "./pages/post-read.php";
        }
      })
    })
}) 
</script>
<script>
  const removeBtn = document.querySelectorAll('.blog__btn--delete');
  removeBtn.forEach((removeBtn)=>{
    removeBtn.addEventListener('click',function(){
      let value = this.value;
      // console.log(value);
      $.ajax({
        url:'./pages/delete.php',
        type: 'GET',
        data:{
          'removeKey': value
        },
        success: function(data){
          window.location.href = "./index.php";
          
        }
      });

    })
  });
</script>
<script>
  let buttonsCatSort = document.querySelectorAll('.blog__cat');
  let blog_ids = document.querySelectorAll('.blog__id');
  buttonsCatSort.forEach((cat)=>{
    cat.addEventListener('click',function(e){
      let tempId = this.id;
      console.log(tempId);
      $.ajax({
        url:'./pages/sort-cat.php',
        type:'GET',
        data:{
          'tempId':`${tempId}`
        },success: function(data){
          window.location.href = "./pages/sort.php";
        }
      });

    })
  });
</script>
<script>
  let catRemover = document.querySelectorAll('.blog__del');
  catRemover.forEach(function(item){
    item.addEventListener('click',function(e){
      e.preventDefault();
      let value = e.target.value;
      $.ajax({
        url:'./pages/categorie-remover.php',
        type:'GET',
        data:{
          id: `${value}`,
        },success: ()=>{
          alert('ok');
          window.location.href = "./index.php";
        }
      });
    })
  });

</script>
</body>
</html>
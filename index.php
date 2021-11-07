<?php
    require __DIR__.'\config\db.php';
?>
<?php 
    $userId = -1; // после теста поставить -1

    if(isset($_COOKIE['user'])){
        $user_pass_hash = $_COOKIE['user'];
        $user_data = R::findOne('users','hash = ?',[$user_pass_hash]);
        $userId = $user_data['id'];  
     }
     
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyNote</title>
    <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
<div class="wrapper">
    <?php
      $conf = array(
        'class' => 'header__btn--new',
        'text' => 'Новая+',
        'disabled' => ''
      );
      include __DIR__.'/includes/header.php';
    ?>
    <section class="blog">
        <div class="blog__posts">
            <div class="container blog__container">
                <ul class="blog__list">
                    <?php
                        $limit = 8;
                        $currentSortId = $_GET['sort'];
                        $currentPage = $_GET['page'] ? $_GET['page'] : 1;
                        $offset = ($limit * $currentPage) - $limit;

                        $count = $currentSortId ? R::count('articles','categorie_id = ? AND user_id = ?',[$currentSortId,$userId])
                            : R::count('articles','user_id = ?',[$userId]); // give count = ok

                        //give selected articles = ok
                        $selected_articles = $currentSortId ? R::getAll('SELECT * FROM `articles` WHERE `categorie_id` = ? AND `user_id` = ? ORDER BY `pubdate` DESC LIMIT  ?,?',[$currentSortId,$userId,$offset,$limit])
                        : R::getAll('SELECT * FROM `articles` WHERE `user_id` = ? ORDER BY `pubdate` DESC LIMIT ?,?',[$userId,$offset,$limit]);
                        
                        $sa_count = count($selected_articles);

                        if($sa_count == 0){
                          echo 'Записей не найдено...';
                        }else{
                          foreach($selected_articles as $value){
                            $title = $value['title'];
                            $text = $value['text'];
                            $id = $value['id'];
                            echo <<<HTML
                                    <li class="blog__post">
                                      <div class="blog__head">
                                        <div class="blog__pin"></div>
                                        <h2 class="blog__category">${title}</h2>
                                          <div class="blog__info">
                                                <div class="blog__sticky"></div>
                                                <div class="blog__text">${text}</div>
                                            </div>
                                      </div>
                                      <div class="blog__wrap">
                                          <button class="blog__btn blog__btn--delete" value="${id}" >
                                            <span class="icon-bin"></span>
                                          </button>
                                          <a href="./pages/post-editor.php?id=${id}&type=read" class="blog__btn blog__btn--redact">
                                            <span class="icon-pencil2"></span>
                                        </a>
                                      </div>
                                  </li>
                                  HTML;
                          }
                        }
                    ?>
                </ul>
            </div>
        </div>
    <?php 
        $style = 'blog__sidebar';
        include __DIR__.'/includes/sidebar.php'; //ok
      ?>
    </section>
    <?php
        include __DIR__.'\includes\pagination.php';  // ok
    ?>
  
    <?php
        include __DIR__.'/includes/footer.php'; // ok
    ?>
</div>

<script src="./js/jquery.min.js"></script>
<script src="./js/logic.js"></script>

</body>
</html>

<?php
    require('config/db.php');
?>
<?php 
    $userId = -1; // после теста поставить -1

    if(isset($_COOKIE['user'])){
       $user_pass_temp = $_COOKIE['user'];
       $current_user_data_temp = mysqli_query($connection,"SELECT * FROM `users` WHERE  `pass` = '$user_pass_temp'");
       $user_data = mysqli_fetch_assoc($current_user_data_temp);
       $userId = $user_data['id'];  
    }
     
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main</title>
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
      include('./includes/header.php');
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
                        $articles_all = $currentSortId ?

                        mysqli_query($connection, "SELECT * FROM `articles` WHERE `categorie_id` = '$currentSortId' AND `user_id` = '$userId' ") :
                        mysqli_query($connection,"SELECT * FROM `articles` WHERE `user_id` = '$userId' ");

                        $count = mysqli_num_rows($articles_all);

                        $selected_articles = $currentSortId ?
                        mysqli_query($connection, "SELECT * FROM `articles` WHERE `categorie_id` = '$currentSortId'  AND `user_id` = '$userId' ORDER BY `pubdate` DESC LIMIT $offset,$limit") :
                        mysqli_query($connection,"SELECT * FROM `articles` WHERE `user_id` = '$userId' ORDER BY `pubdate` DESC LIMIT $offset,$limit" );


                        if (mysqli_num_rows($selected_articles) == 0) {
                            echo 'Записей не найдено...';
                        } else {
                            while ($item = mysqli_fetch_assoc($selected_articles)) {
                                echo '<li class="blog__post">' . '<div class="blog__head"><div class="blog__pin">' . '</div>'
                                    . '<h2 class="blog__category">' . $item['title'] . '</h2>
                          </div><div class="blog__info"><div class="blog__sticky">' . '</div><div class="blog__text">' . $item['text'] . '</div></div>' .
                                    '<div class="blog__wrap"><button class="blog__btn blog__btn--delete" value="' . $item['id'] . '" ><span class="icon-bin"></span></button><a href="./pages/post-editor.php?id='. $item['id'] .'&type=read" ' . $item['id'] . '" class="blog__btn blog__btn--redact"><span class="icon-pencil2"></span></a></div></li>';
                            }
                        }
                    ?>
                </ul>
            </div>
        </div>
    <?php 
        $style = 'blog__sidebar';
        include('./includes/sidebar.php');
      ?>
    </section>
    <?php include('./includes/pagination.php');?>
  
    <?php
        include('includes/footer.php');
    ?>
</div>

<script src="./js/jquery.min.js"></script>
<script src="./js/logic.js"></script>

</body>
</html>

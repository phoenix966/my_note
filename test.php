<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php 
      require('./config/db.php');


    //   // $articles_all = $currentSortId ?  R::getAll('SELECT * FROM `articles` WHERE `categorie_id` = ? AND `user_id` = ? ',[$currentSortId,$user_id])
    //   // : R::getAll('SELECT * FROM `articles` WHERE `user_id` = ?',[$user_id]);

    // $count = $currentSortId ? R::count('articles','categorie_id = ? AND user_id = ?',[$currentSortId,$user_id])
    //   : R::count('articles','user_id = ?',[$user_id]);

    //   echo $count ;
    //   // var_dump($articles_all);
    ?>
    <?php 
    $currentSortId = 40;
    $user_id = 7;
    $offset = 1;
    $limit = 8;
      // $selected_articles = $currentSortId ?
      // mysqli_query($connection, "SELECT * FROM `articles` WHERE `categorie_id` = '$currentSortId'  AND `user_id` = '$userId' ORDER BY `pubdate` DESC LIMIT $offset,$limit") :
      // mysqli_query($connection,"SELECT * FROM `articles` WHERE `user_id` = '$userId' ORDER BY `pubdate` DESC LIMIT $offset,$limit" );

      $selected_articles = $currentSortId ? R::getAll('SELECT * FROM `articles` WHERE `categorie_id` = ? AND `user_id` = ? ORDER BY `pubdate` DESC LIMIT  ?,?',[$currentSortId,$user_id,$offset,$limit])
      : R::getAll('SELECT * FROM `articles` WHERE `user_id` = ? ORDER BY `pubdate` DESC LIMIT ?,?',[$userId,$offset,$limit]);
      

    //   if (mysqli_num_rows($selected_articles) == 0) {
    //     echo 'Записей не найдено...';
    // } else {
    //     while ($item = mysqli_fetch_assoc($selected_articles)) {
    //         echo '<li class="blog__post">' . '<div class="blog__head"><div class="blog__pin">' . '</div>'
    //             . '<h2 class="blog__category">' . $item['title'] . '</h2>
    //   </div><div class="blog__info"><div class="blog__sticky">' . '</div><div class="blog__text">' . $item['text'] . '</div></div>' .
    //             '<div class="blog__wrap"><button class="blog__btn blog__btn--delete" value="' . $item['id'] . '" ><span class="icon-bin"></span></button><a href="./pages/post-editor.php?id='. $item['id'] .'&type=read" ' . $item['id'] . '" class="blog__btn blog__btn--redact"><span class="icon-pencil2"></span></a></div></li>';
    //     }
    // }
    $sa_count = count($selected_articles);

    if($sa_count == 0){
      echo 'Записей не найдено...';
    }else{
      foreach($selected_articles as $value){
        $title = $value['title'];
        $text = $value['text'];
        $id = $value['id'];
        echo <<<HTML
                <li class="blog__post" style="width: 300px">
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




<!-- <li class="blog__post">
  <div class="blog__head">
    <div class="blog__pin"></div>
    <h2 class="blog__category">$item['title']</h2>
       <div class="blog__info">
            <div class="blog__sticky"></div>
            <div class="blog__text">$item['text']</div>
        </div>
  </div>
   <div class="blog__wrap">
      <button class="blog__btn blog__btn--delete" value="$item['id']" >
        <span class="icon-bin"></span>
      </button>
      <a href="./pages/post-editor.php?id='. $item['id'] .'&type=read"$item['id']" class="blog__btn blog__btn--redact">
        <span class="icon-pencil2"></span>
     </a>
  </div>
</li> -->

</body>
</html>
<?php
    require('config/db.php');
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

                        mysqli_query($connection, "SELECT * FROM `articles` WHERE `categorie_id` = '$currentSortId' ") :
                        mysqli_query($connection,"SELECT * FROM `articles` ");

                        $count = mysqli_num_rows($articles_all);

                        $selected_articles = $currentSortId ?
                        mysqli_query($connection, "SELECT * FROM `articles` WHERE `categorie_id` = '$currentSortId' ORDER BY `pubdate` DESC LIMIT $offset,$limit") :
                        mysqli_query($connection,"SELECT * FROM `articles` ORDER BY `pubdate` DESC LIMIT $offset,$limit" );


                        if (mysqli_num_rows($selected_articles) == 0) {
                            echo 'Записей не найдено!';
                        } else {
                            while ($item = mysqli_fetch_assoc($selected_articles)) {
                                echo '<li class="blog__post">' . '<div class="blog__head"><div class="blog__pin">' . '</div>'
                                    . '<h2 class="blog__category">' . $item['title'] . '</h2>
                          </div><div class="blog__info"><div class="blog__sticky">' . '</div><div class="blog__text">' . $item['text'] . '</div></div>' .
                                    '<div class="blog__wrap"><button class="blog__btn blog__btn--delete" value="' . $item['id'] . '" ><span class="icon-bin"></span></button><a href="./pages/post-editor.php?id='. $item['id'] .'&type=read" ' . $item['id'] . '" class="blog__btn blog__btn--redact"><span class="icon-pencil"></span></a></div></li>';
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
    <?php
        $pages_temp = $count / $limit;
        $pages = ceil($pages_temp);
        $prev_page = $currentPage == 1 ? $currentPage : $currentPage - 1;
        $next_page = $currentPage == $pages ? $currentPage : $currentPage + 1;
        $page_sort_url = $currentSortId ? '&sort='. $currentSortId .'' : '';
    ?>
    <div class="container container__pagination">
        <span class="blog__arrow"><a href="./index.php?page=<?php echo $prev_page . $page_sort_url; ?>" class="blog__link"> < </a></span>
        <?php
        $min = $currentPage - 2;
        $max = $currentPage + 2;
        $linksPerPage = 5;
        $classDefault = 'blog__pagination-btn';
        $classActive = 'blog__pagination-btn blog__pagination-btn--active';

        function getLinks($currentPage, $linksPerPage, $pages, $min, $max, $classActive, $classDefault,$page_sort_url)
        {
            if ($pages <= $linksPerPage) {
                for ($i = 1; $i <= $pages; $i++) {
                    $isActive = $i == $currentPage ? $classActive : $classDefault;
                    echo '<li><a href="./index.php?page='. $i .''.  $page_sort_url .'" class="' . $isActive . '">' . $i . '</a></li>';

                }
                return;
            }

            if ($currentPage <= 3) {
                for ($i = 1; $i <= $linksPerPage; $i++) {
                    $isActive = $i == $currentPage ? $classActive : $classDefault;
                    // echo '<li><a class="' . $isActive . '">' . $i . '</a></li>';
                    echo '<li><a href="./index.php?page='. $i .''.  $page_sort_url .'" class="' . $isActive . '">' . $i . '</a></li>';

                }
                return;
            }

            if ($currentPage >= $pages - 2) {
                for ($i = $pages - $linksPerPage + 1; $i <= $pages; $i++) {
                    $isActive = $i == $currentPage ? $classActive : $classDefault;
                    // echo '<li><a class="' . $isActive . '">' . $i . '</a></li>';
                    echo '<li><a href="./index.php?page='. $i .''.  $page_sort_url .'" class="' . $isActive . '">' . $i . '</a></li>';

                }
                return;

            }

            for ($i = $min; $i <= $max; $i++) {
                $isActive = $i == $currentPage ? 'blog__pagination-btn blog__pagination-btn--active' : 'blog__pagination-btn';
                // echo '<li><a class="' . $isActive . '">' . $i . '</a></li>';
                echo '<li><a href="./index.php?page='. $i .''.  $page_sort_url .'" class="' . $isActive . '">' . $i . '</a></li>';

            }


        }


        ?>

        <ul class="blog__pagination">
            <?php
              getLinks($currentPage, $linksPerPage, $pages, $min, $max, $classActive, $classDefault,$page_sort_url);
            ?>
        </ul>
        <span class="blog__arrow"><a href="./index.php?page=<?php echo $next_page . $page_sort_url; ?>" class="blog__link"> > </a></span>
    </div>
    <?php
        include('includes/footer.php');
    ?>
</div>

<script src="./js/logic.js"></script>
<script src="./js/jquery.min.js"></script>

<script>
    let defaultSearchInput = document.querySelector('.header__input');
    let defaultSearch = document.querySelector('.header__searchbar');
    let defaultSearchForm = document.querySelector('.header__form');

    defaultSearchForm.addEventListener('input',function(e){
        let value = e.target.value;
        if(value) {
            defaultSearch.classList.add('header__searchbar--active');
        }else{
            defaultSearch.classList.remove('header__searchbar--active');
        }
    })
    defaultSearchInput.addEventListener('focusout',()=>{
        defaultSearch.classList.remove('header__searchbar--active');
    })
</script>
<!-- 
<script>
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
    

</script>  -->  
<script>
    let btn = document.querySelector('.header__btn--new');
    if(btn){
      btn.addEventListener('click', function (e) {
        e.preventDefault();
        window.location.href = "./pages/post-editor.php?type=new";
    })  
    }
    
</script>
</body>
</html>

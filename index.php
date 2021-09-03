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
<?php
$connection = mysqli_connect('localhost:8889', 'root', 'root', 'note_db');

if ($connection == false) {
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
                    <a href="./index.php?page=1"><img src="./img/logo.png" alt="logo" class="header__img"></a>
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
                    $limit = 8;
                    $offset = ($limit * $_GET['page']) - $limit;

                    $articles_all = mysqli_query($connection, "SELECT * FROM `articles`");
                    $count = mysqli_num_rows($articles_all);

                    $selected_articles = mysqli_query($connection, "SELECT * FROM `articles` LIMIT $offset,$limit ");
                    if (mysqli_num_rows($selected_articles) == 0) {
                        echo 'Записей не найдено!';
                    } else {
                        while ($item = mysqli_fetch_assoc($selected_articles)) {
                            echo '<li class="blog__post">' . '<div class="blog__head"><div class="blog__pin">' . '</div>'
                                . '<h2 class="blog__category">' . $item['title'] . '</h2>
                      </div><div class="blog__info"><div class="blog__sticky">' . '</div><div class="blog__text">' . $item['text'] . '</div></div>' .
                                '<div class="blog__wrap"><button class="blog__btn blog__btn--delete" value="' . $item['id'] . '" ><span class="icon-bin"></span></button><button value="' . $item['id'] . '" class="blog__btn blog__btn--redact"><span class="icon-pencil"></span></button></div></li>';
                        }
                    }
                    ?>
                </ul>
            </div>
        </div>
        <div class="blog__overlay"></div>
        <div class="blog__sidebar">
            <form class="blog__search" method="POST">
                <div class="blog__row">
                    <input class="blog__input" type="text" name="cat_search">
                    <button class="blog__btn" type="submit" name="submit">Поиск</button>
                </div>
            </form>
            <ul class="blog__search-bar">
                <?php
                if (isset($_POST['cat_search'])) {
                    $cat_search = $_POST['cat_search'];
                    $search_result_temp = mysqli_query($connection, "SELECT * FROM `articles_categories` WHERE `categorie_title` = '$cat_search' ");
                    $search_result = mysqli_fetch_assoc($search_result_temp);
                    if (mysqli_num_rows($search_result_temp) == 0) {
                        echo '<li>ничего не найдено</li>';
                    } else {
                        // echo $search_result['categorie_title'];
                        echo '<li class="blog__search-item">
                              <p>Найденная категория: </p>
                              <br>
                              <button value="' . $search_result['id'] . '" class="blog__search_btn">' . $search_result['categorie_title'] . '</button>
                            </li>';

                    }

                } else {
                    echo '';
                }

                ?>
            </ul>
            <?php
            $result = mysqli_query($connection, "SELECT * FROM `articles_categories` ");
            if (mysqli_num_rows($result) == 0){
                echo 'Категорий не найдено!';
            } else{
            ?>
            <ul class="blog__note">
                <?php
                while (($cat = mysqli_fetch_assoc($result))) {
                    $articles_count = mysqli_query($connection, "SELECT COUNT(`id`) AS `total_count` FROM `articles`
                    WHERE `categorie_id` = " . $cat['id']);
                    $articles_count_result = mysqli_fetch_assoc($articles_count);
                    $id = $cat['id'];
                    if ($id == 18) {
                        echo '<li class="blog__item">' .
                            '<span class="blog__cat" id="' . $cat['id'] . '">'
                            . $cat['categorie_title'] . '[' . $articles_count_result['total_count'] . ']' .
                            '</span>' . '
                            </li>';
                    } else {
                        echo '<li class="blog__item">' .
                            '<span class="blog__cat" id="' . $cat['id'] . '">'
                            . $cat['categorie_title'] . '[' . $articles_count_result['total_count'] . ']' .
                            '</span>' .
                            '<button ' . $var . ' class="blog__del" value="' . $cat['id'] . '"><span class="icon-bin"></span></button> 
                        </li>';
                    }

                }
                }
                mysqli_close($connection);
                ?>
            </ul>
        </div>
    </section>
    <?php
        $pages_temp = $count / $limit;
        $pages = ceil($pages_temp);
        $currentPage = $_GET['page'];
        $prev_page = $currentPage == 1 ? $currentPage : $currentPage - 1;
        $next_page = $currentPage == $pages ? $currentPage : $currentPage + 1;
    ?>
    <div class="container container__pagination">
        <span class="blog__arrow"><a href="./index.php?page=<?php echo $prev_page; ?>" class="blog__link"> < </a></span>
        <?php
           $min = $currentPage - 2;
           $max = $currentPage + 2;
           $linksPerPage = 5;
           $classDefault = 'blog__pagination-btn';
           $classActive = 'blog__pagination-btn blog__pagination-btn--active';

           function getLinks($currentPage, $linksPerPage,$pages,$min,$max,$classActive,$classDefault){
               if($pages <= $linksPerPage){
                   for($i=1;$i <= $pages;$i++){
                       $isActive = $i == $currentPage ? $classActive : $classDefault;
                       echo '<li><button class="'. $isActive .'">'. $i .'</button></li>';

                   }
                   return;
               }

               if($currentPage <= 3){
                   for($i=1;$i <= $linksPerPage;$i++){
                       $isActive = $i == $currentPage ? $classActive : $classDefault;
                       echo '<li><button class="'. $isActive .'">'. $i .'</button></li>';

                   }
                   return;
               }

               if($currentPage >= $pages - 2){
                   for($i=$pages - $linksPerPage + 1;$i <= $pages;$i++){
                       $isActive = $i == $currentPage ? $classActive : $classDefault;
                       echo '<li><button class="'. $isActive .'">'. $i .'</button></li>';

                   }
                   return;

               }

               for($i=$min;$i <= $max; $i++){
                   $isActive = $i == $currentPage ? 'blog__pagination-btn blog__pagination-btn--active' : 'blog__pagination-btn';
                   echo '<li><button class="'. $isActive .'">'. $i .'</button></li>';

               }


           }


        ?>

        <ul class="blog__pagination">
            <?php
                getLinks($currentPage, $linksPerPage,$pages,$min,$max,$classActive,$classDefault);
            ?>
        </ul>
        <span class="blog__arrow"><a href="./index.php?page=<?php echo $next_page; ?>" class="blog__link"> > </a></span>
    </div>
    <footer class="footer">
<!--        <p class="footer__text">All rights reserved by Phoenix</p>-->

        <p>

        </p>
    </footer>
</div>

<script src="./js/logic.js"></script>
<script src="./js/jquery.min.js"></script>
<script>
    let btn = document.querySelector('.header__btn--new');
    btn.addEventListener('click', function (e) {
        e.preventDefault();
        window.location.href = "./pages/post-new.php";
    })
</script>
<script>

    const lists = document.querySelectorAll('.blog__btn--redact');
    lists.forEach((list) => {
        list.addEventListener('click', function () {
            let value = this.value;
            $.ajax({
                url: './pages/link.php',
                type: 'POST',
                data: {
                    'temp_id': value
                },
                success: function (data) {
                    window.location.href = "./pages/post-read.php";
                }
            })
        })
    })
</script>
<script>
    const removeBtn = document.querySelectorAll('.blog__btn--delete');
    removeBtn.forEach((removeBtn) => {
        removeBtn.addEventListener('click', function () {
            let value = this.value;
            // console.log(value);
            $.ajax({
                url: './pages/delete.php',
                type: 'GET',
                data: {
                    'removeKey': value
                },
                success: function (data) {
                    window.location.href = "./index.php";

                }
            });

        })
    });
</script>
<script>
    let buttonsCatSort = document.querySelectorAll('.blog__cat');
    // let blog_ids = document.querySelectorAll('.blog__id');
    buttonsCatSort.forEach((cat) => {
        cat.addEventListener('click', function (e) {
            let tempId = this.id;
            console.log(tempId);
            $.ajax({
                url: './pages/sort-cat.php',
                type: 'GET',
                data: {
                    'tempId': `${tempId}`
                }, success: function (data) {
                    window.location.href = "./pages/sort.php";
                }
            });

        })
    });
</script>
<script>

    let catRemover = document.querySelectorAll('.blog__del');
    catRemover.forEach(function (item) {
        item.addEventListener('click', function (e) {
            e.preventDefault();
            let value = e.currentTarget.value;
            $.ajax({
                url: './pages/categorie-remover.php',
                type: 'GET',
                data: {
                    id: `${value}`,
                }, success: () => {
                    window.location.href = "./index.php";
                }
            });
        })
    });

</script>
<script>
    let catSearch = document.querySelector('.blog__search_btn');
    if (catSearch) {
        catSearch.addEventListener('click', function (e) {
            e.preventDefault();
            let value = this.value;
            $.ajax({
                url: './pages/sort-cat.php',
                type: 'GET',
                data: {
                    'tempId': `${value}`
                }, success: function (data) {
                    window.location.href = "./pages/sort.php";
                }
            });

        })
    }
    ;
</script>
<script>
    let paginationBtns = document.querySelectorAll('.blog__pagination-btn');
    paginationBtns.forEach((post) => {
        post.addEventListener('click', function () {
            window.location.href = `./index.php?page=${this.innerText}`;
        })
    })
</script>

</body>
</html>
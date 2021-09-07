<div class="blog__overlay"></div>
<div class="blog__sidebar <?php echo $style; ?>">
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
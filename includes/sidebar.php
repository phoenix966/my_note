<div class="blog__overlay"></div>
<div class="blog__sidebar <?php echo $style; ?>">
    <div class="blog__auth">
        <?php 
            $user_check = $user_data['name'] ? '<span class="blog__quad blog__quad--active"></span>'  : '<span class="blog__quad"></span>' ;
            echo $user_check;
        ?>
        <h4 class="blog__name">
            <?php 
                $user_name = $user_data['name'] ?  $user_data['name'] : 'Войдите или зарегестрируйтесь!' ; 
                echo $user_name;
            ?>
            
        </h4>
    </div>
    <form class="blog__search" method="POST">
        <div class="blog__row">
            <input class="blog__input" type="text" name="catSearch" autocomplete="off">
            <div class="blog__btn" type="submit">Поиск</div>
        </div>
    </form>
    <?php
    $result = mysqli_query($connection, "SELECT * FROM `articles_categories` WHERE `user_id` = '$userId' ");
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
            $total_count = $articles_count_result['total_count'];
            $cat_id = $cat['id'];
            $cat_title = $cat['categorie_title']; 
            if ($id == 18){
                echo  "<li class='blog__item'>
                                <span class='blog__row-wrap'>
                                    <a href='/my_note/index.php?sort=${cat_id}' class='blog__cat'>{$cat_title}</a><span class='blog__count'>[{$total_count}]</span>
                                </span>
                            </li>";
            }else{
                echo <<<HTML
                    <li class='blog__item'>
                        <span class='blog__row-wrap'>
                            <a href='/my_note/index.php?sort=${cat_id}' class='blog__cat'>{$cat_title}</a>
                            <span class='blog__count'>[{$total_count}]</span>
                        </span>
                        <button ${var} class='blog__del' value='${cat_id}'>
                            <span class='icon-bin'></span>
                        </button>
                    </li>
                    HTML;
            }

        }
        }
        mysqli_close($connection);
        ?>
    </ul>
</div>
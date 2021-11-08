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
    $result = R::getAll('SELECT * FROM `articles_categories` WHERE `user_id` = ?',[$userId]);
    $cat_count = count($result);
    if ($cat_count == 0){
        echo 'Категорий не найдено!';
        if(isset($_COOKIE['user'])){
            R::exec('INSERT INTO `articles_categories` (`categorie_title`,`user_id`) VALUES (?,?)',['Без категории',$userId]);
            header('Location: /my_note/index.php');
        }
    } else{
?>
    <ul class="blog__note">
        <?php
        $default_cat = R::findOne('articles_categories', 'user_id = ? AND categorie_title = ?', [$userId,'Без категории']);
        $default_id = $default_cat['id'];
            foreach($result as $cat){
                $total_count = R::count('articles','categorie_id = ?',[$cat['id']]);
                $cat_id = $cat['id'];
                $cat_title = $cat['categorie_title'];
                if($cat_id == $default_id){
                    echo <<<HTML
                            <li class='blog__item'>
                                <span class='blog__row-wrap'>
                                    <a href='/my_note/index.php?sort=${cat_id}' class='blog__cat'>${cat_title}</a><span class='blog__count'>[${total_count}]</span>
                                </span>
                            </li> 
                            HTML;
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
        R::close();
        ?>
    </ul>
</div>
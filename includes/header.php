<?php 
    include('../config/config.php');
?>
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
                <a href="<?php echo $config['root_name'];?>/index.php"><img src="<?php echo $config['root_name']; ?>/img/logo.png" alt="logo" class="header__img"></a>
            </div>
        </div>
        <form class="header__form">
            <div class="header__form-wrapper">
                <div class="header__wrap">
                    <input type="text" class="header__input" placeholder="Найти запись...">
                    <div class="header__btn header__btn--search">Поиск</div>
                    <div class="header__searchbar">
                        <ul class="header__searchbar-list">
                            
                        </ul>
                    </div>
                </div>
                <?php 
                    $checkBtn = $_COOKIE['user'] ? '' : 'disabled';

                ?>
                <button <?php echo $checkBtn; ?> <?php echo $conf['disabled']; ?> class="header__btn  header__btn--round <?php echo $conf['class']; ?>"><?php echo $conf['text']; ?></button>
            </div>
        </form>
    </div>
    <div class="container">
        <button class="header__scroll">закрыть</button>
    </div>
    <?php 
        if(!$_COOKIE['user']){
            echo <<<HTML
                    <a href="/my_note/pages/register-page.php" class="header__box">
                       <span class="header__icon icon-lock"></span>
                    </a>
                  HTML;
        }else{
            echo <<<HTML
                    <a href="/my_note/pages/auth/exit.php?exit=true" class="header__box">
                       <span class="header__icon icon-unlocked"></span>
                    </a>
                 HTML;
        }
    ?>   
</header>
<section>
   
</section>

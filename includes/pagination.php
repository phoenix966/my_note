<div class="container container__pagination">
<?php
    $pages_temp = $count / $limit;
    $pages = ceil($pages_temp);
    $prev_page = $currentPage == 1 ? $currentPage : $currentPage - 1;
    $next_page = $currentPage == $pages ? $currentPage : $currentPage + 1;
    $page_sort_url = $currentSortId ? '&sort='. $currentSortId .'' : '';
?>
    <div class="container">
       <a href="./index.php?page=<?php echo $prev_page . $page_sort_url; ?>" class="blog__arrow blog__arrow--left"> < </a> 
    </div>
   
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
    <div class="container">
         <a href="./index.php?page=<?php echo $next_page . $page_sort_url; ?>" class="blog__arrow blog__arrow--right"> > </a>
    </div>
   
</div>
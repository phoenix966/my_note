<div class="modal">
  <div class="modal__overlay"></div>
  <form class="modal__form">
    <div class="modal__window">
      <div class="modal__wrapper">
        <p class="modal__title">Название: </p>
        <?php 
          $dataInfo = $info['title'];
          $get_type = $_GET['type'];
          if($get_type == 'edit'){
            echo '<input maxlength="65" type="text" class="modal__input modal__name" name="title" value="'. $dataInfo .'">';
          }else{
            echo '<input maxlength="65" type="text" class="modal__input modal__name" name="title">';
          }
        ?>
      </div>
      <div class="modal__wrapper">
        <p class="modal__title">Категория: </p>
        <div class="modal__row">
          <select name="catSelect" class="modal__select">
          <?php
            if($get_type == 'new'){
              $temp_cat = mysqli_query($connection," SELECT * FROM `articles_categories` ");
              while(($cat = mysqli_fetch_assoc($temp_cat)) ){
                echo '<option value="'. $cat['id'] .'">' . $cat['categorie_title'] . '</option>';
              }
            }
            if($get_type == 'edit'){
              $temp_cat_edit = mysqli_query($connection," SELECT * FROM `articles_categories` ");
              $selected_cat_id = $info['categorie_id'];
              while(($cat = mysqli_fetch_assoc($temp_cat_edit)) ){
                if($cat['id'] == $selected_cat_id){
                  echo '<option selected="true" value="'. $cat['id'] .'">' . $cat['categorie_title'] . '</option>';
                  continue;
                }
                  echo '<option value="'. $cat['id'] .'">' . $cat['categorie_title'] . '</option>';
              }
            }
          ?>
        </select>
        <button class="modal__btn modal__btn--show">+</button>
          <div class="modal__bar">
            <input type="text" class="modal__new-category" name="newCat" placeholder="Новая категория...">
          </div>
        </div>
        </div>
        <?php $titleText = $type == 'new' ? 'Добавить' : 'Изменить';?>
        <button type="submit" class="modal__btn modal__btn--add"><?php echo $titleText ?></button>
  </form>
</div>
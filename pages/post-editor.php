<?php
    include('../config/db.php');
  ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit post</title>
  <link rel="stylesheet" href="../css/style.css">
  <link rel="shortcut icon" href="../img/favicon.ico" type="image/x-icon">
<!--   <link href="highlight.js/monokai-sublime.min.css" rel="stylesheet"> -->
</head>
<body>
   <?php
      $currentId = $_GET['id'];
      $currentType = $_GET['type'];
      $res = mysqli_query($connection,"SELECT * FROM `articles` WHERE  `id` = '$currentId' ");
      $info = mysqli_fetch_assoc($res);
    ?>
  <div class="wrapper">
    <?php
      $conf = [];
       if($_GET['type'] == 'edit'){
         $conf = array(
          'class' => 'header__btn--action',
          'text' => 'Изменить',
          'disabled' => ''
        );
       }elseif($_GET['type'] == 'new'){
         $conf = array(
          'class' => 'header__btn--action',
          'text' => 'Добавить',
          'disabled' => ''
        );
       }else{
        $conf = array(
          'class' => 'header__btn--action',
          'text' => 'Изменить',
          'disabled' => 'disabled'
        );
       }
        
        include('../includes/header.php');
       ?>
       <?php 
        include('../includes/modal.php');
     ?>
    <section class="post">
      <div class="post__container">
        <h1 class="post__title"> <?php echo $info['title']?> </h1>
        <?php 
          $btn_text = '';
          $btn_url = '';
          $btn_class = '';
          $btn_link_class = '';
          if($currentType == 'edit'){
            $btn_text = 'Включен режим редактирования';
            $btn_class = '';
            $btn_url = 'read';
          }elseif($currentType == 'read'){
            $btn_text = 'Включен режим чтения';
            $btn_class = 'post__btn-dot--unlock';
            $btn_url = 'edit';
          }else{
            $btn_text = 'Включен режим создания новой записи';
            $btn_class = 'post__btn-dot--unlock';
            $btn_url = '';
            $btn_link_class = 'post__btn--disabled';
          }
        ?>
        <a href="/my_note/pages/post-editor.php?id=<?php echo $currentId; ?>&type=<?php echo $btn_url; ?>" class="post__btn post__btn--redact <?php echo $btn_link_class; ?>"><?php echo $btn_text;?><span class="post__btn-dot <?php echo $btn_class; ?>"></span></a>
        <div class="post__editor" style="height: 70vh" id="editor">
          <?php echo $info['text']; ?>
        </div>
        <div class="post__test"></div>
      </div>
      <?php 
        $style = 'blog__sidebar--mix';
        include('../includes/sidebar.php');
      ?>
    </section>
    <?php include('../includes/footer.php');?>
  </div>


<script src="../js/jquery.min.js"></script>
<!-- <script href="highlight.js"></script> -->
<script src="../js/quill.js"></script>
<script src="../js/jquery.nicescroll.min.js"></script>
<script src="../js/logic.js"></script>
<script src="../js/logic-edit.js"></script>


</body>
</html>
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

      </div>
    <section class="post">
      <div class="container post__container">
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
    <footer class="footer">
      <p class="footer__text">All rights reserved by Phoenix</p>
    </footer>
  </div>


  <script src="../js/jquery.min.js"></script>
  <script src="../js/logic.js"></script>
  <script src="../js/quill.js"></script>

  <script>
    let temp = window.location;
    let url = new URL(`${temp.href}`);
    let searchParams = new URLSearchParams(url.search);
    let getType = searchParams.get('type'); 
    let getId = searchParams.get('id'); 
    // let isTrue = false;

    let toolbarOptions = [
      [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
      // [{ 'font': [] }],
      ['bold', 'italic', 'underline', 'strike'],        // toggled buttons
      ['blockquote', 'code-block'],
      ['link', 'image'],
      [{ 'list': 'ordered' }, { 'list': 'bullet' }],
      // [{ 'script': 'sub' }, { 'script': 'super' }],      // superscript/subscript
      [{ 'indent': '-1' }, { 'indent': '+1' }],          // outdent/indent
      [{ 'direction': 'rtl' }],                         // text direction

      [{ 'color': [] }, { 'background': [] }],          // dropdown with defaults from theme
      [{ 'align': [] }],

      ['clean']                                         // remove formatting button
    ];

    let options = {
      modules: {
        toolbar: toolbarOptions
      },
      placeholder: 'Начните что-нибудь писать ...',
      theme: 'snow',
      readOnly: false,
    }
    if(getType == 'new' || getType == 'edit'){
      options.readOnly = false; 
    }else{
      options.readOnly = true;
    }
    let editor = new Quill('#editor', options);

  </script>
  <script>
    let showNewCat = document.querySelector('.modal__btn--show');
    let bar = document.querySelector('.modal__bar');
    let select = document.querySelector('.modal__select');
    let isNewCatActive = false;
    showNewCat.addEventListener('click',(e)=>{
      e.preventDefault();
      bar.classList.toggle('modal__bar--active');
      isNewCatActive ? isNewCatActive = false : isNewCatActive = true;
      isNewCatActive ? select.disabled = true : select.disabled = false;
    });

  </script>
  <script>  
  document.querySelector('.modal__form').addEventListener('submit',(e)=>{
    e.preventDefault();
    let textTemp = editor.root.innerHTML;
    let textArray = textTemp.split('');
    let text = '';
    const form = document.querySelector('.modal__form');
    for(let value of textArray){
      if(value == "'"){
        value = "~";
        text += value;
      } else{
        text += value;
      }
    }
    let obj = {
      'title': `${form.elements.title.value}`,
      'text': `${text}`,
    }
    if(!isNewCatActive){
      obj.cat_id = `${form.elements.catSelect.value}`;
    }else{
      obj.new_cat = `${form.elements.newCat.value}`;
    }
    //Редактирование

    if(getType == 'edit'){
    obj.updateKey = getId;
    $.ajax({
      url:'./update.php',
      type: "POST",
      data: obj,
      success: function(data)
        {
          window.location.href = "/my_note/index.php";
        }
});
    return;
    }
     //Создание новой
    if(getType == 'new'){
    $.ajax({
      url:'/my_note/pages/foo.php',
      type: "POST",
      data: obj,
      success: function(data)
        {
          window.location.href = "/my_note/index.php";
        }
});
    }
    return;
  });

</script>

<script>
  let modalOverlay = document.querySelector('.modal__overlay');
  let topBtn = document.querySelector('.header__btn--action');
  let modalPanel = document.querySelector('.modal__window');
  topBtn.addEventListener('click', function (e) {
  e.preventDefault();
  modalOverlay.classList.toggle('modal__overlay--active');
  modalPanel.classList.toggle('modal__window--active');
});
modalOverlay.addEventListener('click', function () {
  modalOverlay.classList.remove('modal__overlay--active');
  modalPanel.classList.remove('modal__window--active');
});
</script>
<!-- <script>
  
  let redactBtn = document.querySelector('.post__btn--redact');
  redactBtn.addEventListener('click',function(){
    window.location.href = "./post-read.php";
  });

</script> -->
<script>
  let buttonsCatSort = document.querySelectorAll('.blog__cat');
  let blog_ids = document.querySelectorAll('.blog__id');
  buttonsCatSort.forEach((cat)=>{
    cat.addEventListener('click',function(e){
      let tempId = this.id;
      $.ajax({
        url:'/my_note/pages/sort-cat.php',
        type:'GET',
        data:{
          'tempId':`${tempId}`
        },success: function(data){
          window.location.href = "/my_note/pages/sort.php";
        }
      });

    })
  });
</script>

</body>
</html>
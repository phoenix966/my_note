<?php 
  require_once('../config/db.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Read post</title>
  <link rel="stylesheet" href="../css/style.css">
</head>

<body>
  <div class="wrapper">
    <?php
      $conf = array(
        'class' => 'header__btn--new',
        'text' => 'Изменить',
        'disabled' => 'disabled'
      );
      include('../includes/header.php');
    ?>
    <section class="post">
      <div class="container post__container">
          <?php
            $currentId = $_GET['id'];
            $res = mysqli_query($connection,"SELECT * FROM `articles` WHERE  `id` = '$currentId' ");
            $info = mysqli_fetch_assoc($res);
          ?>
        <h1 class="post__title"> <?php echo $info['title']; ?> </h1>

        <a href="./post-editor.php?id=<?php echo $currentId; ?>&type=edit" class="post__btn post__btn--redact post__btn--down">Включен режим чтения<span class="post__btn-dot"></span></a>

        <div class="post__editor" style="height: 90vh" id="editor">
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
    let toolbarOptions = [];
    let quill = new Quill('#editor', {
      modules: {
        toolbar: toolbarOptions
      },
      placeholder: 'Начните что-нибудь писать ...',
      theme: 'snow',
      readOnly: true,
    });
  </script>

<!--  <script>
  let redactBtn = document.querySelector('.post__btn--redact');
  redactBtn.addEventListener('click',function(){
    window.location.href = "./post-editor.php";
  });

</script> -->

<script>
  let buttonsCatSort = document.querySelectorAll('.blog__cat');
  let blog_ids = document.querySelectorAll('.blog__id');
  buttonsCatSort.forEach((cat)=>{
    cat.addEventListener('click',function(e){
      let tempId = this.id;
      $.ajax({
        url:'./sort-cat.php',
        type:'GET',
        data:{
          'tempId':`${tempId}`
        },success: function(data){
          window.location.href = "./sort.php";
        }
      });

    })
  });
</script>
<script>
  let textNotSorted = quill.root.innerHTML;
    let array = textNotSorted.split('');
    let newText = '';
    for(let value of array){
      if(value == "~"){
        value = "'";
        newText += value;
      } else{
        newText += value;
      }
    }
    quill.root.innerHTML = newText; 

</script>
</body>

</html>
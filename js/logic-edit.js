// Quill логика

let temp = window.location;
    let url = new URL(`${temp.href}`);
    let searchParams = new URLSearchParams(url.search);
    let getType = searchParams.get('type'); 
    let getId = searchParams.get('id'); 
    
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

//Логика категорий верхней панели

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

// Логика категорий

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

// Логика верхней панели

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
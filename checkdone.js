var checkBox = document.getElementsByClassName("checkboox");
var text= document.getElementsByClassName("text");

for (let i = 0 ; i<checkBox.length ; i++){
    if (checkBox[i].value == 1){

      text[i].style.textDecoration = 'line-through';
      checkBox[i].checked = true;

    }else{
      text[i].style.textDecoration = 'none';
      checkBox[i].checked = false;
    }

  }
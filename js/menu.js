function menuToggle(obj){
  obj.toggle(300);
}

$(document).ready(function(){
  $("#major_1").click(function(){
    menuToggle($('#sub_1'));
    $(this).children("i").toggleClass("icon-chevron-down").toggleClass("icon-chevron-right");
  });  
  $("#major_2").click(function(){
    menuToggle($('#sub_2'));
    $(this).children("i").toggleClass("icon-chevron-down").toggleClass("icon-chevron-right");
  });  
  $("#major_3").click(function(){
    menuToggle($('#sub_3'));
    $(this).children("i").toggleClass("icon-chevron-down").toggleClass("icon-chevron-right");
  });
});

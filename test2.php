<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <a id="foo" href="introduction.php">Home<span><img src="littleegret.jpg" alt="Little Egret"></span></a>
  </body>
  <script>
  $('#foo').hover(
function(){
alert('Вы попали на территорию элемента "foo", известную своей валидной версткой'+
      'и наличием диких обработчиков событий.');
},
function(){
alert('Вы покинули территорию элемента "foo". Мы будем рады видеть вас снова.');
});
  </script>
</html>

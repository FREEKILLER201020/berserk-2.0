<!DOCTYPE html>
<html lang="en" >

<head>
  <meta charset="UTF-8">
  <title>HTML5 Editable Table</title>


  <link rel='stylesheet' href='http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css'>
<link rel='stylesheet' href='http://netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css'>

      <link rel="stylesheet" href="css/style.css">

      <meta charset="utf-8">
      <title>APP Clanberserk - Города</title>
      <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> -->
      <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
      <script src="../jquery.js"></script>
      <script src="../jquery-ui.js"></script>
      <link href="../jquery-ui.css" rel="stylesheet">
      <link rel="stylesheet" href="../css/style.css">
      <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
</head>



<script>
<?php
session_start();
// session_destroy();
$link=htmlentities($_SERVER['PHP_SELF']);
  $links=explode("/", $link);
  $res="";
  for ($i=0;$i<count($links)-1;$i++) {
      $res=$res.$links[$i]."/";
  }
?>
var active;
// document.addEventListener('keydown', function(event) {
//   if (event.code == 'KeyJ' && (event.ctrlKey || event.metaKey)) {
// 	    active=true;
// 	    document.getElementById("dot").style.visibility="visible";
// 	    console.log(document.getElementById("dot"));
//   }
// });
function gotourl(url,extras) {
   if (active==true){
       window.open("<?php echo $res?>"+url+"?results=true&"+extras,"_self");
   }
   else{
       window.open("<?php echo $res?>"+url+"?"+extras,"_self");
   }
}
</script>
<body>
  <div class="header sticky sticky--top js-header">
    <div class="grid">
      <nav class="navigation">
        <!-- <ul class="navigation__list navigation__list--inline parent"> -->
        <ul class="navigation__list parent">
          <li class="navigation__item child"><a class="element" style="cursor: pointer;" onclick="gotourl('index.php')">Статистика</a></li>
          <li class="navigation__item child"><a class="element" style="cursor: pointer;" onclick="gotourl('era_res.php')" >Результаты Эр</a></li>
          <li class="navigation__item child"><a class="element" style="cursor: pointer;" onclick="gotourl('timetable.php','Clan=171')" >Расписание</a></li>
          <li class="navigation__item child"><a class="element" style="cursor: pointer;" onclick="gotourl('history.php','Clan=171')">История</a></li>
          <li class="navigation__item child"><a class="element is-active" style="cursor: pointer;" onclick="gotourl('cities.php','Clan=171')">Города</a></li>
          <li class="navigation__item child"><a class="element" style="cursor: pointer;" onclick="gotourl('clans.php')">Кланы</a></li>
          <!-- <li class="navigation__item child">   |   </li> -->
          <!-- <li class="navigation__item child"><a class="element" style="cursor: pointer;" onclick="gotourl('')">О проекте</a></li> -->
          <?php
            // session_start();
            // if (($_SESSION['u']!=null)&&($_SESSION['p']!=null)) {
            //     echo "<li class=\"navigation__item child\"><a class=\"element\" style=\"cursor: pointer;color:red;\" onclick=\"gotourl('clans.php')\">{$_SESSION['u']}</a></li>";
            //     echo "<li class=\"navigation__item child\"><a class=\"element\" style=\"cursor: pointer;\" onclick=\"gotourl('clans.php')\">Выход</a></li>";
            // } else {
            //     echo "<li class=\"navigation__item child\"><a class=\"element\" style=\"cursor: pointer;\" onclick=\"gotourl('htmltest.php?link=index.php')\">Вход</a></li>";
            // }
          ?>
        </ul>
      </nav>
    </div>
  </div>
<br>
  <div class="container">


  <div id="table" class="table-editable">
    <table class="table">
      <tr>
        <th>ID на форуме</th>
        <th>ID в игре</th>
        <th>Ник в игре</th>
        <th>    <span class="table-add glyphicon glyphicon-plus"></span></th>
        <!-- <th></th> -->
      </tr>
      <tr id="tr1">
        <td contenteditable="true">Stir Fry</td>
        <td contenteditable="true" id="1" class="autoc">stir-fry</td>
        <td contenteditable="true" id="2" class="autoc">stir-fry</td>
        <td>
          <span class="table-remove glyphicon glyphicon-remove"></span>
        </td>
        <!-- <td>
          <span class="table-up glyphicon glyphicon-arrow-up"></span>
          <span class="table-down glyphicon glyphicon-arrow-down"></span>
        </td> -->
      </tr>
      <!-- This is our clonable table line -->
      <tr class="hide">
        <td contenteditable="true">Untitled</td>
        <td contenteditable="true" id="1" class="autoc">undefined</td>
        <td contenteditable="true" id="2" class="autoc">undefined</td>
        <td>
          <span class="table-remove glyphicon glyphicon-remove"></span>
        </td>
        <!-- <td>
          <span class="table-up glyphicon glyphicon-arrow-up"></span>
          <span class="table-down glyphicon glyphicon-arrow-down"></span>
        </td> -->
      </tr>
    </table>
  </div>

  <button id="export-btn" class="btn btn-primary">Export Data</button>
  <p id="export"></p>
</div>
  <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script src='http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js'></script>
<script src='https://netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js'></script>
<script src='http://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.6.0/underscore.js'></script>



    <script  src="js/index.js"></script>

<script>
var data=[];
var data2=[];
$.ajax({
  url:"../sql.php", //the page containing php script
  type: "post", //request type,
  dataType: 'json',
  data: {type:"players"},
  async: false, // HERE
  success:function(result){
    // document.getElementById("id1").remove();
    // console.log(data);
    console.log(result);
    result.forEach(function(res) {
      data.push({label:res.nick,id:res.id});
      data2.push({label:res.id,id:res.nick});
    });
  }
});
// console.log(data);
$( function() {
  $('.autoc').on("focus", function(){
    // console.log(this);
    if (this.id=="1"){
      $( this ).autocomplete({
        source: data2,
        select: function(event, ui) {
          var el=this.parentElement.getElementsByClassName("autoc");
          // console.log(el,this);
          if (this.id=="1"){
            // console.log("GO",ui.item.id);
            // document.getElementById("special").value=ui.item.id;
            el[1].textContent=ui.item.id;
          }
        }
      });
    }
    if (this.id=="2"){
      $( this ).autocomplete({
        source: data,
        select: function(event, ui) {
          var el=this.parentElement.getElementsByClassName("autoc");
          // console.log(el,this);
          if (this.id=="2"){
            // console.log("GO",ui.item.id);
            // document.getElementById("special").value=ui.item.id;
            el[0].textContent=ui.item.id;
          }
        }
      });
    }
  });
});
</script>


</body>

</html>

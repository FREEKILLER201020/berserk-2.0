<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>APP Clanberserk - Результаты Эр</title>
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> -->
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="jquery.js"></script>
		<script src="jquery-ui.js"></script>
		<link href="jquery-ui.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
  </head>

  <script  src="js/index.js"></script>
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
    				<li class="navigation__item child"><a class="element is-active" style="cursor: pointer;" onclick="gotourl('era_res.php')" >Результаты Эр</a></li>
    				<li class="navigation__item child"><a class="element" style="cursor: pointer;" onclick="gotourl('timetable.php','Clan=171')" >Расписание</a></li>
    				<li class="navigation__item child"><a class="element" style="cursor: pointer;" onclick="gotourl('history.php','Clan=171')">История</a></li>
    				<li class="navigation__item child"><a class="element" style="cursor: pointer;" onclick="gotourl('cities.php','Clan=171')">Города</a></li>
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
    <div class="bg"></div>
    <script>
    alert("Страница в процессе разработки!");
    </script>
  </body>
</html>

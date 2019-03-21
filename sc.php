<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>APP Clanberserk - Разведка</title>
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> -->
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="jquery.js"></script>
		<script src="jquery-ui.js"></script>
		<link href="jquery-ui.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel='stylesheet' href='http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css'>
    <link rel='stylesheet' href='http://netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css'>
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
      <div class="parent">
        <br>
          Клан:
          <select id="clans" name="Clans">
          </select>
          Игрок:
          <input id="player" value="">
          <input id="player_id" style="display:none" value="">
              </div>
              <hr>
    </div>
    <!-- <input type="button" onclick="CreateTableFromJSON()" value="Create Table From JSON" /> -->
    <!-- <div style="margin-bottom:20000px;">-->
    <!-- </div> -->
    <div class="container">


    <div id="table" class="table-editable">
      <p id="player_row"></p>
      <table class="table">
        <tr>
          <!-- <th>№</th> -->
          <th>Карта</th>
          <th>Просмотр</th>
          <th style="display:none">ID</th>
          <th>    <span class="table-add glyphicon glyphicon-plus"></span></th>
          <!-- <th></th> -->
        </tr>
        <tr id="tr1">
          <td contenteditable="true" id="1" class="autoc"></td>
          <td contenteditable="true" id="2" class="autoc"><img></td>
          <td contenteditable="true" id="3" class="autoc" style="display:none"></td>
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
          <!-- <td contenteditable="true">Untitled</td> -->
          <td contenteditable="true" id="1" class="autoc"></td>
          <td contenteditable="true" id="2" class="autoc"><img></td>
          <td contenteditable="true" id="3" class="autoc" style="display:none"></td>
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

    <button id="export-btn" class="btn btn-primary">Сохранить сборку</button>
    <p id="export"></p>
  </div>
  <div class="parent">
    <p>Типовая сборка игрока</p>
    <p id="showData_t"></p>
  </div>
  <div class="parent">
    <p>Сборки игрока</p>
    <p id="showData"></p>
  </div>
    <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
  <script src='http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js'></script>
  <script src='https://netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js'></script>
  <script src='http://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.6.0/underscore.js'></script>
  <!-- <script  src="extra/js/index.js"></script> -->
    <script>



      function clans () {
        var pad = function(num) { return ('00'+num).slice(-2) };
        date = new Date();
        date = pad(date.getUTCMonth()+1)        + '/' +
        pad(date.getUTCDate() ) + '/' +
        date.getUTCFullYear();
        console.log("Clans!");
        $.ajax({
          url:"sql.php", //the page containing php script
          type: "post", //request type,
          dataType: 'json',
          data: {type:"clans", datee: date},
          async: false, // HERE
          success:function(result){
            // document.getElementById("id1").remove();
            // console.log(data);
            console.log(result);
            var bcp=$('#clans').val();
            var x = document.getElementById("clans");
            var option = document.createElement("clans");
            x.options.length = 0;
            var option = document.createElement("option");
            option.text = "Все кланы";
            option.value = -1;
            x.add(option);
            for (var i = 0; i < result.length; i++) {
              // console.log(result[i].title);
              // console.log(result[i].id);
              var option = document.createElement("option");
              option.text = result[i].title;
              option.value = result[i].id;
              // console.log(option);
              x.add(option);
            }
            var option = document.createElement("option");
            option.text = "Нет клана";
            option.value = -2;
            x.add(option);
            if (bcp==null){
              document.getElementById("clans").value=-1;
            }
            else{
              document.getElementById("clans").value=bcp;
            }
          }
        });
      }





    // Usage
    var data_fill=[];
    var idds=[];
    $.ajax({
      url:"sql.php", //the page containing php script
      type: "post", //request type,
      dataType: 'json',
      data: {type:"players"},
      async: false, // HERE
      success:function(result){
        // document.getElementById("id1").remove();
        // console.log(data);
        console.log(result);
        result.forEach(function(res) {
          data_fill.push(res.nick);
          idds.push(res.id);
        });
      }
    });
    $( function() {
    $( "#player" ).autocomplete({
      source: data_fill,
      close: function( event, ui ) {player_check();}
    });
  } );

  $(document).ready(function(){
    $('#player').on("change", player_check);
  });
  $(document).ready(function(){
    $('#player').on("input", player_check);
  });

    function player_check(){
      console.log(data_fill.includes($('#player').val()));
      var divContainer = document.getElementById("showData");
      divContainer.innerHTML = "";
      if (data_fill.includes($('#player').val())){
        $('#player_id').val(idds[data_fill.indexOf($('#player').val())]);
        $('#table').show();
        $('#player_row').text($('#player').val());
        console.log($('#player_row'));
        Load_d();
      }
      else{
        $('#table').hide();
      }
    }
    clans();
    player_check();








    var data=[];
    var data2=[];
    $.ajax({
      url:"sql.php", //the page containing php script
      type: "post", //request type,
      dataType: 'json',
      data: {type:"cards"},
      async: false, // HERE
      success:function(result){
        // document.getElementById("id1").remove();
        // console.log(data);
        console.log(result);
        result.forEach(function(res) {
          data.push({label:res.name,id:res.file,ext:res.id});
          // data2.push({label:res.file,id:res.name});
        });
      }
    });
    // console.log(data);
    $( function() {
      $('.autoc').on("focus", function(){
        // console.log(this);
        if (this.id=="1"){
          $( this ).autocomplete({
            source: data,
            select: function(event, ui) {
              var el=this.parentElement.getElementsByClassName("autoc");
              // console.log(el,this);
              if (this.id=="1"){
                // console.log("GO",ui.item.id);
                // document.getElementById("special").value=ui.item.id;
                console.log(el);
                var img = document.createElement('img');
                img.src = "cards/small/"+ui.item.id;
                img.setAttribute("onmouseover", "this.src='cards/info/"+ui.item.id+"'");
                img.setAttribute("onmouseout", "this.src='cards/small/"+ui.item.id+"'");
                while (el[1].firstChild) {
                  el[1].removeChild(el[1].firstChild);
                }
                el[1].appendChild(img);
                el[2].textContent=ui.item.ext;
                // el[1].prepend('<img id="theImg" src="scards/info/'+ui.item.id+'" />')
              }
            }
          });
        }
        // if (this.id=="2"){
        //   $( this ).autocomplete({
        //     source: data,
        //     select: function(event, ui) {
        //       var el=this.parentElement.getElementsByClassName("autoc");
        //       // console.log(el,this);
        //       if (this.id=="2"){
        //         // console.log("GO",ui.item.id);
        //         // document.getElementById("special").value=ui.item.id;
        //         el[0].textContent=ui.item.id;
        //       }
        //     }
        //   });
        // }
      });
    });











    var $TABLE = $('#table');
    var $BTN = $('#export-btn');
    var $EXPORT = $('#export');

    $('.table-add').click(function() {
      var $clone = $TABLE.find('tr.hide').clone(true).removeClass('hide table-line');
      $TABLE.find('table').append($clone);
    });

    $('.table-remove').click(function() {
      $(this).parents('tr').detach();
    });

    $('.table-up').click(function() {
      var $row = $(this).parents('tr');
      if ($row.index() === 1) return; // Don't go above the header
      $row.prev().before($row.get(0));
    });

    $('.table-down').click(function() {
      var $row = $(this).parents('tr');
      $row.next().after($row.get(0));
    });

    // A few jQuery helpers for exporting only
    jQuery.fn.pop = [].pop;
    jQuery.fn.shift = [].shift;

    $BTN.click(function() {
      var $rows = $TABLE.find('tr:not(:hidden)');
      var headers = [];
      var data = [];

      // Get the headers (add special header logic here)
      $($rows.shift()).find('th:not(:empty)').each(function() {
        headers.push($(this).text().toLowerCase());
      });

      // Turn all existing rows into a loopable array
      $rows.each(function() {
        var $td = $(this).find('td');
        var h = {};

        // Use the headers from earlier to name our hash keys
        headers.forEach(function(header, i) {
          if (i < 3) {
            h[header] = $td.eq(i).text();
          }
        });

        data.push(h);
      });

      // Output the result
      console.log(JSON.stringify(data));
      var dt = JSON.stringify(data);
      $.ajax({
        url: "sql.php", //the page containing php script
        type: "post", //request type,
        dataType: 'json',
        data: {
          type: "save_cards",
          json: dt,
          player: $('#player_id').val()
        },
        async: false, // HERE
        success: function(result) {
          // document.getElementById("id1").remove();
          // console.log(data);
          console.log(result);

          // for (var i = 0; i < result.length; i++) {
          //   for (var key in result[i]) {
          //     var string = "";
          //     if (result[i][key] == "2") {
          //       alert(string.concat(key, " : Данного id нет в БД"));
          //     }
          //     if (result[i][key] == "1") {
          //       alert(string.concat(key, " : Что то пошло не так при записи в БД. Возможно эта запись уже есть там. Попробуйте загрузить данные нажав 'Загрузить'"));
          //     }
          //     console.log(key, result[i][key]);
          //   }
          // }
        }
      });
      Load_d();
      // $EXPORT.text(JSON.stringify(data));
    });








    function Load_d(){
      var divContainer = document.getElementById("showData");
      divContainer.innerHTML = "";
      $.ajax({
        url: "sql.php", //the page containing php script
        type: "post", //request type,
        dataType: 'json',
        data: {
          type: "load_cards",
          player: $('#player_id').val()
        },
        async: false, // HERE
        success: function(result) {
          // document.getElementById("id1").remove();
          // console.log(data);
          console.log(result);
          for (var i = 0; i < result.length-1; i++) {
            console.log(result[i][0]);
            // var tmp=[];
            // tmp.push(result[i])
            CreateTableFromJSON(result[i]);
            // divContainer.appendChild(document.createElement("br"));
          //   for (var key in result[i]) {
          //     var string = "";
          //     if (result[i][key] == "2") {
          //       alert(string.concat(key, " : Данного id нет в БД"));
          //     }
          //     if (result[i][key] == "1") {
          //       alert(string.concat(key, " : Что то пошло не так при записи в БД. Возможно эта запись уже есть там. Попробуйте загрузить данные нажав 'Загрузить'"));
          //     }
          //     console.log(key, result[i][key]);
          //   }
          }
          CreateTableFromJSON_t(result[result.length-1]);
          test();
          // $EXPORT.text(result);
        }
      });
    }






    function CreateTableFromJSON(myBooks) {


        // EXTRACT VALUE FOR HTML HEADER.
        // ('Book ID', 'Book Name', 'Category' and 'Price')
        var col = [];
        for (var i = 0; i < myBooks.length; i++) {
            for (var key in myBooks[i]) {
                if (col.indexOf(key) === -1) {
                    col.push(key);
                }
            }
        }

        // CREATE DYNAMIC TABLE.
        var table = document.createElement("table");
        table.setAttribute("align", "center");
        table.setAttribute("id", "table1");
        table.setAttribute("display", "inline-block");
        // table.setAttribute("table-layout", "fixed");
        // table.setAttribute("width", "300px");
        table.setAttribute("class", "table1");

        // CREATE HTML TABLE HEADER ROW USING THE EXTRACTED HEADERS ABOVE.

        var tr = table.insertRow(-1);                   // TABLE ROW.

        for (var i = 0; i < col.length; i++) {
            var th = document.createElement("th");      // TABLE HEADER.
            th.innerHTML = col[i];
            tr.appendChild(th);
        }

        // ADD JSON DATA TO THE TABLE AS ROWS.
        for (var i = 0; i < myBooks.length; i++) {

            tr = table.insertRow(-1);

            for (var j = 0; j < col.length; j++) {
                var tabCell = tr.insertCell(-1);
                if (j>0){
                  // tabCell.innerHTML = myBooks[i][col[j]];
                  var img = document.createElement('img');
                  img.src = "cards/small/"+myBooks[i][col[j]];
                  img.setAttribute("onmouseover", "this.src='cards/info/"+myBooks[i][col[j]]+"'");
                  img.setAttribute("onmouseout", "this.src='cards/small/"+myBooks[i][col[j]]+"'");
                  while (tabCell.firstChild) {
                    tabCell.removeChild(tabCell.firstChild);
                  }
                  tabCell.appendChild(img);
                }
                else{
                  tabCell.innerHTML = myBooks[i][col[j]];
                }
            }
        }

        // FINALLY ADD THE NEWLY CREATED TABLE WITH JSON DATA TO A CONTAINER.
        var divContainer = document.getElementById("showData");
        // divContainer.innerHTML = "";
        divContainer.appendChild(table);
    }

    function CreateTableFromJSON_t(myBooks) {


        // EXTRACT VALUE FOR HTML HEADER.
        // ('Book ID', 'Book Name', 'Category' and 'Price')
        var col = [];
        for (var i = 0; i < myBooks.length; i++) {
            for (var key in myBooks[i]) {
                if (col.indexOf(key) === -1) {
                    col.push(key);
                }
            }
        }

        // CREATE DYNAMIC TABLE.
        var table = document.createElement("table");
        table.setAttribute("align", "center");
        table.setAttribute("id", "table1");
        // table.setAttribute("table-layout", "fixed");
        // table.setAttribute("width", "300px");
        table.setAttribute("class", "table1");

        // CREATE HTML TABLE HEADER ROW USING THE EXTRACTED HEADERS ABOVE.

        var tr = table.insertRow(-1);                   // TABLE ROW.

        for (var i = 0; i < col.length; i++) {
            var th = document.createElement("th");      // TABLE HEADER.
            th.innerHTML = col[i];
            tr.appendChild(th);
        }

        // ADD JSON DATA TO THE TABLE AS ROWS.
        for (var i = 0; i < myBooks.length; i++) {

            tr = table.insertRow(-1);

            for (var j = 0; j < col.length; j++) {
                var tabCell = tr.insertCell(-1);
                if (j>0){
                  // tabCell.innerHTML = myBooks[i][col[j]];
                  var img = document.createElement('img');
                  img.src = "cards/small/"+myBooks[i][col[j]];
                  img.setAttribute("onmouseover", "this.src='cards/info/"+myBooks[i][col[j]]+"'");
                  img.setAttribute("onmouseout", "this.src='cards/small/"+myBooks[i][col[j]]+"'");
                  while (tabCell.firstChild) {
                    tabCell.removeChild(tabCell.firstChild);
                  }
                  tabCell.appendChild(img);
                }
                else{
                  tabCell.innerHTML = myBooks[i][col[j]];
                }
            }
        }

        // FINALLY ADD THE NEWLY CREATED TABLE WITH JSON DATA TO A CONTAINER.
        var divContainer = document.getElementById("showData_t");
        // divContainer.innerHTML = "";
        divContainer.appendChild(table);
    }


    function test(){
      var max=[];
      var all=document.getElementsByClassName("table1");
      for (var i = 0; i < all.length; i++) {
        max.push(all[i].rows[0].cells[0].offsetWidth);
        max.push(all[i].rows[0].cells[1].offsetWidth);
      }
      for (var i = 0; i < all.length; i++) {
        all[i].rows[0].cells[0].width=getMaxOfArray(max);
        all[i].rows[0].cells[1].width=getMaxOfArray(max);
      }
      console.log(getMaxOfArray(max));
    }
    function getMaxOfArray(numArray) {
      return Math.max.apply(null, numArray);
    }
</script>
    <!-- <div style="padding-top:10px; padding-bottom:10px;">
      Footer
    </div> -->
  </body>
</html>

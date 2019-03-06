<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>APP Clanberserk - История</title>
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
alert("Время указано по гринвичу!");
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
    				<li class="navigation__item child"><a class="element is-active" style="cursor: pointer;" onclick="gotourl('history.php','Clan=171')">История</a></li>
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
          <?php
        require("classes.php");
        require("data.php");
        require("class.php");
        require("functions.php");
        $file  = file_get_contents(realpath(dirname(__FILE__))."/../config.json");
        $config = json_decode($file, true);
        // print_r($config);
        $connection=Connect($config);

        $order="frags";
        // $nickname=null;
        $era_selected=-1;
        $time=GetLatestDate($connection, $config);
        $eras=array();
        $query = "\nSELECT * FROM {$config["base_database"]}.eras ORDER BY started DESC;\n";
        $result = $connection->query($query);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $tmp=new Era_class($row["id"], $row["started"], $row["ended"], $row["lbz"], $row["points"]);
                array_push($eras, $tmp);
            }
        }
        $dates=array();
        if ($era_selected!=-1) {
            // $end=date("Y-m-d", strtotime("$end 00:00:00") + 60 * 60 * 24);
            $query = "\nSELECT DISTINCT timemark FROM {$config["base_database"]}.Players WHERE timemark>=\"$start\" and timemark<=\"$end\" ORDER BY timemark DESC;\n";
        } else {
            $query = "\nSELECT DISTINCT timemark FROM {$config["base_database"]}.Players ORDER BY timemark DESC;\n";
        }
                // echo $query;
        $result = $connection->query($query);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $tmp=array();
                $split=explode("-", $row["timemark"]);
                $split2=explode(" ", $split[2]);
                $year=(int)$split[0];
                $month=(int)$split[1];
                $day=(int)$split2[0];
                $ret="$split[1]-$split2[0]-$split[0]";
                $ret2="$day-$month-$year";
                array_push($tmp, $ret);
                array_push($tmp, $ret2);
                array_push($dates, $tmp);
            }
        }
      ?>
      <br>
      <script>
      var $$header = document.querySelector('.js-header');

      // var availableDates = [<?php 	echo "\"{$dates[0][1]}\""; for ($i=1;$i<count($dates);$i++) {echo ",\"{$dates[$i][1]}\"";}?>];
      // console.log(availableDates);
        $(function() {
          function available(date) {
            dmy = date.getDate() + "-" + (date.getMonth()+1) + "-" + date.getFullYear();
            if ($.inArray(dmy, availableDates) != -1) {
              return [true, "","Available"];
            } else {
              return [false,"","unAvailable"];
            }
          }
          $('#date').datepicker({ beforeShowDay: available });
        });
      </script>
      <div class="parent">
        <input type="hidden" name="date" id="date" size="12" value=""/>
          Эра:
          <select id="era" name="era">
                <!-- <option value="-1"> --- </option> -->
                  <?php
                    foreach ($eras as $era) {
                      if ($era->id==$era_selected) {
                        echo "<option selected value=\"$era->id\">$era->id [$era->started - $era->ended]</option>";
                      } else {
                        echo "<option value=\"$era->id\">$era->id [$era->started - $era->ended]</option>";
                      }
                    }
                ?>
          </select>
          Клан:
          <select id="clans" name="Clans">
          </select>
          <!-- Игрок:
          <input id="player"> -->

          <!-- <button type="button" onclick="create()">Click Me</button> -->
      </div>
      <hr>
      <div class="parent">
        <p id="showData2"></p>
      </div>
    </div>
    <!-- <input type="button" onclick="CreateTableFromJSON()" value="Create Table From JSON" /> -->
    <p id="showData"></p>
    <!-- <div style="margin-bottom:20000px;">
    </div> -->
    <script>
    // func();
    var pad = function(num) { return ('00'+num).slice(-2) };
    date = new Date();
    date = pad(date.getUTCMonth()+1)        + '/' +
    pad(date.getUTCDate() ) + '/' +
    date.getUTCFullYear();
    $('#date').val(date);
    clans();
    // eras_data();
    create2();
    $('#era').val($("#era").find('option').eq(0).val());

      // $(document).ready(function(){
      //   $('#era').on("input", eras_data);
      // });
      $(document).ready(function(){
        $('#date').on("input", func);
      });
      $(document).ready(function(){
        $('#date').on("change", func);
      });
      $(document).ready(function(){
        $('#order').on("change", func);
      });
      $(document).ready(function(){
        $('#clans').on("change", func);
      });
      // function eras_data(){
      //   console.log($('#era').val());
      //   get_eras_data();
      // }
      function func(){
        var date = $('#date').val();
        console.log(date);
        console.log($('#order').val());
        console.log($('#order_way').val());
        console.log($('#era').val());
        console.log($('#clans').val());
        create2();
      }
      function clans () {
        console.log("Clans!");
        $.ajax({
          url:"sql.php", //the page containing php script
          type: "post", //request type,
          dataType: 'json',
          data: {type:"clans", datee: $('#date').val()},
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
      function create2 () {
        $.ajax({
          url:"sql.php", //the page containing php script
          type: "post", //request type,
          dataType: 'json',
          data: {type:"history", id: $('#era').val(),clan:$('#clans').val()},
          async: false, // HERE
          success:function(result){
            // document.getElementById("id1").remove();
            // console.log(data);
            console.log(result);
            CreateTableFromJSON(result)
          }
        });
      }
      // function get_eras_data () {
      //   $.ajax({
      //     url:"sql.php", //the page containing php script
      //     type: "post", //request type,
      //     dataType: 'json',
      //     data: {type:"era", id: $('#era').val()},
      //     success:function(result){
      //       // document.getElementById("id1").remove();
      //       // console.log(data);
      //       console.log(result);
      //       console.log(result[0].started);
      //       console.log(result[0].ended);
      //       var start = result[0].started.split("-");
      //       var end = result[0].ended.split("-");
      //       var start_date=new Date(start[0],start[1]-1,start[2]);
      //       var end_date=new Date(end[0],end[1]-1,end[2]);
      //       if ($('#era').val() != -1){
      //         end_date.setDate(end_date.getDate() + 1);
      //       }
      //       console.log(start_date);
      //       console.log(end_date);
      //       var dates = getDates(start_date,end_date );
      //       var string="";
      //       availableDates=[];
      //       dates.forEach(function(date) {
      //         availableDates.push(string.concat(date.getDate(),"-",date.getMonth()+1,"-",date.getFullYear()));
      //         console.log(string.concat(date.getDate(),"-",date.getMonth()+1,"-",date.getFullYear()));
      //       });
      //       document.getElementById('date').value=string.concat(end_date.getDate(),"/",end_date.getMonth()+1,"/",end_date.getFullYear());
      //       var tmp=end_date.getMonth()+1;
      //       document.getElementById('date').value=string.concat(("0" + tmp).slice(-2),"/",("0" + end_date.getDate()).slice(-2),"/",end_date.getFullYear());
      //       func();
      //
      //       // CreateTableFromJSON(result)
      //     }
      //   });
      // }

        function CreateTableFromJSON(myBooks) {


            // EXTRACT VALUE FOR HTML HEADER.
            // ('Book ID', 'Book Name', 'Category' and 'Price')
            // myBooks.sort(function(a, b){
            //   var srt=document.getElementById("order").value;
            //   console.log(srt);
            //   return b.srt - a.srt;
            // });
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

            // var table = document.getElementById("myTable");
            // var header = table.createTHead();
            var tblBody = table.createTBody();
            // var row = header.insertRow(0);
            //
            //
            // for (var i = 0; i < col.length; i++) {
            //     var th = document.createElement("th");      // TABLE HEADER.
            //     th.innerHTML = col[i];
            //     row.appendChild(th);
            //     // var cell = row.insertCell(0);
            //     // cell.innerHTML = "<b>This is a table header</b>";
            // }

            // CREATE HTML TABLE HEADER ROW USING THE EXTRACTED HEADERS ABOVE.

            var tr = tblBody.insertRow(-1);                   // TABLE ROW.
            //
            // for (var i = 0; i < col.length; i++) {
            //     var th = document.createElement("th");      // TABLE HEADER.
            //     th.innerHTML = col[i];
            //     tr.appendChild(th);
            // }

            // ADD JSON DATA TO THE TABLE AS ROWS.
            for (var i = 0; i < myBooks.length; i++) {

                tr = table.insertRow(-1);

                for (var j = 0; j < col.length; j++) {
                    var tabCell = tr.insertCell(-1);
                    tabCell.innerHTML = myBooks[i][col[j]];
                }
            }

            // FINALLY ADD THE NEWLY CREATED TABLE WITH JSON DATA TO A CONTAINER.
            var divContainer = document.getElementById("showData");
            divContainer.innerHTML = "";
            divContainer.appendChild(table)
            var rrow=document.getElementById('table1').rows[2].cells;
            var width = [];
            for(let i = 0; i < rrow.length; i++){
              width.push(rrow[i].offsetWidth+5);
            }

            var table2 = document.createElement("table");
            table2.setAttribute("align", "center");
            table2.setAttribute("id", "table2");

            var header2 = table2.createTHead();
            var tblBody2 = table2.createTBody();
            var row2 = header2.insertRow(0);


            for (var i = 0; i < col.length; i++) {
                var th = document.createElement("th");      // TABLE HEADER.
                th.innerHTML = col[i];
                row2.appendChild(th);
            }
            var divContainer = document.getElementById("showData2");
            divContainer.innerHTML = "";
            divContainer.appendChild(table2);
            document.getElementById('table2').rows[0].cells;
            var rrow=document.getElementById('table2').rows[0].cells;
            var width2 = [];
            for(let i = 0; i < rrow.length; i++){

              width2.push(rrow[i].offsetWidth+5);
            }
            var rrow=document.getElementById('table2').rows[0].cells;
            for(let i = 0; i < rrow.length; i++){
              document.getElementById('table2').rows[0].cells[i].width=Math.max(width[i],width2[i]);
            }
            var rrow=document.getElementById('table1').rows;
            for(let i = 0; i < rrow.length; i++){
              var ccells=document.getElementById('table1').rows[i].cells;
              for(let j = 0; j < ccells.length; j++){
                document.getElementById('table1').rows[i].cells[j].width=Math.max(width[j],width2[j]);
              }
            }
        }

    // var getDates = function(startDate, endDate) {
    //   var dates = [],
    //       currentDate = startDate,
    //       addDays = function(days) {
    //         var date = new Date(this.valueOf());
    //         date.setDate(date.getDate() + days);
    //         return date;
    //       };
    //   while (currentDate <= endDate) {
    //     // console.log("here");
    //     dates.push(currentDate);
    //     currentDate = addDays.call(currentDate, 1);
    //   }
    //   return dates;
    // };

    // Usage

    </script>
    <!-- <div style="padding-top:10px; padding-bottom:10px;">
      Footer
    </div> -->
  </body>
</html>

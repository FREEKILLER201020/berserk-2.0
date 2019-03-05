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
    url: "../sql.php", //the page containing php script
    type: "post", //request type,
    dataType: 'json',
    data: {
      type: "save",
      json: dt
    },
    async: false, // HERE
    success: function(result) {
      // document.getElementById("id1").remove();
      // console.log(data);
      console.log(result);

      for (var i = 0; i < result.length; i++) {
        for (var key in result[i]) {
          var string = "";
          if (result[i][key] == "2") {
            alert(string.concat(key, " : Данного id нет в БД"));
          }
          if (result[i][key] == "1") {
            alert(string.concat(key, " : Что то пошло не так при записи в БД. Возможно эта запись уже есть там. Попробуйте загрузить данные нажав 'Загрузить'"));
          }
          console.log(key, result[i][key]);
        }
      }
    }
  });
  $EXPORT.text(JSON.stringify(data));
});
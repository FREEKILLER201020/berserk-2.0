<!DOCTYPE html>
<html>
<?php
require("functions.php");

// the following line prevents the browser from parsing this as HTML.
// header('Content-Type: text/plain');

$table=array();
$ls=shell_exec("ls");
// $folders=array();
$files=explode("\n", $ls);
unset($files[count($files)-1]);
// print_r($files);
foreach ($files as $key => $value) {
  if (HasText_string($value,".")!=1){
    unset($files[$key]);
  }
}

// print_r($files);
// exit();
$t0=microtime(true)*10000;
$i=0;
// for ($i=0;$i<count($folders);$i++) {
    $total=count($files)*count($files);
foreach ($files as $file1) {
  $tmp=array();
  foreach ($files as $file2) {

    $t=(microtime(true)*10000-$t0)/$i;
    // progressBar($i, $total, $t, $t0);
    $i++;
    $res=HasText($file1,$file2);
    // echo $res;
    $tmp[$file2]=$res;

}
$table[$file1]=$tmp;
}

// print_r($table);
// PrintTable($table);
// echo HasText($file,$searchfor);

function HasText($file,$searchfor){
// get the file contents, assuming the file to be readable (and exist)
$contents = file_get_contents($file);
// escape special characters in the query
$pattern = preg_quote($searchfor, '/');
// finalise the regular expression, matching the whole line
$pattern = "/^.*$pattern.*\$/m";
// search, and store all matching occurences in $matches
$good=0;
if(preg_match_all($pattern, $contents, $matches)){
  $good++;
}
return $good;
}
function HasText_string($string,$searchfor){
// get the file contents, assuming the file to be readable (and exist)
$contents = $string;
// escape special characters in the query
$pattern = preg_quote($searchfor, '/');
// finalise the regular expression, matching the whole line
$pattern = "/^.*$pattern.*\$/m";
// search, and store all matching occurences in $matches
$good=0;
if(preg_match_all($pattern, $contents, $matches)){
  $good++;
}
return $good;
}
?>
</html>

<body>
  <script src="https://unpkg.com/gojs/release/go.js"></script>
  <div id="myDiagramDiv"
       style="width:1300px; height:700px; background-color: #DAE4E4;"></div>
<script>

var $ = go.GraphObject.make;

myDiagram =
  $(go.Diagram, "myDiagramDiv",
      {
        initialContentAlignment: go.Spot.Center,
        // double-click in background creates new node
        "clickCreatingTool.archetypeNodeData": {},
        "undoManager.isEnabled": true
      });

myDiagram.nodeTemplate =
  $(go.Node, "Spot",
    { locationSpot: go.Spot.Center, locationObjectName: "SHAPE" },
    // remember the location, which is at the center of the circle
    new go.Binding("location", "loc", go.Point.parse).makeTwoWay(go.Point.stringify),
    $(go.Shape, "Circle",
      {
        name: "SHAPE", fill: "steelblue", width: 40, height: 40,
        // allow users to draw links to and from this circle
        portId: "", cursor: "pointer",
        fromLinkable: true, toLinkable: true,
        fromLinkableDuplicates: true, toLinkableDuplicates: true,
        fromLinkableSelfNode: true, toLinkableSelfNode: true
      }),
    // show in-place editable text, by default above the circle
    $(go.TextBlock, "abc",
      { alignment: new go.Spot(0.5, 0.5, 0, -30), editable: true },
      // TwoWay Binding automatically remembers text edits
      new go.Binding("text").makeTwoWay())
  );

myDiagram.linkTemplate =
  $(go.Link,
    { relinkableFrom: true, relinkableTo: true },
    $(go.Shape, { stroke: "steelblue", strokeWidth: 1.5 }),
    $(go.Shape, { toArrow: "OpenTriangle", stroke: "steelblue" })
  );

myDiagram.model = new go.GraphLinksModel(
  [
    <?php
    $i=1;
    $r=1000;
    $delta_fi=360/(count($files));
    $fi=0;
    foreach ($files as $file) {
      $x = $r*cos($fi);
      $y = $r*sin($fi);
      // $x=rand(-1000,1000);
      // $y=rand(-1000,1000);
      // $y=$i*10;
      echo "{ key: $i, text: \"$file\", loc: \"$x $y\" },";
      $i++;
      $fi+=$delta_fi;
    }
     ?>
  ],
  [
    <?php
    $i=1;
    foreach ($table as $row) {
      $j=1;
      foreach ($row as $cell) {
        if ($cell==1){
          echo "{ from: $i, to: $j },";
        }
        $j++;
      }
      $i++;
    }
     ?>
    // { from: 1, to: 2 },
    // { from: 1, to: 3 },
    // { from: 2, to: 2 },
    // { from: 3, to: 4 },
    // { from: 4, to: 3 },
    // { from: 4, to: 1 }
  ]);

</script>
</body>

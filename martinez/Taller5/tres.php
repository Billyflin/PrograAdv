<!DOCTYPE html>
<html lang="en">
<head>
    <title>Primer Formulario</title>
</head>
<body>
<?php
//$color = "blue";
//$row = 10;
//$col = 15;
$color=$_GET['color'];
$row=$_GET['row'];
$col=$_GET['col'];
function deg_selector($color){
if($color=="red"){
    $color=0;
}else if($color=="green"){
    $color=240;
}else if($color=="blue"){
    $color=120;
}else if($color=="yellow"){
    $color=60;
}
return $color;
}
function paint($color,$row,$col){
    $deg=deg_selector($color);
    $light=100/$col;
    $sat=100/$row;
    echo "<table cellspacing='0' cellpadding='0'>";
    for ($i = 0; $i < $row; $i++) {
        echo "\n<tr >";
        for ($j = 0; $j < $col; $j++) {
            if((100-($light*$j))==100){
                $c = "hsl(".$deg.",".($sat*$i)."%, ".(95)."%)";
            }else{
                $c = "hsl(".$deg.",".($sat*$i)."%, ".(100-($light*$j))."%)";
            }
            echo "\n<td style='background-color:$c;height: 40px;width: 40px ' > ". " </td>";
        }
        echo "\n</tr>";
    }
}
paint($color,$row,$col);
?>

<h1 id="div"></h1>
</body>
</html>
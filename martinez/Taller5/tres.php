<!DOCTYPE html>
<html lang="en">
<head>
    <title>Primer Formulario</title>
</head>
<body>
<?php

$color = $_GET['color'];
$row = $_GET['row'];
$col = $_GET['col']+1;


function get($color, $row, $col): void
{
    $gradiente = 20 / $row;
    $deg = $color - 12;
    $light = 100 / $col;
    echo "<table  cellpadding='0' cellspacing='1px' >";
    for ($j = 0; $j < $col; $j++) {
        echo "<tr>";
        for ($i = 0; $i < $row; $i++) {
            $l = $light * $j;
            $hsl = "hsl(" . ($deg + ($gradiente * $i)) . ", 100%, $l%)";
            if ($l < 95 && $l > 7) {
                echo "<td  style='background-color: $hsl; width: 50px; height: 50px; '></td>";
            }
        }
    }
}

get($color, $row, $col);
?>

<h1 id="div"></h1>
</body>
</html>
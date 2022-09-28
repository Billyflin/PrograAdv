<html >
<head>
<title>Ejemplo prog. avanz. php 01</title>
</head>
<body>
<?php
$n = 10;
$m = 8;

echo "<h2> tabla de $n x $m </h2>";
echo '<table border="1">';
for($i=0;$i<$n;$i++){
    echo "\n<tr>";
    for ($j=0;$j<$m;$j++){
        echo "\n <td> pos ($i,$j) </td>";
    }
    echo "\n</tr>";
}
echo '</table>'

?>

</body>
</html>


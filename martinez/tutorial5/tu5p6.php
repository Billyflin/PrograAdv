<html >
<head>
<title>Ejemplo prog. avanz. php 01</title>
</head>
<body>
<?php
$n = 6;
$m = 8;
$col = array("00","35","96","B4","CC","F4");
$col2 = array("0000","3500","9600","9696","96B4","B4B4","0096","35F4");

echo '<table border="1">';
for($i=0;$i<$n;$i++){
    echo "\n<tr>";
    for ($j=0;$j<$m;$j++){
        $c = $col[$i].$col2[$j];
        echo "\n <td bgcolor=\"$c\"> ".$c." </td>";
    }
    echo "\n</tr>";
}
echo '</table>'

?>

</body>
</html>


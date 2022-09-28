<html >
<head>
<title>Ejemplo prog. avanz. php 01</title>
</head>
<body>
<?php
$n = 26;
$m = 10;
$col = array("00", "0A", "14", "1E", "28", "32", "3C", "46", "50", "5A", "64", "6E", "78", "82", "8C", "96", "A0", "AA", "B4", "BE", "C8", "D2", "DC", "E6", "F0", "FA", "FD");
$col2 = array("0000", "3500", "9600", "9696", "96B4", "B4B4", "0096", "ff33", "33ff", "ff99");

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


<html>
<head>
</head>
<body>
<?php
include_once "class.Ambiente4.php";
$amb = new Ambiente(1000,800);
$amb ->generaEntesAlAzar(50,true);
$amb ->generaEntesAlAzar(10,false);

for ($k=0; $k<100 ; $k++){
    echo "\n";
    echo '<div id="amb_'.$k.'" style="display:none">';
    echo $amb->vistaSVG();
    echo "\n</div>'";
    $amb->mueve();
}
?>
<script>

    let actual = 0;

    function muestraSiguiente(){
        let nuevo = (actual === 99) ? 0 : (actual + 1);
        console.log(nuevo);
        document.getElementById('amb_'+actual).style.display='none';
        document.getElementById('amb_'+nuevo).style.display='';
        actual = nuevo;
        setTimeout(muestraSiguiente,20);
    }
    muestraSiguiente();
</script>
</body>
</html>

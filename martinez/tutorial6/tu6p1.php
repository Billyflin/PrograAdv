<?php
include_once "class.Ambiente.php";
$amb = new Ambiente(1000,800);
$amb ->generaEntesAlAzar(50,"#33AA44");
$amb ->generaEntesAlAzar(1,"#AA3344");
echo $amb->vistaSVG();
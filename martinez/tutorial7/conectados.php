<?php
$accion = $_GET['accion'];
$color = "";
$nombre = "";

if (isset($_GET['nombre'])) {
    $nombre = $_GET['nombre'];
}
if (isset($_GET['color'])) {
    $color = $_GET['color'];
}

if ($accion == 'agrega' && $color != '' && $nombre != '') {
    $con = arreglo_conectados();
    $neo['nombre'] = $nombre;
    $neo['color'] = $color;
    array_push($con, $neo);
    $resul = graba_conectados($con);
    if ($resul) {
        $ret['ok'] = 'yes';
        $ret['error'] = '';
    }
    else {
        $ret['ok'] = 'no';
        $ret['error'] = 'error desconocido al agregar';
    }
    echo json_encode($ret);
    return;
}
else if ($accion == 'agrega' && ($color == '' or $nombre == '')) {
    $ret['ok'] = 'no';
    $ret['error'] = 'faltan parámetros';
    echo json_encode($ret);
    return;
}
else if ($accion == "desconecta") {
    $con = arreglo_conectados();
    for ($k = 0; $k < sizeof($con); $k++) {
        if ($nombre == $con[$k]['nombre']) {
            unset($con[$k]);
            break;
        }
    }
    $resul = graba_conectados($con);
    if ($resul) {
        $ret['ok'] = 'yes';
        $ret['error'] = '';
    }
    else {
        $ret['ok'] = 'no';
        $ret['error'] = 'error desconocido al desconectar';
    }
    echo json_encode($ret);
    return;
}
else if ($accion == "todos") {
    $con = arreglo_conectados();
    $ret['ok'] = 'yes';
    $ret['error'] = '';
    $ret['conectados'] = $con;
    echo json_encode($ret);
    return;
}

function graba_conectados($con) {
    $archi = fopen("conectados.txt", "w");
    if (!$archi)
        return false;
    foreach ($con as $conectado) {
        fwrite($archi, $conectado['nombre'].",".$conectado['color'].PHP_EOL);
    }
    fclose($archi);
    return true;
}

function arreglo_conectados() {
    if (!file_exists("conectados.txt")) {
        return [];
    }
    $archi = fopen("conectados.txt", "r");
    $ret = [];
    $k = 0;
    while (!feof($archi)) {
        $campo = explode(",", str_replace(PHP_EOL, "", fgets($archi)));
        if (sizeof($campo) == 2) {
            $ret[$k]['nombre'] = $campo[0];
            $ret[$k]['color'] = $campo[1];
            $k++;
        }
    }
    fclose($archi);
    return $ret;
}
?>
<html>

<head>
</head>

<body>
    <?php
include_once "class.Ambiente3.php";

$ancho = $_GET["ancho"];
$alto = $_GET["alto"];
$diametro = $_GET["diametro"];
$contagiados = $_GET["contagiados"];
$ciclosContagio = $_GET["ciclosContagio"];
$densidad = $_GET["densidad"];
$maximo = intval($densidad / 100 * $alto * $ancho / pow($diametro, 2) / 10);

$sanos = $maximo - $contagiados;

$ciclos = 500;

$cicloActual = 0;

$amb = new Ambiente($ancho, $alto, 0.7);

$amb->generaEntesAlAzar($sanos, "s", $ciclosContagio);
$amb->generaEntesAlAzar($contagiados, "c", $ciclosContagio);

for ($ciclo = 0; $ciclo < $ciclos; $ciclo++) {
    echo "\n";
    echo '<div id="amb_' . $ciclo . '" style="display:none">';
    echo $amb->vistaSVG();
    echo "\n</div>'";
    $amb->mueve($ciclo);

    if ($amb->getContagiadosHistoricos() == $maximo) {
        $cicloActual = $ciclo + 1;
        break;
    }
}

echo "<div id='resultado' style='visibility: hidden'>\n";

if ($amb->getContagiadosHistoricos() == $maximo) {
    echo "<br><p>Finalizado: ${cicloActual}</p>";
}
else {
    echo "<br><p>Se llegó al máximo de ciclos ${ciclos} sin contagiar a todos</p>";
}
echo "\n</div>";
?>


    <script>
        var actual = 0;

        function mostrarResultado() {
            document.getElementById("resultado").style.visibility = "visible";
            document.getElementById("resultado").style.fontWeight = "bold";
            document.getElementById("resultado").style.fontSize = "25px";
        }

        function muestraSiguiente() {

            var nuevo = actual + 1;
            console.log(nuevo);

            try {
                document.getElementById("amb_" + actual).style.display = "none";
                document.getElementById("amb_" + nuevo).style.display = "";
                actual = nuevo;
                setTimeout(muestraSiguiente, 100);
            } catch (error) {
                if (error instanceof TypeError) {
                    document.getElementById("amb_" + actual).style.display = "";
                    console.log("FIN");
                    mostrarResultado();
                }
            }
        }

        muestraSiguiente();
    </script>
</body>

</html>
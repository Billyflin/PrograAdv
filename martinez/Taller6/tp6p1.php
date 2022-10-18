<html>

<head>
</head>

<body>
    <?php
include_once "class.Ambiente1.php";

$ancho = $_GET["ancho"];
$alto = $_GET["alto"];
$diametro = $_GET["diametro"];
$contagiados = $_GET["contagiados"];
$densidad = $_GET["densidad"];
$maximo = intval($densidad / 100 * $alto * $ancho / pow($diametro, 2) / 10);

$sanos = $maximo - $contagiados;

$ciclos = 500;

$cicloActual = 0;

$amb = new Ambiente($ancho, $alto);

$amb->generaEntesAlAzar($sanos, false);
$amb->generaEntesAlAzar($contagiados, true);

for ($ciclo = 0; $ciclo < $ciclos; $ciclo++) {
    echo "\n";
    echo '<div id="amb_' . $ciclo . '" style="display:none">';
    echo $amb->vistaSVG();
    echo "\n</div>'";
    $amb->mueve();

    if ($amb->calcularEntesContagiados() == $maximo) {
        $cicloActual = $ciclo + 1;
        break;
    }
}

echo "<div id='resultado' style='visibility: hidden'>\n";

if ($amb->calcularEntesContagiados() == $maximo) {
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
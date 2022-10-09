<?php
include_once('class.Ente4.php');

class Ambiente
{
    private $ancho;
    private $alto;
    private $entes;
    private $radio;


    function __construct($ancho_x, $alto_y)
    {
        $this->ancho = $ancho_x;
        $this->alto = $alto_y;
        $this->radio = 7;
        $this->entes = [];
    }

    function generaEnte($sano)
    {
        $delx = rand(0, 10) - 5;
        $dely = rand(0, 10) - 5;
        $cel = new Ente(rand(0, $this->ancho), rand(0, $this->alto), $delx, $dely, $sano);
        $this->entes[] = $cel;
    }

    function generaEntesAlAzar($cantidad, $sano)
    {
        for ($j = 0; $j < $cantidad; $j++) {
            $this->generaEnte($sano);
        }
    }

    function vistaSVG()
    {
        $contagiados = $this->contagiados();
        $noContagiados = count($this->entes) - $contagiados;
        echo "<h2>sanos: $noContagiados <br> contagiados: $contagiados</h2>";
        $ret = "<svg width='" . $this->ancho . "' height='" . $this->alto . "'>" . "\n";
        foreach ($this->entes as $ente) {
            $ret .= $ente->svg() . "\n";
        }
        $ret .= '</svg>';
        return $ret;
    }

    function contagiados()
    {
        $contagiados = 0;
        foreach ($this->entes as $ente) {
            if (!$ente->getSano()) {
                $contagiados++;
            }
        }
        return $contagiados;
    }

    function mueve()
    {
        foreach ($this->entes as $ente) {
            $ente->mueve(0, 0, $this->ancho, $this->alto);
            foreach ($this->entes as $otro) {
                $ente->contagia($otro);
            }
        }
    }
}

?>
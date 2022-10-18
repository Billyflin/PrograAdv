<?php
include_once("class.Ente1.php");

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

    function generaEnte($estaContagiado)
    {
        $delx = rand(0, 10) - 5;
        $dely = rand(0, 10) - 5;
        $cel = new Ente(rand(0, $this->ancho), rand(0, $this->alto), $delx, $dely, $estaContagiado);
        array_push($this->entes, $cel);
    }

    function generaEntesAlAzar($cantidad, $estaContagiado)
    {
        for ($j = 0; $j < $cantidad; $j++) {
            $this->generaEnte($estaContagiado);
        }
    }

    function vistaSVG()
    {
        $countEntesContagiados = $this->calcularEntesContagiados();
        $countEntesSanos = count($this->entes) - $countEntesContagiados;

        $ret = "<em>Contagiados: </em>" . $countEntesContagiados . "<br>";
        $ret .= "<em>Sanos: </em>" . $countEntesSanos . "<br>";
        $ret .= "<svg width='" . $this->ancho . "' height='" . $this->alto . "'>" . "\n";
        foreach ($this->entes as $ente) {
            $ret .= $ente->svg() . "\n";
        }
    
        $ret .= "</svg>";
        return $ret;
    }

    function calcularEntesContagiados(){
        $enfermos = 0;

        foreach ($this->entes as $ente) {
            if ($ente->estaContagiado()) {
                $enfermos++;
            }
        }
        return $enfermos;
    }
    function mueve()
    {
        foreach ($this->entes as $ente) {
            $ente->mueve(0, 0, $this->ancho, $this->alto);

            foreach ($this->entes as $otro) {
                if ($ente != $otro) {
                    $ente->contagia($otro);
                }
            }
        }
    }
}
?>
<?php
class Ente
{
    private $x;
    private $y;
    private $deltax;
    private $deltay;
    private $color;
    private $radio;

    private $estaContagiado;

    function __construct($pos_x, $pos_y, $velocidad_x, $velocidad_y, $estadoContagio)
    {
        $this->x = $pos_x;
        $this->y = $pos_y;
        $this->deltax = $velocidad_x;
        $this->deltay = $velocidad_y;
        $this->radio = 10;
        $this->estaContagiado = $estadoContagio;

        $this->color = !$this->estaContagiado ? "#33AA44" : "#AA3344";
    }

    function estaContagiado()
    {
        return $this->estaContagiado;
    }
    function fijaRadio($nuevoRadio)
    {
        $this->radio = $nuevoRadio;
    }

    function svg()
    {
        $ret = '<circle cx="&1" cy="&2" r="&3" stroke-width="0" fill="&4" />';
        $ret = str_replace("&1", $this->x, $ret);
        $ret = str_replace("&2", $this->y, $ret);
        $ret = str_replace("&3", $this->radio, $ret);
        $ret = str_replace("&4", $this->color, $ret);
        return $ret;
    }

    function mueve($minx, $miny, $maxx, $maxy)
    {
        $nuevo_x = $this->x + $this->deltax;
        $nuevo_y = $this->y + $this->deltay;
        if ($nuevo_x > $minx && $nuevo_x < $maxx) {
            $this->x = $nuevo_x;
        }
        else {
            $this->deltax *= -1;
            $this->x += $this->deltax;
        }

        if ($nuevo_y > $miny && $nuevo_y < $maxy) {
            $this->y = $nuevo_y;
        }
        else {
            $this->deltay *= -1;
            $this->y += $this->deltay;
        }
    }

    function calcularDistanciaConOtroEnte($otro)
    {
        $dist_x = $this->x - $otro->x;
        $dist_y = $this->y - $otro->y;

        return sqrt(pow($dist_x, 2) + pow($dist_y, 2));
    }

    function colisionaConOtro($otro)
    {
        return $this->calcularDistanciaConOtroEnte($otro) < $this->radio * 2;
    }

    function contagia($otro)
    {
        if ($this->colisionaConOtro($otro) && $this->estaContagiado && !$otro->estaContagiado) {
            $otro->estaContagiado = true;
            $otro->color = $this->color;
        }
    }
}
?>
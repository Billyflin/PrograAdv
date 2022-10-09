<?php

class Ente
{
    private $x;
    private $y;
    private $deltax;
    private $deltay;
    private $color;
    private $radio;

    function __construct($pos_x, $pos_y, $velocidad_x, $velocidad_y)
    {
        $this->x = $pos_x;
        $this->y = $pos_y;
        $this->deltax = $velocidad_x;
        $this->deltay = $velocidad_y;
        $this->color = '#000000';
        $this->radio = 10;
    }

    function fijaColor($nuevoColor)
    {
        $this->color = $nuevoColor;
    }

    function fijaRadio($nuevoRadio)
    {
        $this->radio = $nuevoRadio;
    }

    function svg()
    {
        $ret = '<circle cx="&1" cy="&2" r="&3" stroke-width="0" fill="&4" />';
        $ret = str_replace('&1', $this->x, $ret);
        $ret = str_replace('&2', $this->y, $ret);
        $ret = str_replace('&3', $this->radio, $ret);
        $ret = str_replace('&4', $this->color, $ret);
        return $ret;
    }

    function mueve($minx, $miny, $maxx, $maxy)
    {
        $nuevo_x = $this->x + $this->deltax;
        $nuevo_y = $this->y + $this->deltay;
        if ($nuevo_x > $minx && $nuevo_x < $maxx) {
            $this->x = $nuevo_x;
        } else {
            $this->deltax = -1;
            $this->x += $this->deltax;
        }

        if ($nuevo_y > $miny && $nuevo_y < $maxy) {
            $this->y = $nuevo_y;
        } else {
            $this->deltay = -1;
            $this->y += $this->deltay;
        }
    }
}
?>
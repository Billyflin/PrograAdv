<?php
class Ente
{
    private $x;
    private $y;
    private $deltax;
    private $deltay;
    private $colorActual;
    private $colores = ["sano" => "#33AA44", "contagiado" => "#AA3344", "inmune" => "#A333AA"];
    private $radio;

    private $estadoActual;
    private $estados = ["s" => "sano", "c" => "contagiado", "i" => "inmune"];

    private $ciclosContagio;

    private $asintomatico;

    function __construct($pos_x, $pos_y, $velocidad_x, $velocidad_y, $estado, $ciclosContagio)
    {
        $this->x = $pos_x;
        $this->y = $pos_y;
        $this->deltax = $velocidad_x;
        $this->deltay = $velocidad_y;
        $this->radio = 10;
        $this->fijarEstado($estado);
        $this->ciclosContagio = $ciclosContagio;
        $this->asintomatico = true;
    }

    function fijarSintomatico(){

        if($this->estaContagiado()){
            $this->asintomatico = false;
            return true;
        }
        return false;
    }
    
    function fijarColor()
    {
        $this->colorActual = $this->colores[$this->estadoActual];
    }
    function estaContagiado()
    {
        return $this->estadoActual == $this->estados["c"];
    }

    function estaSano() 
    {
        return $this->estadoActual == $this->estados["s"];
    }

    function esInmune()
    {
        return $this->estadoActual == $this->estados["i"];
    }

    function fijarEstado($estado)
    {
        $this->estadoActual = $this->estados[$estado];
        $this->fijarColor();
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
        $ret = str_replace("&4", $this->colorActual, $ret);
        return $ret;
    }

    function mueve($minx, $miny, $maxx, $maxy)
    {
        $nuevo_x = $this->x + $this->deltax;
        $nuevo_y = $this->y + $this->deltay;

        if($this->asintomatico){
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
    }

    function calcularDistanciaConOtroEnte($otro)
    {
        $dist_x = $this->x - $otro->x;
        $dist_y = $this->y - $otro->y;

        return sqrt(pow($dist_x, 2) + pow($dist_y, 2));
    }

    function inmuniza()
    {
        if ($this->ciclosContagio > 0) {
            $this->ciclosContagio--;
            return false;
        }
        $this->fijarEstado("i");
        $this->asintomatico = true;
        return true;
    }
    
    function colisionaConOtro($otro)
    {
        return $this->calcularDistanciaConOtroEnte($otro) < $this->radio * 2;
    }

    function contagia($otro)
    {
        if ($this->colisionaConOtro($otro) && $this->estaContagiado() && $otro->estaSano()) {
            $otro->estadoActual = $this->estadoActual;
            $otro->colorActual = $this->colorActual;
            return true;
        }
        return false;
    }
}
?>
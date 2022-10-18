<?php

include_once("class.Ente4.php");



class Ambiente
{

    private $ancho;
    private $alto;
    private $entes;
    private $radio;
    private $contagiadosIniciales;
    private $tasaSintomaticosPreferida;

    private $tasaMuertosPreferida;


    //Contadores (Los contadores aparecen porque sino 
    //se disparaba el O grande de la función mueve a O(n³)
    private $sanos;
    private $contagiados;
    private $inmunes;
    private $sintomaticos;

    private $muertos;

    function __construct($ancho_x, $alto_y, $tasaSintomaticos, $tasaMuertos)
    {
        $this->ancho = $ancho_x;
        $this->alto = $alto_y;
        $this->radio = 7;
        $this->entes = [];
        $this->tasaSintomaticosPreferida = $tasaSintomaticos;
        $this->tasaMuertosPreferida = $tasaMuertos;
        $this->inmunes = 0;
        $this->sintomaticos = 0;
        $this->muertos = 0;
    }

    function getTotal()
    {
        return $this->getContagiadosHistoricos() + $this->sanos;
    }

    function getContagiadosHistoricos()
    {
        return $this->contagiados + $this->inmunes + $this->muertos;
    }

    function generaEnte($estado, $ciclosContagio)
    {
        $delx = rand(0, 10) - 5;
        $dely = rand(0, 10) - 5;
        $cel = new Ente(rand(0, $this->ancho), rand(0, $this->alto), $delx, $dely, $estado, $ciclosContagio);
        array_push($this->entes, $cel);
    }



    function generaEntesAlAzar($cantidad, $estado, $ciclosContagio)
    {
        if ($estado == "s") {
            $this->sanos = $cantidad;
        }

        if ($estado == "c") {
            $this->contagiadosIniciales = $cantidad;
            $this->contagiados = $cantidad;
        }

        for ($j = 0; $j < $cantidad; $j++) {
            $this->generaEnte($estado, $ciclosContagio);
        }
    }



    function getEstadisticas()
    {
        $ret = "<h2>Estadísticas históricas</h2>";
        $ret .= "<em>Total: </em>" . $this->getTotal() . "<br>";
        $ret .= "<em>Sanos: </em>" . $this->sanos . "<br>";
        $ret .= "<em>Contagiados: </em>" . $this->contagiados . "<br>";
        $ret .= "<em>Contagiados Históricos: </em>" . $this->getContagiadosHistoricos() . "<br>";
        $ret .= "<em>Inmunes: </em>" . $this->inmunes . "<br>";
        $ret .= "<em>Sintomáticos: </em>" . $this->sintomaticos . "<br>";
        $ret .= "<em>Tasa de sintomáticos: </em>" . $this->tasaSintomaticos() . "<br>";
        $ret .= "<em>Tasa de sintomáticos esperada: </em>" . $this->tasaSintomaticosPreferida . "<br>";
        $ret .= "<em>Tasa de muertos esperada: </em>" . $this->tasaMuertosPreferida . "<br>";

        return $ret;
    }

    function vistaSVG()
    {
        $ret = $this->getEstadisticas();
        $ret .= "<svg width='" . $this->ancho . "' height='" . $this->alto . "'>" . "\n";
        foreach ($this->entes as $ente) {
            $ret .= $ente->svg() . "\n";
        }
        $ret .= "</svg>";
        return $ret;
    }



    function tasaSintomaticos()
    {
        $contagiadosHistoricos = $this->getContagiadosHistoricos();
        return ($contagiadosHistoricos - $this->contagiadosIniciales) / $contagiadosHistoricos;
    }

    function mueve()
    {
        foreach ($this->entes as $ente) {
            $ente->mueve(0, 0, $this->ancho, $this->alto);
            foreach ($this->entes as $otro) {
                if ($ente != $otro) {
                    $seHaContagiado = $ente->contagia($otro);

                    if ($seHaContagiado) {
                        $this->contagiados++;
                        $this->sanos--;

                        if ($this->tasaSintomaticos() < $this->tasaSintomaticosPreferida) {
                            $otro->fijarSintomatico();
                            $this->sintomaticos++;
                        }
                        if ($this->tasaSintomaticos() < $this->tasaMuertosPreferida) {
                            $otro->fijarSentenciado();
                        }
                    }
                }
            }

            if ($ente->estaContagiado()) {
                $seHaInmunizado = $ente->inmuniza();

                if ($seHaInmunizado) {
                    $this->contagiados--;
                    $this->inmunes++;
                }
            }

            if ($ente->estaSentenciado()) { 
                $seMurio = $ente->muere();

                if ($seMurio) {
                    $this->contagiados--;
                    $this->muertos++;
                }
            }
        }
    }
}

?>
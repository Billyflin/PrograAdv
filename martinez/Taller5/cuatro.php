<!DOCTYPE html>
<html lang="en">
<head>
    <title>Primer Formulario</title>
</head>
<body>
<?php

$color = $_GET['color'];
$row = $_GET['row'];
$col = $_GET['col'] + 1;


function get($color, $row, $col): void
{
    $gradiente = 20 / $row;
    $deg = $color - 12;
    $light = 100 / $col;
    echo "<table  cellpadding='0' cellspacing='1px' >";
    for ($j = 0; $j < $col; $j++) {
        echo "<tr>";
        for ($i = 0; $i < $row; $i++) {
            $l = $light * $j;
            $hsl = "hsl(" . ($deg + ($gradiente * $i)) . ", 100%, $l%)";
            if ($l < 95 && $l > 7) {
                $color_hex= hslToHex(($deg + ($gradiente * $i)), 100, $l);
                echo "<td onclick="."alert(id)"." id='$color_hex' style='background-color: $hsl; width: 50px; height: 50px; '></td>";
            }
        }
    }
}

// Funcion para convertir de HSL a HEX

function degPercPercToHsl($h, $s, $l) {
	//convert h, s, and l back to the 0-1 range

	//convert the hue's 360 degrees in a circle to 1
	$h /= 360;

	//convert the saturation and lightness to the 0-1
	//range by multiplying by 100
	$s /= 100;
	$l /= 100;

	$hsl['h'] =  $h;
	$hsl['s'] = $s;
	$hsl['l'] = $l;

	return $hsl;
}

function hslToRgb($h, $s, $l){
	$hsl = degPercPercToHsl($h, $s, $l);
	$h = $hsl['h'];
	$s = $hsl['s'];
	$l = $hsl['l'];

	//If there's no saturation, the color is a greyscale,
	//so all three RGB values can be set to the lightness.
	//(Hue doesn't matter, because it's grey, not color)
	if ($s == 0) {
   		$r = $l * 255;
   		$g = $l * 255;
   		$b = $l * 255;
	}
	else {
		//calculate some temperary variables to make the
		//calculation eaisier.
   		if ($l < 0.5) {
   			$temp2 = $l * (1 + $s);
   		} else {
   			$temp2 = ($l + $s) - ($s * $l);
   		}
   		$temp1 = 2 * $l - $temp2;

		//run the calculated vars through hueToRgb to
		//calculate the RGB value.  Note that for the Red
		//value, we add a third (120 degrees), to adjust
		//the hue to the correct section of the circle for
		//red.  Simalarly, for blue, we subtract 1/3.
   		$r = 255 * hueToRgb($temp1, $temp2, $h + (1 / 3));
   		$g = 255 * hueToRgb($temp1, $temp2, $h);
   		$b = 255 * hueToRgb($temp1, $temp2, $h - (1 / 3));
	}

	$rgb['r'] = $r;
	$rgb['g'] = $g;
	$rgb['b'] = $b;

	return $rgb;
}

function hueToRgb($temp1, $temp2, $hue) {
   	if ($hue < 0) {
   		$hue += 1;
   	}
   	if ($hue > 1) {
   		$hue -= 1;
   	}

   	if ((6 * $hue) < 1 ) {
   		return ($temp1 + ($temp2 - $temp1) * 6 * $hue);
   	} elseif ((2 * $hue) < 1 ) {
   		return $temp2;
   	} elseif ((3 * $hue) < 2 ) {
   		return ($temp1 + ($temp2 - $temp1) * ((2 / 3) - $hue) * 6);
   	}
   	return $temp1;
}


function hslToHex($h, $s, $l, $prependPound = true) {
	//convert hsl to rgb
	$rgb = hslToRgb($h,$s,$l);

	//convert rgb to hex
	$hexR = $rgb['r'];
	$hexG = $rgb['g'];
	$hexB = $rgb['b'];

	//round to the nearest whole number
	$hexR = round($hexR);
	$hexG = round($hexG);
	$hexB = round($hexB);

	//convert to hex
	$hexR = dechex($hexR);
	$hexG = dechex($hexG);
	$hexB = dechex($hexB);

	//check for a non-two string length
	//if it's 1, we can just prepend a
	//0, but if it is anything else non-2,
	//it must return false, as we don't
	//know what format it is in.
	if (strlen($hexR) != 2) {
		if (strlen($hexR) == 1) {
			//probably in format #0f4, etc.
			$hexR = "0" . $hexR;
		} else {
			//unknown format
			return false;
		}
	}
	if (strlen($hexG) != 2) {
		if (strlen($hexG) == 1) {
			$hexG = "0" . $hexG;
		} else {
			return false;
		}
	}
	if (strlen($hexB) != 2) {
		if (strlen($hexB) == 1) {
			$hexB = "0" . $hexB;
		} else {
			return false;
		}
	}

	//if prependPound is set, will prepend a
	//# sign to the beginning of the hex code.
	//(default = true)
	$hex = "";
	if ($prependPound) {
		$hex = "#";
	}

	$hex = $hex . $hexR . $hexG . $hexB;

	return $hex;
}


get($color, $row, $col);
?>

<h1 id="div"></h1>
</body>
</html>
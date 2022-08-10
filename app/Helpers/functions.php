<?php

// Retorna uma string do tipo rgb(255,255,255) com os valores RGB
if (! function_exists('hex2Rgb'))
{
    function hex2Rgb($hex): String
    {

        $hex = str_replace("#", "", $hex);

        if(strlen($hex) == 3) {
            $r = hexdec(substr($hex,0,1).substr($hex,0,1));
            $g = hexdec(substr($hex,1,1).substr($hex,1,1));
            $b = hexdec(substr($hex,2,1).substr($hex,2,1));
        } else {
            $r = hexdec(substr($hex,0,2));
            $g = hexdec(substr($hex,2,2));
            $b = hexdec(substr($hex,4,2));
        }
            $rgbArray = array($r, $g, $b);



            return  $rgb ="rgb(" . $rgbArray[0] . ", " . $rgbArray[1] . ", " . $rgbArray[2]. ")";
    }

}

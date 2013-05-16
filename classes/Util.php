<?php
class Util
{

    public static function crop($string, $longueur) {
        if (strlen($string) <= $longueur)
            return $string;
        return substr($string, 0, $longueur) . '...';
    }

}
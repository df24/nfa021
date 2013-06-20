<?php
class Util
{

    public static function crop($string, $longueur) {
        if (strlen($string) <= $longueur)
            return $string;
        return substr($string, 0, $longueur) . '...';
    }

    public static function ToMysqlDate($date) {
        if (preg_match('`^\d{2}/\d{2}/\d{4}$`', $date)) {
            return substr($date, 6, 4) . '-' . substr($date, 3, 2) . '-' . substr($date, 0, 2);
        }
        return $date;
    }

    public static function ToFrDate($date) {
        if (preg_match('`^\d{4}-\d{2}-\d{2}$`', $date)) {
            return substr($date, 8, 2) . '/' . substr($date, 5, 2) . '/' . substr($date, 0, 4);
        }
        return $date;
    }

}
<?php

function pluralForm($number, $one, $two, $many) {
    $mod10 = $number % 10;
    $mod100 = $number % 100;
    if ($mod10 == 1 && $mod100 != 11) {
        return $one;
    }
    if ($mod10 >= 2 && $mod10 <= 4 && ($mod100 < 10 || $mod100 >= 20)) {
        return $two;
    }
    return $many;
}
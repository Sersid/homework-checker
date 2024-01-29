<?php
// сюда копируется содержимое файла
function convertString(string $a, string $b) : string
{
    $pattern = '/^[a-z0-9]+$/i';
    if (preg_match($pattern, $a)) {
        if ((strlen($a) > strlen($b)) && !empty($b)) {
            if (substr_count($a, $b) >= 2) {
                $indexOne = strpos($a, $b) + strlen($b);
                $indexTwo = strpos($a, $b, $indexOne);
                $replace = strrev($b);
                return substr_replace($a, $replace, $indexTwo, strlen($b));
            } else {
                throw new \RuntimeException('$b не входит в $a или входит, но только 1 раз');
            }
        } else {
            throw new \RuntimeException('$a и $b должны быть не пустые, причем длина $a должна быть больше $b');
        }
    } else {
        throw new \RuntimeException('строка $a может содержать только латинские буквы и цифры');
    }
}
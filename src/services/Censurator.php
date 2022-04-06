<?php

namespace App\services;

use PhpParser\Node\Scalar\String_;

class Censurator
{
    const GROS_MOTS = ["con", "merde"];

    public function purify(
        string $text
    ): string
    {
        foreach (self::GROS_MOTS as $grosMot){
            $texteARemplacer = str_repeat("*", mb_strlen($grosMot));
            $text = str_ireplace($grosMot, $texteARemplacer, $text);
            // $text = str_ireplace($grosMot,"***", $text);
        }
        return $text;
    }
}
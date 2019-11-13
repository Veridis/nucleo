<?php

namespace Nucleo;

class Nucleo
{
    private function __construct()
    {
    }

    public static function run(): void
    {
        $expression = null;
        while (true) {
            $expression = readline('nucleo > ');
            if ('exit' === $expression) {
                break;
            }

            echo "$expression\n";
        }
    }
}
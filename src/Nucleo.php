<?php

namespace Nucleo;

use Nucleo\Lexer\Lexer;
use Nucleo\Stream\StreamFactory;

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

            $lexer = new Lexer(StreamFactory::fromString($expression));
            $lexer->lex();
        }
    }
}
<?php

namespace Nucleo\Lexer;


use Psr\Http\Message\StreamInterface;

class Lexer
{
    /** @var StreamInterface */
    private $stream;

    public function __construct(StreamInterface $stream)
    {
        $this->stream = $stream;
    }

    public function lex(): void
    {
        echo (string) $this->stream;
    }
}
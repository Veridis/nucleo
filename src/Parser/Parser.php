<?php

namespace Nucleo\Parser;

use Nucleo\Lexer\Token;

class Parser
{
    /** @var \Generator|Token[] */
    private $tokens;

    private function __construct(\Generator $tokens, string $expressionDelimiter = ';')
    {
        $this->tokens = $tokens;
    }

    public static function fromTokens(\Generator $tokens)
    {
        return new self($tokens, ';');
    }

    public function parse(): void
    {
        while($this->tokens->valid()) {
            echo $this->tokens->current() . "\n";
            $this->tokens->next();
        }
    }

}

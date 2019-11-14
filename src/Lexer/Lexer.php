<?php

namespace Nucleo\Lexer;


use Psr\Http\Message\StreamInterface;

class Lexer
{
    /** @var StreamInterface */
    private $stream;

    /** @var Token[] */
    private $tokens;

    public function __construct(StreamInterface $stream)
    {
        $this->stream = $stream;
        $this->tokens = [];
    }

    public function lex(): void
    {
        $this->stream->rewind();
        while (!$this->stream->eof()) {
            $currentChar = $this->stream->read(1);
            if ('' === $currentChar) {
                break;
            }

            if ($this->isWhiteSpace($currentChar)) {
                continue;
            } elseif ('+' === $currentChar) {
                $this->tokens[] = Token::plus();
            } elseif ('-' === $currentChar) {
                $this->tokens[] = Token::minus();
            } elseif ('*' === $currentChar) {
                $this->tokens[] = Token::multiply();
            } elseif ('/' === $currentChar) {
                $this->tokens[] = Token::divide();
            } elseif ('(' === $currentChar) {
                $this->tokens[] = Token::leftParenthesis();
            } elseif (')' === $currentChar) {
                $this->tokens[] = Token::rightParenthesis();
            } elseif ($this->isInt($currentChar)) {
                $this->tokens[] = Token::int($this->scan($currentChar, '/^\d+$/'));
            } else {
                throw new \Exception(sprintf('invalid char "%s"', $currentChar));
            }
        }
    }

    /**
     * @return Token[]
     */
    public function getTokens(): array
    {
        return $this->tokens;
    }

    private function isWhiteSpace(string $currentChar): bool
    {
        return \in_array($currentChar, [' ', "\n", "\t"], true);
    }

    private function scan(string $currentChar, string $regex): string
    {
        $tokenValue = $currentChar;
        while (1 === preg_match($regex, $nextChar = $this->stream->read(1))) {
            $tokenValue .= $nextChar;
        }

        if ('' !== $nextChar) {
            // we need to rewind 1 char from the current position because the last char was not matched
            $this->stream->seek(-1, SEEK_CUR);
        }

        return $tokenValue;
    }

    private function isInt(string $currentChar): bool
    {
        return 1 === preg_match('/^\d$/', $currentChar);
    }
}
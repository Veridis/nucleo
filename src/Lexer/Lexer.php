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

    /**
     * @return \Generator|Token[]
     */
    public function lex(): \Generator
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
                yield Token::plus();
            } elseif ('-' === $currentChar) {
                yield Token::minus();
            } elseif ('*' === $currentChar) {
                yield Token::multiply();
            } elseif ('/' === $currentChar) {
                yield Token::divide();
            } elseif ('(' === $currentChar) {
                yield Token::leftParenthesis();
            } elseif (')' === $currentChar) {
                yield Token::rightParenthesis();
            } elseif ($this->isInt($currentChar)) {
                yield Token::int($this->scan($currentChar, '/^\d+$/'));
            } else {
                throw new \Exception(sprintf('invalid char "%s"', $currentChar));
            }
        }
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
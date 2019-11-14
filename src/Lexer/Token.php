<?php

namespace Nucleo\Lexer;

class Token
{
    /** @var string */
    private $type;

    /** @var null|string */
    private $value;

    private function __construct(string $type, ?string $value = null)
    {
        $this->type = $type;
        $this->value = $value;
    }

    public static function int(string $value): self
    {
        return new self(TokenTypes::INT, $value);
    }

    public static function float(string $value): self
    {
        return new self(TokenTypes::FLOAT, $value);
    }

    public static function bool(string $value): self
    {
        return new self(TokenTypes::BOOL, $value);
    }

    public static function plus(): self
    {
        return new self(TokenTypes::PLUS);
    }

    public static function minus(): self
    {
        return new self(TokenTypes::MINUS);
    }

    public static function multiply(): self
    {
        return new self(TokenTypes::MULT);
    }

    public static function divide(): self
    {
        return new self(TokenTypes::DIV);
    }

    public static function leftParenthesis(): self
    {
        return new self(TokenTypes::LEFT_PARENTHESIS);
    }

    public static function rightParenthesis(): self
    {
        return new self(TokenTypes::RIGHT_PARENTHESIS);
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return null !== $this->value
            ? sprintf('%s:%s', $this->type, $this->value)
            : $this->type;
    }
}
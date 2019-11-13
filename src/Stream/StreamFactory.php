<?php

namespace Nucleo\Stream;

use Psr\Http\Message\StreamInterface;
use Sunrise\Stream\StreamFactory as BaseStreamFactory;

class StreamFactory extends BaseStreamFactory
{
    public static function fromString(string $content = ''): StreamInterface
    {
        return (new StreamFactory())->createStream($content);
    }

    public function fromFile(string $filename, string $mode = 'r'): StreamInterface
    {
        return (new StreamFactory())->createStreamFromFile($filename, $mode);
    }

    public function fromResource($resource): StreamInterface
    {
        return (new StreamFactory())->createStreamFromResource($resource);
    }
}
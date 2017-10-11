<?php

namespace OpenSdk\Framework\Resource;

interface DecoderInterface
{
    /**
     * Decode the response of the resource factory to a PHP array.
     */
    public function toArray(Factory $factory): array;
}

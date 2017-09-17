<?php

namespace app\models;

use app\exception\InvalidApiResponseException;

abstract class AbstractNormalizable implements NormalizableInterface
{
    public static function fromArray(array $data): NormalizableInterface
    {
        static::validate($data);
        return static::build($data);
    }

    protected static function validate(array $data): void
    {
        $missingRequiredKeys = array_diff(static::getRequiredKeys(), array_keys($data));
        if (0 !== count($missingRequiredKeys)) {
            throw new InvalidApiResponseException(sprintf('Expected keys: [%s]', implode(',', $data)));
        }
    }

    abstract protected static function getRequiredKeys(): array;

    abstract protected static function build(array $data): AbstractNormalizable;
}

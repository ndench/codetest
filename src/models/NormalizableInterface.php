<?php

namespace app\models;

interface NormalizableInterface
{
    public static function fromArray(array $data): NormalizableInterface;
    public function toArray(): array;
}

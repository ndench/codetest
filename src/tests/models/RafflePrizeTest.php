<?php

namespace models;

use app\exception\InvalidApiResponseException;
use app\models\RafflePrize;
use PHPUnit\Framework\TestCase;

class RafflePrizeTest extends TestCase
{
    public function testFromArrayInvalid()
    {
        $this->expectException(InvalidApiResponseException::class);
        RafflePrize::fromArray([]);
    }

    public function testFromArray()
    {
        $cardTitle = 'You shall not card';
        $name = 'Mr Dench';
        $description = 'Mr Dench will write code for you';
        $exact = true;
        $image = 'hackertyper.net';
        $value = '$9999999999999 AUD';

        /** @var RafflePrize $prize */
        $prize = RafflePrize::fromArray([
            'card_title' => $cardTitle,
            'name' => $name,
            'description' => $description,
            'value_is_exact' => $exact,
            'edm_image' => $image,
            'value' => [
                'amount' => '9999999999999',
                'currency' => 'AUD'
            ],
        ]);

        static::assertInstanceOf(RafflePrize::class, $prize);
        static::assertSame($cardTitle, $prize->getCardTitle());
        static::assertSame($name, $prize->getName());
        static::assertSame($description, $prize->getDescription());
        static::assertSame($exact, $prize->isExact());
        static::assertSame($image, $prize->getImage());
        static::assertSame($value, $prize->getValue());
    }

    public function testToArray()
    {
        $cardTitle = 'You shall not card';
        $name = 'Mr Dench';
        $description = 'Mr Dench will write code for you';
        $exact = true;
        $image = 'hackertyper.net';
        $value = '$9999999999999 AUD';

        /** @var RafflePrize $prize */
        $prize = RafflePrize::fromArray([
            'card_title' => $cardTitle,
            'name' => $name,
            'description' => $description,
            'value_is_exact' => $exact,
            'edm_image' => $image,
            'value' => [
                'amount' => '9999999999999',
                'currency' => 'AUD'
            ],
        ]);

        $expected = [
            'cardTitle' => $cardTitle,
            'name' => $name,
            'description' => $description,
            'exact' => $exact,
            'image' => $image,
            'value' => $value,
        ];

        static::assertSame($expected, $prize->toArray());
    }
}

<?php

namespace models;

use app\exception\InvalidApiResponseException;
use app\models\RaffleOffer;
use PHPUnit\Framework\TestCase;

class RaffleOfferTest extends TestCase
{
    public function testFromArrayInvalid()
    {
        $this->expectException(InvalidApiResponseException::class);
        RaffleOffer::fromArray([]);
    }

    public function testFromArray()
    {
        $name = 'This be my offer';
        $key = 'offer-key';
        $numTickets = 99999999;
        $price = '$0.5 AUD';
        $ribbon = 'plz buy me, kind sir :/';

        /** @var RaffleOffer $offer */
        $offer = RaffleOffer::fromArray([
            'name'        => $name,
            'key'         => $key,
            'num_tickets' => $numTickets,
            'price'       => [
                'amount'   => '0.5',
                'currency' => 'AUD',
            ],
            'ribbon'      => $ribbon,
        ]);

        static::assertInstanceOf(RaffleOffer::class, $offer);
        static::assertSame($name, $offer->getName());
        static::assertSame($key, $offer->getKey());
        static::assertSame($numTickets, $offer->getNumTickets());
        static::assertSame($price, $offer->getPrice());
        static::assertSame($ribbon, $offer->getRibbon());
    }

    public function testToArray()
    {
        $name = 'This be my offer';
        $key = 'offer-key';
        $numTickets = 99999999;
        $price = '$0.5 AUD';
        $ribbon = 'plz buy me, kind sir :/';

        /** @var RaffleOffer $offer */
        $offer = RaffleOffer::fromArray([
            'name'        => $name,
            'key'         => $key,
            'num_tickets' => $numTickets,
            'price'       => [
                'amount'   => '0.5',
                'currency' => 'AUD',
            ],
            'ribbon'      => $ribbon,
        ]);

        $expected = [
            'name'       => $name,
            'key'        => $key,
            'numTickets' => $numTickets,
            'price'      => $price,
            'ribbon'     => $ribbon,
        ];

        static::assertSame($expected, $offer->toArray());
    }
}

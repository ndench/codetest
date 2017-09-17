<?php

namespace models;

use app\exception\InvalidApiResponseException;
use app\models\RaffleDraw;
use app\models\RaffleOffer;
use app\models\RafflePrize;
use PHPUnit\Framework\TestCase;

class RaffleDrawTest extends TestCase
{
    protected $prize;
    protected $offer;

    public function setUp()
    {
        $this->prize = [
            'card_title' => 'Mr',
            'name' => 'Dench',
            'description' => 'Mr Dench Owns This Prize',
            'value_is_exact' => false,
            'edm_image' => 'hackertyper.net',
            'value' => [
                'amount' => '100',
                'currency' => 'AUD'
            ],
        ];

        $this->offer = [
            'name' => 'Offer me something',
            'key' => 'For your life',
            'num_tickets' => 1,
            'price' => [
                'amount' => 'infinity',
                'currency' => 'AUD'
            ],
            'ribbon' => 'You need this',
        ];
    }

    public function testFromArrayInvalid()
    {
        $this->expectException(InvalidApiResponseException::class);
        RaffleDraw::fromArray([]);
    }

    public function testFromArray()
    {
        $name = 'I dare you';
        $description = 'Go ahead, draw one.';
        $number = 666;
        $start = '2017-09-30T22:55:00+1000';
        $end = '2017-10-01T00:00:00+1000';
        $termsUrl = 'dench.com/terms-of-code.php';

        /** @var RaffleDraw $draw */
        $draw = RaffleDraw::fromArray([
            'name' => $name,
            'description' => $description,
            'draw_number' => $number,
            'draw_date' => $start,
            'draw_stop' => $end,
            'terms_and_conditions_url' => $termsUrl,
            'prize' => $this->prize,
            'offers' => [$this->offer],
        ]);

        static::assertInstanceOf(RaffleDraw::class, $draw);
        static::assertSame($name, $draw->getName());
        static::assertSame($description, $draw->getDescription());
        static::assertSame($number, $draw->getNumber());
        static::assertEquals(new \DateTime($start), $draw->getStart());
        static::assertEquals(new \DateTime($end), $draw->getEnd());
        static::assertSame($termsUrl, $draw->getTermsUrl());
        static::assertInstanceOf(RafflePrize::class, $draw->getPrize());
        static::assertCount(1, $draw->getOffers());
        static::assertInstanceOf(RaffleOffer::class, $draw->getOffers()[0]);
    }

    public function testToArray()
    {
        $name = 'I dare you';
        $description = 'Go ahead, draw one.';
        $number = 666;
        $start = '2017-09-30T22:55:00+1000';
        $end = '2017-10-01T00:00:00+1000';
        $termsUrl = 'dench.com/terms-of-code.php';

        /** @var RaffleDraw $draw */
        $draw = RaffleDraw::fromArray([
            'name' => $name,
            'description' => $description,
            'draw_number' => $number,
            'draw_date' => $start,
            'draw_stop' => $end,
            'terms_and_conditions_url' => $termsUrl,
            'prize' => $this->prize,
            'offers' => [$this->offer],
        ]);

        $expected = [
            'name' => $name,
            'description' => $description,
            'number' => $number,
            'startDate' => (new \DateTime($start))->format('d.m.Y H:i:s'),
            'endDate' => (new \DateTime($end))->format('d.m.Y H:i:s'),
            'termsUrl' => $termsUrl,
        ];

        $actual = $draw->toArray();
        static::assertArrayHasKey('prize', $actual);
        static::assertArrayHasKey('offers', $actual);
        static::assertCount(1, $actual['offers']);

        // We have already tested toArray for offer and prize
        unset($actual['prize'], $actual['offers']);

        static::assertSame($expected, $actual);
    }
}

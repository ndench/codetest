<?php

namespace models;

use app\exception\InvalidApiResponseException;
use app\models\Lottery;
use app\models\RaffleDraw;
use app\models\RaffleTicket;
use PHPUnit\Framework\TestCase;

class RaffleTicketTest extends TestCase
{
    protected $prize;

    protected $offer;

    protected $draw;

    protected $lottery;

    public function setUp()
    {
        $this->prize = [
            'card_title'     => 'Mr',
            'name'           => 'Dench',
            'description'    => 'Mr Dench Owns This Prize',
            'value_is_exact' => false,
            'edm_image'      => 'hackertyper.net',
            'value'          => [
                'amount'   => '100',
                'currency' => 'AUD',
            ],
        ];

        $this->offer = [
            'name'        => 'Offer me something',
            'key'         => 'For your life',
            'num_tickets' => 1,
            'price'       => [
                'amount'   => 'infinity',
                'currency' => 'AUD',
            ],
            'ribbon'      => 'You need this',
        ];

        $this->draw = [
            'name'                     => 'I dare you',
            'description'              => 'Go ahead, draw one.',
            'draw_number'              => 666,
            'draw_date'                => '2017-09-30T22:55:00+1000',
            'draw_stop'                => '2017-10-01T00:00:00+1000',
            'terms_and_conditions_url' => 'dench.com/terms-of-code.php',
            'prize'                    => $this->prize,
            'offers'                   => [$this->offer],
        ];

        $this->lottery = [
            'id'         => 'MEGA_LOTTERY_BUCKS',
            'name'       => 'Super Nintendo Lottery',
            'desc'       => 'A lottery to win Mario as a slave',
            'multidraw'  => true,
            'type'       => 'Draw names from a hat',
            'icon_url'   => 'nintendo.com/mario.jpg',
            'play_url'   => 'nintendo.com/lottery/mario',
            'lottery_id' => 1,
        ];
    }

    public function testFromArrayInvalid()
    {
        $this->expectException(InvalidApiResponseException::class);
        RaffleTicket::fromArray([]);
    }

    public function testFromArray()
    {
        $name = 'The Greatest Super Awesome Raffle';
        $key = 'SUPER_RAFFLE_AWESOMENESS';
        $autoPlayable = 'sometimes';

        /** @var RaffleTicket $ticket */
        $ticket = RaffleTicket::fromArray([
            'draw'         => $this->draw,
            'lottery'      => $this->lottery,
            'name'         => $name,
            'key'          => $key,
            'autoplayable' => $autoPlayable,
        ]);

        static::assertInstanceOf(RaffleTicket::class, $ticket);
        static::assertSame($name, $ticket->getName());
        static::assertSame($key, $ticket->getKey());
        static::assertSame($autoPlayable, $ticket->getAutoPlayable());
        static::assertInstanceOf(RaffleDraw::class, $ticket->getDraw());
        static::assertInstanceOf(Lottery::class, $ticket->getLottery());
    }

    public function testToArray()
    {
        $name = 'The Greatest Super Awesome Raffle';
        $key = 'SUPER_RAFFLE_AWESOMENESS';
        $autoPlayable = 'sometimes';

        /** @var RaffleTicket $ticket */
        $ticket = RaffleTicket::fromArray([
            'draw'         => $this->draw,
            'lottery'      => $this->lottery,
            'name'         => $name,
            'key'          => $key,
            'autoplayable' => $autoPlayable,
        ]);

        $expected = [
            'name'         => $name,
            'key'          => $key,
            'autoPlayable' => $autoPlayable,
        ];

        $actual = $ticket->toArray();

        static::assertArrayHasKey('draw', $actual);
        static::assertArrayHasKey('lottery', $actual);

        // We have already tested toArray for draw and lottery
        unset($actual['draw'], $actual['lottery']);

        static::assertSame($expected, $actual);
    }
}

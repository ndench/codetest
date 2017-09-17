<?php

namespace models;

use app\exception\InvalidApiResponseException;
use app\models\Lottery;
use PHPUnit\Framework\TestCase;

class LotteryTest extends TestCase
{
    public function testFromArrayInvalid()
    {
        $this->expectException(InvalidApiResponseException::class);
        Lottery::fromArray([]);
    }

    public function testFromArray()
    {
        $id = 'MEGA_LOTTERY_BUCKS';
        $name = 'Super Nintendo Lottery';
        $description = 'A lottery to win Mario as a slave';
        $multidraw = true;
        $type = 'Draw names from a hat';
        $iconUrl = 'nintendo.com/mario.jpg';
        $playUrl = 'nintendo.com/lottery/mario';
        $lotteryId = 1;

        /** @var Lottery $lottery */
        $lottery = Lottery::fromArray([
            'id' => $id,
            'name' => $name,
            'desc' => $description,
            'multidraw' => $multidraw,
            'type' => $type,
            'icon_url' => $iconUrl,
            'play_url' => $playUrl,
            'lottery_id' => $lotteryId,
        ]);

        static::assertInstanceOf(Lottery::class, $lottery);
        static::assertSame($id, $lottery->getId());
        static::assertSame($name, $lottery->getName());
        static::assertSame($description, $lottery->getDescription());
        static::assertSame($multidraw, $lottery->isMultidraw());
        static::assertSame($type, $lottery->getType());
        static::assertSame($iconUrl, $lottery->getIconUrl());
        static::assertSame($playUrl, $lottery->getPlayUrl());
        static::assertSame($lotteryId, $lottery->getLotteryId());
    }

    public function testToArray()
    {
        $id = 'MEGA_LOTTERY_BUCKS';
        $name = 'Super Nintendo Lottery';
        $description = 'A lottery to win Mario as a slave';
        $multidraw = true;
        $type = 'Draw names from a hat';
        $iconUrl = 'nintendo.com/mario.jpg';
        $playUrl = 'nintendo.com/lottery/mario';
        $lotteryId = 1;

        /** @var Lottery $lottery */
        $lottery = Lottery::fromArray([
            'id' => $id,
            'name' => $name,
            'desc' => $description,
            'multidraw' => $multidraw,
            'type' => $type,
            'icon_url' => $iconUrl,
            'play_url' => $playUrl,
            'lottery_id' => $lotteryId,
        ]);

        $expected = [
            'id' => $id,
            'name' => $name,
            'description' => $description,
            'multidraw' => $multidraw,
            'type' => $type,
            'icon' => $iconUrl,
            'playUrl' => $playUrl,
            'lotteryId' => $lotteryId,
        ];

        static::assertSame($expected, $lottery->toArray());
    }
}

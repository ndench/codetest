<?php

namespace app\serializer\handler;

use app\models\Lottery;
use app\models\LotteryTicket;
use app\models\RaffleTicket;
use app\models\TicketInterface;
use JMS\Serializer\Context;
use JMS\Serializer\GraphNavigator;
use JMS\Serializer\Handler\SubscribingHandlerInterface;
use JMS\Serializer\JsonDeserializationVisitor;
use JMS\Serializer\TypeParser;

class LotteryHandler implements SubscribingHandlerInterface
{
    /**
     * {@inheritdoc}
     */
    public static function getSubscribingMethods(): array
    {
        return [
            [
                'direction' => GraphNavigator::DIRECTION_DESERIALIZATION,
                'format' => 'json',
                'type' => Lottery::class,
                'method' => 'deserializeLottery',
            ],
        ];
    }

    public static function deserializeLottery(JsonDeserializationVisitor $visitor, array $data, $type, Context $context)
    {
        static::validateLottery($data);

        return (new Lottery())
            ->setId($data['id'])
            ->setName($data['name'])
            ->setDescription($data['desc'])
            ->setMultidraw(filter_var($data['multidraw'], FILTER_VALIDATE_BOOLEAN))
            ->setType($data['type'])
            ->setIconUrl($data['icon_url'])
            ->setPlayUrl($data['play_url'])
            ->setLotteryId(filter_var($data['lottery_id'], FILTER_VALIDATE_INT))
        ;
    }

    protected static function validateLottery(array $lottery)
    {
        $required = [
            'id',
            'name',
            'desc',
            'multidraw',
            'type',
            'icon_url',
            'play_url',
            'lottery_id',
        ];

        $missingRequiredKeys = array_diff($required, array_keys($lottery));
        if (0 !== count($missingRequiredKeys)) {
            // TODO: custom exception
            throw new \Exception('invalid ticket');
        }
    }
}

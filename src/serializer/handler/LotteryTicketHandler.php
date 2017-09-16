<?php

namespace app\serializer\handler;

use app\models\LotteryTicket;
use JMS\Serializer\Context;
use JMS\Serializer\GraphNavigator;
use JMS\Serializer\Handler\SubscribingHandlerInterface;
use JMS\Serializer\JsonDeserializationVisitor;

class LotteryTicketHandler implements SubscribingHandlerInterface
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
                'type' => LotteryTicket::class,
                'method' => 'deserializeLotteryTicket',
            ],
        ];
    }

    public static function deserializeLotteryTicket(JsonDeserializationVisitor $visitor, array $data, $type, Context $context)
    {
        static::validateTicket($data);

        $ticket = (new LotteryTicket())
            ->setName($data['name'])
            ->setKey($data['key'])
            ->setAutoPlayable($data['autoplayable'])
        ;

        return $ticket;
    }

    protected static function validateTicket(array $ticket)
    {
        $required = [
            'type',
            'key',
            'name',
            'autoplayable',
            'game_types',
            'draws',
            'days',
            'addons',
            'quickpick_sizes',
        ];

        $missingRequiredKeys = array_diff($required, array_keys($ticket));
        if (0 !== count($missingRequiredKeys)) {
            // TODO: custom exception
            throw new \Exception('invalid ticket');
        }
    }
}

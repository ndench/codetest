<?php

namespace app\serializer\handler;

use app\models\RaffleTicket;
use JMS\Serializer\Context;
use JMS\Serializer\GraphNavigator;
use JMS\Serializer\Handler\SubscribingHandlerInterface;
use JMS\Serializer\JsonDeserializationVisitor;

class RaffleTicketHandler implements SubscribingHandlerInterface
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
                'type' => RaffleTicket::class,
                'method' => 'deserializeRaffleTicket',
            ],
        ];
    }

    public static function deserializeRaffleTicket(JsonDeserializationVisitor $visitor, array $data, $type, Context $context)
    {
        static::validateTicket($data);

        $ticket = (new RaffleTicket())
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
            'lottery',
            'draw',
        ];

        $missingRequiredKeys = array_diff($required, array_keys($ticket));
        if (0 !== count($missingRequiredKeys)) {
            // TODO: custom exception
            throw new \Exception('invalid ticket');
        }
    }
}

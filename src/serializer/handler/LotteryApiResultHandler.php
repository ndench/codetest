<?php

namespace app\serializer\handler;

use app\models\LotteryTicket;
use app\models\RaffleTicket;
use app\models\TicketInterface;
use JMS\Serializer\Context;
use JMS\Serializer\GraphNavigator;
use JMS\Serializer\Handler\SubscribingHandlerInterface;
use JMS\Serializer\JsonDeserializationVisitor;
use JMS\Serializer\TypeParser;

class LotteryApiResultHandler implements SubscribingHandlerInterface
{
    const TYPE = 'lottery_api_result';

    /**
     * {@inheritdoc}
     */
    public static function getSubscribingMethods(): array
    {
        return [
            [
                'direction' => GraphNavigator::DIRECTION_DESERIALIZATION,
                'format' => 'json',
                'type' => static::TYPE,
                'method' => 'deserializeApiResult',
            ],
        ];
    }

    public static function deserializeApiResult(JsonDeserializationVisitor $visitor, array $data, $type, Context $context)
    {
        if (!array_key_exists('result', $data)) {
            // TODO: custom exception
            throw new \Exception('Lottery API result must contain a result key');
        }

        $typeParser = new TypeParser();

        $result = [];
        foreach ($data['result'] as $value) {
            static::validateTicket($value);

            if (LotteryTicket::getType() === $value['type']) {
                $type = $typeParser->parse(LotteryTicket::class);
            } elseif (RaffleTicket::getType() === $value['type']) {
                $type = $typeParser->parse(RaffleTicket::class);
            }

            $ticket = $visitor->getNavigator()->accept($value, $type, $context);
            $result[] = $ticket;
        }

        return $result;
    }

    protected static function validateTicket(array $ticket)
    {
        if (!array_key_exists('type', $ticket)) {
            // TODO: custom exception
            throw new \Exception('invalid ticket');
        }
    }
}

<?php

namespace app\models;

class RaffleTicket extends AbstractTicket
{
    public static function getType(): string
    {
        return 'raffle_ticket';
    }
}

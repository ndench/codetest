<?php

namespace app\models;

class LotteryTicket extends AbstractTicket
{
    public static function getType(): string
    {
        return 'lottery_ticket';
    }
}

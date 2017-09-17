<?php

namespace app\models;

class RaffleTicket extends AbstractTicket
{
    /** @var Lottery */
    protected $lottery;

    /** @var RaffleDraw */
    protected $draw;

    public static function getType(): string
    {
        return 'raffle_ticket';
    }

    protected static function getRequiredKeys(): array
    {
        return [
            'key',
            'name',
            'autoplayable',
            'lottery',
            'draw',
        ];
    }

    protected static function build(array $data): AbstractNormalizable
    {
        $raffleDraw = RaffleDraw::fromArray($data['draw']);
        $lottery = Lottery::fromArray($data['lottery']);

        $ticket = new static();
        $ticket
            ->setDraw($raffleDraw)
            ->setLottery($lottery)
            ->setName($data['name'])
            ->setKey($data['key'])
            ->setAutoPlayable($data['autoplayable'])
        ;

        return $ticket;
    }

    public function getLottery(): Lottery
    {
        return $this->lottery;
    }

    public function setLottery(Lottery $lottery): RaffleTicket
    {
        $this->lottery = $lottery;

        return $this;
    }

    public function getDraw(): RaffleDraw
    {
        return $this->draw;
    }

    public function setDraw(RaffleDraw $draw): RaffleTicket
    {
        $this->draw = $draw;

        return $this;
    }

    public function toArray(): array
    {
        return [
            'name'         => $this->getName(),
            'key'          => $this->getKey(),
            'autoPlayable' => $this->getAutoPlayable(),
            'draw'         => $this->getDraw()->toArray(),
            'lottery'      => $this->getLottery()->toArray(),
        ];
    }
}

<?php

namespace app\api;

use app\exception\InvalidApiResponseException;
use app\exception\InvalidTicketException;
use app\models\Lottery;
use app\models\RaffleDraw;
use app\models\RaffleTicket;
use GuzzleHttp\Client;

class LotteryClient
{
    /** @var Lottery[] */
    protected $raffleLotteries = [];

    /** @var RaffleDraw[] */
    protected $raffleDraws = [];

    /** @var RaffleTicket[] */
    protected $raffleTickets = [];

    /* @var Client */
    protected $guzzle;

    /* @var string */
    protected $lotteryUrl;

    /** @var bool */
    protected $initialised = false;

    public function __construct(Client $guzzle, string $lotteryUrl)
    {
        $this->guzzle = $guzzle;
        $this->lotteryUrl = $lotteryUrl;
    }

    /**
     * @return Lottery[]
     */
    public function getRaffleLotteries(): array
    {
        $this->init();
        return $this->raffleLotteries;
    }

    /**
     * @return RaffleDraw[]
     */
    public function getRaffleDraws(): array
    {
        $this->init();
        return $this->raffleDraws;
    }

    /**
     * @return RaffleTicket[]
     */
    public function getRaffleTickets(): array
    {
        $this->init();
        return $this->raffleTickets;
    }

    public function getLotteryById(string $id): ?Lottery
    {
        $this->init();

        if (!array_key_exists($id, $this->raffleLotteries)) {
            return null;
        }

        return $this->raffleLotteries[$id];
    }

    public function getDrawByNumber(int $number): ?RaffleDraw
    {
        $this->init();

        if (!array_key_exists($number, $this->raffleDraws)) {
            return null;
        }

        return $this->raffleDraws[$number];
    }

    protected function init(): void
    {
        if (!$this->initialised) {
            $results = $this->getResults();
            $this->deserialize($results);
        }
    }

    protected function getResults(): array
    {
        $res = $this->guzzle->get($this->lotteryUrl);
        $body = $res->getBody()->getContents();
        $response = json_decode($body, true);

        if (!array_key_exists('result', $response)) {
            throw new InvalidApiResponseException('Response must contain [result]');
        }

        return $response['result'];
    }

    protected function deserialize(array $data): void
    {
        foreach ($data as $ticketData) {
            if (!array_key_exists('type', $ticketData)) {
                throw new InvalidApiResponseException('Every ticket must contain a [type]');
            }

            if (RaffleTicket::getType() === $ticketData['type']) {
                $ticket = RaffleTicket::fromArray($ticketData);

                $draw = $ticket->getDraw();
                if (!array_key_exists($draw->getNumber(), $this->raffleDraws)) {
                    $this->raffleDraws[$draw->getNumber()] = $draw;
                }

                $lottery = $ticket->getLottery();
                if (!array_key_exists($lottery->getId(), $this->raffleLotteries)) {
                    $this->raffleLotteries[$lottery->getId()] = $lottery;
                }


                $this->raffleTickets[] = $ticket;
            }
        }

        $this->initialised = true;
    }

}

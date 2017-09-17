<?php

namespace app\models;

class RaffleOffer extends AbstractNormalizable
{
    /** @var string */
    protected $name;

    /** @var string */
    protected $key;

    /** @var int */
    protected $numTickets;

    /** @var string */
    protected $price;

    /** @var string */
    protected $ribbon;

    public function getName(): string
    {
        return $this->name;
    }

    public function getKey(): string
    {
        return $this->key;
    }

    public function getNumTickets(): int
    {
        return $this->numTickets;
    }

    public function getPrice(): string
    {
        return $this->price;
    }

    public function getRibbon(): string
    {
        return $this->ribbon;
    }

    protected static function getRequiredKeys(): array
    {
        return [
            'name',
            'key',
            'num_tickets',
            'price',
            'ribbon',
        ];
    }

    protected static function build(array $data): AbstractNormalizable
    {
        $offer = new static();
        $offer->name = $data['name'];
        $offer->key = $data['key'];
        $offer->numTickets = filter_var($data['num_tickets'], FILTER_VALIDATE_INT);
        $offer->price = sprintf('$%s %s', $data['price']['amount'], $data['price']['currency']);
        $offer->ribbon = $data['ribbon'];

        return $offer;
    }

    public function toArray(): array
    {
        return [
            'name' => $this->getName(),
            'key' => $this->getKey(),
            'numTickets' => $this->getNumTickets(),
            'price' => $this->getPrice(),
            'ribbon' => $this->getRibbon(),
        ];
    }
}

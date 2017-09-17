<?php

namespace app\models;

class RaffleDraw extends AbstractNormalizable
{
    /** @var string */
    protected $name;

    /** @var string */
    protected $description;

    /** @var int */
    protected $number;

    /** @var \DateTime */
    protected $start;

    /** @var \DateTime */
    protected $end;

    /** @var string */
    protected $termsUrl;

    /** @var */
    protected $prize;

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getNumber(): int
    {
        return $this->number;
    }

    public function getStart(): \DateTime
    {
        return $this->start;
    }

    public function getEnd(): \DateTime
    {
        return $this->end;
    }

    public function getTermsUrl(): string
    {
        return $this->termsUrl;
    }

    public function getPrize(): RafflePrize
    {
        return $this->prize;
    }

    protected static function getRequiredKeys(): array
    {
        return [
            'name',
            'description',
            'draw_number',
            'draw_date',
            'draw_stop',
            'terms_and_conditions_url',
            'prize',
        ];
    }

    protected static function build(array $data): AbstractNormalizable
    {
        $draw = new static();
        $draw->name = $data['name'];
        $draw->description = $data['description'];
        $draw->number = $data['draw_number'];
        $draw->start = new \DateTime($data['draw_date']);
        $draw->end = new \DateTime($data['draw_stop']);
        $draw->termsUrl = $data['terms_and_conditions_url'];
        $draw->prize = RafflePrize::fromArray($data['prize']);

        return $draw;
    }

    public function toArray(): array
    {
        return [
            'name' => $this->getName(),
            'description' => $this->getDescription(),
            'number' => $this->getNumber(),
            'startDate' => $this->getStart()->format('d.m.Y H:i:s'),
            'endDate' => $this->getEnd()->format('d.m.Y H:i:s'),
            'termsUrl' => $this->getTermsUrl(),
            'prize' => $this->getPrize()->toArray(),
        ];
    }
}

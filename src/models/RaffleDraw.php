<?php

namespace app\models;

class RaffleDraw extends AbstractNormalizable
{
    /** @var string */
    protected $name;

    /** @var string */
    protected $desc;

    /** @var int */
    protected $number;

    /** @var \DateTime */
    protected $start;

    /** @var \DateTime */
    protected $end;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): RaffleDraw
    {
        $this->name = $name;

        return $this;
    }

    public function getDesc(): string
    {
        return $this->desc;
    }

    public function setDesc(string $desc): RaffleDraw
    {
        $this->desc = $desc;

        return $this;
    }

    public function getNumber(): int
    {
        return $this->number;
    }

    public function setNumber(int $number): RaffleDraw
    {
        $this->number = $number;

        return $this;
    }

    public function getStart(): \DateTime
    {
        return $this->start;
    }

    public function setStart(\DateTime $start): RaffleDraw
    {
        $this->start = $start;

        return $this;
    }

    public function getEnd(): \DateTime
    {
        return $this->end;
    }

    public function setEnd(\DateTime $end): RaffleDraw
    {
        $this->end = $end;

        return $this;
    }

    protected static function getRequiredKeys(): array
    {
        return [
            'name',
            'description',
            'draw_number',
            'draw_date',
            'draw_stop',
        ];
    }

    protected static function build(array $data): AbstractNormalizable
    {
        return (new static())
            ->setName($data['name'])
            ->setDesc($data['description'])
            ->setNumber($data['draw_number'])
            ->setStart(new \DateTime($data['draw_date']))
            ->setEnd(new \DateTime($data['draw_stop']))
        ;
    }

    public function toArray(): array
    {
        return [
            'name' => $this->getName(),
            'desc' => $this->getDesc(),
            'number' => $this->getNumber(),
            'startDate' => $this->getStart()->format('d.m.Y H:i:s'),
            'endDate' => $this->getEnd()->format('d.m.Y H:i:s')
        ];
    }
}

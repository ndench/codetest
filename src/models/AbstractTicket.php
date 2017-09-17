<?php

namespace app\models;

abstract class AbstractTicket extends AbstractNormalizable implements TicketInterface
{
    /** @var string */
    protected $key;

    /** @var string */
    protected $name;

    /** @var string */
    protected $autoPlayable;


    public function getKey(): string
    {
        return $this->key;
    }

    public function setKey(string $key): TicketInterface
    {
        $this->key = $key;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): TicketInterface
    {
        $this->name = $name;

        return $this;
    }

    public function getAutoPlayable(): string
    {
        return $this->autoPlayable;
    }

    public function setAutoPlayable(string $autoPlayable): TicketInterface
    {
        $this->autoPlayable = $autoPlayable;

        return $this;
    }
}

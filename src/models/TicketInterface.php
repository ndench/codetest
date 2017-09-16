<?php

namespace app\models;

interface TicketInterface
{
    public static function getType(): string;
    
    public function getKey(): string;

    public function setKey(string $key): TicketInterface;

    public function getName(): string;

    public function setName(string $name): TicketInterface;

    public function getAutoPlayable(): string;

    public function setAutoPlayable(string $autoPlayable): TicketInterface;
}

<?php

namespace app\models;

class RafflePrize extends AbstractNormalizable
{
    /** @var string */
    protected $cardTitle;

    /** @var string */
    protected $name;

    /** @var string */
    protected $description;

    /** @var bool */
    protected $exact;

    /** @var string */
    protected $image;

    /** @var string */
    protected $value;

    protected static function getRequiredKeys(): array
    {
        return [
            'card_title',
            'name',
            'description',
            'value_is_exact',
            'edm_image',
            'value',
        ];
    }

    protected static function build(array $data): AbstractNormalizable
    {
        $prize = new static();
        $prize->cardTitle = $data['card_title'];
        $prize->name = $data['name'];
        $prize->description = $data['description'];
        $prize->exact = filter_var($data['value_is_exact'], FILTER_VALIDATE_BOOLEAN);
        $prize->image = $data['edm_image'];
        $prize->value = sprintf('$%s %s', $data['value']['amount'], $data['value']['currency']);

        return $prize;
    }

    public function getCardTitle(): string
    {
        return $this->cardTitle;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function isExact(): bool
    {
        return $this->exact;
    }

    public function getImage(): string
    {
        return $this->image;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function toArray(): array
    {
        return [
            'cardTitle'   => $this->getCardTitle(),
            'name'        => $this->getName(),
            'description' => $this->getDescription(),
            'exact'       => $this->isExact(),
            'image'       => $this->getImage(),
            'value'       => $this->getValue(),
        ];
    }
}

<?php

namespace app\models;

class Lottery extends AbstractNormalizable
{
    /** @var string */
    protected $id;

    /** @var string */
    protected $name;

    /** @var string */
    protected $description;

    /** @var bool */
    protected $multidraw;

    /** @var string */
    protected $type;

    /** @var string */
    protected $iconUrl;

    /** @var string */
    protected $playUrl;

    /** @var int */
    protected $lotteryId;

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): Lottery
    {
        $this->id = $id;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): Lottery
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): Lottery
    {
        $this->description = $description;

        return $this;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): Lottery
    {
        $this->type = $type;

        return $this;
    }

    public function isMultidraw(): bool
    {
        return $this->multidraw;
    }

    public function setMultidraw(bool $multidraw): Lottery
    {
        $this->multidraw = $multidraw;

        return $this;
    }

    public function getIconUrl(): string
    {
        return $this->iconUrl;
    }

    public function setIconUrl(string $iconUrl): Lottery
    {
        $this->iconUrl = $iconUrl;

        return $this;
    }

    public function getPlayUrl(): string
    {
        return $this->playUrl;
    }

    public function setPlayUrl(string $playUrl): Lottery
    {
        $this->playUrl = $playUrl;

        return $this;
    }

    public function getLotteryId(): int
    {
        return $this->lotteryId;
    }

    public function setLotteryId(int $lotteryId): Lottery
    {
        $this->lotteryId = $lotteryId;

        return $this;
    }

    protected static function getRequiredKeys(): array
    {
        return [
            'id',
            'name',
            'desc',
            'multidraw',
            'type',
            'icon_url',
            'play_url',
            'lottery_id',
        ];
    }

    protected static function build(array $data): AbstractNormalizable
    {
        return (new static())
            ->setId($data['id'])
            ->setName($data['name'])
            ->setDescription($data['desc'])
            ->setMultidraw(filter_var($data['multidraw'], FILTER_VALIDATE_BOOLEAN))
            ->setType($data['type'])
            ->setIconUrl($data['icon_url'])
            ->setPlayUrl($data['play_url'])
            ->setLotteryId(filter_var($data['lottery_id'], FILTER_VALIDATE_INT))
            ;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'description' => $this->getDescription(),
            'multidraw' => $this->isMultidraw(),
            'type' => $this->getType(),
            'icon' => $this->getIconUrl(),
            'playUrl' => $this->getPlayUrl(),
            'lotteryId' => $this->getLotteryId(),
        ];
    }
}

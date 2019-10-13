<?php
declare(strict_types=1);

namespace ieov\MigrationVs;

class Migration
{
    public const
        STATUS_DONE = 1,
        STATUS_NOT_DONE = 0;

    /** @var int */
    private $id;

    /** @var string */
    private $name;

    /** @var int */
    private $status;

    /** @var \DateTimeInterface */
    private $time;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return bool
     */
    public function isDone(): bool
    {
        return $this->status === self::STATUS_DONE;
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    public function setStatus(int $status): void
    {
        $this->status = $status > 0 ? self::STATUS_DONE : self::STATUS_NOT_DONE;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getTime(): \DateTimeInterface
    {
        return $this->time;
    }

    /**
     * @param \DateTime $time
     */
    public function setTime(\DateTimeInterface $time): void
    {
        $this->time = $time;
    }

}

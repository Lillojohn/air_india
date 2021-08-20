<?php

namespace App\Entity;

class RosterDay
{
    private string $date;
    private ?string $startTime;
    private ?string $endTime;

    /**
     * @var RosterActivity[]
     */
    private array $rosterActivities;

    public function __construct(
        string $date,
        ?string $startTime = null,
        ?string $endTime = null
    ) {
        $this->date = $date;
        $this->startTime = $startTime;
        $this->endTime = $endTime;
    }

    /**
     * @return string
     */
    public function getDate(): string
    {
        return $this->date;
    }

    /**
     * @return string|null
     */
    public function getStartTime(): ?string
    {
        return $this->startTime;
    }

    /**
     * @return string|null
     */
    public function getEndTime(): ?string
    {
        return $this->endTime;
    }

    /**
     * @return RosterActivity[]
     */
    public function getRosterActivities(): array
    {
        return $this->rosterActivities;
    }

    /**
     * @param RosterActivity $rosterActivity
     */
    public function addRosterActivities(RosterActivity $rosterActivity): void
    {
        $this->rosterActivities[] = $rosterActivity;
    }
}

<?php

namespace App\Entity;

class RosterActivity
{
    private string $activityType;

    public function __construct(
        string $activityType
    ) {
        $this->activityType = $activityType;
    }

    /**
     * @return string
     */
    public function getActivityType(): string
    {
        return $this->activityType;
    }
}

<?php

namespace App\Services;

use App\Entity\FlightActivity;
use App\Entity\RosterActivity;
use App\Enums\ActivityTypesEnum;

class RosterActivityService
{
    /**
     * @param array<mixed> $activity
     * @return RosterActivity|null
     */
    public function makeRosterActivity(array $activity): ?RosterActivity
    {
        if ($activity[0] === "D/O") {
            return new RosterActivity(ActivityTypesEnum::DO);
        }

        if (preg_match("/^[0-9]{3,4}$/", $activity[0])) {
            return new FlightActivity(
                ActivityTypesEnum::FLIGHT,
                $activity[0],
                $activity[1],
                $activity[2],
                $activity[3],
                $activity[4],
            );
        }

        $activityType = ActivityTypesEnum::getType($activity[0]);
        if ($activityType === null) {
            return null;
        }

        return new RosterActivity($activityType);
    }
}

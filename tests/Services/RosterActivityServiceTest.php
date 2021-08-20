<?php

namespace App\Tests\Services;

use App\Entity\FlightActivity;
use App\Entity\RosterActivity;
use App\Enums\ActivityTypesEnum;
use App\Services\RosterActivityService;
use PHPUnit\Framework\TestCase;

class RosterActivityServiceTest extends TestCase
{
    /**
     * @dataProvider getInputData
     */
    public function testMakeRosterActivity(array $value, ?RosterActivity $result): void
    {
        $rosterActivityService = new RosterActivityService();

        $this->assertEquals($result, $rosterActivityService->makeRosterActivity($value));
    }

    public function getInputData(): array
    {
        return [
            [["D/O"], new RosterActivity(ActivityTypesEnum::DO)],
            [["ESBY"], new RosterActivity(ActivityTypesEnum::ESBY)],
            [["9865", "10:00", "ASM", "12:00", "RMS"], new FlightActivity(
                ActivityTypesEnum::FLIGHT,
                9865,
                "10:00",
                "ASM",
                "12:00",
                "RMS"
            )
            ],
            [["Flight"], null],
        ];
    }
}

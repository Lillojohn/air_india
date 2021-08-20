<?php

namespace App\Tests\Enums;

use App\Enums\ActivityTypesEnum;
use PHPUnit\Framework\TestCase;

class ActivityTypesEnumTest extends TestCase
{
    /**
     * @dataProvider getInputData
     */
    public function testGetType(string $value, ?string $result): void
    {
        $obj = new ActivityTypesEnum();

        $this->assertSame($result, $obj->getType($value));
    }

    /**
     * @return array[]
     */
    public function getInputData(): array
    {
        return [
            ["DO", ActivityTypesEnum::DO],
            ["ESBY", ActivityTypesEnum::ESBY],
            ["CSBE", ActivityTypesEnum::CSBE],
            ["ADTY", ActivityTypesEnum::ADTY],
            ["INTV", ActivityTypesEnum::INTV],
            ["Flight", null],
        ];
    }
}

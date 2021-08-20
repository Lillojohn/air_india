<?php

namespace App\Tests\Services;

use App\Services\RosterActivityService;
use App\Services\RosterService;
use PHPUnit\Framework\TestCase;

class RosterServiceTest extends TestCase
{
    private RosterActivityService $rosterActivityService;
    private RosterService $rosterService;

    public function setUp(): void
    {
        $this->rosterActivityService =  $this->createMock(RosterActivityService::class);
        $this->rosterService = new RosterService($this->rosterActivityService);
    }

    /**
     * @dataProvider getTime
     */
    public function testGetTime(string $value, bool $result): void
    {
        $this->assertEquals($result, $this->callMethod($this->rosterService, 'getTime', [$value]));
    }

    public function getTime(): array
    {
        return [
            ["red", false],
            ["23:00", true]
        ];
    }

    private function callMethod(Object $object, string $method, array $parameters = []): int
    {
        try {
            $className = get_class($object);
            $reflection = new \ReflectionClass($className);
        } catch (\ReflectionException $e) {
            throw new \Exception($e->getMessage());
        }

        $method = $reflection->getMethod($method);
        $method->setAccessible(true);

        return $method->invokeArgs($object, $parameters);
    }
}

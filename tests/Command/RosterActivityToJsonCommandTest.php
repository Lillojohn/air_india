<?php

namespace App\Tests\Command;

use App\Command\RosterActivityToJsonCommand;
use App\Services\RosterService;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use function PHPUnit\Framework\assertEquals;

class RosterActivityToJsonCommandTest extends TestCase
{
    private MockObject $rosterServiceMock;
    private RosterActivityToJsonCommand $rosterActivityToJsonCommand;
    private MockObject $inputInterface;
    private MockObject $outputInterface;

    public function setUp(): void
    {
        $this->rosterServiceMock = $this->createMock(RosterService::class);
        $this->rosterActivityToJsonCommand = new RosterActivityToJsonCommand($this->rosterServiceMock);
        $this->inputInterface = $this->createMock(InputInterface::class);
        $this->outputInterface = $this->createMock(OutputInterface::class);
    }

    public function testExecuteWithRosterNull(): void
    {
        $this->rosterServiceMock->expects($this->once())
            ->method('getHtmlContentToRosterDays')
            ->willReturn(null);

        assertEquals(1, $this->callMethod($this->rosterActivityToJsonCommand, 'execute', [$this->inputInterface, $this->outputInterface]));
    }

    public function testExecuteWithRoster(): void
    {
        $this->rosterServiceMock->expects($this->once())
            ->method('getHtmlContentToRosterDays')
            ->willReturn(["red" => "black"]);

        assertEquals(0, $this->callMethod($this->rosterActivityToJsonCommand, 'execute', [$this->inputInterface, $this->outputInterface]));
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

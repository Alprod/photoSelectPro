<?php

namespace App\Tests\Unit\Entity;

use App\Entity\Client;
use App\Entity\SelectionProcess;
use App\Entity\Thematic;
use PHPUnit\Framework\TestCase;

use function PHPUnit\Framework\assertInstanceOf;

class SelectionProcessTest extends TestCase
{
    private SelectionProcess $selectionProcess;

    protected function setUp(): void
    {
        $this->selectionProcess = new SelectionProcess();
    }

    public function testInstanceOf(): void
    {
        assertInstanceOf(SelectionProcess::class, $this->selectionProcess);
    }

    public function testSetAndGetName(): void
    {
        $name = 'Amboirse process';

        $this->selectionProcess->setName($name);
        self::assertEquals($name, $this->selectionProcess->getName());
    }

    public function testSetAndGetStartDate(): void
    {
        $date = new \DateTimeImmutable('now');
        $this->selectionProcess->setStartDate($date);

        self::assertEquals($date, $this->selectionProcess->getStartDate());
        self::assertInstanceOf(\DateTimeImmutable::class, $this->selectionProcess->getStartDate());
    }

    public function testSetAndGetEndDate(): void
    {
        $date = new \DateTimeImmutable('now');
        $this->selectionProcess->setEndDate($date);

        self::assertEquals($date, $this->selectionProcess->getEndDate());
        self::assertInstanceOf(\DateTimeImmutable::class, $this->selectionProcess->getEndDate());
    }

    public function testEndDateIsAfterStartDate(): void
    {
        $startDate = new \DateTimeImmutable('now');
        $endDate = $startDate->add(new \DateInterval('P1M'));

        $this->selectionProcess->setStartDate($startDate);
        $this->selectionProcess->setEndDate($endDate);

        $selectStartDate = $this->selectionProcess->getStartDate();
        $selectEndDate = $this->selectionProcess->getEndDate();

        self::assertGreaterThan($selectStartDate, $selectEndDate);
        self::assertInstanceOf(\DateTimeImmutable::class, $selectStartDate);
        self::assertInstanceOf(\DateTimeImmutable::class, $selectEndDate);
    }

    public function testRelationClient(): void
    {
        $client = new Client();
        $name = 'chanel';
        $client->setName($name);
        $this->selectionProcess->setClient($client);
        $nameClientRelation = $this->selectionProcess->getClient()->getName();

        self::assertEquals($name, $nameClientRelation);
    }

    public function testRelationThematic(): void
    {
        $thematic_1 = new Thematic();
        $thematic_2 = new Thematic();

        $this->selectionProcess->addThematic($thematic_1);
        $this->selectionProcess->addThematic($thematic_2);

        $nbTheme = count($this->selectionProcess->getThematics());

        self::assertCount($nbTheme, $this->selectionProcess->getThematics());
    }

    public function testRemoveThematic(): void
    {
        $t1 = new Thematic();
        $t2 = new Thematic();

        $this->selectionProcess->addThematic($t1);
        $this->selectionProcess->addThematic($t2);

        self::assertCount(2, $this->selectionProcess->getThematics());

        $this->selectionProcess->removeThematic($t1);
        self::assertCount(1, $this->selectionProcess->getThematics());
        self::assertNull($t1->getSelectionProcess());

        $this->selectionProcess->removeThematic(new Thematic());
        self::assertCount(1, $this->selectionProcess->getThematics());
    }
}

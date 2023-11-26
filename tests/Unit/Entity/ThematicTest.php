<?php

namespace App\Tests\Unit\Entity;

use App\Entity\Group;
use App\Entity\SelectionProcess;
use App\Entity\Thematic;
use PHPUnit\Framework\TestCase;

class ThematicTest extends TestCase
{
    private Thematic $thematic;

    protected function setUp(): void
    {
        $this->thematic = new Thematic();
    }

    public function testInstanceOf(): void
    {
        self::assertInstanceOf(Thematic::class, $this->thematic);
    }

    public function testSetAndGetName(): void
    {
        $name = 'Chanel';
        $this->thematic->setName($name);

        self::assertEquals($name, $this->thematic->getName());
        self::assertLessThan(100, strlen($name));
    }

    /**
     * @throws \Exception
     */
    protected function generateRandomText(int $length = 200): string
    {
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $text = '';

        for ($i = 0; $i < $length; ++$i) {
            $text .= $characters[random_int(0, strlen($characters) - 1)];
        }

        return $text;
    }

    /**
     * @throws \Exception
     */
    public function testSetAndGetDescription(): void
    {
        $this->thematic->setDescription($this->generateRandomText());
        self::assertGreaterThanOrEqual(100, strlen($this->thematic->getDescription()));
    }

    public function testSelectionProcessRelation(): void
    {
        $selectionProcess = new SelectionProcess();
        $this->thematic->setSelectionProcess($selectionProcess);

        self::assertEquals($selectionProcess, $this->thematic->getSelectionProcess());
        self::assertInstanceOf(SelectionProcess::class, $this->thematic->getSelectionProcess());
    }

    public function testGroupRelation(): void
    {
        $group = new Group();
        $this->thematic->addGroup($group);

        self::assertNotNull($this->thematic->getGroups());
        self::assertIsObject($this->thematic->getGroups());
    }

    public function testRemoveGroup(): void
    {
        $group_1 = new Group();
        $group_2 = new Group();

        $this->thematic->addGroup($group_1);
        $this->thematic->addGroup($group_2);

        self::assertNotNull($this->thematic->getGroups());
        self::assertCount(2, $this->thematic->getGroups());

        $this->thematic->removeGroup($group_1);
        self::assertCount(1, $this->thematic->getGroups());
        self::assertNull($group_1->getThematic());

        $this->thematic->removeGroup(new Group());

        self::assertCount(1, $this->thematic->getGroups());

    }
}
